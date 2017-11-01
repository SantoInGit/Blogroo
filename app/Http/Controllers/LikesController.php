<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Like;

class LikesController extends Controller
{
    //

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth',['except'=>['index','show']]);
        $this->middleware('auth');
        //this means users, who are not logged in, will required to be authenticated(logged in)
        //to invoke functions below in this controller
    }

    public function store(Post $post)
    {
        // //checking if ther user has already liked the post. ie if the user has like the post, there should
        // //be a record in the likes table
        // $alreadyLiked = $post->likes->where('user_id',auth()->id());
        // if(count($alreadyLiked) == 0)
        //   //i.e there is no record of the current user liking the post, create new like record
        // {
        //Create Like
          $like = new Like;
          $like->post_id =  $post->id;
          $like->user_id = auth()->user()->id;
          $like->save();

          $messageType = "success";
          $messageBody = "You've recently liked a post by ".$post->user->name;
        // }else{
        //   $messageType = "error";
        //   $messageBody = "Sorry! You have already liked this post.";
        //   // $likeButtonText = "Like";
        // }
        return redirect('/posts')->with($messageType,$messageBody);
        //return redirect('/posts')->with($messageType,$messageBody)->withLikebuttontext("Unlike");
        //return redirect('/posts')->with(compact('messageType','messageBody','likeButtonText'));
      }


    public function destroy(Post $post){
      $id = $post->likes->where('user_id',auth()->id())->pluck('id')->toArray();
      $like = Like::find($id[0]);
      $like->delete();
      return redirect('/posts');
    }
}
