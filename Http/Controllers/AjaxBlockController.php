<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Block\Entities\Block;
use Pingu\Block\Entities\BlockProvider;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Http\Controllers\AjaxModelController;
use Pingu\Forms\Fields\Text;
use Pingu\Forms\FormModel;
use Pingu\Forms\Renderers\Hidden;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageRegion;

class AjaxBlockController extends AjaxModelController
{
    public function getModel(): string
    {
        return Block::class;
    }

    public function create(): array
    {
        $provider = $this->request->route()->parameter(BlockProvider::routeSlug());
        $form = new FormModel(
            ['url' => Block::makeUri('store', [$provider], ajaxPrefix())], 
            ['submit' => ['Save'], 'view' => 'forms.modal', 'title' => 'Add a ' . $provider->name . ' block'], 
            $provider->class
        );
        $form->end();
        return ['html' => $form->renderAsString()];
    }

    public function store(): array
    {
        $post = $this->request->post();
        $provider = $this->request->route()->parameter(BlockProvider::routeSlug());
        $model = new $provider->class;
        $validated = $model->validateStoreRequest($post);

        Block::unguard();
        $model::unguard();

        $model->formFill($validated)->save();

        $block = new Block(
            [
            'system' => false
            ]
        );
        $block->provider()->associate($provider);
        $block->instance()->associate($model);
        $block->save();

        return $this->onStoreSuccess($request, $block);
    }

    public function edit(BaseModel $block):array
    {
        $form = new FormModel(
            ['url' => Block::makeUri('update', [$block], ajaxPrefix()), 'method' => 'put'], 
            ['submit' => ['Save'], 'view' => 'forms.modal', 'title' => 'Edit a ' . $block->instance->name . ' block'], 
            $block->instance
        );
        $form->end();
        return ['html' => $form->renderAsString()];
    }

    public function update(BaseModel $block): array
    {   
        $validated = $this->validateUpdateRequest($block->instance);

        try{
            $block->instance->saveFields($validated);
        }
        catch(ModelNotSaved $e){
            $this->onUpdateFailure($block, $e);
        }
        catch(ModelRelationsNotSaved $e){
            $this->onUpdateRelationshipsFailure($block, $e);
        }

        return $this->onSuccessfullUpdate($block);
    }

}
