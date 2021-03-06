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
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">New Ticket</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-material m-t-10" action="{{ route('tickets.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Tracker: </label>&nbsp;&nbsp;
                            <select class="select2 form-control select-tracker" name="tracker">
                                @foreach(config('ticket.tracker') as $keyTracker => $tracker)
                                    <option value="{{ $keyTracker }}">{{ $tracker['name'] }}</option>
                                @endforeach
                            </select>
                            <label class="form-label m-l-30">Priority: </label>&nbsp;
                            <select class="select2 form-control select-priority" name="priority">
                                @foreach(config('ticket.priority') as $keyPriority => $priority)
                                    <option value="{{ $keyPriority }}">{{ $priority['name'] }}</option>
                                @endforeach
                            </select>
                            <label class="form-label m-l-30">Ticket Parent: </label>&nbsp;
                            @if (!empty($ticketParent))
                            <select class="select2 form-control select-priority" name="parent" disabled="true">
                                <option selected="" value="{{ $ticketParent->id }}">#{{ $ticketParent->id }}: {{ str_limit($ticketParent->title, 20) }}</option>
                            </select>
                            @else
                            <select class="select2 form-control select-priority" name="parent">
                                <option selected=""></option>
                                @foreach($project->tickets as $ticket)
                                    <option value="{{ $ticket->id }}">#{{ $ticket->id }}: {{ str_limit($ticket->title, 20) }}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                        <input type="hidden" value="{{ $project->id }}" name="pid">
                        <input type="hidden" value="{{ $project->slug }}" name="project">
                        <div class="form-group">
                            <label class="form-label">Title: </label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control form-control-line" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description: </label>
                            <textarea id="mymce" name="description" class="form-control form-control-line">{{ $sample->description ?? old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status: </label>&nbsp;&nbsp;
                            <select class="select2 form-control select-status" name="status">
                                @foreach(config('ticket.status') as $keyStatus => $status)
                                    <option value="{{ $keyStatus }}">{{ $status['name'] }}</option>
                                @endforeach
                            </select>
                            <label class="form-label m-l-30">Assignee: </label>&nbsp;
                            <select class="select2 form-control select-assignee" name="assignee">
                                @foreach($project->users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label m-l-30">Team: </label>&nbsp;
                            <select class="select2 form-control select-team" name="team">
                                @foreach($project->teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label m-l-30">Version: </label>&nbsp;
                            <select class="select2 form-control select-version" name="version">
                                @foreach($project->versions as $version)
                                    <option value="{{ $version->id }}">{{ $version->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Start Date: </label>&nbsp;&nbsp;
                            <input type="text" name="start_date" value="{{ old('start_date') }}" class="form-control select-start-date" value="{{ now()->toDateString() }}" id="mstartdate">
                            <label class="form-label" style="margin-left: 30px;">Due Date: </label>&nbsp;&nbsp;
                            <input type="text" name="due_date" value="{{ old('due_date') }}" class="form-control select-due-date" value="{{ now()->toDateString() }}" id="mduedate">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Estimated Time (hours): </label>&nbsp;&nbsp;&nbsp;
                            <input type="text" name="estimated_time" value="{{ old('estimated_time') }}" class="form-control form-control-line" style="width: 300px;">
                            <label class="form-label" style="margin-left: 30px;">Spend Time (hours): </label>&nbsp;&nbsp;&nbsp;
                            <input type="text" name="spend_time" value="{{ old('spend_time') }}" class="form-control form-control-line" style="width: 230px;">
                            <label class="form-label" style="margin-left: 10px;">% Done: </label>
                            <select class="select2 form-control select-progress" name="progress">
                                @foreach (config('ticket.progress') as $progress)
                                <option value="{{ $progress }}">{{ $progress }} %</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-rounded btn-info m-t-20">Create</button>
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
