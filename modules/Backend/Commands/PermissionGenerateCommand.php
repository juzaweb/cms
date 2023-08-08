<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Commands;

use Illuminate\Console\Command;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Models\Permission;

class PermissionGenerateCommand extends Command
{
    protected $signature = 'permission:generate';

    protected $description = 'Generate all permissions.';

    public function handle(): int
    {
        do_action(Action::PERMISSION_INIT);

        $permissions = HookAction::getPermissions();

        $exists = Permission::whereIn(
            'name',
            $permissions->pluck('name')->toArray()
        )
            ->get(['name'])
            ->pluck('name')
            ->toArray();

        $permissions = $permissions
            ->whereIn(
                'name',
                $permissions->whereNotIn('name', $exists)->toArray()
            );

        foreach ($permissions as $item) {
            Permission::create(
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                ]
            );
        }

        /*$postTypes = HookAction::getPostTypes();
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
        }*/

        return self::SUCCESS;
    }
}
