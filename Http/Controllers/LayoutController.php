<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Contracts\ModelController as ModelControllerContract;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\ModelController;
use Pingu\Jsgrid\Contracts\JsGridController as JsGridControllerContract;
use Pingu\Jsgrid\Traits\JsGridController;
use Pingu\Page\Entities\PageLayout;
use Auth;

class LayoutController extends BaseController implements ModelControllerContract, JsGridControllerContract
{
	use JsGridController, ModelController;

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
