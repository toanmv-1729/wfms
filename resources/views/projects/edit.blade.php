@extends('layouts.app')

@push('css')
    <link href="{{ asset('vendor/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">{{ $project->name }} Edit</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('projects.update', $project->id) }}" class="form-material m-t-40" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="name" class="form-control" name="name" value="{{ $project->name }}" placeholder="Please input project name">
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea class="form-control" rows="5" value="" name="description" placeholder="{{ $description }}">{{ $project->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Folder link (Google Drive,...):</label>
                            <input name="root_folder_link" class="form-control" value="{{ $project->root_folder_link }}" placeholder="https://drive.google.com">
                        </div>
                        <div class="form-group">
                            <label>Repository link (Github, Gitlab, Bitbucket,etc...):</label>
                            <input name="repository_link" class="form-control" value="{{ $project->repository_link }}" placeholder="https://github.com">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Image: </label>
                            <br>
                            <div class="fileupload btn btn-success btn-rounded waves-effect waves-light">
                                <span>
                                    <i class="fa fa-link"></i>
                                </span>
                                <input type="file" onchange="loadFile(event)" accept="image/*" name="image" class="upload">
                                <br>
                            </div>
                            <br>
                            <img src="{{ asset(storage_url($project->media[0]->preview_path)) }}" id="output" style="width: 50%;">
                        </div>
                        @foreach($roles as $role)
                        <div class="form-group">
                            <label class="control-label">{{ $role->name }}</label>
                            <select class="select2 m-b-10 select2-multiple" name="users[{{ str_slug($role->id, '_') }}][]" style="width: 100%" multiple="multiple" data-placeholder="Choose Contributors...">
                                @php
                                $positions = $project->positions($role->id)->get()->pluck('id')->toArray();
                                @endphp
                                @foreach($users as $user)
                                <option
                                    value="{{ $user->id }}"
                                    {{ in_array($user->id, $positions) ? 'selected' : '' }}
                                >{{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i>Update
                            </button>
                            <a href="{{ route('staffs.my_projects.overview', $project->slug) }}" class="btn btn-inverse">Cancel</a>
                        </div>
                    </form>
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
            toastr['success']('Image upload successfully!', 'Success');
        };
    </script>
    <script src="{{ asset('vendor/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            $(".select2").select2();
        });
    </script>
@endpush
