@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
            @foreach($discussions as $d)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <img src="{{$d->user->avatar}}" alt="" width="50px" height="50px">
                        <span>{{$d->user->name}}, {{$d->created_at->diffForHumans()}}</span>

                        @if($d->has_best_answer())
                            <span class="btn btn-sm pull-right btn-danger">Closed</span>
                        @else
                            <span class="btn btn-sm pull-right btn-success">Opened</span>
                        @endif

                        <a href="{{route('discussion', ['slug' => $d->slug])}}" style="margin-right: 10px;" class="btn btn-sm btn-default pull-right">View discussion</a>
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
