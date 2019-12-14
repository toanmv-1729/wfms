@extends('layouts.app')

@push('css')
    <link href="{{ asset('vendor/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .select-tracker {
            width: 120px;
        }
        .select-priority {
            width: 150px;
        }
        .select-status {
            width: 120px;
        }
        .select-assignee {
            width: 200px;
        }
        .select-team {
            width: 200px;
        }
        .select-version {
            width: 200px;
        }
        .select-start-date {
            width: 410px;
        }
        .select-due-date {
            width: 470px;
        }
        .select-progress {
            width: 80px;
        }
        .form-label {
            color: #000000;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-12 align-self-center">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-themecolor m-b-0 m-t-0">{{ config('ticket.tracker')[$ticket->tracker]['name'] }} #{{ $ticket->id }}: {{ $ticket->title }}</h3>
                    <br>
                    <form class="form-material m-t-10" action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Tracker: </label>&nbsp;&nbsp;
                            <select class="select2 form-control select-tracker" name="tracker">
                                @foreach(config('ticket.tracker') as $keyTracker => $tracker)
                                    <option
                                        {{ $ticket->tracker === $keyTracker ? 'selected' : '' }}
                                        value="{{ $keyTracker }}">{{ $tracker['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="form-label m-l-30">Priority: </label>&nbsp;
                            <select class="select2 form-control select-priority" name="priority">
                                @foreach(config('ticket.priority') as $keyPriority => $priority)
                                    <option
                                        {{ $ticket->priority === $keyPriority ? 'selected' : '' }}
                                        value="{{ $keyPriority }}">{{ $priority['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="form-label m-l-30">Ticket Parent: </label>&nbsp;
                            <select class="select2 form-control select-priority" name="parent">
                                <option selected="" value=""></option>
                                @foreach($ticket->project->tickets as $ticketParent)
                                    @if ($ticketParent->id != $ticket->id)
                                    <option
                                        {{ $ticketParent->id === $ticket->ticket_parent_id ? 'selected' : '' }}
                                        value="{{ $ticketParent->id }}"
                                        tooltip="{{ $ticketParent->title }}"
                                    >
                                        #{{ $ticketParent->id }}: {{ str_limit($ticketParent->title, 20) }}
                                    </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" value="{{ $ticket->project_id }}" name="pid">
                        <input type="hidden" value="{{ $ticket->project->slug }}" name="project">
                        <div class="form-group">
                            <label class="form-label">Title: </label>
                            <input type="text" name="title" value="{{ $ticket->title }}" class="form-control form-control-line" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description: </label>
                            <textarea id="mymce" name="description"  value="{{ $ticket->description }}"  class="form-control form-control-line">{{ $ticket->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status: </label>&nbsp;&nbsp;
                            <select class="select2 form-control select-status" name="status">
                                @foreach(config('ticket.status') as $keyStatus => $status)
                                    <option {{ $ticket->status === $keyStatus ? 'selected' : '' }} value="{{ $keyStatus }}">{{ $status['name'] }}</option>
                                @endforeach
                            </select>
                            <label class="form-label m-l-30">Assignee: </label>&nbsp;
                            <select class="select2 form-control select-assignee" name="assignee">
                                @foreach($ticket->project->users as $user)
                                    <option {{ $ticket->assignee_id === $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label m-l-30">Team: </label>&nbsp;
                            <select class="select2 form-control select-team" name="team">
                                @foreach($ticket->project->teams as $team)
                                    <option {{ $ticket->team_id === $team->id ? 'selected' : ''}} value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label m-l-30">Version: </label>&nbsp;
                            <select class="select2 form-control select-version" name="version">
                                @foreach($ticket->project->versions as $version)
                                    <option {{ $ticket->version_id === $version->id ? 'selected' : '' }} value="{{ $version->id }}">{{ $version->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Start Date: </label>&nbsp;&nbsp;
                            <input type="text" name="start_date" value="{{ $ticket->start_date }}" class="form-control select-start-date" id="mstartdate">
                            <label class="form-label" style="margin-left: 30px;">Due Date: </label>&nbsp;&nbsp;
                            <input type="text" name="due_date" value="{{ $ticket->due_date }}" class="form-control select-due-date" id="mduedate">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Estimated Time (hours): </label>&nbsp;&nbsp;&nbsp;
                            <input type="text" name="estimated_time" value="{{ $ticket->estimated_time }}" class="form-control form-control-line" style="width: 300px;">
                            <label class="form-label" style="margin-left: 30px;">Spend Time (hours): </label>&nbsp;&nbsp;&nbsp;
                            <input type="text" name="spend_time" class="form-control form-control-line" style="width: 230px;">
                            <label class="form-label" style="margin-left: 10px;">% Done: </label>
                            <select class="select2 form-control select-progress" name="progress">
                                @foreach (config('ticket.progress') as $progress)
                                <option {{ $ticket->progress === $progress ? 'selected' : '' }} value="{{ $progress }}">{{ $progress }} %</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-rounded btn-info m-t-20">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendor/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/plugins/moment/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/plugins/tinymce/tinymce.min.js') }}" type="text/javascript"></script>
<script>
    $(".select2").select2();
    $('#mstartdate').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false
    });
    $('#mduedate').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false
    });
</script>
<script>
    $(document).ready(function() {
        if ($("#mymce").length > 0) {
            tinymce.init({
                selector: "textarea#mymce",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
            });
        }
    });
</script>
@endpush
