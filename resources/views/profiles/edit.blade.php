@extends('layouts.app')

@section('content')

  <h1>Edit Profile</h1>
  {!! Form::open(['action' => ['ProfilesController@update',$profile->id],'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
    <div class="form-group">
      {{Form::label('address','Address')}}
      {{Form::text('address',$profile->address,['class'=>'form-control','placeholder'=>'Your address'])}}
    </div>
    <div class="form-group">
      {{Form::label('aboutme','About Me')}}
      {{Form::text('aboutme',$profile->about_me,['class'=>'form-control','placeholder'=>'Short line about yourself'])}}
    </div>

    <div class="form-group">
      {{Form::file('profile_image')}}
    </div>

    {{Form::hidden('_method','PUT')}}
    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
  {!! Form::close() !!}

@endsection
