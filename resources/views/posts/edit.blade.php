@extends('layouts.app')

@section('title', '我的部落格-編輯單筆')

@section('content')
    <h1 class="mt-3">單筆編輯</h1>
    @include('posts.partials.form', [
        'action' => route('posts.update', $post),
        'method' => 'PUT',
        'post' => $post,
        'readonly' => false,
    ])
@endsection

@section('scripts')
    @vite('resources/js/index.js')
@endsection