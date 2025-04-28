<?php

namespace App\Http\Controllers;

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
}
