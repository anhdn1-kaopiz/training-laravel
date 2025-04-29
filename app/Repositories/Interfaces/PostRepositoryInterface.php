<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    /**
     * Get all posts with pagination
     */
    public function getAllWithPaginate(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get post by id
     */
    public function findById(int $id): ?Post;

    /**
     * Create new post
     */
    public function create(array $data): Post;

    /**
     * Update post
     */
    public function update(Post $post, array $data): bool;

    /**
     * Delete post
     */
    public function delete(Post $post): bool;

    /**
     * Sync categories for post
     */
    public function syncCategories(Post $post, array $categoryIds): void;
}
