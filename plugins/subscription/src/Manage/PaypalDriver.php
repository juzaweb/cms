<?php

namespace Juzaweb\Subscription\Manage;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Juzaweb\Subscription\Models\SubscriptionHistory;
use PayPal\Api\Agreement;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Payer;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\VerifyWebhookSignature;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Common\PayPalModel;
use PayPal\Api\Plan;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

class PaypalDriver extends SubscriptionDriver
{
    private $apiContext;

    public function syncPlan()
    {
        $plan = new Plan();
        $plan->setName($this->package->name)
            ->setDescription($this->package->description)
            ->setType('infinite');

        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval('1')
            ->setCycles('0')
            ->setAmount(new Currency([
                'value' => floatval($this->package->price),
                'currency' => 'USD'
            ]));

        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl(
            route(
                'subscription.return',
                [
                    $this->driver,
                    $this->package->key
                ]
            )
        )->setCancelUrl(route('subscription.cancel', [
                $this->driver,
                $this->package->key
            ]))
            ->setAutoBillAmount('yes')
            ->setInitialFailAmountAction('CONTINUE')
            ->setMaxFailAttempts('0');

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        try {
            $createdPlan = $plan->create($this->getContext());

            $patch = new Patch();
            $value = new PayPalModel('{"state":"ACTIVE"}');
            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);
            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);
            $createdPlan->update($patchRequest, $this->getContext());
            $plan = Plan::get($createdPlan->getId(), $this->getContext());
            return $plan->getId();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function redirect()
    {
        $packPlan = $this->getPlan();

        if (empty($packPlan)) {
            throw new \Exception('Please sync your package.');
        }

        $agreement = new Agreement();
        $agreement->setName("{$this->package->name} Monthly Subscription Agreement")
            ->setDescription($this->package->description)
            ->setStartDate(
                Carbon::now()
                    ->addMinutes(5)
                    ->toIso8601String()
            );

        $plan = new Plan();
        $plan->setId($packPlan->plan_id);
        $agreement->setPlan($plan);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        try {
            $agreement = $agreement->create($this->getContext());
            $approvalUrl = $agreement->getApprovalLink();
            return $approvalUrl;
        } catch (PayPalConnectionException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function return($data)
    {
        if (!Arr::has($data, 'token')) {
            return [
                'message' => trans('app.cancel_paypal'),
                'error' => true
            ];
        }

        $token = Arr::get($data, 'token');

        if (SubscriptionHistory::where('token', '=', $token)->exists()) {
            return [
                'message' => trans('app.cancel_paypal'),
                'error' => true
            ];
        }

        $agreement = new Agreement();

        $error = false;
        try {
            $result = $agreement->execute($token, $this->getContext());
            $message = trans('app.payment_success');

            if ($result->state != 'Active') {
                $message = 'Payment not active';
                $error = true;
            }

            if ($error) {
                $session = [
                    'status' => $error,
                    'message' => $message,
                ];

                return $session;
            }

            return [
                'message' => trans('app.payment_success'),
                'error' => false,
                'data' => [
                    'token' => $token,
                    'payer_id' => $result->payer->payer_info->payer_id,
                    'payer_email' => $result->payer->payer_info->email,
                    'agreement_id' => $result->id,
                    'amount' => $result->plan->payment_definitions[0]->amount->value,
                ]
            ];
        } catch (PayPalConnectionException $e) {
            Log::error($e);
        }

        return [
            'message' => trans('app.cancel_paypal'),
            'error' => true
        ];
    }

    public function notify(Request $request)
    {
        $config = $this->getConfig();
        $mode = Arr::get($config, 'mode');

        if ($mode == 'live') {
            $webhookId = Arr::get($config, 'live_webhook_id');
        } else {
            $webhookId = Arr::get($config, 'sandbox_webhook_id');
        }

        if ($webhookId && !$this->signatureVerification($request, $webhookId)) {
            throw new \Exception(
                'Error: Could not verify signature.'
            );
        }

        $resource = $request->input('resource');
        if (empty($resource)) {
            return false;
        }

        $agreementId = Arr::get($resource, 'billing_agreement_id');
        if (empty($agreementId)) {
            return false;
        }

        $agreement = SubscriptionHistory::where(
            'agreement_id',
            '=',
            $agreementId
        )->first();

        if (empty($agreement)) {
            throw new \Exception(
                "Not available agreement: {$agreementId}"
            );
        }

        return $agreement;
    }

    public function cancel()
    {
        return true;
    }

    private function signatureVerification(Request $request, $webhookId)
    {
        $body = $request->getContent();
        $headers = array_change_key_case(
            $request->headers->all(),
            CASE_UPPER
        );

        $verification = new VerifyWebhookSignature();
        $verification->setAuthAlgo($headers['PAYPAL-AUTH-ALGO'][0]);
        $verification->setTransmissionId($headers['PAYPAL-TRANSMISSION-ID'][0]);
        $verification->setCertUrl($headers['PAYPAL-CERT-URL'][0]);
        $verification->setWebhookId($webhookId);
        $verification->setTransmissionSig($headers['PAYPAL-TRANSMISSION-SIG'][0]);
        $verification->setTransmissionTime($headers['PAYPAL-TRANSMISSION-TIME'][0]);
        $verification->setRequestBody($body);

        try {
            $result = $verification->post($this->getContext());
        } catch (\Exception $ex) {
            Log::critical($ex->getMessage());
            throw new \Exception('Error: Could not verify signature.');
        }

        $status = $result->getVerificationStatus();

        switch (strtoupper($status)) {
            case 'SUCCESS':
                $json = json_decode($body, 1);
                break;
            default:
                throw new \Exception('Forbidden: Invalid signature.');
        }

        switch ($json['event_type']) {
            case "PAYMENT.SALE.COMPLETED":
                if (strtoupper($json['resource']['state']) != "COMPLETED") {
                    return false;
                }

                return true;
            default:
                Log::info("PayPal Webhook event {$json['event_type']} not handled. Ignoring...");
                return false;
        }
    }

    private function getContext()
    {
        if ($this->apiContext) {
            return $this->apiContext;
        }

        $config = $this->getConfig();

        $mode = Arr::get($config, 'mode');
        if ($mode == 'live') {
            $clientId = $config['live_client_id'];
            $secret = $config['live_secret'];
        } else {
            $clientId = $config['sandbox_client_id'];
            $secret = $config['sandbox_secret'];
        }

        // Set the Paypal API Context/Credentials
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential($clientId, $secret)
        );

        $this->apiContext->setConfig([
            'mode' => $mode,

            // Specify the max connection attempt (3000 = 3 seconds)
            'http.ConnectionTimeOut' => 3000,

            // Specify whether or not we want to store logs
            'log.LogEnabled' => true,

            // Specigy the location for our paypal logs
            'log.FileName' => storage_path() . '/logs/paypal.log',

            'log.LogLevel' => 'DEBUG'
        ]);

        return $this->apiContext;
    }
}
