<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $favorites = $request->user()->posts()->with('category')->get();

        $data = [
            'favorites' => $favorites,
        ];

        return $this->apiDataResponse($data, 'Favorites fetched successfully');
    }

    public function toggleFavorite(Request $request, $post_id)
    {
        $post = Post::find($post_id);

        if (!$post) {
            return $this->apiErrorResponse('Post not found', 404);
        }

        $user = $request->user();

        if ($user->posts()->where('post_id', $post_id)->exists()) {
            // لو موجود → نحذفه
            $user->posts()->detach($post_id);
            return $this->apiDataResponse($post, 'Post removed from favorites successfully');
        } else {
            // لو مش موجود → نضيفه
            $user->posts()->attach($post_id);
            return $this->apiDataResponse($post, 'Post added to favorites successfully');
        }
    }

}


