<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Page\Entities\Page;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageWebController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function view(Request $request)
    {
        $page = Page::findBySlug($request->path());
        if (!\Gate::check('view', $page)) {
            throw new NotFoundHttpException;
        }
        return $page->render();
    }
}