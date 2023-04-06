<?php

namespace App\Http\Controllers\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class postController extends Controller
{
    //
    public function index($categoryId){
        $posts = Post::withCommentsByCategoryId($categoryId)->get();
        return view('post.index',  ['categoryId' => $categoryId, 'posts' => $posts]);
    }

    public function create(){
        return view('posts/create');
    }

    public function insert(Request $request,$category_id){
        $validatedData = $request->validate([
            'body' => ['required', 'string', 'max:500']
        ]);
        $user = Auth::user()->id;
        $post = Post::create([
            'body' => $validatedData['body'],
            'category_id' => $category_id,
            'created_by' => $user
        ]);

        return redirect()->route('posts.index', $category_id)->with('success', 'Post created successfully.');
    } 
}
