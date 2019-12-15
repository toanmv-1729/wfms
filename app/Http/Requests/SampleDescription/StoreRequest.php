<?php

namespace App\Http\Requests\SampleDescription;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project' => 'required|exists:projects,id',
            'slug' => 'required|exists:projects,slug',
            'name' => 'required|max:40',
            'description' => 'required',
        ];
    }
}
