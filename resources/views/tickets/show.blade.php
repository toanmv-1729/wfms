@extends('layouts.app')

@push('css')
    <link href="{{ asset('vendor/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .header img {
            float: left;
            width: 45px;
            background: #555;
            border-style: solid;
            border-width: 2px;
            border-color: #000000;
        }
        .header h4 {
            position: relative;
            top: 0px;
            left: 10px;
            font-weight: 500;
            color: #000000;
        }
        .header h6 {
            position: relative;
            top: 0px;
            left: 10px;
        }
        .label-item {
            margin-left: 15px;
            font-weight: 400;
            color: #000000;
        }
        .label-item-important {
            margin-left: 15px;
            font-weight: 400;
            color: blue;
        }
        .label-status {
            font-weight: 400;
            color: #000000;
        }
        .description {
            font-weight: 500;
        }
        .sub-ticket {
            font-weight: 500;
            margin-left: 15px;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">{{ config('ticket.tracker')[$ticket->tracker]['name'] }} #{{ $ticket->id }}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-12 header">
                        <img
                            src="{{ $ticket->user->media->count() ? asset(storage_url(\Auth::user()->media[0]->preview_path)) : '/img/default_avatar.jpg'}}"
                            alt="avatar"
                            class="ticket-owner-pic"
                        />
                        <h4>{{ $ticket->title }}</h4>
                        <div>
                            <a href="{{ route('tickets.edit', $ticket->id) }}" style="position: absolute; right: 100px; top: 0px;">
                                <i class="mdi mdi-table-edit"></i> Edit
                            </a>
                            <a href="javascript:void(0)" onclick="destroyTicket({{ $ticket->id }})" style="color:red; position: absolute; right: 25px; top: 0px;">
                                <i class="mdi mdi-delete-empty"></i> Delete
                            </a>
                            <form id="delete-form-{{ $ticket->id }}" action="{{ route('tickets.destroy', $ticket->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        @if ($ticket->created_at == $ticket->updated_at)
                        <h6>Created by {{ $ticket->user->name }} about {{ $ticket->created_at->diffForHumans() }}.</h6>
                        @else
                        <h6>Created by {{ $ticket->user->name }} about {{ $ticket->created_at->diffForHumans() }}. Lastest updated {{ $ticket->updated_at->diffForHumans() }}.</h6>
                        @endif
                    </div>
                    <div class="row m-t-40">
                        <div class="col-2">
                            <label class="label-item-important">Status: </label>
                        </div>
                        <div class="col-4">
                            <label class="label-status">{{ config('ticket.status')[$ticket->status]['name'] }}</label>
                        </div>
                        <div class="col-2">
                            <label class="label-item">Start date: </label>
                        </div>
                        <div class="col-4">
                            <label class="label-status">{{ date_format(date_create($ticket->start_date), 'd-m-Y') }}</label>
                        </div>
                        <div class="col-2">
                            <label class="label-item">Priority: </label>
                        </div>
                        <div class="col-4">
                            <label class="label-status">{{ config('ticket.priority')[$ticket->priority]['name'] }}</label>
                        </div>
                        <div class="col-2">
                            <label class="label-item">Due date: </label>
                        </div>
                        <div class="col-4">
                            <label class="label-status">{{ date_format(date_create($ticket->due_date), 'd-m-Y') }}</label>
                        </div>
                        <div class="col-2">
                            <label class="label-item">Assignee: </label>
                        </div>
                        <div class="col-4">
                            <label class="label-status">{{ optional($ticket->assignee)->name }}</label>
                        </div>
                        <div class="col-2">
                            <label class="label-item">% Done ({{ $ticket->progress }}%): </label>
                        </div>
                        <div class="col-4">
                            <div class="progress" style="margin-top: 4px; width: 200px;">
                                <div class="progress-bar bg-success progress-bar-striped" style="width: {{ $ticket->progress }}%; height:15px;" role="progressbar">{{ $ticket->progress ? $ticket->progress . '%' : '' }}</div>
                            </div>
                        </div>
                        <div class="col-2">
                            <label class="label-item">Team: </label>
                        </div>
                        <div class="col-4">
                            <label class="label-status">{{ optional($ticket->team)->name }}</label>
                        </div>
                        <div class="col-2">
                            <label class="label-item">Estimated time: </label>
                        </div>
                        <div class="col-4">
                            <label class="label-status">{{ $ticket->estimated_time }} (hours)</label>
                        </div>
                        <div class="col-2">
                            <label class="label-item">Version: </label>
                        </div>
                        <div class="col-4">
                            <label class="label-status">{{ optional($ticket->version)->name }}</label>
                        </div>
                        <div class="col-2">
                            <label class="label-item">Spend time: </label>
                        </div>
                        <div class="col-4">
                            <label class="label-status">{{ $ticket->spend_time }} {{ !is_null($ticket->spend_time) ? '(hours)' : ''}}</label>
                        </div>
                    </div>
                    <hr>
                    <div style="color: #000000;">
                        <label class="description">Description</label>
                        {!! $ticket->description !!}
                    </div>
                    <hr>
                    <div style="color: #000000;">
                        <div class="row">
                            <label class="sub-ticket">Sub Ticket: </label>
                            <a href="{{ route('tickets.create_sub_ticket', ['slug' => $ticket->project->slug, 'id' => $ticket->id]) }}" style="position: absolute; right: 50px;">Add <i class="mdi mdi-plus"></i></a>
                        </div>
                        @foreach($ticket->tickets as $subTicket)
                        <div>
                            <a href="{{ route('tickets.show', $subTicket->id) }}">{{ config('ticket.tracker')[$subTicket->tracker]['name'] }}#{{ $subTicket->id }}</a>{{' : ' . $subTicket->title }}
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <div style="color: #000000;">
                        <div class="row">
                            <label class="sub-ticket">Related Ticket: </label>
                            <a href="#addRelationTicket" style="position: absolute; right: 50px;" data-toggle="modal" data-target="#addRelationTicket">Add <i class="mdi mdi-plus"></i></a>
                        </div>
                        @foreach($ticketRelations as $ticketRelation)
                        <div>
                            <a href="{{ route('tickets.show', $ticketRelation->id) }}">{{ config('ticket.tracker')[$ticketRelation->tracker]['name'] }}#{{ $ticketRelation->id }}</a>{{ ' : ' . $ticketRelation->title }}
                        </div>
                        @endforeach
                        <div class="modal fade" id="addRelationTicket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form class="form-horizontal form-material" method="POST" action="{{ route('tickets.add_relation_ticket') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label class="m-b-20">Add Related Ticket</label>
                                                <input type="hidden" name="tid" value="{{ $ticket->id }}">
                                                <select class="select2 m-b-10 select2-multiple" name="relation_tickets[]" style="width: 100%" multiple="multiple">
                                                    @foreach($relationTickets as $relationTicket)
                                                    <option value="{{ $relationTicket->id }}">{{ config('ticket.tracker')[$relationTicket->tracker]['name'] }}#{{ $relationTicket->id }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div style="right: 0px;">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
<script>
    $(".select2").select2();
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.11/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">
function destroyTicket(id) {
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
