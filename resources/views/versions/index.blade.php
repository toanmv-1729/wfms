@extends('layouts.app')

@push('css')
    <link href="{{ asset('vendor/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .label-open {
            background-color: #155724;
        }
        .label-closed {
            background-color: #ffb22b;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">{{ $project->name }} Versions</h3>
        </div>
        <div class="row col-md-7 col-4 align-self-center">
            <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-block btn-info" type="button" data-toggle="modal" data-target="#createVersionModal" style="width: auto">
                    <i class="mdi mdi-account-multiple-plus"></i>
                    <span>Create New Version</span>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="modal fade bs-example-modal-lg" id="createVersionModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel2">{{ $project->name }} New Version</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" enctype="multipart/form-data" method="POST" action="{{ route('versions.store') }}">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="project" value="{{ $project->id }}">
                                <input type="hidden" name="slug" value="{{ $project->slug }}">
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Name:</label>
                                    <input type="text" name="name" class="form-control" placeholder="Version Name">
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <label class="form-label">Goal: </label>
                                    <textarea id="mymce" name="description" class="form-control form-control-line">{{ old('description') }}</textarea>
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Version Range: </label>
                                    <input
                                        class="form-control input-daterange-datepicker"
                                        type="text"
                                        name="daterange"
                                        value="{{ now()->format('m/d/Y') }} - {{ now()->format('m/d/Y') }}"
                                    />
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

        @foreach($versions as $version)
        <div class="modal fade bs-example-modal-lg" id="editVersionModal{{ $version->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $project->name }} New Version</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" enctype="multipart/form-data" method="POST" action="{{ route('versions.update', $version->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="project" value="{{ $project->id }}">
                                <input type="hidden" name="slug" value="{{ $project->slug }}">
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Name:</label>
                                    <input type="text" name="name" class="form-control" placeholder="Version Name" value="{{ $version->name }}">
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <label class="form-label">Goal: </label>
                                    <textarea id="mymce" name="description" class="form-control form-control-line">
                                        {{ $version->description ?? old('description') }}
                                    </textarea>
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Version Range: </label>
                                    <input
                                        class="form-control input-daterange-datepicker"
                                        type="text"
                                        name="daterange"
                                        value="{{ date_create($version->start_date)->format('m/d/Y') }} - {{ date_create($version->due_date)->format('m/d/Y') }}"
                                    />
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

        <div class="modal fade bs-example-modal-lg" id="showVersionModal{{ $version->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel2">{{ $version->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h3>Version Statistics</h3>
                        <div class="row m-t-20">
                            <!-- Column -->
                            <div class="col-md-6 col-lg-3 col-xlg-3">
                                <div class="card card-inverse card-dark">
                                    <div class="box bg-inverse text-center">
                                        <h1 class="font-light text-white">{{ $version->tickets->count() }}</h1>
                                        <h6 class="text-white">Total Tickets</h6>
                                        @if (!$version->tickets->count() || !$version->ticketsClosed->count())
                                        <div class="progress-bar bg-warning progress-bar-striped" style="width: {{1}}%; height:15px;" role="progressbar"></div>
                                        @else
                                        <div
                                            class="progress-bar bg-success progress-bar-striped"
                                            style="width: {{ number_format($version->ticketsClosed->count()/$version->tickets->count() * 100) }}%; height:15px;"
                                            role="progressbar"
                                        ></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <div class="col-md-6 col-lg-3 col-xlg-3">
                                <div class="card card-inverse card-primary">
                                    <div class="box bg-info text-center">
                                        <h1 class="font-light text-white">{{ $version->tasks->count() }}</h1>
                                        <h6 class="text-white">Task</h6>
                                        @if (!$version->tasks->count() || !$version->tasksClosed->count())
                                        <div class="progress-bar bg-warning progress-bar-striped" style="width: {{1}}%; height:15px;" role="progressbar"></div>
                                        @else
                                        <div
                                            class="progress-bar bg-success progress-bar-striped"
                                            style="width: {{ number_format($version->tasksClosed->count()/$version->tasks->count() * 100) }}%; height:15px;"
                                            role="progressbar"
                                        ></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <div class="col-md-6 col-lg-3 col-xlg-3">
                                <div class="card card-inverse card-danger">
                                    <div class="box text-center">
                                        <h1 class="font-light text-white">{{ $version->bugs->count() }}</h1>
                                        <h6 class="text-white">Bug</h6>
                                        @if (!$version->bugs->count() || !$version->bugsClosed->count())
                                        <div class="progress-bar bg-warning progress-bar-striped" style="width: {{1}}%; height:15px;" role="progressbar"></div>
                                        @else
                                        <div
                                            class="progress-bar bg-success progress-bar-striped"
                                            style="width: {{ number_format($version->bugsClosed->count()/$version->bugs->count() * 100) }}%; height:15px;"
                                            role="progressbar"
                                        ></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <div class="col-md-6 col-lg-3 col-xlg-3">
                                <div class="card card-inverse card-dark">
                                    <div class="box bg-primary text-center">
                                        <h1 class="font-light text-white">{{ $version->features->count() }}</h1>
                                        <h6 class="text-white">Feature</h6>
                                        @if (!$version->features->count() || !$version->featuresClosed->count())
                                        <div class="progress-bar bg-warning progress-bar-striped" style="width: {{1}}%; height:15px;" role="progressbar"></div>
                                        @else
                                        <div
                                            class="progress-bar bg-success progress-bar-striped"
                                            style="width: {{ number_format($version->featuresClosed->count()/$version->features->count() * 100) }}%; height:15px;"
                                            role="progressbar"
                                        ></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($version->description)
                        <h3>Goals Of Version</h3>
                        {!! $version->description !!}
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">List versions</h4>
                    <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Total Ticket</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($versions as $key => $version)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $version->name }}</td>
                                    <td>{{ $version->tickets->count() }}</td>
                                    <td>{{ $version->start_date }}</td>
                                    <td>{{ $version->due_date }}</td>
                                    <td>
                                        <span class="label label-rounded {{ $version->status ? 'label-open' : 'label-closed' }}">
                                            {{ $version->status ? 'Open' : 'Closed' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-icon btn-primary"
                                            aria-describedby="tooltip190692"
                                            data-toggle="modal"
                                            data-original-title="123123123"
                                            data-target="#showVersionModal{{$version->id}}"
                                        >
                                            <i class="ti-eye" aria-hidden="true"></i>
                                        </button>
                                        @can('versions.update')
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-icon btn-success"
                                            data-original-title="Edit"
                                            aria-describedby="tooltip190692"
                                            data-toggle="modal"
                                            data-target="#editVersionModal{{$version->id}}"
                                        >
                                            <i class="ti-pencil-alt" aria-hidden="true"></i>
                                        </button>
                                        @endcan
                                        @can('versions.destroy')
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-icon btn-danger"
                                            data-toggle="tooltip"
                                            data-original-title="Delete"
                                            aria-describedby="tooltip190692"
                                            onclick="destroyVersion({{ $version->id }})"
                                        >
                                            <i class="ti-trash" aria-hidden="true"></i>
                                        </button>
                                        <form id="delete-form-{{ $version->id }}" action="{{ route('versions.destroy', $version->id) }}" method="POST">
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
    <script src="{{ asset('vendor/plugins/tinymce/tinymce.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('vendor/plugins/moment/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script>
        $('.input-daterange-datepicker').daterangepicker({
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-danger',
            cancelClass: 'btn-inverse'
        });
    </script>
    <script>
        $(document).ready(function() {
            if ($("#mymce").length > 0) {
                tinymce.init({
                    selector: "textarea#mymce",
                    theme: "modern",
                    height: 180,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media fullpage | forecolor backcolor",
                });
            }
        });
    </script>
    <script>
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.11/dist/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
    function destroyVersion(id) {
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
