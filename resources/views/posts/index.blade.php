@extends('layouts.app')

@section('title', '我的部落格')

@section('content-search')
    <div class="p-3 mb-3">
        <form method="GET" action="{{ route('posts.index') }}" class="row g-2 align-itmes-center">
            <div class="col-md-4">
                <input type="text" name="keyword" class="form-control" placeholder="搜尋標題、內容或作者"
                    value="{{ request('keyword') }}">
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">全部分類</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 text-right">
                <button type="submit" class="btn btn-primary">搜尋</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">重設</a>
            </div>
        </form>
    </div>
@endsection

@section('content')
    <h1 class="mt-3">文章列表</h1>
    <div class="text-end p-1">
        <a href="{{ route('posts.create') }}" target="_blank" class="btn btn-primary btn-small">新增文章</a>
    </div>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>標題</th>
                <th>作者</th>
                <th>分類</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->user->name ?? '-' }}</td>
                    <td>{{ $post->category->name ?? '-'  }}</td>
                    <td>
                        <a href="{{ route('posts.show', $post) }}">查看</a>
                        <a href="{{ route('posts.edit', $post) }}">編輯</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm">刪除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">目前沒有文章</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex mt-3">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>
@endsection