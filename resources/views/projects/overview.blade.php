@extends('layouts.app')

@push('css')
    <link href="{{ asset('vendor/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .members-list-border {
            border: 1px solid;
            border-radius: 5px;
            padding: 5px 20px 5px 10px;
            box-sizing: border-box;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">{{ $project->name }} Overview</h3>
        </div>
        <div class="row col-md-7 col-4 align-self-center">
            <div class="col-8 d-flex justify-content-end">
                <button class="btn btn-block btn-info" type="button" data-toggle="modal" data-target="#createTeamModal" style="width: auto">
                    <i class="mdi mdi-account-multiple-plus"></i>
                    <span>Create New Team</span>
                </button>
            </div>
            <div class="col-4 d-flex justify-content-end">
                <button class="btn btn-block btn-info" type="button" data-toggle="modal" data-target="#createVersionModal" style="width: auto;">
                    <i class="mdi mdi-tag-plus"></i>
                    <span>Create New Version</span>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="modal fade" id="createTeamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">{{ $project->name }} New Team</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" enctype="multipart/form-data" method="POST" action="{{ route('team.store') }}">
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
                                    <select class="select2 m-b-10 select2-multiple" name="users[]" style="width: 100%" multiple="multiple" data-placeholder="Choose Members...">
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
        <div class="modal fade" id="createVersionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel2">{{ $project->name }} New Version</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" enctype="multipart/form-data" method="POST" action="{{ route('version.store') }}">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="project" value="{{ $project->id }}">
                                <input type="hidden" name="slug" value="{{ $project->slug }}">
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Name:</label>
                                    <input type="text" name="name" class="form-control" placeholder="Version Name">
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <label for="recipient-name" class="control-label">Members: </label>
                                    <input
                                        class="form-control input-daterange-datepicker"
                                        type="text"
                                        name="daterange"
                                        value="{{ now()->format('m/d/Y') }} - {{ now()->format('m/d/Y') }}"
                                    />
                                </div>
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
                    <h4 class="card-title">Ticket List Tracking</h4>
                    <h6 class="card-subtitle">List of ticket open by customers</h6>
                    <div class="row m-t-40">
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-inverse card-dark">
                                <div class="box bg-inverse text-center">
                                    <h1 class="font-light text-white">2,064</h1>
                                    <h6 class="text-white">Total Tickets</h6>
                                    <div class="progress-bar bg-success progress-bar-striped" style="width: 75%; height:15px;" role="progressbar">75%</div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-inverse card-primary">
                                <div class="box bg-info text-center">
                                    <h1 class="font-light text-white">1,738</h1>
                                    <h6 class="text-white">Task</h6>
                                    <div class="progress-bar bg-success progress-bar-striped" style="width: {{100}}%; height:15px;" role="progressbar">100%</div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-inverse card-danger">
                                <div class="box text-center">
                                    <h1 class="font-light text-white">1100</h1>
                                    <h6 class="text-white">Bug</h6>
                                    <div class="progress-bar bg-success progress-bar-striped" style="width: 75%; height:15px;" role="progressbar">75%</div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-inverse card-dark">
                                <div class="box bg-primary text-center">
                                    <h1 class="font-light text-white">964</h1>
                                    <h6 class="text-white">Feature</h6>
                                    <div class="progress-bar bg-success progress-bar-striped" style="width: 75%; height:15px;" role="progressbar">75%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <h4 class="card-title">Members ({{ $project->users->count() }})</h4>
                    <div class="row m-t-30">
                        @foreach($roles as $roleName => $roleHasUsers)
                        <div class="col-md-4 p-r-40">
                            <h6 class="card-subtitle">{{ $roleName }}</h6>
                            <div class="members-list-border">
                            @foreach($roleHasUsers as $key => $user)
                                @if ($key === count($roleHasUsers) - 1)
                                    {{ $user->name }}
                                @else
                                    {{ $user->name }},
                                @endif
                            @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <br>
                    <h4 class="card-title">Infomation</h4>
                    <div class="row m-t-30">
                        <div class="col-md-4 p-r-40">
                            <p>- Document link:
                                <a href="{{ $project->root_folder_link }}">{{ $project->root_folder_link }}</a>
                            </p>
                            <p>- Repository link:
                                <a href="{{ $project->repository_link }}">{{ $project->repository_link }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('vendor/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/plugins/moment/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            $(".select2").select2();
        });
        $('.input-daterange-datepicker').daterangepicker({
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-danger',
            cancelClass: 'btn-inverse'
        });
    </script>
@endpush
