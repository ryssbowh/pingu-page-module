<?php

namespace Pingu\Page\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Pingu\Menu\Entities\Menu;
use Pingu\Menu\Entities\MenuItem;
use Pingu\Page\BlockProviders\BlockTextProvider;
use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\BlockText;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;
use Pingu\Permissions\Entities\Permission;
use Pingu\User\Entities\Role;

class PageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $layout = PageLayout::where('name', 'One column')->get();

        if($layout->isEmpty()){

            $layout = PageLayout::create([
                'name' => 'One column'
            ]);

            $region = PageRegion::create([
                'name' => 'Content',
                'width' => 100, 
                'height' => 400, 
                'page_layout_id' => $layout->id 
            ]);

            $provider = BlockProvider::create([
                'name' => 'Text',
                'system' => false,
                'class' => BlockText::class
            ]);

            $page = Page::create([
                'name' => 'test',
                'slug' => 'test1', 
                'page_layout_id' => $layout->id
            ]);

            $block = new Block([
                'system' => false
            ]);
            $block->provider()->associate($provider);

            $textBlock = BlockText::create([
                'text' => 'My First Block',
                'name' => 'First block'
            ]);
            $textBlock->block()->save($block);
        }

        $perm1 = Permission::findOrCreate(['name' => 'view pages', 'section' => 'Page']);
        $perm2 = Permission::findOrCreate(['name' => 'view layouts', 'section' => 'Page']);
        
        Role::find(4)->givePermissionTo([
            $perm1,
            $perm2,
            Permission::findOrCreate(['name' => 'edit pages', 'section' => 'Page']),
            Permission::findOrCreate(['name' => 'add pages', 'section' => 'Page']),
            Permission::findOrCreate(['name' => 'delete pages', 'section' => 'Page']),
            Permission::findOrCreate(['name' => 'add layouts', 'section' => 'Page']),
            Permission::findOrCreate(['name' => 'edit layouts', 'section' => 'Page']),
            Permission::findOrCreate(['name' => 'delete layouts', 'section' => 'Page']),
            Permission::findOrCreate(['name' => 'view layouts regions', 'section' => 'Page']),
            Permission::findOrCreate(['name' => 'manage layouts regions', 'section' => 'Page']),
            Permission::findOrCreate(['name' => 'view pages blocks', 'section' => 'Page']),
            Permission::findOrCreate(['name' => 'manage pages blocks', 'section' => 'Page']),
        ]);

        $menu = Menu::findByName('admin-menu');
        $structure = MenuItem::findByName('admin-menu.structure');
        MenuItem::create([
            'name' => 'Pages',
            'url' => 'page.admin.pages',
            'active' => 1,
            'weight' => 1,
            'deletable' => 0,
            'permission_id' => $perm1->id
        ], $menu, $structure);
        MenuItem::create([
            'name' => 'Layouts',
            'weight' => 2,
            'active' => 1,
            'deletable' => 0,
            'url' => 'page.admin.layouts',
            'permission_id' => $perm2->id
        ], $menu, $structure);
    }
}
