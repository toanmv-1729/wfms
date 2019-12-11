<?php

namespace App\Http\Requests\Version;

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
            'project' => 'required',
            'name' => 'required|string|max:20',
            'description' => 'string',
            'slug' => 'required|exists:projects,slug',
            'daterange' => 'required|string',
        ];
    }
}
