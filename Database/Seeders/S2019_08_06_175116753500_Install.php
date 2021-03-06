<?php

use Illuminate\Database\Eloquent\Model;
use Pingu\Core\Seeding\DisableForeignKeysTrait;
use Pingu\Core\Seeding\MigratableSeeder;
use Pingu\Menu\Entities\Menu;
use Pingu\Menu\Entities\MenuItem;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;
use Pingu\Permissions\Entities\Permission;
use Pingu\User\Entities\Role;

class S2019_08_06_175116753500_Install extends MigratableSeeder
{
    use DisableForeignKeysTrait;

    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        Model::unguard();

        $page = Page::create(
            [
            'name' => 'test',
            'slug' => 'test1',
            'layout' => 'layouts.app'
            ]
        );

        $perm1 = Permission::findOrCreate(['name' => 'view pages', 'section' => 'Page']);
        
        Role::find(4)->givePermissionTo(
            [
            $perm1,
            Permission::findOrCreate(['name' => 'edit pages', 'helper' => 'Will need block permissions to manage pages blocks', 'section' => 'Page']),
            Permission::findOrCreate(['name' => 'create pages', 'section' => 'Page']),
            Permission::findOrCreate(['name' => 'delete pages', 'section' => 'Page']),
            Permission::findOrCreate(['name' => 'view unpublished pages', 'section' => 'Page'])
            ]
        );

        MenuItem::create(
            [
            'name' => 'Pages',
            'url' => 'page.admin.index',
            'active' => 1,
            'weight' => 1,
            'deletable' => 0,
            'permission_id' => $perm1->id
            ], 'admin-menu', 'admin-menu.structure'
        );
    }

    /**
     * Reverts the database seeder.
     */
    public function down(): void
    {
        // Remove your data
    }
}
