<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Services\PostService;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $filters = [
            'keyword' => $request->input('keyword'),
            'category_id' => $request->input('category_id'),
        ];

        $filteredPosts = $this->postService->getFilteredPosts($filters);

        $posts = $filteredPosts['posts'];
        $categories = $filteredPosts['categories'];

        return view('posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $result = $this->postService->createPost($data);

        if ($result['success']) {
            return redirect()->route('posts.index')
                            ->with('success', $result['message']);
        } else {
            return redirect()->back()
                            ->withInput()
                            ->with('error', $result['message']);
        }
    }

    public function show(Post $post)
    {
        if ($post->trashed()) {
            echo 'yes with soft delete';
        }
        $categories = Category::all();

        return view('posts.show', compact('post', 'categories'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(PostRequest $postRequest, Post $post)
    {
        $validateData = $postRequest->validated();
        // $categoryId = $request->input('category_id');
        $result = $this->postService->updatePost($post, $validateData);

        if ($result['success']) {
            return redirect()->route('posts.index')
                            ->with('success', $result['message']);
        } else {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($result['message']);
        }
    }

    public function destroy(Post $post)
    {
        $result = $this->postService->deletePost($post);
        if ($result['success']) {
            return redirect()->route('posts.index')
                            ->with('success', $result['message']);
        } else {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($result['message']);
        }
    }
}
