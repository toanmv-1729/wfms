<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckUniqueContributorsInProject;

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
        $rules = [
            'name' => 'required|unique:projects',
            'description' => 'required',
            'root_folder_link' => 'url|unique:projects',
            'repository_link' => 'url|unique:projects',
            'image' => 'image',
            'users' => [
                'required',
                new CheckUniqueContributorsInProject($this->users),
            ],
        ];

        return $rules;
    }
}
