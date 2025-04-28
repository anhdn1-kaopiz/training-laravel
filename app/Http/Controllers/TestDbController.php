<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestDbController extends Controller
{
    public function practiceDb()
    {
        // get admin user
        $adminUser = DB::table('users')->where('email', 'admin@example.com')->first();
        echo "<h2>Admin User:</h2><pre>" . print_r($adminUser, true) . "</pre>";

        // get all category names
        $categoryNames = DB::table('categories')->pluck('name');
        echo "<h2>Category Names:</h2><pre>" . print_r($categoryNames->toArray(), true) . "</pre>";

        // count total posts
        $totalPosts = DB::table('posts')->count();
        echo "<h2>Total Posts:</h2><p>" . $totalPosts . "</p>";

        // get posts (title) with author (JOIN)
        $postsWithAuthors = DB::table('posts')
                            ->join('users', 'posts.user_id', '=', 'users.id')
                            ->select('posts.title', 'users.name as author')
                            ->orderBy('posts.created_at', 'desc')
                            ->limit(3)
                            ->get();
        echo "<h2>Latest 3 Posts with Authors:</h2><pre>" . print_r($postsWithAuthors->toArray(), true) . "</pre>";
    }

    public function practiceEloquent()
    {
        // get related data (with)
        $posts = Post::with('user')->take(2)->get();
        foreach ($posts as $post) {
            echo '<h3>' . $post->title . '</h3>' . ' by ' . $post->user->name . '<br>';
        }

        // get users with at least 3 posts (has)
        $usersWithPosts = User::has('posts', '>=', 7)->get();
        echo "<h2>Users with Posts:</h2><pre>" . print_r($usersWithPosts->toArray(), true) . "</pre>";

        // get posts by admin user (whereHas)
        $adminPosts = Post::whereHas('user', function ($query) {
            $query->where('name', 'Admin User');
        })->get();
        echo "<h2>Admin Posts:</h2><pre>" . print_r($adminPosts->toArray(), true) . "</pre>";

        // get categories with post count (withCount)
        $categories = Category::withCount('posts')->get();
        echo "<h2>Categories with Post Count:</h2><pre>" . print_r($categories->toArray(), true) . "</pre>";
    }
}
