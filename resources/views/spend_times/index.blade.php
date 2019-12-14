@extends('layouts.app')

@push('css')
    <style>
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
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Spend Time</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                    <div class="table-responsive m-t-20">
                        <table id="example23" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr style="color: #000000; font-size: 14px;" class="thead-ticket">
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>User</th>
                                    <th>Ticket</th>
                                    <th>Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($spendTimes as $key => $spendTime)
                                <tr style="color: #000000; font-size: 14px;">
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a class="ticket-show" href="{{ route('staffs.my_projects.overview', $spendTime->project->slug) }}">
                                            {{ $spendTime->project->name }}
                                        </a>
                                    </td>
                                    <td>{{ $spendTime->user->name }}</td>
                                    <td>
                                        <a class="ticket-show" href="{{ route('tickets.show', $spendTime->ticket_id) }}">
                                            {{ config('ticket.tracker')[$spendTime->ticket->tracker]['name'] }} #{{ $spendTime->ticket->id }}: {{ $spendTime->ticket->title }}
                                        </a>
                                    </td>
                                    <td>{{ $spendTime->spend_time }}</td>
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
@endpush
