@extends('layouts.app')

@push('css')
    <link href="{{ asset('vendor/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">{{ $project->name }} Teams</h3>
        </div>
        <div class="row col-md-7 col-4 align-self-center">
            <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-block btn-info" type="button" data-toggle="modal" data-target="#createTeamModal" style="width: auto">
                    <i class="mdi mdi-account-multiple-plus"></i>
                    <span>Create New Team</span>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="modal fade" id="createTeamModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">{{ $project->name }} New Team</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" enctype="multipart/form-data" method="POST" action="{{ route('teams.store') }}">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="project" value="{{ $project->id }}">
                                <input type="hidden" name="slug" value="{{ $project->slug }}">
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Name:</label>
                                    <input type="text" name="name" class="form-control" placeholder="Team Name">
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Members: </label>
                                    <select class="select2 m-b-10 select2-multiple" name="users[]" style="width: 100%" multiple="multiple" data-placeholder="Members...">
                                        @foreach($project->users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($teams as $team)
        <div class="modal fade" id="editTeamModal{{ $team->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">{{ $team->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" enctype="multipart/form-data" method="POST" action="{{ route('teams.update', $team->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <input type="hidden" name="project" value="{{ $project->id }}">
                                <input type="hidden" name="slug" value="{{ $project->slug }}">
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Name:</label>
                                    <input type="text" name="name" class="form-control" value="{{ $team->name }}">
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Members: </label>
                                    <select class="select2 m-b-10 select2-multiple" name="users[]" style="width: 100%" multiple="multiple" data-placeholder="Members...">
                                        @foreach($project->users as $user)
                                            @if (in_array($user->id, $team->users->pluck('id')->toArray()))
                                                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                            @else
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">List Teams</h4>
                    <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Members</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teams as $key => $team)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $team->name }}</td>
                                    <td>
                                        @if($team->users->count())
                                        @foreach($team->users as $user)
                                            <span class="label label-rounded label-success">{{ $user->name }}</span>
                                        @endforeach
                                        @else
                                            <span class="label label-rounded label-warning">NONE</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('teams.update')
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-icon btn-success"
                                            data-original-title="Edit"
                                            aria-describedby="tooltip190692"
                                            data-toggle="modal"
                                            data-target="#editTeamModal{{$team->id}}"
                                        >
                                            <i class="ti-pencil-alt" aria-hidden="true"></i>
                                        </button>
                                        @endcan
                                        @can('teams.destroy')
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-icon btn-danger"
                                            data-toggle="tooltip"
                                            data-original-title="Delete"
                                            aria-describedby="tooltip190692"
                                            onclick="destroyTeam({{ $team->id }})"
                                        >
                                            <i class="ti-trash" aria-hidden="true"></i>
                                        </button>
                                        <form id="delete-form-{{ $team->id }}" action="{{ route('teams.destroy', $team->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        @endcan
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

    <script src="{{ asset('vendor/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            $(".select2").select2();
        });
    </script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.11/dist/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
    function destroyTeam(id) {
        const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
        })
        swalWithBootstrapButtons({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                document.getElementById('delete-form-'+id).submit();
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                    'Cancelled',
                    'Your data is safe :)',
                    'error'
                )
            }
        })
    }
    </script>
@endpush
