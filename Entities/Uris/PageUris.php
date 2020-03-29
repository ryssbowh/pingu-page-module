<?php

namespace Pingu\Page\Entities\Uris;

use Pingu\Block\Entities\Block;
use Pingu\Entity\Support\Uris\BaseEntityUris;

class PageUris extends BaseEntityUris
{
    protected function uris(): array
    {
        return [
            'content' => '@entity/{@entity}/content',
            'blocks' => '@entity/{@entity}/blocks',
            'patchBlocks' => '@entity/{@entity}/blocks',
            'addBlock' => '@entity/{@entity}/addBlock/{'.Block::routeSlug().'}',
            'deleteBlock' => '@entity/{@entity}/deleteBlock/{'.Block::routeSlug().'}'
        ];
    }
}