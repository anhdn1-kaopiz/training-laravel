<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    /**
     * Get all posts with pagination
     */
    public function getAllWithPaginate(int $perPage = 10): LengthAwarePaginator
    {
        return Post::with('user', 'categories')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get post by id
     */
    public function findById(int $id): ?Post
    {
        return Post::with('user', 'categories')->find($id);
    }

    /**
     * Create new post
     */
    public function create(array $data): Post
    {
        return Post::create($data);
    }

    /**
     * Update post
     */
    public function update(Post $post, array $data): bool
    {
        return $post->update($data);
    }

    /**
     * Delete post
     */
    public function delete(Post $post): bool
    {
        return $post->delete();
    }

    /**
     * Sync categories for post
     */
    public function syncCategories(Post $post, array $categoryIds): void
    {
        $post->categories()->sync($categoryIds);
    }
}
