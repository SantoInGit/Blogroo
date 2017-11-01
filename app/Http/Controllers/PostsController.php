<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;  //to work with storage folder
use App\Post;
use App\Comment;
use DB;
use Carbon\Carbon;

class PostsController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
        //this means users, who are not logged in, will required to be authenticated to get any posts views except index and show views
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$posts = Post::all(); //gets all post
        //$posts = DB:select('SELECT * FROM posts');
        //$posts = Post::orderBy('title','desc')->get();
        //$posts = Post::orderBy('title','desc')->take(1)->get();
        //$post = Post::where('title','Post two')->get();
        //$posts = Post::orderBy('created_at','desc')->paginate(5);

        $posts = Post::latest();
        //when the archieves links are clicked.
        if($month = request('month')){
          $posts->whereMonth('created_at', Carbon::parse($month)->month);
        }
        if($year = request('year')) {
          $posts->whereYear('created_at',$year);
        }
        //
        //$posts->orderBy('created_at','desc')->paginate(5);
        //$posts = $posts->get();
        $posts = $posts->orderBy('created_at','desc')->paginate(3);

        $archives = Post::selectRaw(' year(created_at) year, monthname(created_at) month, count(*) published')
        ->groupBy('year','month')
        ->orderByRaw('min(created_at) desc')
        ->get()
        ->toArray();
        return view('posts.index', compact('posts','archives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
          'title'=> 'required',
          'body'=>'required',
          'cover_image'=>'image|nullable|max:1999'
        ]);


        //handle file upload

        if($request->hasFile('cover_image')){
          //Get filename with the extension
          $fileNameWithExtension = $request->file('cover_image')->getClientOriginalName();

          //get just file name without extension
          $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);

          //get just extension
          $extension = $request->file('cover_image')->getClientOriginalExtension();

          //create file name to Store
          $fileNameToStore = $fileName.'_'.time().'.'.$extension;

          //upload Image
          $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
          //this saves the image to storage/app/public/cover_images which is not accessible through browser.
          //We need to link this folder to browser accessible public folder by running following artisan command.
          //Basically it creates a folder in public folder which is mirror of original folder "storage"

          //[artisan command]  $ php artisan storage:link

          //

        }else{
          $fileNameToStore = 'no_image.jpg';
        }

        //Create post
        $post = new Post;
        $post->title =  $request->input('title');
        $post->body =  $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success','Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);
        return view("posts.show")->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::find($id);

        //check for correct user ie can't let others' post to be edited by current user. redirect to /posts with error message
        if(auth()->user()->id !== $post->user_id){
          return redirect('/posts')->with('error', 'Unauthorised page!!');
        }
        return view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[
          'title'=> 'required',
          'body'=>'required'
        ]);

        //handle file upload

        if($request->hasFile('cover_image')){
          //Get filename with the extension
          $fileNameWithExtension = $request->file('cover_image')->getClientOriginalName();

          //get just file name without extension
          $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);

          //get just extension
          $extension = $request->file('cover_image')->getClientOriginalExtension();

          //create file name to Store
          $fileNameToStore = $fileName.'_'.time().'.'.$extension;

          //upload Image
          $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
          //this saves the image to storage/app/public/cover_images which is not accessible through browser.
          //We need to link this folder to browser accessible public folder by running following artisan command.
          //Basically it creates a folder in public folder which is mirror of original folder "storage"

          //[artisan command]  $ php artisan storage:link

          //

        }

        //Update post
        $post = Post::find($id); //find the post to be updated by id
        $post->title =  $request->input('title');
        $post->body =  $request->input('body');
        if($request->hasFile('cover_image')){
          $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success','Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);
        //check for correct user ie can't let others' post to be deleted by current user. redirect to /posts with error message
        if(auth()->user()->id !== $post->user_id){
          return redirect('/posts')->with('error', 'Unauthorised page!!');
        }

        if($post->cover_image != 'no_image.jpg'){
              Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success','Post Removed');
    }
}
