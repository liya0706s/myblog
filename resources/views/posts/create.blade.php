@extends('layouts.app')

@section('title', '我的部落格-新增文章')

@section('content')
    <h1 class="mt-3">新增文章</h1>
    @include('posts.partials.form', [
        'action' => route('posts.store'),
        'method' => 'POST',
        'post' => null,
        'readonly' => false,
    ])
@endsection

@section('scripts')
    @vite('resources/js/index.js')
@endsection