@extends('layouts.app')

@section('title', '我的部落格-單筆文章')

@section('content')
    <h1 class="mt-3">單筆文章</h1>
    @include('posts.partials.form', [
        'action' => '#',
        'method' => 'GET',
        'post' => $post,
        'readonly' => true,
    ])
@endsection