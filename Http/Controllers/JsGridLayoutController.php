<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Jsgrid\Http\Controllers\JsGridController;
use Pingu\Page\Entities\PageLayout;

class JsGridLayoutController extends JsGridController
{
	public function getModel():string
	{
		return PageLayout::class;
	}

	/**
     * @inheritDoc
     */
    protected function canClick()
    {
    	return \Auth::user()->can('edit layouts');
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
    	return \Auth::user()->can('delete layouts');
    }

    /**
     * @inheritDoc
     */
	public function index()
	{
		$options['jsgrid'] = $this->buildJsGridView($this->request);
		$options['title'] = str_plural(PageLayout::friendlyName());
		$options['canSeeAddLink'] = \Auth::user()->can('add layouts');
		$options['addLink'] = '/admin/'.PageLayout::routeSlugs().'/create';
		
		return view('pages.listModel-jsGrid', $options);
	}
}
