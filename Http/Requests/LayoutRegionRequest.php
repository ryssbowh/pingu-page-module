<?php

namespace Modules\Page\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LayoutRegionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'regions' => 'required',
            'regions.*.id' => 'sometimes|exists:page_regions,id',
            'regions.*.name' => 'required',
            'regions.*.width' => 'numeric',
            'regions.*.height' => 'numeric',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'regions.required' => 'Create at least one region',
            'regions.*.id' => 'Region id is not valid',
            'regions.*.name' => 'Name is required',
            'regions.*.width' => 'Width must be numeric',
            'regions.*.height' => 'Height must be numeric'
        ];
    }
}
