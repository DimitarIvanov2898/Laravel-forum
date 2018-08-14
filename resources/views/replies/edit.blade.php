@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Edit reply</div>

        <div class="panel-body">
            <form action="{{route('reply.update', ['id'=> $r->id])}}" method="post">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="content">Reply</label>
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{$r->content}}</textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>

@endsection
