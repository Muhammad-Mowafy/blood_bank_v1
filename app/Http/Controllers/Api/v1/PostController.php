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
        $query = Post::with('category');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->get();

        $data = [
            'posts' => $posts,
        ];

        return $this->apiDataResponse($data, 'Posts fetched successfully');
    }

    public function show($id)
    {
        $post = Post::with('category')->find($id);

        if (!$post) {
            return $this->apiErrorResponse('Post not found', 404);
        }

        $data = [
            'post' => $post,
        ];

        return $this->apiDataResponse($data, 'Post fetched successfully');
    }
}
