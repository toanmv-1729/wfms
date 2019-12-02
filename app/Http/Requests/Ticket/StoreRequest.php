<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Contracts\Repositories\ProjectRepository;

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
        $project = app(ProjectRepository::class)->getProjectInfo($this->project, ['id', 'slug']);
        $ticketIds = $project->tickets->pluck('id')->toArray();
        $assigneeIds = $project->users->pluck('id')->toArray();
        $teamIds = $project->teams->pluck('id')->toArray();
        $versionIds = $project->versions->pluck('id')->toArray();

        return [
            'tracker' => 'required|integer|in:1,2,3',
            'priority' => 'required|integer|in:1,2,3,4,5',
            'pid' => 'required|integer|in:' . $project->id,
            'parent' => [
                'integer',
                Rule::in($ticketIds),
            ],
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|integer|in:1,2,3,4,5,6,7',
            'assignee' => [
                'required',
                'integer',
                Rule::in($assigneeIds),
            ],
            'team' => [
                'required',
                'integer',
                Rule::in($teamIds),
            ],
            'version' => [
                'required',
                'integer',
                Rule::in($versionIds),
            ],
            'start_date' => 'required|date_format:Y-m-d',
            'due_date' => 'required|date_format:Y-m-d',
            'estimated_time' => 'required|integer|min:0',
            'spend_time' => 'nullable|integer|min:0',
            'progress' => 'required|integer|in:0,10,20,30,40,50,60,70,80,90,100',
        ];
    }

    public function attributes()
    {
        return [
            'tracker' => 'Tracker',
            'priority' => 'Priority',
            'parent' => 'Ticket Parent',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'assignee' => 'Assignee',
            'team' => 'Team',
            'version' => 'Version',
            'start_date' => 'Start Date',
            'due_date' => 'Due Date',
            'estimated_time' => 'Estimated Time',
            'spend_time' => 'Spend Time',
            'progress' => 'Progress',
        ];
    }

    public function messages()
    {
        return [
            'pid.required' => 'Error when create new ticket. Please make another data!',
            'pid.integer' => 'Error when create new ticket. Please make another data!',
            'pid.in' => 'Error when create new ticket. Please make another data!',
            '*.required' => __(':attribute cannot be blank.'),
        ];
    }
}
