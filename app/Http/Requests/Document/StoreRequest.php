<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckValidDataInProjectsTable;

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
            'project' => [
                'required',
                new CheckValidDataInProjectsTable($this->project, $this->slug),
            ],
            'slug' => 'required|exists:projects,slug',
            'name' => 'required|string|max:40',
            'parent' => 'nullable|exists:documents,uuid',
            'link' => 'required_if:type,on|nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'project.*' => 'Add Document Error!',
            'slug.*' => 'Add Document Error!',
            'parent.*' => 'Add Document Error!',
            'link.required' => 'Link Document cannot be blank!',
        ];
    }
}
