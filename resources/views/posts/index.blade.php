
<h1>Danh sách bài viết</h1>

@if (session('status'))
    <div style="color: green;">
        {{ session('status') }}
    </div>
@endif

<a href="{{ route('posts.create') }}">Tạo bài viết mới</a>

<ul>
    @forelse ($posts as $post)
        <li>
            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
            (by {{ $post->user->name }}) -
            Categories:
            @foreach($post->categories as $category)
                <span>{{ $category->name }}</span>{{ !$loop->last ? ',' : '' }}
            @endforeach
            <a href="{{ route('posts.edit', $post) }}" style="margin-left: 10px;">Sửa</a>
            <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline-block; margin-left: 10px;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
            </form>
        </li>
    @empty
        <li>Chưa có bài viết nào.</li>
    @endforelse
</ul>

{{ $posts->links() }}