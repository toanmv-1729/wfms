<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckUniqueContributorsInProject;
use App\Rules\CheckRequiredProductOwnerProject;

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
            'name' => 'required',
            'description' => 'required',
            'root_folder_link' => 'url',
            'repository_link' => 'url',
            'image' => 'image|max:1024',
            'users' => [
                'required',
                new CheckUniqueContributorsInProject($this->users),
                new CheckRequiredProductOwnerProject($this->user(), $this->users),
            ],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'users.required' => 'Product Owner cannot be blank!',
        ];
    }
}
