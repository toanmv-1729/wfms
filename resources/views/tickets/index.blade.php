@extends('layouts.app')

@push('css')
    <link href="{{ asset('vendor/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .important {
            background: #ffcccc;
        }
        .thead-ticket {
            background: #e6e6e6;
        }
        .ticket-show {
            color: #000000;
        }
        .ticket-show:hover {
            color: #000000;
            text-decoration: underline;
        }
        .over-date {
            color: #ff3333;
        }
        .custom--filter {
            position: absolute;
            right: 8%;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Tickets</h3>
        </div>
        @if (!empty(request()->slug))
        <div class="custom--filter">
            <h3 class="text-themecolor m-b-0 m-t-0">Custom Filter</h3>
        </div>
        <div style="position: absolute; right: 50px; margin-top: 3%;">
            <form action="{{ route('tickets.index', $project->slug) }}" method="GET">
                <label>Tracker: </label>&nbsp;&nbsp;&nbsp;&nbsp;
                <select class="select2 select2-multiple" multiple="multiple" name="tracker[]" style="width: 150px;">
                    @foreach(config('ticket.tracker') as $keyTracker => $tracker)
                        <option value="{{ $keyTracker }}" {{ in_array($keyTracker, request()->tracker ?? []) ? 'selected' : '' }}>
                            {{ $tracker['name'] }}
                        </option>
                    @endforeach
                </select>
                <br>
                <br>
                <label>Status: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select class="select2 select2-multiple" multiple="multiple" name="status[]" style="width: 150px;">
                    @foreach(config('ticket.status') as $keyStatus => $status)
                        <option value="{{ $keyStatus }}" {{ in_array($keyStatus, request()->status ?? []) ? 'selected' : '' }}>
                            {{ $status['name'] }}
                        </option>
                    @endforeach
                </select>
                <br>
                <br>
                <label>Priority: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select class="select2 select2-multiple" multiple="multiple" name="priority[]" style="width: 150px;">
                    @foreach(config('ticket.priority') as $keyPriority => $priority)
                        <option value="{{ $keyPriority }}" {{ in_array($keyPriority, request()->priority ?? []) ? 'selected' : '' }}>
                            {{ $priority['name'] }}
                    </option>
                    @endforeach
                </select>
                <br>
                <br>
                <label>Assignee: </label>&nbsp;
                <select class="select2 select2-multiple" multiple="multiple" name="assignee[]" style="width: 150px;">
                    @foreach($project->users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id, request()->assignee ?? []) ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                <br>
                <br>
                <label>Version: </label>&nbsp;&nbsp;&nbsp;&nbsp;
                <select class="select2 select2-multiple" multiple="multiple" name="version[]" style="width: 150px;">
                    @foreach($project->versions as $version)
                        <option value="{{ $version->id }}" {{ in_array($version->id, request()->version ?? []) ? 'selected' : '' }}>
                            {{ $version->name }}
                        </option>
                    @endforeach
                </select>
                <br>
                <br>
                <button type="submit">Filter</button>
            </form>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr style="color: #000000; font-size: 14px;" class="thead-ticket">
                                    <th>#</th>
                                    <th>Tracker</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Title</th>
                                    <th>Assignee</th>
                                    <th>Version</th>
                                    <th>Due date</th>
                                    <th>Estimated time</th>
                                    <th>% Done</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $key => $ticketInfo)
                                <tr style="color: #000000; font-size: 14px;" class="{{ ($ticketInfo->priority > 2) ? 'important' : '' }}">
                                    <td><a class="ticket-show" href="{{ route('tickets.show', $ticketInfo->id) }}">{{ $ticketInfo->id }}</a></td>
                                    <td>{{ config('ticket.tracker')[$ticketInfo->tracker]['name'] }}</td>
                                    <td>{{ config('ticket.status')[$ticketInfo->status]['name'] }}</td>
                                    <td>{{ config('ticket.priority')[$ticketInfo->priority]['name'] }}</td>
                                    <td><a class="ticket-show" href="{{ route('tickets.show', $ticketInfo->id) }}">{{ $ticketInfo->title }}</a></td>
                                    <td>{{ optional($ticketInfo->assignee)->name }}</td>
                                    <td>{{ optional($ticketInfo->version)->name }}</td>
                                    <td class="{{ (date_create($ticketInfo->due_date) <= now()->startOfDay()) ? 'over-date' : '' }}">
                                        {{ date_format(date_create($ticketInfo->due_date), 'd-m-Y') }}
                                    </td>
                                    <td class="{{ (date_create($ticketInfo->due_date) <= now()->startOfDay()) ? 'over-date' : '' }}">
                                        {{ $ticketInfo->estimated_time }} (hours)
                                    </td>
                                    <td>
                                        <p style="color: #000000; text-align: center;">{{ $ticketInfo->progress . '%' }}</p>
                                        <div class="progress" style="margin-top: 4px; width: 80px;">
                                            <div class="progress-bar bg-success progress-bar-striped" style="width: {{ $ticketInfo->progress }}%; height:15px;" role="progressbar"></div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('vendor/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('vendor/js/dataTables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/js/dataTables/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('vendor/js/dataTables/jszip.min.js') }}"></script>
    <script src="{{ asset('vendor/js/dataTables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendor/js/dataTables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendor/js/dataTables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendor/js/dataTables/buttons.print.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                var table = $('#example').DataTable({
                    "columnDefs": [{
                        "visible": false,
                        "targets": 2
                    }],
                    "order": [
                        [2, 'asc']
                    ],
                    "displayLength": 25,
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var rows = api.rows({
                            page: 'current'
                        }).nodes();
                        var last = null;
                        api.column(2, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                                last = group;
                            }
                        });
                    }
                });
                // Order by the grouping
                $('#example tbody').on('click', 'tr.group', function() {
                    var currentOrder = table.order()[0];
                    if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                        table.order([2, 'desc']).draw();
                    } else {
                        table.order([2, 'asc']).draw();
                    }
                });
            });
        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>
    <script src="{{ asset('vendor/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            $(".select2").select2();
        });
    </script>
@endpush
