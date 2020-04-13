<?php

namespace Pingu\Page\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Pingu\Page\Entities\BlockPage;

class ClearPageBlockCache
{
    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        if ($blockPage = BlockPage::where('block_id', $event->block->id)->first()) {
            \Pages::clearBlockCache(\Pages::getById($blockPage->page_id));
        }
    }
}