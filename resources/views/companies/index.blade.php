@extends('layouts.app')

@push('css')
<style>
    .page-wrapper {
        padding-top: 0px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <button class="btn btn-block btn-info" type="button" data-toggle="modal" data-target="#createCompanyModal" style="width: 200px;">
                <i class="mdi mdi-account-plus"></i>
                <span>Create New Company</span>
            </button>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>THIS MONTH</small></h6>
                        <h4 class="m-t-0 text-info">$58,356</h4></div>
                    <div class="spark-chart">
                        <div id="monthchart"></div>
                    </div>
                </div>
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>LAST MONTH</small></h6>
                        <h4 class="m-t-0 text-primary">$48,356</h4></div>
                    <div class="spark-chart">
                        <div id="lastmonthchart"></div>
                    </div>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="modal fade" id="createCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Create New Company</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" enctype="multipart/form-data" method="POST" action="{{ route('company.store') }}">
                            @csrf
                            <div class="form-group">
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Name:</label>
                                    <input type="text" name="name" class="form-control" placeholder="Company Name">
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Image: </label>
                                    <div class="fileupload btn btn-success btn-rounded waves-effect waves-light">
                                        <span>
                                            <i class="fa fa-link"></i>
                                        </span>
                                        <input type="file" onchange="loadFile(event)" accept="image/*" name="image" class="upload">
                                        <br>
                                    </div>
                                    <img id="output" style="width: 100%;">
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Company</h4>
                    <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Image</th>
                                    <th>Last Login Time</th>
                                    <th>Employees</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companies as $key => $company)
                                <tr>
                                    <td>{{ $company->users[0]->name }}</td>
                                    <td>{{ $company->users[0]->email }}</td>
                                    <td>
                                        <img src="{{ asset(storage_url($company->users[0]->media[0]->preview_path ?? null)) }}" alt="Company Image">
                                    </td>
                                    <td>{{ $company->users[0]->last_login_time ?? '-' }}</td>
                                    <td>{{ $company->users->count() }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-icon btn-success" data-toggle="tooltip" data-original-title="Edit" aria-describedby="tooltip190692">
                                            <i class="ti-pencil-alt" aria-hidden="true"></i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-icon btn-danger"
                                            data-toggle="tooltip"
                                            data-original-title="Delete"
                                            aria-describedby="tooltip190692"
                                            onclick="destroyCompany({{ $company->id }})"
                                        >
                                            <i class="ti-trash" aria-hidden="true"></i>
                                        </button>
                                        <form id="delete-form-{{ $company->id }}" action="{{ route('company.destroy', $company->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>

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
    function destroyCompany(id){
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
