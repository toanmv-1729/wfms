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
                                    <h1 class="font-light text-white">{{ $project->tickets->count() }}</h1>
                                    <h6 class="text-white">Total Tickets</h6>
                                    @if (!$project->tickets->count())
                                        <h6 class="text-white">(Done: 0%)</h6>
                                    @else
                                        <h6 class="text-white">
                                            (Done: {{ number_format($project->ticketsClosed->count()/$project->tickets->count() * 100) }}%)
                                        </h6>
                                    @endif
                                    @if (!$project->tickets->count() || !$project->ticketsClosed->count())
                                        <div class="progress-bar bg-warning progress-bar-striped" style="width: {{1}}%; height:15px;" role="progressbar"></div>
                                    @else
                                        <div
                                            class="progress-bar bg-success progress-bar-striped"
                                            style="width: {{ number_format($project->ticketsClosed->count()/$project->tickets->count() * 100) }}%; height:15px;"
                                            role="progressbar">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-inverse card-primary">
                                <div class="box bg-info text-center">
                                    <h1 class="font-light text-white">{{ $project->tasks->count() }}</h1>
                                    <h6 class="text-white">Task</h6>
                                    @if (!$project->tasks->count())
                                        <h6 class="text-white">(Done: 0%)</h6>
                                    @else
                                        <h6 class="text-white">
                                            (Done: {{ number_format($project->tasksClosed->count()/$project->tasks->count() * 100) }}%)
                                        </h6>
                                    @endif
                                    @if (!$project->tasks->count() || !$project->tasksClosed->count())
                                        <div class="progress-bar bg-warning progress-bar-striped" style="width: {{1}}%; height:15px;" role="progressbar"></div>
                                    @else
                                        <div
                                            class="progress-bar bg-success progress-bar-striped"
                                            style="width: {{ number_format($project->tasksClosed->count()/$project->tasks->count() * 100) }}%; height:15px;"
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
                                    <h1 class="font-light text-white">{{ $project->bugs->count() }}</h1>
                                    <h6 class="text-white">Bug</h6>
                                    @if (!$project->bugs->count())
                                        <h6 class="text-white">(Done: 0%)</h6>
                                    @else
                                        <h6 class="text-white">
                                            (Done: {{ number_format($project->bugsClosed->count()/$project->bugs->count() * 100) }}%)
                                        </h6>
                                    @endif
                                    @if (!$project->bugs->count() || !$project->bugsClosed->count())
                                        <div class="progress-bar bg-warning progress-bar-striped" style="width: {{1}}%; height:15px;" role="progressbar"></div>
                                    @else
                                        <div
                                            class="progress-bar bg-success progress-bar-striped"
                                            style="width: {{ number_format($project->bugsClosed->count()/$project->bugs->count() * 100) }}%; height:15px;"
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
                                    <h1 class="font-light text-white">{{ $project->features->count() }}</h1>
                                    <h6 class="text-white">Feature</h6>
                                    @if (!$project->features->count())
                                        <h6 class="text-white">(Done: 0%)</h6>
                                    @else
                                    <h6 class="text-white">
                                        (Done: {{ number_format($project->featuresClosed->count()/$project->features->count() * 100) }}%)
                                    </h6>
                                    @endif
                                    @if (!$project->features->count() || !$project->featuresClosed->count())
                                        <div class="progress-bar bg-warning progress-bar-striped" style="width: {{1}}%; height:15px;" role="progressbar"></div>
                                    @else
                                        <div
                                            class="progress-bar bg-success progress-bar-striped"
                                            style="width: {{ number_format($project->featuresClosed->count()/$project->features->count() * 100) }}%; height:15px;"
                                            role="progressbar"
                                        ></div>
                                    @endif
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
                    <h4 class="card-title">Teams ({{ $project->teams->count() }})</h4>
                    <div class="row m-t-30">
                        <div class="col-md-4 p-r-40">
                            @foreach($project->teams as $team)
                            <p>- {{ $team->name }}: {{ $team->users->count() }} Members
                                <a href="{{ route('teams.index', $project->slug) }}">(Detail...)</a>
                            </p>
                            @endforeach
                        </div>
                    </div>
                    <h4 class="card-title">Versions ({{ $project->versions->count() }})</h4>
                    <div class="row m-t-30">
                        <div class="col-md-4 p-r-40">
                            @foreach($project->versions as $version)
                            <p>- {{ $version->name }}: From {{ date_format(date_create($version->start_date), 'd-m-Y') }} to {{ date_format(date_create($version->due_date), 'd-m-Y') }}
                                <a href="{{ route('versions.index', $project->slug) }}">(Detail...)</a>
                            </p>
                            @endforeach
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
