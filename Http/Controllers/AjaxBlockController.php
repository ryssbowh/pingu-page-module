<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Contracts\AjaxModelController as AjaxModelControllerContract;
use Pingu\Core\Contracts\Controllers\HandlesAjaxModelContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\AjaxModelController;
use Pingu\Core\Traits\Controllers\HandlesAjaxModel;
use Pingu\Forms\Contracts\FormableModel;
use Pingu\Forms\Fields\Text;
use Pingu\Forms\FormModel;
use Pingu\Forms\Renderers\Hidden;
use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageRegion;

class AjaxBlockController extends BaseController implements HandlesAjaxModelContract
{
    use HandlesAjaxModel;

	public function getModel(): string
	{
		return Block::class;
	}

	public function create(Request $request): array
	{
		$provider = $request->route()->parameter(BlockProvider::routeSlug());
		$form = new FormModel(
			['url' => Block::transformAjaxUri('store', [$provider], true)], 
			['submit' => ['Save'], 'view' => 'forms.modal', 'title' => 'Add a ' . $provider->name . ' block'], 
			$provider->class
		);
		$form->end();
		return ['form' => $form->renderAsString()];
	}

	public function index(Request $request): array
	{
		$page = $request->route()->parameter(Page::routeSlug());
		$regions = $page->page_layout->regions;
		$out = [];
		foreach($regions as $region){
			foreach($region->blocks as $block){
				$out[$region->id][] = $block->toArray();
			}
		}
		return $out;
	}

	public function store(Request $request): array
	{
		$post = $request->post();
		$provider = $request->route()->parameter(BlockProvider::routeSlug());
		$model = new $provider->class;
		$validated = $model->validateForm($post, $model->getAddFormFields(), false);

		Block::unguard();
		$model::unguard();

		$model->formFill($validated)->save();

		$block = new Block([
            'system' => false
        ]);
        $block->provider()->associate($provider);
		$block->instance()->associate($model);
		$block->save();

		return $this->onStoreSuccess($request, $block);
	}

	public function patch(Request $request): array
	{
		$regions = $request->post()['regions'];
		foreach($regions as $row){
			$region = PageRegion::findOrFail($row['region']);
			$region->blocks()->detach();
			if(isset($row['blocks'])){
				foreach($row['blocks'] as $weight => $id){
					$block = Block::findOrFail($id);
					$region->blocks()->attach($block, ['weight' => $weight]);
				}
			}
		}

		return ['message' => 'Blocks have been saved'];
	}

	public function edit(Request $request, BaseModel $block):array
	{
		$form = new FormModel(
			['url' => Block::transformAjaxUri('update', [$block], true), 'method' => 'put'], 
			['submit' => ['Save'], 'view' => 'forms.modal', 'title' => 'Edit a ' . $block->instance->name . ' block'], 
			$block->instance
		);
		$form->end();
		return ['form' => $form->renderAsString()];
	}

	public function update(Request $request, BaseModel $block): array
	{	
		$validated = $this->validateUpdateRequest($request, $block->instance);

		try{
			$block->instance->saveWithRelations($validated);
		}
		catch(ModelNotSaved $e){
			$this->onUpdateFailure($request, $block, $e);
		}
		catch(ModelRelationsNotSaved $e){
			$this->onUpdateRelationshipsFailure($request, $block, $e);
		}

		return $this->onSuccessfullUpdate($request, $block);
	}

}