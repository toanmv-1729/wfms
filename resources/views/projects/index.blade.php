@extends('layouts.app')

@push('css')
    <link href="{{ asset('vendor/plugins/Magnific-Popup-master/dist/magnific-popup.css') }}" rel="stylesheet">
    <style>
        .project-basic-info {
            margin: 10px 0px -10px auto;
        }
        .project-pagination {
            margin: 0 auto;
            width: 100px;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
    </div>
    <div class="row el-element-overlay">
        @foreach($projects as $project)
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="el-card-item">
                    <div class="el-card-avatar el-overlay-1">
                        <a href="{{ route('staffs.my_projects.overview', $project->slug) }}">
                            <img
                                src="{{ asset(storage_url($project->media[0]->preview_path ?? '../img/default-project.jpg')) }}"
                                style="height: 180px;"
                                alt="img"
                            />
                        </a>
                    </div>
                    <div class="el-card-content">
                        <h3 class="box-title">{{ $project->name }}</h3>
                        <div class="project-basic-info">
                            <p>Project Manager: {{ $project->getProjectManager()->name }}</p>
                            <p>Contributors: {{ $project->users_count }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="project-pagination">
        {{ $projects->links() }}
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('vendor/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js') }}"></script>
@endpush
