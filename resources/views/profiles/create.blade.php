@extends('layouts.app')

@section('content')

  <h1>Create Profile</h1>
  {!! Form::open(['action' => 'ProfilesController@store','method'=>'post', 'enctype'=>'multipart/form-data']) !!}
    <div class="form-group">
      {{Form::label('address','Address')}}
      {{Form::text('address','',['class'=>'form-control','placeholder'=>'Your address here.'])}}
    </div>
    <div class="form-group">
      {{Form::label('aboutme','About Me')}}
      {{Form::text('aboutme','',['class'=>'form-control','placeholder'=>'Short line about yourself'])}}
    </div>
    <div class="form-group">
      {{Form::file('profile_image')}}
    </div>
    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
  {!! Form::close() !!}

@endsection
