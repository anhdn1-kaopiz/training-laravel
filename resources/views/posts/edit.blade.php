
<h1>Chỉnh sửa bài viết: {{ $post->title }}</h1>

<form action="{{ route('posts.update', $post) }}" method="POST">
    @csrf
    @method('PUT')

    @include('posts._form', [
        'submitButtonText' => 'Cập nhật bài viết',
        'post' => $post,
        'categories' => $categories,
        'postCategoryIds' => $postCategoryIds
    ])
</form>

 <a href="{{ route('posts.index') }}">Quay lại danh sách</a>