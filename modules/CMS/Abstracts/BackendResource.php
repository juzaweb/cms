<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Abstracts;

abstract class BackendResource
{
    protected string $key;
    protected string $repository;
    protected string $label;
    protected ?string $postType = null;

    public function getFields(): array
    {
        return [];
    }

    public function getMenu(): array
    {
        return [];
    }

    public function getValidator(): array
    {
        return [];
    }

    public function getPostType(): ?string
    {
        return $this->postType;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function toArray(): array
    {
        return [
            'label' => trans($this->label),
            'menu' => [
                'icon' => 'fa fa-file',
                'position' => 1,
                'parent' => 'ads-manager'
            ],
            'repository' => $this->repository,
            'custom_resource' => true,
            'fields' => $this->getFields(),
            'validator' => $this->getValidator()
        ];
    }
}
