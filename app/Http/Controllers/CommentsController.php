<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class CommentsController extends Controller
{


  //create a comment to a post
    public function store(Post $post){

      //validate the request
      $this->validate(request(),[
        'body'=>'required|min:1'
      ]);

      //if validated create comment
      Comment::create([
        'body'=> request('body'),
        'post_id' => $post->id,
        'user_id' => auth()->id()
      ]);

      //redirect back to previous page
    //  $c = $post->comments->sortByDesc('id');
      //return view('posts.show')->with('c',$c);
      return back();
    //  return view("posts.show")->with('c',$c);
    }


}
