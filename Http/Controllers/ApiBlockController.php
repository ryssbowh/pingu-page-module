<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Contracts\ApiModelController as ApiModelControllerContract;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\ApiModelController;
use Pingu\Forms\Fields\Text;
use Pingu\Forms\FormModel;
use Pingu\Forms\Renderers\Hidden;
use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageRegion;

class ApiBlockController extends BaseController implements ApiModelControllerContract
{
	use ApiModelController;

	public function getModel(): string
	{
		return Block::class;
	}

	public function create(Request $request): array
	{
		$provider = $request->route()->parameter(BlockProvider::routeSlug());
		$form = new FormModel(
			['url' => '/api/' . Block::routeSlugs() . '/save'], 
			['submit' => ['Save'], 'view' => 'forms.modal', 'title' => 'Add a ' . $provider->name . ' block'], 
			$provider->block_class
		);
		$form->addField('provider',[
			'type' => Text::class,
			'default' => $provider->id,
			'renderer' => Hidden::class
		]);
		$form->end();
		return ['form' => $form->renderAsString()];
	}

	public function index(Page $page)
	{
		$regions = $page->page_layout->regions;
		$out = [];
		foreach($regions as $region){
			$out[$region->id] = [];
			foreach($region->getBlocks() as $block){
				$blockBuild = $block->loadBlock()->toArray();
				$blockBuild['provider'] = $block->block_provider->toArray();
				$out[$region->id][] = $blockBuild;
			}
		}
		return $out;
	}

	public function store(Request $request): array
	{
		$post = $request->post();
		$provider = BlockProvider::findOrFail($post['provider']);
		$model = new $provider->block_class;
		$validated = $model->validateForm($post, $model->addFormFields());

		Block::unguard();
		$model::unguard();

		$genericBlock = Block::create(['block_provider_id' => $provider->id]);

		$model->formFill($validated);
		$model->block_id = $genericBlock->id;
		$model->save();

		return $this->onStoreSuccess($request, $model);
	}

	public function update(Request $request)
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

}
