<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Page\BlockProviders\BlockTextProvider;
use Modules\Page\Entities\Block;
use Modules\Page\Entities\BlockProvider;
use Modules\Page\Entities\BlockText;
use Modules\Page\Entities\Page;
use Modules\Page\Entities\PageLayout;
use Modules\Page\Entities\PageRegion;

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
            $layout = Pagelayout::create([
                'name' => 'One column'
            ]);
            $region = PageRegion::firstOrCreate(
                ['name' => 'Content'],
                [
                    'width' => 100, 
                    'height' => 400, 
                    'page_layout_id' => $layout->id
                ]
            );
            $page = Page::create(
                ['name' => 'test'
                    'slug' => 'test1', 
                    'page_layout_id' => $layout->id
                ]
            );

            $provider = BlockProvider::firstOrCreate(
                ['class' => BlockTextProvider::class],
                [
                    'name' => 'Text', 
                    'block_class' => BlockText::class, 
                    'system' => false
                ]
            );

            $block = Block::create([
                'block_provider_id' => $provider->id
            ]);

            $textBlock = BlockText::create([
                'block_id' => $block->id,
                'text' => 'My First Block',
                'name' => 'First block'
            ]);
        }
    }
}
