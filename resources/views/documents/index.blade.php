@extends('layouts.app')

@push('css')
    <link href="{{ asset('vendor/plugins/icheck/skins/all.css') }}" rel="stylesheet">
    <style>
        .mn--height {
            min-height: 650px;
        }
        .fs--70 {
            font-size: 70px;
        }
        .fs--100 {
            font-size: 70px;
            margin-left: 160px;
        }
        .doc-item {
            border: 1px solid;
            border-color: #d7dfe3;
            border-radius: 10px;
        }
        .doc-item:hover {
            background-color: #f2f2f2;
        }
        .doc-name {
            display: inline;
            font-size: 20px;
        }
        .btn-custom-edit {
            margin-top: 3px;
            position: absolute;
            right: 70px;
        }
        .btn-custom-delete {
            margin-top: 3px;
            position: absolute;
            right: 30px;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">{{$project->name}} Documents</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('staffs.my_projects.overview', $project->slug) }}">Home</a>
                </li>
                @if (request()->uuid)
                    <li class="breadcrumb-item">
                        <a href="{{ route('documents.index', $project->slug) }}">Root</a>
                    </li>
                @foreach($breadcrumbDocuments as $breadcrumbDocument)
                    <li class="breadcrumb-item">
                        <a href="{{ route('documents.child', ['slug' => $project->slug, 'uuid' => $breadcrumbDocument->uuid]) }}">
                            {{ $breadcrumbDocument->name }}
                        </a>
                    </li>
                @endforeach
                    <li class="breadcrumb-item">{{ $currentDocument->name }}</li>
                @else
                    <li class="breadcrumb-item">Root</li>
                @endif
            </ol>
        </div>
        <div class="row col-md-7 col-4 align-self-center">
            <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-block btn-info" type="button" data-toggle="modal" data-target="#createDocumentModal" style="width: auto">
                    <i class="mdi mdi-account-multiple-plus"></i>
                    <span>Create New Document</span>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="modal fade" id="createDocumentModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $project->name }} New Document</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" enctype="multipart/form-data" method="POST" action="{{ route('documents.store') }}">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="project" value="{{ $project->id }}">
                                <input type="hidden" name="slug" value="{{ $project->slug }}">
                                <input type="hidden" name="parent" value="{{ request()->uuid }}">
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Name:</label>
                                    <input type="text" name="name" class="form-control" placeholder="Document Name">
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <input type="checkbox" class="check" name="type" id="minimal-checkbox-1">
                                    <label for="minimal-checkbox-1"> File</label>
                                </div>
                                <div class="col-md-12 m-b-20" id="link" style="display: none;">
                                    <label for="recipient-name" class="control-label">Link:</label>
                                    <input type="text" name="link" class="form-control" placeholder="Document Link">
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
        @foreach($documents as $document)
        <div class="modal fade" id="editDocumentModal{{ $document->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit {{ $document->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" enctype="multipart/form-data" method="POST" action="{{ route('documents.update', $document->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <input type="hidden" name="project" value="{{ $project->id }}">
                                <input type="hidden" name="slug" value="{{ $project->slug }}">
                                <input type="hidden" name="parent" value="{{ request()->uuid }}">
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Name:</label>
                                    <input type="text" name="name" class="form-control" value="{{ $document->name }}">
                                </div>
                                @if ($document->type)
                                <div class="col-md-12 m-b-20">
                                    <input type="checkbox" class="check" disabled checked>
                                    <label> File</label>
                                </div>
                                <div class="col-md-12 m-b-20" id="link">
                                    <label for="recipient-name" class="control-label">Link:</label>
                                    <input type="text" name="link" class="form-control" value="{{ $document->link }}">
                                </div>
                                @endif
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
                <div class="card-body {{ $documents->count() ? '' : 'mn--height' }}">
                    <div class="row">
                        @foreach($documents as $document)
                            @if ($document->type === 0)
                            <div class="col-4 m-t-20 m-b-30" ondblclick="redirectChildFolder('{{ route('documents.child', ['slug' => $project->slug, 'uuid' => $document->uuid]) }}')">
                                <div class="doc-item">
                                    <span class="fa fa-folder fs--70 m-l-10">
                                        <p class="doc-name">{{ str_limit($document->name, 20) }}</p>
                                    </span>
                                    @can('documents.update')
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-icon btn-success btn-custom-edit"
                                        data-toggle="modal"
                                        data-target="#editDocumentModal{{$document->id}}"
                                        aria-describedby="tooltip190692"
                                    >
                                        <i class="ti-pencil-alt" aria-hidden="true"></i>
                                    </button>
                                    @endcan
                                    @can('documents.destroy')
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-icon btn-danger btn-custom-delete"
                                        data-toggle="tooltip"
                                        data-original-title="Delete"
                                        aria-describedby="tooltip190692"
                                        onclick="destroyDocument({{ $document->id }})"
                                    >
                                        <i class="ti-trash" aria-hidden="true"></i>
                                    </button>
                                    <form id="delete-form-{{ $document->id }}" action="{{ route('documents.destroy', $document->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endcan
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        @foreach($documents as $document)
                            @if ($document->type !== 0)
                            <div class="col-4 m-t-20 m-b-30" ondblclick="redirectFile('{{ $document->link }}')">
                                <div class="doc-item">
                                    <span class="fa fa-file fs--100 m-t-20"></span>
                                    @can('documents.update')
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-icon btn-success btn-custom-edit"
                                        data-toggle="modal"
                                        data-target="#editDocumentModal{{$document->id}}"
                                        aria-describedby="tooltip190692"
                                    >
                                        <i class="ti-pencil-alt" aria-hidden="true"></i>
                                    </button>
                                    @endcan
                                    @can('documents.destroy')
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-icon btn-danger btn-custom-delete"
                                        data-toggle="tooltip"
                                        data-original-title="Delete"
                                        aria-describedby="tooltip190692"
                                        onclick="destroyDocument({{ $document->id }})"
                                    >
                                        <i class="ti-trash" aria-hidden="true"></i>
                                    </button>
                                    <form id="delete-form-{{ $document->id }}" action="{{ route('documents.destroy', $document->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endcan
                                    <p class="m-t-10 m-b-20" style="font-size: 20px; text-align: center;">
                                        {{ str_limit($document->name, 20) }}
                                    </p>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('vendor/plugins/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/icheck/icheck.init.js') }}"></script>
    <script>
        $('#minimal-checkbox-1').on('ifChanged', function () {
            var element = document.getElementById("link");
            if (this.checked) {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        });
    </script>
    <script>
        function redirectChildFolder(urlFolder) {
            window.location.replace(urlFolder);
        }
        function redirectFile(urlFile) {
            window.open(urlFile);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.11/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
    function destroyDocument(id) {
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
