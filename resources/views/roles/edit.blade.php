@extends('layouts.app')

@push('css')
    <link href="{{ asset('vendor/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Create New Role</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Create New Role</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Create New Role Form</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input
                                            type="text"
                                            id="firstName"
                                            name="name"
                                            class="form-control"
                                            placeholder="Please Input Role's Name"
                                            value="{{ $role->name }}"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-danger">
                                        <label class="control-label">Permissions</label>
                                        <select class="select2 m-b-10 select2-multiple" name="permissions[]" style="width: 100%" multiple="multiple" data-placeholder="Choose Permissions...">
                                            @foreach($permissions as $permission)
                                                <option
                                                    @foreach($role->permissions as $rolePermission)
                                                        {{ $rolePermission->id === $permission->id ? 'selected' : ''}}
                                                    @endforeach
                                                    value="{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i>Save
                            </button>
                            <a href="{{ route('roles.index') }}" class="btn btn-inverse">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('vendor/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            $(".select2").select2();
        });
    </script>
@endpush
