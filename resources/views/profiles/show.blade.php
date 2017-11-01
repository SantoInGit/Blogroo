@extends('layouts.app')
@section('content')

<div class="row text-center">
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <div class="card text-center">
      <img class="card-img-top img-circle" style="width:40%; height:20%" src="/storage/profile_images/{{$profile->profile_image}}" alt="Card image cap">
      <div class="card-block">
      <h1 class="card-title">{!!$profile->user->name!!}</h1>
      <p class="card-text"><strong class="text-muted">{!!$profile->user->email!!}</strong></p>
      <p class="card-text"><small class="text-muted">{!!$profile->address!!}</small></p>
      <p class="card-text">{!!$profile->about_me!!}</p>

      <div class="row text-center">
        <div class="col-md-4">
          {{-- <div class="bg-primary" style="padding: 10px">{{$likesForProfile}} likes</div> --}}
          <div class="bg-primary" style="padding: 10px"> Following {{$isFollowingForProfile}}</div>
        </div>

        <div class="col-md-4">
          {{-- <div class="bg-primary" style="padding: 10px">{{$commentsForProfile}} comments</div> --}}
          <div class="bg-primary" style="padding: 10px">{{$followersForProfile}} Followers</div>
        </div>

        <div class="col-md-4">
          <div class="bg-primary" style="padding: 10px">{{$postsForProfile}} posts</div>
        </div>
      </div>
      <div class="row">
        <br>

      {{-- display Follow/Unfollow button --}}
      {{-- if the logged in user has followed the user in the profile, display Unfollow button else display Follow button --}}
      {{-- do not display the Follow/UnFollow button in profile of current logged in user --}}
      {{--Guests can not Follow/Unfollow users--}}
      @if(!Auth::guest())
        {{-- check if current user is view profile of his/her own. if no, display the Follow/Unfollow button --}}
        @if( auth()->id() != $profile->user_id )
          {{-- @if()  check to see if the current user has already followed the user with $profile->user_id--}}
          @if(  count(auth()->user()->followers->where('isFollowing_user_id',$profile->user->id)) >0  )
              {{-- here $profile->user->followers are the collection of followers record of profile->user which is clicked --}}
              {!! Form::open(['action' => ['FollowersController@destroy',$profile->user_id],'method'=>'post','style'=>'display: inline-block']) !!}
                {{Form::hidden('_method','DELETE')}}
                {{Form::submit('UnFollow',['class'=>'btn btn-danger'])}}
              {!! Form::close()!!}
          @else
            <form action="/followers/{{$profile->id}}/follower" method="post">
              {{csrf_field()}}
              <button type="submit" class="btn btn-primary">Follow</button>
            </form>
          @endif
        @endif
      @endif
      </div>
    </div>

    <br>

    {{--Display edit and delete button to only the user that the profile belong to--}}
    @if(!Auth::guest()) <!--if the user is not a guest-->
      @if(Auth::user()->id == $profile->user_id) <!-- and if the profile belongs to logged in user, then show following buttons -->
        <div class="well ">
          {{--Edit profile button--}}
          <a href="/profile/{{$profile->id}}/edit" class="btn btn-default" role="button" style="display: inline-block">Edit</a>
          {{--Delete profile button--}}
          {!! Form::open(['action' => ['ProfilesController@update',$profile->id],'method'=>'post', 'style'=>'display: inline-block']) !!}
            {{Form::hidden('_method','DELETE')}}
            {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
          {!! Form::close()!!}

        </div>
      @endif
    @endif
    </div>
  </div>
  <div class="col-md-3"></div>

</div>
@endsection
