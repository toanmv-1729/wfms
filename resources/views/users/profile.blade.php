@extends('layouts.app')

@push('css')
@endpush

@section('content')
<div class="container-fluid">
    <div><br></div>
    <div class="row">
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="m-t-30">
                        <img src="{{ $user->media->count() ? asset(storage_url($user->media[0]->preview_path)) : '/img/default_avatar.jpg'}}" class="img-circle" width="150" height="150" id="output"/>
                        <h4 class="card-title m-t-10">{{ $user->name }}</h4>
                        <h6 class="card-subtitle">{{ $user->company->name }}</h6>
                        <h6 class="card-subtitle">{{ $user->roles->count() ? $user->roles[0]->name : 'Company Account' }}</h6>
                    </center>
                </div>
                <div>
                    <hr> </div>
                <div class="card-body"> <small class="text-muted">Email address </small>
                    <h6>{{ $user->email }}</h6>
                    <small class="text-muted p-t-30 db">Phone</small>
                    <h6>{{ $user->phone ?? '' }}</h6>
                    <small class="text-muted p-t-30 db">Address</small>
                    <h6>{{ $user->address ?? '' }}</h6>
                    <small class="text-muted p-t-30 db">Social Profile</small>
                    <br/>
                    <button class="btn btn-circle btn-secondary">
                        <i class="fa fa-facebook"></i>
                    </button>
                    <button class="btn btn-circle btn-secondary">
                        <i class="fa fa-twitter"></i>
                    </button>
                    <button class="btn btn-circle btn-secondary">
                        <i class="fa fa-youtube"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#change-profile" data-toggle="tab" role="tab">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#change-password" data-toggle="tab" role="tab">Change Password</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="change-profile" role="tabpanel">
                        <div class="card-body">
                            <form class="form-horizontal form-material" enctype="multipart/form-data" method="POST" action="{{ route('users.update.profile', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label class="col-md-12">Full Name</label>
                                    <div class="col-md-12">
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" value="{{ $user->email }}" class="form-control form-control-line" name="email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Phone</label>
                                    <div class="col-md-12">
                                        <input type="text" value="{{ $user->phone }}" class="form-control form-control-line" name="phone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Address</label>
                                    <div class="col-md-12">
                                        <input type="text" value="{{ $user->address }}" class="form-control form-control-line" name="address">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Image</label>
                                    <div class="col-md-12">
                                        <div class="fileupload btn btn-secondary btn-rounded waves-effect waves-light">
                                            <span>
                                                <i class="fa fa-link"></i>
                                            </span>
                                            <input type="file" onchange="loadFile(event)" accept="image/*" name="avatar" class="upload">
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <br><br><br>
                                        <button class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane" id="change-password" role="tabpanel">
                        <div class="card-body">
                            <form class="form-horizontal form-material" method="POST" action="{{ route('users.update.password') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="col-md-12">Old Password</label>
                                    <div class="col-md-12">
                                        <input type="password" name="old_password" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">New Password</label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control form-control-line" name="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Confirm Password</label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control form-control-line" name="password_confirmation">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <br><br><br>
                                        <button class="btn btn-success">Change Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
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
@endpush
