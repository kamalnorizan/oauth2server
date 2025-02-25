<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $postCount = Post::count();
        // $posts = Post::all();
        // $posts = Post::where('id', '>', 100)->get();
        // $posts = Post::where('id', 1)->get();
        // dd($posts);

        // $post = Post::first();
        // $post = Post::find(5);

        // $users = User::whereHas('posts')->count();

        // $posts = Post::all();
        // dump($posts->first());
        // $posts = Post::with('user.posts')->get();

        $posts = Post::with(['user'=>function($query){
            $query->withCount('posts');
        }])->get();

        return $posts;

        // dd($posts->first());
        // foreach ($posts as $post) {
        //     echo $post->title . ' | ~'.$post->user->name.'('.$post->user->posts_count.')'.'<br>';
        // }

        // dd($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
