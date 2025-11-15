{{-- 需要以下四個有定義的參數：action, method, post, readonly --}}
<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="mb-3">
        <label>標題</label>
        <input type="text" name="title"
            value="{{ old('title', $post->title ?? '') }}"
            class="form-control"
            @if($readonly) readonly @endif>
    </div>

    <div class="mb-3">
        <label>分類</label>
        <div class="row gap-1">
            <div class="col-md-6">
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">選擇分類</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-secondary" id="add-category-btn"
                        data-bs-toggle="modal" data-bs-target="#categoryModal">
                    新增分類
                </button>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label>內容</label>
        <textarea name="content" rows="10" class="form-control"
        @if ($readonly) readonly @endif>{{ old('content', $post->content ?? '') }}</textarea>
    </div>

    @unless ($readonly)
        <button type="submit" class="btn btn-primary">儲存</button>
    @endunless
    <a href="{{ route('posts.index') }}" class="btn btn-light">返回</a>
</form>

{{-- Bootstrap Modal --}}
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">新增分類</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="new-category-name" name="form-label">分類名稱</label>
                    <input type="text" class="form-control" id="new-category-name" placeholder="輸入新分類">
                </div>
                <div class="text-danger small" id="category-error"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="save-category-btn">新增</button>
            </div>
        </div>
    </div>
</div>
