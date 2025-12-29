@extends('layouts.admin')

@section('header', isset($article) ? __('articles.edit') : __('articles.create'))

@section('content')
<div class="container-fluid pt-4 px-4">
    <form action="{{ isset($article) ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($article))
            @method('PUT')
        @endif

        <div class="row g-4">
            <!-- Left Column: Main Content -->
            <div class="col-sm-12 col-xl-8">
                <div class="bg-secondary rounded p-4">
                    <h6 class="mb-4">{{ __('articles.form_title') }}</h6>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('articles.title_label') }} <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $article->title ?? '') }}" class="form-control" placeholder="{{ __('articles.title_label') }}" required>
                        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('articles.content') }} <span class="text-danger">*</span></label>
                        <textarea name="content" id="editor" class="form-control" rows="10">{{ old('content', $article->content ?? '') }}</textarea>
                        @error('content') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('articles.excerpt') }}</label>
                        <textarea name="excerpt" class="form-control" rows="3" placeholder="...">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
                    </div>
                </div>

                <!-- SEO Section -->
                <div class="bg-secondary rounded p-4 mt-4">
                    <h6 class="mb-4">{{ __('articles.seo_settings') }}</h6>
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $article->meta_title ?? '') }}" class="form-control" placeholder="Custom SEO Title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $article->meta_description ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keywords</label>
                        <input type="text" name="keywords" value="{{ old('keywords', $article->keywords ?? '') }}" class="form-control" placeholder="tech, tutorial, laravel">
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings -->
            <div class="col-sm-12 col-xl-4">
                <div class="bg-secondary rounded p-4 mb-4">
                    <h6 class="mb-4">{{ __('articles.publishing') }}</h6>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('articles.category') }} <span class="text-danger">*</span></label>
                        <select class="form-select" name="category_id" required>
                            <option value="">{{ __('common.select') ?? 'Select' }} {{ __('articles.category') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $article->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('articles.status') }}</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="statusDraft" value="draft" {{ old('status', $article->status ?? 'draft') == 'draft' ? 'checked' : '' }}>
                            <label class="form-check-label" for="statusDraft">{{ __('articles.draft') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="statusPublished" value="published" {{ old('status', $article->status ?? '') == 'published' ? 'checked' : '' }}>
                            <label class="form-check-label" for="statusPublished">{{ __('articles.published') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="statusArchived" value="archived" {{ old('status', $article->status ?? '') == 'archived' ? 'checked' : '' }}>
                            <label class="form-check-label" for="statusArchived">{{ __('articles.archived') }}</label>
                        </div>
                    </div>

                    @if(auth()->user()->role === 1)
                    <div class="mb-3">
                        <label class="form-label">{{ __('articles.visibility') }}</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured" {{ old('is_featured', $article->is_featured ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isFeatured">{{ __('articles.featured') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_trending" id="isTrending" {{ old('is_trending', $article->is_trending ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isTrending">{{ __('articles.trending') }}</label>
                        </div>
                    </div>
                    @endif

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">{{ isset($article) ? __('common.save') : __('articles.create') }}</button>
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-light">{{ __('common.cancel') }}</a>
                    </div>
                </div>

                <div class="bg-secondary rounded p-4">
                    <h6 class="mb-4">{{ __('articles.featured_image') }}</h6>
                    <div class="mb-3 text-center">
                         @if(isset($article) && $article->featured_image)
                            <img id="image-preview" src="{{ asset('storage/' . $article->featured_image) }}" class="img-fluid rounded mb-2" style="max-height: 200px;">
                        @else
                            <img id="image-preview" src="" class="img-fluid rounded mb-2 d-none" style="max-height: 200px;">
                        @endif
                    </div>
                    <div class="mb-3">
                        <input class="form-control bg-dark" type="file" name="featured_image" id="featured_image_input" accept="image/*">
                        <div class="form-text">JPG, PNG, GIF</div>
                    </div>
                    <script>
                        document.getElementById('featured_image_input').addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const preview = document.getElementById('image-preview');
                                    preview.src = e.target.result;
                                    preview.classList.remove('d-none');
                                }
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- TinyMCE 6 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '#editor',
            height: 500,
            menubar: false,
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media link anchor codesample',
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            toolbar_mode: 'sliding',
            skin: 'oxide-dark',
            content_css: 'dark',
            content_style: 'body { font-family: "Open Sans", sans-serif; background-color: #191C24; color: #6C7293; }',
            
            // Image Upload Logic (Same as before)
            images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route('admin.articles.upload-image') }}');
                xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
                xhr.upload.onprogress = (e) => { progress(e.loaded / e.total * 100); };
                xhr.onload = () => {
                   if (xhr.status < 200 || xhr.status >= 300) { reject('HTTP Error: ' + xhr.status); return; }
                   const json = JSON.parse(xhr.responseText);
                   if (!json || typeof json.url !== 'string') { reject('Invalid JSON: ' + xhr.responseText); return; }
                   resolve(json.url);
                };
                xhr.onerror = () => { reject('Image upload failed.'); };
                const formData = new FormData();
                formData.append('upload', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            })
        });
    });
</script>
@endsection
