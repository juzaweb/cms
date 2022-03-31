<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Permission\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Permission\Models\Permission;
use Juzaweb\Permission\Models\PermissionGroup;

class PermissionGenerateCommand extends Command
{
    protected $signature = 'permission:generate';
    protected $resourcePermissions = ['index', 'store', 'update', 'delete'];
    
    public function handle()
    {
        $this->resourceGenerate('users');
        $this->resourceGenerate('email_templates');
        $this->resourceGenerate('themes');
        $this->resourceGenerate('menus');
        
        $postTypes = HookAction::getPostTypes();
        foreach ($postTypes as $type => $postType) {
            $this->resourceGenerate($type);
            
            $taxonomies = HookAction::getTaxonomies($type);
            foreach ($taxonomies as $key => $taxonomy) {
                $typeSingular = Str::singular($type);
                $this->resourceGenerate("{$typeSingular}.{$key}");
            }
        }
        
        return self::SUCCESS;
    }
    
    protected function resourceGenerate($resource)
    {
        $permissions = $this->resourcePermissions;
        foreach ($permissions as $permission) {
            $group = PermissionGroup::firstOrCreate([
                'name' => $resource,
            ]);
        
            Permission::firstOrCreate([
                'name' => "{$resource}.{$permission}",
                'group_id' => $group->id
            ]);
        }
    }
}