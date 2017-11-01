@extends('layouts.app')
@section('content')
  <div class="jumbotron text-center">
    <h1>{{$title}}</h1>
    <p>Login or register to get started with exciting new blog post application.</p>
    <p><a class="btn btn-primary btn-lg" href="/login" role="button">Login</a>
    <a class="btn btn-success btn-lg" href="/register" role="button">Register</a></p>
  </div>
@endsection
