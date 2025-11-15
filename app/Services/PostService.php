<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

class PostService
{
    public function createPost(array $data): array
    {
        try {
            $post = Post::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'user_id' => auth()->id() ?? '1',   // 假設沒有登入是給1, angie
                'category_id' => $data['category_id'],
            ]);

            return [
                'success' => true,
                'message' => '文章建立成功',
                'post' => $post,
            ];
        } catch (\Exception $e) {
            Log::error('建立文章失敗:' . $e->getMessage());
            // dd($e->getMessage());

            return [
                'success' => false,
                'message' => '文章建立失敗，請稍後再試。',
                'post' => null,
            ];
        }
    }

    public function updatePost(Post $post, array $data): array
    {
        try {
            $post->update([
                'title' => $data['title'],
                'content' => $data['content'],
                'category_id' => $data['category_id']
            ]);

            return [
                'success' => true,
                'message' => '文章更新成功',
                'post' => $post,
            ];
        } catch (\Exception $e) {
            Log::error('文章更新失敗：' . $e->getMessage());

            return [
                'success' => false,
                'message' => '文章更新失敗，請稍後再試。',
                'post' => null,
            ];
        }
    }

    public function deletePost(Post $post): array
    {
        try {
            $post->delete();
            return ['success' => true, 'message' => '已刪除文章。'];
        } catch (\Exception $e) {
            Log::error('刪除失敗：' . $e->getMessage());
            return ['success' => false, 'message' => '系統錯誤，請稍後再試。'];
        }
    }

    /**
     * 查找搜尋欄位的值
     *
     * @param array $filters
     * @return array
     */
    public function getFilteredPosts($filters): array
    {
        $query = Post::query();

        if (!empty($filters['keyword'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['keyword']. '%')
                    ->orWhere('content', 'like', '%' . $filters['keyword'] . '%')
                    ->orWhereHas('user', function ($q2) use ($filters) {
                        $q2->where('name', 'like', '%' . $filters['keyword'] . '%');
                    });
            });
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        $posts = $query->with(['category', 'user'])
                    ->latest()
                    ->paginate(10)
                    ->withQueryString();

        $categories = Category::all();

        return [
            'posts' => $posts,
            'categories' => $categories,
        ];
    }
}