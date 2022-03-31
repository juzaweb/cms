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
    }

    public function registerPostTypes()
    {
    }

    public function addAdminMenu()
    {
        HookAction::registerAdminPage(
            'ecommerce',
            [
                'title' => trans('cms::app.ecommerce'),
                'menu' => [
                    'icon' => 'fa fa-shopping-cart',
                    'position' => 50,
<<<<<<< HEAD
=======

>>>>>>> 0c6d535 (:construction: feat/ecommerce-plugin in progress build variant)
                ]
            ]
        );
        HookAction::registerAdminPage(
            'ecommerce.settings',
            [
                'title' => trans('cms::app.setting'),
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
                'title' => trans('cms::app.payment_methods'),
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
                'title' => trans('cms::app.inventories'),
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
                'title' => trans('cms::app.variants'),
                'menu' => [
                    'icon' => 'fa fa-indent',
                    'position' => 3,
<<<<<<< HEAD
                    'parent' => 'ecommerce',
=======
                    'parent' => 'ecommerce'
>>>>>>> 0c6d535 (:construction: feat/ecommerce-plugin in progress build variant)
                ]
            ]
        );
    }

    public function addFormProduct($model)
    {
        $variant = Variant::findByProduct($model->id);

        echo e(view('ecom::backend.product.form', compact(
            'variant',
            'model'
        )));
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
}
