<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Helpers\ResponseHelper;

class PostApiController extends Controller
{
    // Get all posts
    public function all()
    {
        $posts = Posts::all();

        if ($posts->isEmpty()) {
            return ResponseHelper::error('No posts found');
        }

        return ResponseHelper::success($posts, 'All posts retrieved');
    }

    // Get selected post by ID
    public function SelectedPost($id)
    {
        $post = Posts::find($id);

        if (!$post) {
            return ResponseHelper::error('Post not found');
        }

        return ResponseHelper::success($post, 'Post retrieved');
    }

    // Get posts by category
    public function Category($categoryId)
    {
        $posts = Posts::where('category_id', $categoryId)->get();

        if ($posts->isEmpty()) {
            return ResponseHelper::error('No posts found in this category');
        }

        return ResponseHelper::success($posts, 'Posts retrieved by category');
    }

    // Get post by category and post ID
    public function CategorySelectedId($categoryId, $postId)
    {
        $post = Posts::where('category_id', $categoryId)
                     ->where('id', $postId)
                     ->first();

        if (!$post) {
            return ResponseHelper::error('Post not found in this category');
        }

        return ResponseHelper::success($post, 'Post retrieved by category and ID');
    }
}
