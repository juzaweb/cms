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
    protected $resourcePermissions = ['index', 'create', 'edit', 'delete'];
    
    public function handle()
    {
        $this->resourceGenerate('users', 'User');
        $this->resourceGenerate('email_templates', 'Email Template');
        $this->resourceGenerate('themes', 'Theme');
        $this->resourceGenerate('menus', 'Menu');
        $this->resourceGenerate('roles', 'Role');
        
        $postTypes = HookAction::getPostTypes();
        foreach ($postTypes as $type => $postType) {
            $typeSingular = Str::singular($type);
            $this->resourceGenerate(
                "post-type.{$type}",
                $postType->get('label')
            );
            
            $taxonomies = HookAction::getTaxonomies($type);
            foreach ($taxonomies as $key => $taxonomy) {
                $this->resourceGenerate(
                    "taxonomy.{$typeSingular}.{$key}",
                    $taxonomy->get('label')
                );
            }
            
            if (in_array('comment', $postType->get('supports', []))) {
                $this->resourceGenerate(
                    "post-type.{$typeSingular}.comments",
                    $postType->get('label') . ' Comment'
                );
            }
        }
        
        return self::SUCCESS;
    }
    
    protected function resourceGenerate($resource, $name)
    {
        $this->info("-- Generate permission {$name}");
        
        $permissions = $this->resourcePermissions;
        foreach ($permissions as $permission) {
            $group = PermissionGroup::firstOrCreate([
                'name' => $resource,
                'description' => $name,
            ]);
    
            $label = $permission == 'index' ? 'View List' : $permission;
            $permission =  $permission == 'index' ? $resource : "{$resource}.{$permission}";
            Permission::firstOrCreate(
                [
                    'name' => $permission,
                    'group_id' => $group->id,
                    'description' => Str::ucfirst($label) . " {$name}",
                ]
            );
        }
    }
}