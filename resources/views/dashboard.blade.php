@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h2>Welcome to Dashboard</h2></div>

                <div class="panel-body">
                    <a href="/posts/create" class="btn btn-primary">Create Posts</a>
                    <a href="/profile/{{auth()->id()}}" class="btn btn-primary">View Profile</a>
                    <h3>Your Blog Posts( {{count($posts)}} )</h3>

                    @if(count($posts) > 0)
                    <table class="table table-hover">
                      <tr>
                          <th class="text-center">Post Title</th>

                          <th class="text-center">Action</th>
                      </tr>
                      @foreach($posts as $post)
                        <tr>
                          <td>{{$post->title}}
                          <span class="pull-right">{{count($post->likes)}}likes {{count($post->comments)}} comments</span>
                          </td>
                          <td class="text-center">
                            <a href="/posts/{{$post->id}}/edit" class="btn btn-primary" role="button" style="display: inline-block">Edit</a>

                            <a href="/posts/{{$post->id}}" class="btn btn-primary" role="button" style="display: inline-block">View</a>

                            {!! Form::open(['action' => ['PostsController@update',$post->id],'method'=>'post','style'=>'display: inline-block']) !!}
                              {{Form::hidden('_method','DELETE')}}
                              {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
                            {!! Form::close()!!}
                          </td>

                        </tr>
                      @endforeach
                    @else
                      <p> You have no post. Create a new post </p>

                    @endif
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
