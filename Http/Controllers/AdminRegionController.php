<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Support\Collection;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Http\Controllers\AdminModelController;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageRegion;

class AdminRegionController extends AdminModelController
{
	use RegionController;

	protected function onStoreSuccess(BaseModel $model)
    {
        return redirect($model::makeUri('index', $model->page, adminPrefix()));
    }

    protected function onDeleteSuccess(BaseModel $model)
	{
		return redirect($model::makeUri('index', $model->page, adminPrefix()));
	}

	protected function onPatchSuccess(Collection $models)
	{
		return redirect(PageRegion::makeUri('index', $models->first()->page, adminPrefix()));
	}

    public function index(...$parameters)
	{
		$page = $parameters[0];
		\ContextualLinks::addModelLinks($page);
		return view('page::page_layout')->with([
			'regions' => $page->regions,
			'page' => $page,
			'addRegionUri' => PageRegion::makeUri('create', $page, adminPrefix()),
			'saveRegionUri' => PageRegion::makeUri('patch', $page, adminPrefix()),
			'deleteRegionUri' => PageRegion::getUri('delete', adminPrefix())
		]);
	}
}
