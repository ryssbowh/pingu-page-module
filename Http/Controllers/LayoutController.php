<?php

namespace Pingu\Page\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Pingu\Core\Contracts\Controllers\HandlesModelContract;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\Controllers\HandlesModel;
use Pingu\Jsgrid\Contracts\Controllers\JsGridContract;
use Pingu\Jsgrid\Traits\Controllers\JsGrid;
use Pingu\Page\Entities\PageLayout;

class LayoutController extends BaseController implements HandlesModelContract, JsGridContract
{
    use HandlesModel, JsGrid;

	public function getModel():string
	{
		return PageLayout::class;
	}

	/**
     * @inheritDoc
     */
    protected function canClick()
    {
    	return Auth::user()->can('edit layouts');
    }

    /**
     * @inheritDoc
     */
    protected function canEdit()
    {
        return $this->canClick();
    }

    /**
     * @inheritDoc
     */
    protected function canDelete()
    {
    	return Auth::user()->can('delete layouts');
    }

    /**
     * @inheritDoc
     */
	public function index(Request $request)
	{
		$options['jsgrid'] = $this->buildJsGridView($request);
		$options['title'] = str_plural(PageLayout::friendlyName());
		$options['canSeeAddLink'] = Auth::user()->can('add layouts');
		$options['addLink'] = '/admin/'.PageLayout::routeSlugs().'/create';
		
		return view('pages.listModel-jsGrid', $options);
	}
}
