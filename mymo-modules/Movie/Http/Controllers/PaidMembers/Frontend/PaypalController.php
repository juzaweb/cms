<?php

namespace App\Core\Http\Controllers\PaidMembers\Frontend;

use Modules\Movie\Models\PaymentHistory;
use Modules\Movie\Models\UserSubscription;
use App\Core\User;
use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;
use PayPal\Api\Agreement;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Payer;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PaypalController extends BackendController
{
    private $apiContext;
    private $client_id;
    private $secret;
    private $plan_id;

    public function __construct()
    {
        if(config('paypal.settings.mode') == 'live'){
            $this->client_id = config('paypal.live_client_id');
            $this->secret = config('paypal.live_secret');
            $this->plan_id = config('paypal.live_plan');
        } else {
            $this->client_id = config('paypal.sandbox_client_id');
            $this->secret = config('paypal.sandbox_secret');
            $this->plan_id = config('paypal.sandbox_plan');
        }
        
        // Set the Paypal API Context/Credentials
        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->secret));
        $this->apiContext->setConfig(config('paypal.settings'));
    }
    
    public function createPlan(){
        $plan = new Plan();
        $plan->setName('Stream3s Monthly Billing')
            ->setDescription('Monthly Subscription to the Stream3s')
            ->setType('infinite');
        
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval('1')
            ->setCycles('0')
            ->setAmount(new Currency([
                'value' => 59,
                'currency' => 'USD'
            ]));
        
        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl(route('paypal.return'))
            ->setCancelUrl(route('paypal.cancel'))
            ->setAutoBillAmount('yes')
            ->setInitialFailAmountAction('CONTINUE')
            ->setMaxFailAttempts('0');
        
        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);
        
        try {
            $createdPlan = $plan->create($this->apiContext);
            
            try {
                $patch = new Patch();
                $value = new PayPalModel('{"state":"ACTIVE"}');
                $patch->setOp('replace')
                    ->setPath('/')
                    ->setValue($value);
                $patchRequest = new PatchRequest();
                $patchRequest->addPatch($patch);
                $createdPlan->update($patchRequest, $this->apiContext);
                $plan = Plan::get($createdPlan->getId(), $this->apiContext);
                
                echo 'Plan ID:' . $plan->getId();
            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                echo $ex->getCode();
                echo $ex->getData();
                die($ex);
            } catch (\Exception $ex) {
                die($ex);
            }
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (\Exception $ex) {
            die($ex);
        }
        
    }
    
    public function paypalRedirect() {
        $agreement = new Agreement();
        $agreement->setName('Stream3s Monthly Subscription Agreement')
            ->setDescription('Stream3s Premium Plan')
            ->setStartDate(\Carbon\Carbon::now()->addMinutes(5)->toIso8601String());
        
        $plan = new Plan();
        $plan->setId($this->plan_id);
        $agreement->setPlan($plan);
        
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);
        
        try {
            $agreement = $agreement->create($this->apiContext);
            $approvalUrl = $agreement->getApprovalLink();
            return redirect()->to($approvalUrl);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            \Log::error($ex->getMessage());
            die();
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            die();
        }
    }
    
    public function paypalReturn(Request $request){
        if (isset($_GET['token'])) {
            $token = $request->token;
            if (UserSubscription::where('token', '=', $token)->exists()) {
                return redirect()->route('client.upgrade');
            }
            
            $agreement = new \PayPal\Api\Agreement();
    
            $error = false;
            try {
                $result = $agreement->execute($token, $this->apiContext);
                $message = trans('app.payment_success');
                
                if ($result->state != 'Active') {
                    $message = 'Payment not active';
                    $error = true;
                }
                
                if ($error) {
                    $session = [
                        'status' => ($error) ? 'warning' : 'success',
                        'message' => $message,
                    ];
        
                    \Log::error('paypalReturn - ' . $message);
        
                    session()->put('message', json_encode($session));
                    session()->save();
        
                    return redirect()->route('client.upgrade');
                }
    
                $subscriber = new UserSubscription();
                $subscriber->user_id = \Auth::id();
                $subscriber->role = 'subscriber';
                $subscriber->method = 'paypal';
                $subscriber->token = $token;
                $subscriber->payer_id = $result->payer->payer_info->payer_id;
                $subscriber->payer_email = $result->payer->payer_info->email;
                $subscriber->agreement_id = $result->id;
                $subscriber->amount = $result->plan->payment_definitions[0]->amount->value;
                $subscriber->save();
                
                event(new PaymentSuccess($result));
                
            }
            catch (\PayPal\Exception\PayPalConnectionException $ex) {
                $message = trans('app.cancel_paypal');
                $error = true;
    
                $session = [
                    'status' => ($error) ? 'warning' : 'success',
                    'message' => $message,
                ];
                
                session()->put('message', json_encode($session));
                session()->save();
    
                return redirect()->route('client.upgrade');
            }
        }
        else {
            $message = trans('app.cancel_paypal');
            $error = true;
        }
        
        $session = [
            'status' => ($error) ? 'warning' : 'success',
            'message' => $message,
        ];
    
        session()->put('message', json_encode($session));
        session()->save();
    
        return redirect()->route('client.upgrade');
    }
    
    public function paypalCancel() {
        if (\Auth::check()) {
            return redirect()->route('client.upgrade');
        }
    
        return redirect()->route('frontend.home');
    }
    
    public function postNotify(Request $request) {
        $resource = $request->input('resource');
        $agreement = UserSubscription::where('agreement_id', '=', @$resource['billing_agreement_id'])->first(['user_id']);
        \Log::info('Paypal Notify: ' . json_encode($request->all()));
        
        if (empty($agreement)) {
            \Log::error('Not available agreement: postNotify ' . json_encode($request->all()));
            return response('Webhook Handled', 200);
        }
        
        $user = User::find($agreement->user_id);
        if (empty($user)) {
            \Log::error('Empty user. ' . json_encode($request->all()));
            return response('Webhook Handled', 200);
        }
    
        if (strtotime($user->premium_enddate) > time()) {
            $expiration_date = date("Y-m-d 23:59:59", strtotime("+1 month", strtotime($user->premium_enddate)));
        }
        else {
            $expiration_date = date("Y-m-d 23:59:59", strtotime("+1 month"));
        }
    
        $user->update([
            'premium_enddate' => $expiration_date,
        ]);
    
        $subscriber = new PaymentHistory();
        $subscriber->method = 'paypal';
        $subscriber->user_id = $user->id;
        $subscriber->agreement_id = $resource['billing_agreement_id'];
        $subscriber->save();
    
        return response('Webhook Handled', 200);
    }
}
