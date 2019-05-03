<?php

namespace Modules\Page\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Forms\Fields\Text;
use Modules\Forms\FormModel;
use Modules\Forms\Renderers\Hidden;
use Modules\Page\Entities\Block;
use Modules\Page\Entities\BlockProvider;
use Modules\Page\Entities\Page;
use Modules\Page\Entities\PageRegion;

class ApiBlockController extends Controller
{

	protected function createForm(BlockProvider $provider)
	{
		$form = new FormModel(['url' => '/api/' . Block::urlSegments() . '/save'], ['submit' => ['Save', ['class' => 'btn btn-primary']], 'view' => 'forms.modal', 'title' => 'Add a ' . $provider->name . ' block'], $provider->block_class);
		$form->addField('provider',[
			'type' => Text::class,
			'default' => $provider->id,
			'renderer' => Hidden::class
		]);
		$form->end();
		return $form;
	}

	public function listBlocksForPage(Page $page)
	{
		$regions = $page->regions;
		$out = [];
		foreach($regions as $region){
			$out[$region->id] = [];
			foreach($region->blocks as $block){
				
			}
		}
	}

	public function create(int $providerId)
	{
		$provider = BlockProvider::findOrFail($providerId);
		return [
			'form' => $this->createForm($provider)->renderAsString()
		];
	}

	public function save(Request $request)
	{
		$post = $request->post();
		$provider = BlockProvider::findOrFail($post['provider']);
		$model = new $provider->block_class;
		$validated = $model->validateForm($request, $model->addFormFields());

		Block::unguard();
		$model::unguard();

		$genericBlock = Block::create(['block_provider_id' => $provider->id]);

		$model->formFill($validated);
		$model->block_id = $genericBlock->id;
		$model->save();

		return ['block' => $model];
	}

	public function updateBlocks(Request $request)
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
