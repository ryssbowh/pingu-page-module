<?php

namespace Pingu\Page\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Pingu\Block\Events\BlockCacheChanged;
use Pingu\Page\Listeners\ClearPageBlockCache;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        BlockCacheChanged::class => [
            ClearPageBlockCache::class
        ]
    ];
}