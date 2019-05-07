<?php

namespace Pingu\Page\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Pingu\Page\BlockProviders\BlockTextProvider;
use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\BlockText;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;
use Pingu\Permissions\Entities\Permission;

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

            $page = Page::create([
                'name' => 'test',
                'slug' => 'test1', 
                'page_layout_id' => $layout->id
            ]);

            $provider = BlockProvider::create([
                'class' => BlockTextProvider::class,
                'name' => 'Text', 
                'block_class' => BlockText::class, 
                'system' => false
            ]);

            $block = Block::create([
                'block_provider_id' => $provider->id
            ]);

            $textBlock = BlockText::create([
                'block_id' => $block->id,
                'text' => 'My First Block',
                'name' => 'First block'
            ]);
        }

        Permission::findOrCreate(['name' => 'manage pages', 'section' => 'Page']);
        Permission::findOrCreate(['name' => 'edit pages', 'section' => 'Page']);
        Permission::findOrCreate(['name' => 'add pages', 'section' => 'Page']);
        Permission::findOrCreate(['name' => 'delete pages', 'section' => 'Page']);

        Permission::findOrCreate(['name' => 'manage layouts', 'section' => 'Page']);
        Permission::findOrCreate(['name' => 'add layouts', 'section' => 'Page']);
        Permission::findOrCreate(['name' => 'edit layouts', 'section' => 'Page']);
        Permission::findOrCreate(['name' => 'delete layouts', 'section' => 'Page']);
        Permission::findOrCreate(['name' => 'add regions to layouts', 'section' => 'Page']);
        Permission::findOrCreate(['name' => 'remove regions from layouts', 'section' => 'Page']);

        Permission::findOrCreate(['name' => 'add blocks to layouts', 'section' => 'Page']);
        Permission::findOrCreate(['name' => 'delete blocks from layouts', 'section' => 'Page']);
    }
}
