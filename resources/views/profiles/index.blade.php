@extends('layouts.app')

@section('content')

  <h1>Profiles </h1>
  @if(count($profiles) > 0)

    <div class="row">
    @foreach($profiles as $profile)
           <div class="col-md-4">
             <div class="well">

               <div class="card text-center">
                 <img class="card-img-top" style="width:40%" src="/storage/profile_images/{{$profile->profile_image}}" alt="Card image cap">
                 <div class="card-block">
                   <h1 class="card-title">{!!$profile->user->name!!}</h1>
                   <p class="card-text"><strong class="text-muted">{!!$profile->user->email!!}</strong></p>
                   <p class="card-text"><small class="text-muted">{!!$profile->address!!}</small></p>
                   <p class="card-text">{!!$profile->about_me!!}</p>
                </div>

                  <div class="card-block">
                    {{-- @if( count($alreadyLiked = $post->likes->where('user_id',auth()->id())) > 0)
                      {!! Form::open(['action' => ['LikesController@destroy',$post],'method'=>'post','style'=>'display: inline-block']) !!}
                        {{Form::hidden('_method','DELETE')}}
                        {{Form::submit('Unlike',['class'=>'btn btn-danger'])}}
                      {!! Form::close()!!}
                  @else --}}
                      {{-- {!! Form::open(['action' => ['FollowersController@store',$profile],'method'=>'post']) !!}
                        {{Form::submit('Follow',['class'=>'btn btn-primary'])}}
                      {!! Form::close()!!} --}}
                    {{-- @endif --}}
                  <a href="/profile/{{$profile->user->id}}" class='btn btn-primary' >View Profile</a>
                  </div>

               </div>
           </div>
         </div>

    @endforeach
    </div>
    <div class="text-center">
      {{$profiles->links()}}
    </div>

  @else
    <p> No profiles Found </p>
  @endif

@endsection
