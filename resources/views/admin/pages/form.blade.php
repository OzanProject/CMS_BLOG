@extends('layouts.admin')

@section('header', isset($page) ? 'Edit Page' : 'Create Page')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="mb-0">{{ isset($page) ? 'Edit Page' : 'Create New Page' }}</h6>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-light"><i class="fa fa-arrow-left me-2"></i>Back</a>
        </div>

        <form action="{{ isset($page) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}" method="POST">
            @csrf
            @if(isset($page))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $page->title ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea class="form-control" name="content" id="editor" rows="10">{{ old('content', $page->content ?? '') }}</textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="bg-dark rounded p-3 mb-3">
                        <h6 class="text-primary mb-3">Publishing</h6>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status', $page->status ?? 1) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active / Published</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-save me-2"></i>{{ isset($page) ? 'Update Page' : 'Save Page' }}</button>
                    </div>

                    <div class="bg-dark rounded p-3">
                        <h6 class="text-primary mb-3">SEO Settings</h6>
                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $page->meta_title ?? '') }}" placeholder="Optional">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" rows="3">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
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
            
            // Image Upload Logic (Reused from Articles)
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
@endpush
@endsection
