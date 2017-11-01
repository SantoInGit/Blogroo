<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\Post;
use App\Like;
use App\Comment;
use App\Follower;


class ProfilesController extends Controller
{

  public function index(){

    $profiles = Profile::orderBy('created_at','desc')->paginate(3);
    return view('profiles.index')->with('profiles',$profiles);
  }
    public function create(){
      return view('profiles.create');
    }

    public function store(Request $request){
        $this->validate($request,[
          'address'=> 'required',
          'profile_image'=>'image|nullable|max:1999'
        ]);

        //handle file upload
        if($request->hasFile('profile_image')){
          //Get filename with the extension
          $fileNameWithExtension = $request->file('profile_image')->getClientOriginalName();

          //get just file name without extension
          $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);

          //get just extension
          $extension = $request->file('profile_image')->getClientOriginalExtension();

          //create file name to Store
          $fileNameToStore = $fileName.'_'.time().'.'.$extension;

          //upload Image
          $path = $request->file('profile_image')->storeAs('public/profile_images',$fileNameToStore);


        }else{
          $fileNameToStore = 'no_image.jpg';
        }

        //Create post
        $profile = new Profile;
        $profile->address =  $request->input('address');
        $profile->about_me = $request->input('aboutme');
        $profile->user_id = auth()->user()->id;
        $profile->profile_image = $fileNameToStore;
        $profile->save();

        return redirect('/dashboard')->with('success','Profile Created.');
    }


    public function show($profile_userid){
      //$profile = auth()->user()->profile;   //gets current signed in users profile.
      $profile = Profile::where('user_id',$profile_userid)->first();

      if(count($profile) > 0){
        $likesForProfile = count(Like::where('user_id',$profile_userid)->pluck('id'));
        $commentsForProfile = count(Comment::where('user_id',$profile_userid)->pluck('id'));
        $isFollowingForProfile = count(Follower::where('user_id',$profile_userid)->pluck('id'));
        $followersForProfile = count(Follower::where('isFollowing_user_id',$profile_userid)->pluck('id'));
        $postsForProfile = count(Post::where('user_id',$profile_userid)->pluck('id'));
        return view('profiles.show')->with(compact('profile', 'likesForProfile','commentsForProfile','postsForProfile','isFollowingForProfile','followersForProfile'));
      }else{
          return view('profiles.create')->with('error','Your profile does not exist. Create one below.');
      }
    }


    public function edit($profile_id){
      $profile = Profile::find($profile_id);
      //dd($profile);
      return view('profiles.edit')->with('profile',$profile);
    }

    public function update(Request $request, $profile_id){
        $this->validate($request,[
          'address'=>'required'
        ]);

        //handle file upload
        if($request->hasFile('profile_image')){
          //Get filename with the extension
          $fileNameWithExtension = $request->file('profile_image')->getClientOriginalName();

          //get just file name without extension
          $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);

          //get just extension
          $extension = $request->file('profile_image')->getClientOriginalExtension();

          //create file name to Store
          $fileNameToStore = $fileName.'_'.time().'profile_image'.auth()->id().$extension;

          //upload Image
          $path = $request->file('profile_image')->storeAs('public/profile_images',$fileNameToStore);
          //this saves the image to storage/app/public/cover_images which is not accessible through browser.
          //We need to link this folder to browser accessible public folder by running following artisan command.
          //Basically it creates a folder in public folder which is mirror of original folder "storage"

          //[artisan command]  $ php artisan storage:link
        }

        //Update post
        $profile = Profile::find($profile_id); //find the post to be updated by id
        $profile->address =  $request->input('address');
        $profile->about_me =  $request->input('aboutme');
        if($request->hasFile('profile_image')){
          $profile->profile_image = $fileNameToStore;
        }
        $profile->save();

        return redirect('/dashboard')->with('success','Profile Updated');
    }

    public function destroy($id){

    }

}
