<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\IndexPostRequest;
use App\Models\Post;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
class PostController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        // Start query on posts and eager load the category relationship
        $query = Post::with('category');

        // If a specific category_id is provided, filter posts by that category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Execute the query and get the results
        $posts = $query->get();

        // Prepare the response data
        $data = [
            'posts' => $posts,
        ];

        // Return JSON response with success message
        return $this->apiDataResponse($data, 'Posts fetched successfully');
    }

    public function show($id)
    {
        // Find the post and eager load its category
        $post = Post::with('category')->find($id);

        // If post not found, return an error response
        if (!$post) {
            return $this->apiErrorResponse('Post not found', 404);
        }

        // Prepare the response data
        $data = [
            'post' => $post,
        ];

        // Return JSON response with success message
        return $this->apiDataResponse($data, 'Post fetched successfully');
    }
}

