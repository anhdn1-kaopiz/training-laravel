<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository
    ) {}

    /**
     * Get all posts with pagination
     */
    public function getAllWithPaginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->postRepository->getAllWithPaginate($perPage);
    }

    /**
     * Get post by id
     */
    public function findById(int $id): ?Post
    {
        return $this->postRepository->findById($id);
    }

    /**
     * Create new post
     */
    public function create(array $data): Post
    {
        $data['user_id'] = Auth::id();

        $post = $this->postRepository->create($data);

        if (!empty($data['categories'])) {
            $this->postRepository->syncCategories($post, $data['categories']);
        }

        return $post;
    }

    /**
     * Update post
     */
    public function update(Post $post, array $data): bool
    {
        $result = $this->postRepository->update($post, $data);

        if (!empty($data['categories'])) {
            $this->postRepository->syncCategories($post, $data['categories']);
        }

        return $result;
    }

    /**
     * Delete post
     */
    public function delete(Post $post): bool
    {
        return $this->postRepository->delete($post);
    }
}
