@extends('layouts.app')

@push('css')
    <link href="{{ asset('vendor/plugins/icheck/skins/all.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Treeview</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Treeview</li>
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
        <h3>Document</h3>
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
@endpush
