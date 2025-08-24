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
        // Get all favorite posts of the authenticated user along with their category
        $favorites = $request->user()->posts()->with('category')->get();

        // Prepare the response data
        $data = [
            'favorites' => $favorites,
        ];

        // Return JSON response with success message
        return $this->apiDataResponse($data, 'Posts fetched successfully');
    }

    public function toggleFavorite(Request $request, $post_id)
    {
        // Find the post by ID
        $post = Post::find($post_id);

        // If post not found, return error
        if (!$post) {
            return $this->apiErrorResponse('Post not found', 404);
        }

        // Get the authenticated user
        $user = $request->user();

        // Check if the post already exists in user's favorites
        if ($user->posts()->where('post_id', $post_id)->exists()) {
            // If exists → remove it from favorites
            $user->posts()->detach($post_id);
            return $this->apiDataResponse($post, 'Post removed from favorites successfully');
        } else {
            // If not exists → add it to favorites
            $user->posts()->attach($post_id);
            return $this->apiDataResponse($post, 'Post added to favorites successfully');
        }
    }

}
