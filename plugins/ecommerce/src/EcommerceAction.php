<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Ecommerce\Http\Controllers\Frontend\CheckoutController;
use Juzaweb\Ecommerce\Models\Variant;
use Juzaweb\Backend\Facades\HookAction;

class EcommerceAction extends Action
{
    public function handle()
    {
        $this->addAction(
            Action::INIT_ACTION,
            [$this, 'registerPostTypes']
        );

        $this->addAction(
            Action::BACKEND_CALL_ACTION,
            [$this, 'addAdminMenu']
        );
    
        $this->addAction(
            Action::INIT_ACTION,
            [$this, 'registerConfigs']
        );
    
        $this->addFilter(
            'theme.get_view_page',
            [$this, 'addCheckoutPage'],
            20,
            2
        );
        
        $this->addAction(
            Action::FRONTEND_CALL_ACTION,
            [$this, 'registerFrontendAjax']
        );
    }

    public function registerPostTypes()
    {
    }

    public function registerConfigs()
    {
        HookAction::registerConfig(
            [
                'ecom_checkout_page',
            ]
        );
    }
    
    public function addAdminMenu()
    {
        HookAction::registerAdminPage(
            'ecommerce',
            [
                'title' => trans('ecom::content.ecommerce'),
                'menu' => [
                    'icon' => 'fa fa-shopping-cart',
                    'position' => 50,
                ]
            ]
        );
        HookAction::registerAdminPage(
            'ecommerce.settings',
            [
                'title' => trans('ecom::content.setting'),
                'menu' => [
                    'icon' => 'fa fa-shopping-cart',
                    'position' => 2,
                    'parent' => 'ecommerce'
                ]
            ]
        );
        
        HookAction::registerAdminPage(
            'ecommerce.payment-methods',
            [
                'title' => trans('ecom::content.payment_methods'),
                'menu' => [
                    'icon' => 'fa fa-credit-card',
                    'position' => 2,
                    'parent' => 'ecommerce'
                ]
            ]
        );
        
        HookAction::registerAdminPage(
            'ecommerce.inventories',
            [
                'title' => trans('ecom::content.inventories'),
                'menu' => [
                    'icon' => 'fa fa-indent',
                    'position' => 3,
                    'parent' => 'ecommerce'
                ]
            ]
        );

        HookAction::registerAdminPage(
            'ecommerce.variants',
            [
                'title' => trans('ecom::content.variants'),
                'menu' => [
                    'icon' => 'fa fa-indent',
                    'position' => 3,
                    'parent' => 'ecommerce',
                ]
            ]
        );
    }

    public function addFormProduct($model)
    {
        $variant = Variant::findByProduct($model->id);

        echo e(
            view(
                'ecom::backend.product.form',
                compact(
                    'variant',
                    'model'
                )
            )
        );
    }

    public function parseDataForSave($data)
    {
        $metas = (array) $data['meta'];
        if ($metas['price']) {
            $metas['price'] = parse_price_format($metas['price']);
        }

        if ($metas['compare_price']) {
            $metas['compare_price'] = parse_price_format($metas['compare_price']);
        }

        $metas['inventory_management'] = $metas['inventory_management'] ?? 0;
        $metas['disable_out_of_stock'] = $metas['disable_out_of_stock'] ?? 0;
        if ($metas['quantity']) {
            $metas['quantity'] = (int) $metas['quantity'];
            $metas['quantity'] = $metas['quantity'] > 0 ? $metas['quantity'] : 0;
        }

        $data['meta'] = $metas;
        return $data;
    }

    /**
     * @param \Juzaweb\Backend\Models\Post
     * @param array $data
     * @return void
     */
    public function saveDataProduct($model, $data)
    {
        $variant = Variant::findByProduct($model->id);
        $variantData = $data['meta'];
        $variantData['title'] = 'Default';
        $variantData['names'] = ['Default'];
        $variantData['product_id'] = $model->id;

        Variant::updateOrCreate(
            ['id' => $variant->id ?? 0],
            $variantData
        );
    }
    
    public function addCheckoutPage($view, $page)
    {
        $checkoutPage = get_config('ecom_checkout_page');
        
        if ($checkoutPage == $page->id) {
            $view = 'ecom::frontend.checkout.index';
            return $view;
        }
        
        return $view;
    }
    
    public function registerFrontendAjax()
    {
        HookAction::registerFrontendAjax(
            'checkout',
            [
                'callback' => [CheckoutController::class, 'checkout'],
                'method' => 'POST',
            ]
        );
    
        HookAction::registerFrontendAjax(
            'payment',
            [
                'callback' => [CheckoutController::class, 'payment'],
            ]
        );
    }
}
