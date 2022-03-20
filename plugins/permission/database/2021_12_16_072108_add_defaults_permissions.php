<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Juzaweb\Permission\Models\Permission;
use Juzaweb\Permission\Models\PermissionGroup;

class AddDefaultsPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = ['index', 'create', 'edit', 'delete'];

        $resources = [
            'pages',
            'posts',
            'post.categories',
            'post.tags',
            'post.comments',
            'users',
            'email_templates',
            'roles',
            'themes',
            'plugins',
            'menus',
            'widgets',
//            'movies',
//            'movie.genres',
//            'movie.countries',
//            'product.tags',
//            'products',
//            'product.categories',
//            'product.tags',
        ];

        foreach ($resources as $resource) {
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
