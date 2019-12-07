<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Page\Entities\Page;
use Pingu\Core\Http\Controllers\BaseController;

class DbPageController extends BaseController
{
    public function view(Page $page)
    {
        return view('page::page')->with([
            'page' => $page,
            'blocks' => \Pages::blocks($page, true)
        ]);
    }
}
