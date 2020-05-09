<?php

namespace Pingu\Page\Entities\Uris;

use Pingu\Block\Entities\Block;
use Pingu\Core\Support\Uris\BaseModelUris;

class PageUris extends BaseModelUris
{
    protected function uris(): array
    {
        return [
            'content' => '@slug@/{@slug@}/content',
            'blocks' => '@slug@/{@slug@}/blocks',
            'patchBlocks' => '@slug@/{@slug@}/blocks',
            'addBlock' => '@slug@/{@slug@}/addBlock/{'.Block::routeSlug().'}',
            'deleteBlock' => '@slug@/{@slug@}/deleteBlock/{'.Block::routeSlug().'}'
        ];
    }
}