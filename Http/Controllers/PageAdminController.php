<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Validation\Validator;
use Pingu\Block\Entities\Block;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\Entity;
use Pingu\Entity\Http\Controllers\AdminEntityController;
use Pingu\Page\Entities\Page;

class PageAdminController extends AdminEntityController
{
    /**
     * Creates the validator for a store request
     * 
     * @return Validator
     */
    protected function getStoreValidator(Entity $entity, ?BundleContract $bundle): Validator
    {
        $validator = $entity->validator()->makeValidator($this->request->except('_token'), false);
        $validator->after(
            function ($validator) {
                $slug = $validator->getData()['slug'];
                if (route_exists($slug)) {
                    $validator->errors()->add('slug', 'The route '.$slug.' already exists');
                }
            }
        );
        return $validator;
    }

    public function content(Page $page)
    {
        \ContextualLinks::addFromObject($page);
        return view('pages.page.content')->with(
            [
            'page' => $page,
            'blocks' => \Blocks::registeredBlocksBySection(),
            'blockModel' => Block::class,
            'saveBlocksUri' => Page::uris()->make('patchBlocks', $page, adminPrefix())
            ]
        );
    }   
}