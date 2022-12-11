<?php

namespace Juzaweb\CMS\Traits\HookAction;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Juzaweb\CMS\Facades\GlobalData;

trait GetHookAction
{
    /**
     * Get registed menu box
     *
     * @param  string|array  $keys
     * @return array
     */
    public function getMenuBoxs(string|array $keys = []): array
    {
        $menuBoxs = GlobalData::get('menu_boxs');
        
        if ($keys) {
            if (is_string($keys)) {
                $keys = [$keys];
            }
            
            return array_only($menuBoxs, $keys);
        }
        
        return $menuBoxs;
    }
    
    /**
     * Get registed menu box
     *
     * @param  string|array  $key
     * @return Collection|false
     */
    public function getMenuBox($key): bool|Collection
    {
        return GlobalData::get('menu_boxs.'.$key);
    }
    
    /**
     * Get post type setting
     *
     * @param  string|null  $postType
     * @return Collection
     * */
    public function getPostTypes(string $postType = null): Collection
    {
        if ($postType) {
            $data = GlobalData::get('post_types.'.$postType);
            
            return is_array($data) ? collect($data) : $data;
        }
        
        return collect(GlobalData::get('post_types'));
    }
    
    public function getTaxonomies($postType = null): Collection
    {
        if (is_array($postType)) {
            $postType = $postType['key'];
        }
        
        $taxonomies = collect(GlobalData::get('taxonomies'));
        
        if (empty($taxonomies) || empty($postType)) {
            return $taxonomies;
        }
        
        $taxonomies = collect($taxonomies->get($postType, []));
        
        return $taxonomies ?
            $taxonomies->sortBy('menu_position')
            : new Collection([]);
    }
    
    public function getSettingForms(): Collection
    {
        return collect(GlobalData::get('setting_forms'))
            ->sortBy('priority');
    }
    
    public function getAdminMenu()
    {
        return GlobalData::get('admin_menu');
    }
    
    public function getConfigs($key = null): Collection
    {
        $configs = config('juzaweb.config');
        $configs = array_merge($this->globalData->get('configs'), $configs);
        if ($key) {
            $configs = [$configs[$key]];
        }
        
        return collect($configs)->mapWithKeys(
            function ($item, $key) {
                if (is_int($key) && is_string($item)) {
                    return [
                        $item => [
                            'type' => 'text',
                            'name' => $key,
                            'label' => trans("cms::config.{$item}"),
                        ],
                    ];
                }
                
                $item['name'] = $key;
                $item['type'] = $item['type'] ?? 'text';
                
                return [
                    $key => $item,
                ];
            }
        );
    }
    
    public function getMasterAdminMenu()
    {
        return GlobalData::get('master_admin_menu');
    }
    
    public function getPermalinks($key = null)
    {
        $data = get_config('permalinks', []);
        $permalinks = GlobalData::get('permalinks');
        
        if ($data) {
            $permalinks = array_map(
                function ($item) use ($data) {
                    if (isset($data[$item->get('key')])) {
                        $item->put('base', $data[$item->get('key')]['base']);
                    }
                    
                    return $item;
                },
                $permalinks
            );
        }
        
        if ($key) {
            $permalink = Arr::get($permalinks, $key);
            
            return $permalink;
        }
        
        return $permalinks;
    }
    
    public function getEmailHooks($key = null)
    {
        if ($key) {
            return GlobalData::get('email_hooks.'.$key);
        }
        
        return new Collection(GlobalData::get('email_hooks'));
    }
    
    public function getWidgets($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('widgets'), $key);
        }
        
        return new Collection(GlobalData::get('widgets'));
    }
    
    public function getPageBlocks($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('page_blocks'), $key);
        }
        
        return new Collection(GlobalData::get('page_blocks'));
    }
    
    public function getSidebars($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('sidebars'), $key);
        }
        
        return new Collection(GlobalData::get('sidebars'));
    }
    
    public function getFrontendAjaxs($key = null)
    {
        if ($key) {
            $data = Arr::get(GlobalData::get('frontend_ajaxs'), $key);
            
            if ($data) {
                return $data;
            }
            
            return false;
        }
        
        $data = new Collection(GlobalData::get('frontend_ajaxs'));
        
        return $data;
    }
    
    public function getThemeTemplates($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('templates'), $key);
        }
        
        return new Collection(GlobalData::get('templates'));
    }
    
    public function getResource($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('resources'), $key);
        }
        
        return new Collection(GlobalData::get('resources'));
    }
    
    public function getAdminPages($key = null): Collection|string|array|null
    {
        if ($key) {
            return Arr::get(GlobalData::get('admin_pages'), $key);
        }
        
        return new Collection(GlobalData::get('admin_pages'));
    }
    
    public function getAdminAjaxs($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('admin_ajaxs'), $key);
        }
        
        return new Collection(GlobalData::get('admin_ajaxs'));
    }
    
    public function getPackageModules($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('package_modules'), $key);
        }
        
        return new Collection(GlobalData::get('package_modules'));
    }
    
    public function getThemeSettings($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('theme_settings'), $key);
        }
        
        return new Collection(GlobalData::get('theme_settings'));
    }
    
    public function getEnqueueScripts($inFooter = false)
    {
        $scripts = new Collection(GlobalData::get('scripts'));
        
        return $scripts->where('inFooter', $inFooter);
    }
    
    public function getEnqueueStyles($inFooter = false)
    {
        $scripts = new Collection(GlobalData::get('styles'));
        
        return $scripts->where('inFooter', $inFooter);
    }
    
    public function getEnqueueFrontendScripts($inFooter = false)
    {
        $scripts = new Collection(GlobalData::get('frontend_scripts'));
        
        return $scripts->where('inFooter', $inFooter);
    }
    
    public function getEnqueueFrontendStyles($inFooter = false): Collection
    {
        $scripts = new Collection(GlobalData::get('frontend_styles'));
        
        return $scripts->where('inFooter', $inFooter);
    }
    
    public function getProfilePages($key = null): Collection
    {
        if ($key) {
            return Arr::get(GlobalData::get('profile_pages'), $key);
        }
        
        return new Collection(GlobalData::get('profile_pages'));
    }
    
    public function getPermissions(string $key = null): Collection
    {
        if ($key) {
            return Arr::get(GlobalData::get('permissions'), $key);
        }
        
        return new Collection(GlobalData::get('permissions'));
    }
    
    public function getPermissionGroups(string $key = null): Collection
    {
        if ($key) {
            return Arr::get(GlobalData::get('permission_groups'), $key);
        }
        
        return new Collection(GlobalData::get('permission_groups'));
    }
    
    public function getResourceManagements(string $key = null): Collection
    {
        //dd(GlobalData::get('resource_managements'));
        return $key ? Arr::get(GlobalData::get('resource_managements'), $key) :
            new Collection(GlobalData::get('resource_managements'));
    }
    
    public function getThumbnailSizes($postType = null): Collection
    {
        if ($postType) {
            return Arr::get($this->globalData->get('thumbnail_sizes'), $postType);
        }
        
        return new Collection($this->globalData->get('thumbnail_sizes'));
    }
    
    public function getEmailTemplates(string $key = null): ?Collection
    {
        if ($key) {
            return Arr::get(GlobalData::get('email_templates'), $key);
        }
        
        return new Collection(GlobalData::get('email_templates'));
    }
    
    public function getAPIDocuments(string $key = null): ?Collection
    {
        return $this->getDataByKey('api_documents', $key);
    }
    
    public function getDataByKey(string $data, string $key = null): ?Collection
    {
        return $key ? Arr::get($this->globalData->get($data), $key)
            : new Collection($this->globalData->get($data));
    }
}
