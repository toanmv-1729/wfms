@extends('layouts.app')

@push('css')
    <link href="{{ asset('vendor/plugins/icheck/skins/all.css') }}" rel="stylesheet">
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
            <h3 class="text-themecolor m-b-0 m-t-0">{{ $project->name }} Samples</h3>
        </div>
        <div class="row col-md-7 col-4 align-self-center">
            <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-block btn-info" type="button" data-toggle="modal" data-target="#createSampleModal" style="width: auto">
                    <i class="mdi mdi-account-multiple-plus"></i>
                    <span>Create New Sample</span>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="modal fade bs-example-modal-lg" id="createSampleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel2">{{ $project->name }} New Sample</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" enctype="multipart/form-data" method="POST" action="{{ route('sample_descriptions.store') }}">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="project" value="{{ $project->id }}">
                                <input type="hidden" name="slug" value="{{ $project->slug }}">
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Name:</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <label class="form-label">Description: </label>
                                    <textarea id="mymce" name="description" class="form-control form-control-line">{{ old('description') }}</textarea>
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <label for="minimal-checkbox-1">Apply </label>
                                    <input type="checkbox" class="check" name="status" id="minimal-checkbox-1">
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
        @foreach($sampleDescriptions as $sample)
        <div class="modal fade bs-example-modal-lg" id="editSampleModal{{ $sample->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel2">Edit {{ $sample->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" method="POST" action="{{ route('sample_descriptions.update', $sample->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <input type="hidden" name="project" value="{{ $project->id }}">
                                <input type="hidden" name="slug" value="{{ $project->slug }}">
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Name:</label>
                                    <input type="text" name="name" value="{{ $sample->name }}" class="form-control">
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <label class="form-label">Description: </label>
                                    <textarea id="mymce" name="description" class="form-control form-control-line">{{ $sample->description }}</textarea>
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <label for="minimal-checkbox-1">Apply </label>
                                    <input type="checkbox" class="check" {{ $sample->status ? 'checked' : '' }} name="status" id="minimal-checkbox-1">
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
        <div class="modal fade bs-example-modal-lg" id="showSampleModal{{ $sample->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body" style="color: #000000;">
                        {!! $sample->description !!}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                    <div class="table-responsive m-t-20">
                        <table id="example23" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr style="color: #000000; font-size: 14px;" class="thead-ticket">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sampleDescriptions as $key => $sampleDescription)
                                <tr style="color: #000000; font-size: 14px;">
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $sampleDescription->name }}</td>
                                    <td>
                                        @if ($sampleDescription->status)
                                        <span class="label label-rounded label-success">Applied</span>
                                        @else
                                        <span class="label label-rounded label-warning">Not Apply</span>
                                        @endif
                                    </td>
                                    <td>{{ $sampleDescription->created_at }}</td>
                                    <td>{{ $sampleDescription->updated_at }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-icon btn-info"
                                            data-toggle="modal"
                                            data-target="#showSampleModal{{ $sampleDescription->id }}"
                                            data-original-title="Edit"
                                            aria-describedby="tooltip190692"
                                        >
                                            <i class="ti-eye" aria-hidden="true"></i>
                                        </button>
                                        @can('samples.update')
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-icon btn-success"
                                            data-toggle="modal"
                                            data-target="#editSampleModal{{ $sampleDescription->id }}"
                                            data-original-title="Edit"
                                            aria-describedby="tooltip190692"
                                        >
                                            <i class="ti-pencil-alt" aria-hidden="true"></i>
                                        </button>
                                        @endcan
                                        @can('samples.destroy')
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-icon btn-danger"
                                            data-toggle="tooltip"
                                            data-original-title="Delete"
                                            aria-describedby="tooltip190692"
                                            onclick="destroySample({{ $sampleDescription->id }})"
                                        >
                                            <i class="ti-trash" aria-hidden="true"></i>
                                        </button>
                                        <form id="delete-form-{{ $sampleDescription->id }}" action="{{ route('sample_descriptions.destroy', $sampleDescription->id) }}" method="POST">
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
    <script>
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>

    <script src="{{ asset('vendor/plugins/tinymce/tinymce.min.js') }}" type="text/javascript"></script>
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

    <script src="{{ asset('vendor/plugins/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/icheck/icheck.init.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.11/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
    function destroySample(id) {
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
