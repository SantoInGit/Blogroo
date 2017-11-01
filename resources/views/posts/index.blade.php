@extends('layouts.app')

@section('content')

  <h1>Post</h1>
  @if(count($posts) > 0)
    <div class="row">
    <div class="col-md-8 col-sm-8">
    @foreach($posts as $post)
      <div class="well">
        <div class="row">
            <div class="col-md-2 col-sm-2">
              <img style="width:100%" src="/storage/cover_images/{{$post->cover_image}}" alt="">
            </div>

            <div class="col-md-10 col-sm-10">
              <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
              <h6>
                {{$post->created_at->toFormattedDateString()}} by <strong>{{$post->user->name}}</strong>
                &nbsp&nbsp<span class="badge badge-success">&nbsp{{count($post->comments)}} comments</span>
                &nbsp&nbsp<span class="badge badge-success">&nbsp{{count($post->likes)}} likes</span>
              </h6>
              <!-- $post->user->name is possible here because we have created a function user in POST model for relation with the user-->
              <!-- Same reason for $post->comments -->

              <div class="well">
                <p>{!!$post->body!!}</p>
              </div>

              <div class="row">

                  {{-- <form action="/posts/{{$post->id}}/likes" method="post" style="display: inline-block">
                    {{csrf_field()}}
                    find out if the logged in user has already liked the post. If yes, display Unlike button else display Like button
                    @if( count($alreadyLiked = $post->likes->where('user_id',auth()->id())) > 0)
                      <button class="btn btn-danger"> Unlike </button>
                      <a href="/likes/{{$alreadyLiked}}" class="btn btn-danger" role="Button">Unlike</a>
                    @else
                      <button type="submit" class="btn btn-primary">Like</button>
                    @endif
                  </form> --}}

                  @if( count($alreadyLiked = $post->likes->where('user_id',auth()->id())) > 0)
                    {!! Form::open(['action' => ['LikesController@destroy',$post],'method'=>'post','style'=>'display: inline-block']) !!}
                      {{Form::hidden('_method','DELETE')}}
                      {{Form::submit('Unlike',['class'=>'btn btn-danger'])}}
                    {!! Form::close()!!}
                @else
                    {!! Form::open(['action' => ['LikesController@store',$post],'method'=>'post','style'=>'display: inline-block']) !!}
                      {{Form::submit('Like',['class'=>'btn btn-primary'])}}
                    {!! Form::close()!!}
                  @endif

                  <a href="/posts/{{$post->id}}" class="btn btn-primary">Comment</a>

              </div>
            </div>

            </div>
          </div>
      @endforeach

      </div>

      <div class="col-md-4 col-sm-4">

            <div class="well" style="padding-top: 2px">
              <div class="card-block">
                <h1 class="card-title">Archives</h1>
                @foreach($archives as $archiveItem)
                    <a href="/posts/?month={{$archiveItem['month']}}&year={{$archiveItem['year']}}">
                      <p class = "card-text">
                        {{$archiveItem['month'] .' '. $archiveItem['year'] .'('.$archiveItem['published'] .')'}}
                      </p>
                    </a>
                @endforeach
              </div>
            </div>


      </div>

    </div>

    <div class="text-center">
    {{$posts->links()}}
    </div>

  @else
    <p> No posts Found </p>
  @endif

@endsection
