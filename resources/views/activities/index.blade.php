@extends('layouts.app')

@push('css')
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
        .history {
            margin-bottom: 30px;
        }
        .history-owner-pic {
            width: 45px;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Your Activities {{ !empty($project) ? 'in ' . $project->name : '' }}</h3>
        </div>
    </div>
    <div>
        <div class="history">
            @foreach($ticketHistories as $ticketsHistory)
                <hr>
                <div class="header">
                    <img
                        src="{{ $ticketsHistory[0]->user->media->count() ? asset(storage_url($ticketsHistory[0]->user->media[0]->preview_path)) : '/img/default_avatar.jpg'}}"
                        alt="avatar"
                        class="history-owner-pic"
                    />
                    <h6>
                        {{ date_format($ticketsHistory[0]->created_at, 'd/m/Y H:m:i') }} by
                        <a href="javascript:void(0)">{{ $ticketsHistory[0]->user->name }}</a>
                    </h6>
                    <h6>
                        <a href="{{ route('tickets.show', $ticketsHistory[0]->ticket_id) }}">
                            {{ config('ticket.tracker')[$ticketsHistory[0]->ticket->tracker]['name'] }} #{{ $ticketsHistory[0]->ticket_id }}: {{ $ticketsHistory[0]->ticket->title }}
                        </a>
                    </h6>
                </div>
                <br>
                @foreach($ticketsHistory as $ticketHistory)
                    <p>{!! $ticketHistory->content !!}</p>
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $("strong").css("font-weight", "600");
</script>
@endpush
