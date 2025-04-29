<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly PostService $postService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->postService->getAllWithPaginate();
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

        $this->postService->create($validatedData);

        return redirect()->route('posts.index')
            ->with('status', 'Bài viết đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = $this->postService->findById($post->id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::orderBy('name')->get();
        $postCategoryIds = $post->categories->pluck('id')->toArray();

        return view('posts.edit', compact('post', 'categories', 'postCategoryIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id'
        ]);

        $this->postService->update($post, $validatedData);

        return redirect()->route('posts.index')
            ->with('status', 'Bài viết đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $this->postService->delete($post);

        return redirect()->route('posts.index')
            ->with('status', 'Bài viết đã được xóa thành công!');
    }
}
