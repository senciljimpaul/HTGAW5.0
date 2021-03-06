<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Standing;
use Illuminate\Http\Request;
use App\Post;
use Auth;
use App\Cat;

use App\Users;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{

    public function index()
    {
        $posts = Standing::orderBy('id', 'desc')->paginate(10);
        return view('posts.index', compact('posts'));
    }


    public function create()
    {
        return view('posts.create');
    }
    public function store(Request $request)
    {

        return redirect('/posts');
    }


    public function show($id)
    {

        $standing = Standing::where('id', '=', $id)->get()->first();

        $categories = Grade::where('standing_id', '=', $id)->get();
        $post = Grade::where('standing_id','=',$id)->get()->first();


        $catingSum = DB::table('grades')
            ->groupBy('category')
            ->selectRaw('*, sum(score) as sum ,sum(total) as total')
            ->where('standing_id', '=', $id)
            ->get();


        return view('posts.show', compact('post', 'categories','standing', 'catingSum'));
    }


    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
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
        $post = Post::findOrFail($id);
        $post->update($request->all());

        return redirect('/posts/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Post::findOrFail($id);
        $posts->delete();

        return redirect('/posts');
    }


}
