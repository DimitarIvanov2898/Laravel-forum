@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
            @foreach($discussions as $d)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <img src="{{asset($d->user->avatar)}}" alt="" width="50px" height="50px">
                        <span>{{$d->user->name}}, {{$d->created_at->diffForHumans()}}</span>
                        <a href="{{route('discussion', ['slug' => $d->slug])}}" class="btn btn-xs btn-default pull-right">View discussion</a>

                        @if($d->has_best_answer())
                            <span class="btn btn-xs pull-right btn-danger" style="margin-right: 10px;">Closed</span>
                        @else
                            <span class="btn btn-xs pull-right btn-success" style="margin-right: 10px;">Opened</span>
                        @endif
                    </div>
                    <div class="panel-body">
                        <h5 class="text-center">
                            <b>
                                {{$d->title}}
                            </b>
                        </h5>
                        <p class="text-center">
                            {{str_limit($d->content, 50)}}
                        </p>
                    </div>
                    <div class="panel-footer">
                        <span>{{$d->replies->count()}} Replies</span>
                        <a href="{{route('channel', ['slug' => $d->channel->slug])}}" class="pull-right btn btn-default btn-xs">
                            {{$d->channel->title}}
                        </a>
                    </div>
                </div>
            @endforeach
            <div class="text-center">
                {{$discussions->links()}}
            </div>
        </div>
    </div>

@endsection
