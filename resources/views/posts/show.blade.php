<h1>{{ $post->title }}</h1>
<p><em>Tác giả: {{ $post->user->name }} - Đăng lúc: {{ $post->created_at->format('d/m/Y H:i') }}</em></p>

<div>
    <strong>Chuyên mục:</strong>
    @forelse($post->categories as $category)
        <span>{{ $category->name }}</span>{{ !$loop->last ? ',' : '' }}
    @empty
        <span>Chưa phân loại</span>
    @endforelse
</div>
<hr>
<div>
    {!! nl2br(e($post->content)) !!}
</div>
<hr>
<a href="{{ route('posts.edit', $post) }}">Chỉnh sửa</a> |
<a href="{{ route('posts.index') }}">Quay lại danh sách</a>