
<h1>Tạo bài viết mới</h1>

<form action="{{ route('posts.store') }}" method="POST">
    @csrf

    @include('posts._form', ['submitButtonText' => 'Tạo bài viết', 'categories' => $categories])
</form>

<a href="{{ route('posts.index') }}">Quay lại danh sách</a>