<?php

namespace App\Traits;

use App\Models\TicketHistory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\TeamRepository;
use App\Contracts\Repositories\TicketRepository;
use App\Contracts\Repositories\VersionRepository;

trait TracksHistoryTrait
{
    protected function track(Model $model, callable $func = null, $table = null, $id = null)
    {
        // Allow for overriding of table if it's not the model table
        $table = $table ?: $model->getTable();
        // Allow for overriding of id if it's not the model id
        $id = $id ?: $model->id;
        // Allow for customization of the history record if needed
        $func = $func ?: [$this, 'getHistoryBody'];
        $beforeUpdated = $model->getOriginal();
        // Get the dirty fields and run them through the custom function, then insert them into the history table
        $this->getUpdated($model)
             ->map(function ($value, $field) use ($func, $beforeUpdated) {
                $data = $this->convertData($beforeUpdated, $field, $value);
                return call_user_func_array($func, $data);
             })
             ->each(function ($fields) use ($table, $id) {
                TicketHistory::create([
                    'ticket_id' => $id,
                    'user_id' => \Auth::user()->id,
                ] + $fields);
             });
    }

    protected function getHistoryBody($oldValue, $newValue, $field)
    {
        return [
            'content' => "{$field} changed from {$oldValue} to ${newValue}",
        ];
    }

    protected function convertData($beforeUpdated, $field, $value)
    {
        switch ($field) {
            case 'team id':
                $newValue = app(TeamRepository::class)->find($value)->name;
                $oldValue = app(TeamRepository::class)->find(array_get($beforeUpdated, 'team_id'))->name;
                $field = '<strong>Team</strong>';
                break;
            case 'version id':
                $newValue = app(VersionRepository::class)->find($value)->name;
                $oldValue = app(VersionRepository::class)->find(array_get($beforeUpdated, 'version_id'))->name;
                $field = '<strong>Version</strong>';
                break;
            case 'ticket parent id':
                $newValue = '#' . app(TicketRepository::class)->find($value)->id;
                $oldValue = '#' . app(TicketRepository::class)->find(array_get($beforeUpdated, 'ticket_parent_id'))->id;
                $field = '<strong>Ticket Parent</strong>';
                break;
            case 'assignee id':
                $newValue = app(UserRepository::class)->find($value)->name;
                $oldValue = app(UserRepository::class)->find(array_get($beforeUpdated, 'assignee_id'))->name;
                $field = '<strong>Assignee</strong>';
                break;
            case 'title':
                $newValue = $value;
                $oldValue = array_get($beforeUpdated, 'title');
                $field = '<strong>Title</strong>';
                break;
            case 'description':
                $newValue = $value;
                $oldValue = array_get($beforeUpdated, 'description');
                $field = '<strong>Description</strong>';
                break;
            case 'tracker':
                $newValue = config('ticket.tracker')[$value]['name'];
                $oldValue = config('ticket.tracker')[array_get($beforeUpdated, 'tracker')]['name'];
                $field = '<strong>Tracker</strong>';
                break;
            case 'status':
                $newValue = config('ticket.status')[$value]['name'];
                $oldValue = config('ticket.status')[array_get($beforeUpdated, 'status')]['name'];
                $field = '<strong>Status</strong>';
                break;
            case 'priority':
                $newValue = config('ticket.priority')[$value]['name'];
                $oldValue = config('ticket.priority')[array_get($beforeUpdated, 'status')]['name'];
                $field = '<strong>Priority</strong>';
                break;
            case 'start date':
                $newValue = Carbon::parse($value)->format('d/m/Y');
                $oldValue = Carbon::parse(array_get($beforeUpdated, 'start_date'))->format('d/m/Y');
                $field = '<strong>Start Date</strong>';
                break;
            case 'due date':
                $newValue = Carbon::parse($value)->format('d/m/Y');
                $oldValue = Carbon::parse(array_get($beforeUpdated, 'due_date'))->format('d/m/Y');
                $field = '<strong>Due Date</strong>';
                break;
            case 'estimated time':
                $newValue = $value;
                $oldValue = array_get($beforeUpdated, 'estimated_time');
                $field = '<strong>Estimated Time</strong>';
                break;
            case 'spend time':
                $newValue = $value;
                $oldValue = array_get($beforeUpdated, 'spend_time');
                $field = '<strong>Spend Time</strong>';
                break;
            case 'progress':
                $newValue = $value;
                $oldValue = array_get($beforeUpdated, 'progress');
                $field = '<strong>Progress</strong>';
                break;
        }

        return [$oldValue, $newValue, $field];
    }

    protected function getUpdated($model)
    {
        return collect($model->getDirty())->filter(function ($value, $key) {
            // We don't care if timestamps are dirty, we're not tracking those
            return !in_array($key, ['created_at', 'updated_at']);
        })->mapWithKeys(function ($value, $key) {
            // Take the field names and convert them into human readable strings for the description of the action
            // e.g. first_name -> first name
            return [str_replace('_', ' ', $key) => $value];
        });
    }
}
