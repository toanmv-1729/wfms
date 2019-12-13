<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Contracts\Repositories\ProjectRepository;

class CheckValidDataInProjectsTable implements Rule
{
    protected $projectId;
    protected $slug;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $projectId, $slug)
    {
        $this->projectId = $projectId;
        $this->slug = $slug;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $project = app(ProjectRepository::class)->find($this->projectId);

        return $project && $project->slug === $this->slug;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Add document error!';
    }
}
