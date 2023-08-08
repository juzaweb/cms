<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Support\Registers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Juzaweb\Backend\Models\Resource;
use Juzaweb\CMS\Abstracts\BackendResource;
use Juzaweb\CMS\Contracts\HookActionContract as HookAction;

class ResourceRegister
{
    protected HookAction $hookAction;
    protected string $key;
    protected ?string $postType;
    protected ?array $args;

    public function __construct(HookAction $hookAction)
    {
        $this->hookAction = $hookAction;
    }

    public function make(string $key, ?string $postType = null, ?array $args = []): static
    {
        if (class_exists($key)) {
            /**
             * @var BackendResource $resource
             */
            $resource = app($key);

            $this->key = $resource->getKey();
            $this->postType = $resource->getPostType();
            $this->args = $resource->toArray();
        } else {
            $this->key = $key;
            $this->postType = $postType;
            $this->args = $args;
        }
        return $this;
    }

    public function args(): Collection
    {
        if (empty($this->postType) && !Arr::get($this->args, 'parent')) {
            if ($menu = Arr::get($this->args, 'menu', [])) {
                $this->registerMenu($menu);
            }
        }

        $this->hookAction->registerResourcePermissions(
            Arr::get($this->args, 'permission_name', "resource_{$this->key}"),
            Arr::get($this->args, 'label')
        );

        return $this->registerResourceWithPost();
    }

    public function getKey(): string
    {
        return $this->key;
    }

    protected function registerMenu(array $menu): void
    {
        $menu = array_merge(
            [
                'icon' => 'fa fa-list-ul',
                'parent' => null,
                'position' => 20,
            ],
            $menu
        );

        $menuKey = "resources.{$this->key}";

        $this->hookAction->addAdminMenu($this->args['label'], $menuKey, $menu);
    }

    protected function registerResourceWithPost(): Collection
    {
        $args = array_merge(
            [
                'key' => $this->key,
                'model' => Resource::class,
                'custom_resource' => false,
                'label' => $this->args['label'],
                'label_action' => $this->args['label'],
                'description' => '',
                'repository' => null,
                'post_type' => $this->postType,
                'priority' => 20,
                'supports' => [],
                'metas' => [],
            ],
            $this->args
        );

        return new Collection($args);
    }
}
