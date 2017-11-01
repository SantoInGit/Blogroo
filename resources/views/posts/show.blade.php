@extends('layouts.app')

@section('content')
  <a href="/posts" class="btn btn-default" role="button">Go Back</a>
  <h1>{{$post->title}}</h1>
  <h6>{{$post->created_at->toFormattedDateString()}} by <strong>{{$post->user->name}}</strong></h6>
  <img style="width:50%" src="/storage/cover_images/{{$post->cover_image}}" alt="">
  <br><br>
  <div>
    <article>{!!$post->body!!}</article>
  </div>

  <hr>

  @if(!Auth::guest()) <!--if the user is not a guest-->
    @if(Auth::user()->id == $post->user_id) <!-- and if the post belongs to logged in user, then show following buttons -->

      <a href="/posts/{{$post->id}}/edit" class="btn btn-default" role="button" style="display: inline-block">Edit</a>

      {!! Form::open(['action' => ['PostsController@update',$post->id],'method'=>'post', 'style'=>'display: inline-block']) !!}
        {{Form::hidden('_method','DELETE')}}
        {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
      {!! Form::close()!!}

    @endif
  @endif

  <h2>Comments</h2>

  <div class="card">
    <div class="card-block">
      <ul class="list-group">

      @if(count($post->comments)>0)
        @foreach($post->comments as $comment)
            <li class="list-group-item" >
              <strong>{{ $comment->created_at->diffForHumans()}} by {{$comment->user->name}}: &nbsp</strong>{{$comment->body}}
            </li>
          @endforeach
      @endif

      </ul>
  </div>
</div>

<div class="card">
  <div class="card-block">

    <form action="/posts/{{$post->id}}/comments" method="post">

      {{ csrf_field() }}

      <div class="form-group">
        <textarea name="body" placeholder="Your comment here." class="form-control"></textarea>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary">Add Comment</button>
      </div>

    </form>
  </div>
</div>

@endsection
