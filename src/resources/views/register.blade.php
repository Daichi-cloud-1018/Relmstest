@extends('layouts.layouts')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<form class="register" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    <h1 class="register__title">商品登録</h1>

    <div class="form-group">
        <label for="name">商品名 <span class="badge">必須</span></label>
        <input id="name" type="text" name="name" placeholder="商品名を入力" value="{{ old('name') }}">
        @error('name')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="price">値段 <span class="badge">必須</span></label>
        <input id="price" type="number" name="price" placeholder="値段を入力" value="{{ old('price') }}">
        @error('price')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label>商品画像 <span class="badge">必須</span></label>
        <div class="image-upload">
            <div class="image-preview" id="imagePreview" @if(old('image_path')) style="display:block" @endif>
                <img id="previewImg" src="{{ old('image_path') }}" alt="プレビュー">
            </div>
            <div class="file-field">
                <label class="file-label">
                    <input type="file" name="image" id="imageInput" accept="image/png,image/jpeg">
                    ファイルを選択
                </label>
                <span class="file-name" id="fileName">{{ old('image_name') }}</span>
            </div>
        </div>
        @error('image')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label>季節 <span class="badge">必須</span> <span class="sub">複数選択可</span></label>
        <div class="checks">
            @php $checkedSeasons = old('season', []); @endphp
            @foreach($seasons as $season)
                <label class="check">
                    <input type="checkbox" name="season[]" value="{{ $season->id }}" {{ in_array($season->id, $checkedSeasons) ? 'checked' : '' }}>
                    {{ $season->name }}
                </label>
            @endforeach
        </div>
        @error('season')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">商品説明 <span class="badge">必須</span></label>
        <textarea id="description" name="description" rows="5" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
        @error('description')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-actions">
        <a class="btn btn--ghost" href="{{ route('products.index') }}">戻る</a>
        <button class="btn btn--primary" type="submit">登録</button>
    </div>
</form>

<script>
document.getElementById('imageInput')?.addEventListener('change', function (e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const img = document.getElementById('previewImg');
    const fileName = document.getElementById('fileName');
    if (file) {
        const reader = new FileReader();
        reader.onload = function (ev) {
            img.src = ev.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
        fileName.textContent = file.name;
    } else {
        preview.style.display = 'none';
        img.src = '';
        fileName.textContent = '';
    }
});
</script>
@endsection
