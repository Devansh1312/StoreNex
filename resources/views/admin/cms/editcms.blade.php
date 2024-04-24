@extends('admin.layouts.app')
@section('content')

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <!-- Content Header (Page header) -->
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <form action="{{ route('UpdateCms',base64_encode($Cms_page->id)) }}" method="POST" name="editCmsForm" id="editCmsForm">
                    @csrf
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update CMS Page</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="edit_title" class="form-label">Title:</label>
                                <input type="text" class="form-control" name="edit_title" placeholder="Enter your title" value="{{ old('edit_title', $Cms_page->title) }}" />
                                @error('edit_title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_content" class="form-label">Content:</label>
                                <textarea id="edit_content" name="edit_content" class="form-control" placeholder="Enter your content">{{ $Cms_page->content }}</textarea>
                                @error('edit_content')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="updateStaffBtn">Update</button>
                                <a href="{{route('cms')}}">
                                    <button type="button" class="btn btn-secondary">Close</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include TinyMCE from CDN -->
<script src="https://cdn.tiny.cloud/1/3k9vt8e8ipgy1d3vjzd53hthgkpfdctedew2zg2jh8xvu3r0/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#edit_content',
        height: 400,
        plugins: 'link image code',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code'
    });
</script>

@endsection
