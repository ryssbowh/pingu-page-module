<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Jsgrid\Http\Controllers\JsGridController;
use Pingu\Page\Entities\Page;

class JsGridPageController extends JsGridController
{
	public function getModel():string
	{
		return Page::class;
	}

	/**
     * @inheritDoc
     */
    protected function canClick()
    {
    	return \Auth::user()->can('edit pages');
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
    	return \Auth::user()->can('delete pages');
    }

    /**
     * @inheritDoc
     */
	public function index()
	{
		$options['jsgrid'] = $this->buildJsGridView($this->request);
		$options['title'] = str_plural(Page::friendlyName());
		$options['canSeeAddLink'] = \Auth::user()->can('add pages');
		$options['addLink'] = '/admin/'.Page::routeSlugs().'/create';
		
		return view('pages.listModel-jsGrid', $options);
	}
}
