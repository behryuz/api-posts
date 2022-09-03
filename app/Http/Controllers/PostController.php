<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'per_page' => 'nullable|int|min:1|max:50'
        ]);

        $posts = Post::query()
            ->with('tags')
            ->latest()
            ->paginate($request->input('per_page'));

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return PostResource
     */
    public function store(PostRequest $request)
    {
        $post = Post::create([
            'title' => $request->input('title'),
            'body'  => $request->input('body')
        ]);

        $post->tags()->sync($request->input('tags'));

        $post->load('tags');

        return new PostResource($post);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param Post $post
     * @return PostResource
     */
    public function update(PostRequest $request, Post $post): PostResource
    {
        $post->update([
            'title' => $request->input('title'),
            'body'  => $request->input('body')
        ]);

        $post->tags()->sync($request->input('tags'));

        $post->load('tags');

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return response()->json(['message' => 'Post deleted']);
    }
}
