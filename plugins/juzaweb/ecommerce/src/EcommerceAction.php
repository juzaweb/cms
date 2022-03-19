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

use Juzaweb\Abstracts\Action;
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
            str_replace('{name}', 'products', Action::POST_FORM_LEFT_ACTION),
            [$this, 'addFormProduct']
        );

        $this->addAction(
            'post_type.products.after_save',
            [$this, 'saveDataProduct'],
            20,
            2
        );

        $this->addFilter(
            'post_type.products.parseDataForSave',
            [$this, 'parseDataForSave']
        );
    }

    public function registerPostTypes()
    {
        HookAction::registerPostType(
            'products',
            [
                'label' => trans('ecom::content.products'),
                'menu_icon' => 'fa fa-list-alt',
                'menu_position' => 10,
                'supports' => [
                    'category',
                    'tag'
                ],
                'metas' => [
                    'price' => [
                        'type' => 'text',
                        'visible' => false,
                    ],
                    'compare_price' => [
                        'type' => 'text',
                        'visible' => false,
                    ],
                    'sku_code' => [
                        'type' => 'text',
                        'visible' => false,
                    ],
                    'barcode' => [
                        'type' => 'text',
                        'visible' => false,
                    ],
                    'images' => [
                        'type' => 'images',
                        'visible' => false,
                    ],
                    'quantity' => [
                        'type' => 'text',
                        'visible' => false,
                    ],
                    'inventory_management' => [
                        'type' => 'text',
                        'visible' => false,
                    ],
                    'disable_out_of_stock' => [
                        'type' => 'text',
                        'visible' => false,
                    ]
                ]
            ]
        );

        HookAction::registerTaxonomy(
            'brands',
            'products',
            [
                'label' => trans('ecom::content.brands'),
                'menu_position' => 11,
            ]
        );

        HookAction::registerTaxonomy(
            'vendors',
            'products',
            [
                'label' => trans('ecom::content.vendors'),
                'menu_position' => 12,
            ]
        );
    }

    public function addAdminMenu()
    {
        HookAction::addAdminMenu(
            trans('ecom::content.ecommerce'),
            'ecommerce',
            [
                'position' => 12,
            ]
        );

        HookAction::addAdminMenu(
            trans('ecom::content.orders'),
            'ecommerce.orders',
            [
                'position' => 1,
                'parent' => 'ecommerce',
            ]
        );

        /*HookAction::addAdminMenu(
            trans('ecom::content.inventories'),
            'ecommerce.inventories',
            [
                'position' => 2,
                'parent' => 'ecommerce',
            ]
        );*/

        HookAction::addAdminMenu(
            trans('ecom::content.payment_methods'),
            'ecommerce.payment-methods',
            [
                'position' => 3,
                'parent' => 'ecommerce',
            ]
        );

        HookAction::addAdminMenu(
            trans('ecom::content.setting'),
            'ecommerce.setting',
            [
                'position' => 3,
                'parent' => 'ecommerce',
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
