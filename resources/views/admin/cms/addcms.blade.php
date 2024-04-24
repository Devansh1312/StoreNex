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
                <form action="{{ route('AddCms') }}" method="POST" name="signupForm" id="quickForm">
                    @csrf
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Staff Registration</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" class="form-control" name="title" placeholder="Enter your title" value="{{ old('title') }}" />
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content:</label>
                                <textarea id="content" name="content" class="form-control" placeholder="Enter your content">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                {{-- <button type="submit" class="btn btn-primary" id="updateStaffBtn">ADD</button>
                                <a href="{{route('cms')}}">
                                    <button type="button" class="btn btn-secondary">Close</button>
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include CKEditor from CDN -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<!-- Initialize CKEditor for the 'content' textarea -->
<script>
    CKEDITOR.replace('content');
</script>

@endsection
