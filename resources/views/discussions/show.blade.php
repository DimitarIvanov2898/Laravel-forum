@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <img src="{{asset($d->user->avatar)}}" alt="" width="50px" height="50px">
            <span>{{$d->user->name}}, {{$d->created_at->diffForHumans()}}</span>
            @if($d->is_being_watched_by_user())
                <a href="{{route('discussion.unwatch', ['id' => $d->id])}}" class="btn btn-xs btn-default pull-right" >Unsubscribe</a>
            @else
                <a href="{{route('discussion.watch', ['id' => $d->id])}}" class="btn btn-xs btn-default pull-right" >Subscribe</a>
            @endif
            @if(Auth::id() == $d->user->id)
                <a href="{{route('discussion.edit', ['slug' => $d->slug])}}" class="btn btn-xs btn-info pull-right" >Edit</a>
            @endif
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
            <hr>
            <p class="text-center">
                {!! Markdown::convertToHtml($d->content)!!}
            </p>
            <hr>
            @if($best_answer)
                <div class="text-center">
                    <h4 class="text-center">Best answer</h4>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <img src="{{asset($best_answer->user->avatar)}}" alt="" width="50px" height="50px">
                            <span>{{$best_answer->user->name}}</span>
                        </div>
                        <div class="panel-body">
                            {{$best_answer->content}}
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="panel-footer">
            <span>{{$d->replies->count()}} Replies</span>
            <a href="{{route('channel', ['slug' => $d->channel->slug])}}" class="pull-right btn btn-default btn-xs">
                {{$d->channel->title}}
            </a>
        </div>
    </div>

    @foreach($d->replies as $r)

        <div class="panel panel-default">
            <div class="panel-heading">
                <img src="{{asset($r->user->avatar)}}" alt="" width="50px" height="50px">
                <span>{{$r->user->name}}, {{$r->created_at->diffForHumans()}}</span>
                @if(!$best_answer)
                    @if(Auth::id() == $d->user->id)
                        <a href="{{route('discussion.best_answer', ['id' => $r->id])}}" class="btn btn-xs btn-info pull-right">Mark as best answer</a>
                     @endif
                @endif

                @if(Auth::id() == $r->user->id)
                    @if(!$r->best_answer)
                        <a href="{{route('reply.edit', ['id' => $r->id])}}" class="btn btn-xs btn-info pull-right">Edit</a>
                    @endif
                @endif
            </div>
            <div class="panel-body">
                <p class="text-center">
                    {{$r->content}}
                </p>
            </div>
            <div class="panel-footer">
                @if($r->is_liked_by_user())
                    <a href="{{route('reply.unlike', ['id' => $r->id])}}" class="btn btn-danger btn-xs">Unlike </a>
                @else
                    <a href="{{route('reply.like', ['id' => $r->id])}}" class="btn btn-success btn-xs">Like
                    </a>
                @endif
                <span class="pull-right badge">{{$r->likes->count()}} users like this</span>
            </div>
        </div>
    @endforeach
    @if($d->has_best_answer())
        <div class="text-center">
            <h2>This topic is closed.</h2>
        </div>
    @else
        @if(\Illuminate\Support\Facades\Auth::check())
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="{{route('discussion.reply', ['id' => $d->id])}}" method="post">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="reply">Leave a reply</label>
                            <textarea name="reply" id="reply" class="form-control" rows="10" cols="30"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn text-center btn-info">Leave a reply</button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="text-center">
                <h2>Sign in to leave a reply</h2>
            </div>
        @endif()

    @endif


@endsection
