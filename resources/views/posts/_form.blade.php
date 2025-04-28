
<div>
    <label for="title">Tiêu đề:</label><br>
    <input type="text"
           id="title"
           name="title"
           value="{{ old('title', $post->title ?? '') }}"
           >
    @error('title')
        <div style="color: red;">{{ $message }}</div>
    @enderror
</div>
<br>

<div>
    <label for="content">Nội dung:</label><br>
    <textarea id="content" name="content" rows="5" >{{ old('content', $post->content ?? '') }}</textarea>
    @error('content')
        <div style="color: red;">{{ $message }}</div>
    @enderror
</div>
<br>

<div>
    <label>Chuyên mục:</label><br>
    @if($categories->count() > 0)
        @foreach ($categories as $category)
            <input type="checkbox"
                   name="categories[]" 
                   value="{{ $category->id }}"
                   id="category_{{ $category->id }}"
                   @if(is_array(old('categories')) && in_array($category->id, old('categories')))
                       checked
                   @elseif(isset($postCategoryIds) && in_array($category->id, $postCategoryIds) && !is_array(old('categories')))
                       checked
                   @endif
                   >
            <label for="category_{{ $category->id }}">{{ $category->name }}</label><br>
        @endforeach
    @else
        <p>Chưa có chuyên mục nào.</p>
    @endif
    @error('categories') 
        <div style="color: red;">{{ $message }}</div>
    @enderror
     @error('categories.*')
        <div style="color: red;">{{ $message }}</div>
    @enderror
</div>
<br>

<button type="submit">{{ $submitButtonText ?? 'Lưu' }}</button>