<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user', 'categories')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'nullable|array',
        ]);

        //random user id
        $randomUser = User::inRandomOrder()->first();
        $randomUserId = $randomUser->id;

        // create Post
        $post = new Post();
        $post->user_id = $randomUserId;
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->save();

        if (!empty($validatedData['categories'])) {
            $post->categories()->attach($validatedData['categories']);
        }

        return redirect()->route('posts.index')
                         ->with('status', 'Bài viết đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        
        $post->load('user', 'categories');
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        $postCategoryIds = $post->categories->pluck('id')->toArray();

        return view('posts.edit', compact('post', 'categories', 'postCategoryIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id'
        ]);

        // update Post
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->save();

        $post->categories()->sync($validatedData['categories'] ?? []);

        return redirect()->route('posts.index')
                         ->with('status', 'Bài viết đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->categories()->detach();
        $post->delete();

        return redirect()->route('posts.index')
                         ->with('status', 'Bài viết đã được xóa thành công!');
    }
}
