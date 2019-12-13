@extends('layouts.app')

@push('css')
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
        <h3>Document</h3>
    </div>
</div>
@endsection

@push('js')
@endpush
