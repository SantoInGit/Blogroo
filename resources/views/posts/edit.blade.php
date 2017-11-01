@extends('layouts.app')

@section('content')

  <h1>Edit Post</h1>
  {!! Form::open(['action' => ['PostsController@update',$post->id],'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
    <div class="form-group">
      {{Form::label('title','Title')}}
      {{Form::text('title',$post->title,['class'=>'form-control','placeholder'=>'Title for your post'])}}
    </div>
    <div class="form-group">
        {{Form::label('body','Body')}}
        {{Form::textarea('body',$post->body,['class'=>'form-control','placeholder'=>'Body of your post','id'=>'article-ckeditor'])}}
    </div>
    <div class="form-group">
      {{Form::file('cover_image')}}
    </div>
    {{Form::hidden('_method','PUT')}}
    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
  {!! Form::close() !!}

@endsection
