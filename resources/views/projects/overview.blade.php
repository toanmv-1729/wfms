@extends('layouts.app')

@push('css')
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
        <h3 class="text-themecolor m-b-0 m-t-0 m-l-20">{{ $project->name }} Overview</h3>
    </div>
    <div class="row">
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
                    <h4 class="card-title">Members</h4>
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
@endpush
