@extends('admin.layouts.app')
@section('content')

<div class="wrapper">
    <div class="content-wrapper" style="padding:10px">
        <div class="content-header">
            <div class="container-fluid">
                <!-- Content Header (Page header) -->
            </div>
        </div>

        <form action="{{ route('UpdateHomepageBlog',base64_encode($HomepageBlog->id)) }}" method="POST" 
            name="editBlogForm" id="editBlogForm" enctype="multipart/form-data">
            @csrf
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Blog</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter the blog title" 
                            value="{{ old('title', $HomepageBlog->title) }}" />
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="sub-title" class="form-label">Subtitle:</label>
                        <input type="text" class="form-control" name="sub-title" placeholder="Enter the blog subtitle" 
                            value="{{ old('sub-title', $HomepageBlog->{'sub-title'}) }}" />
                        @error('sub-title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Image:</label>
                        <input type="file" class="form-control-file" accept="image" name="image" />
                        <p class="text-info">Leave it empty if you don't want to change the image.</p>
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="updateBlogBtn">UPDATE</button>
                    <a href="{{route('HomePageBlog')}}">
                        <button type="button" class="btn btn-secondary">Close</button>
                    </a>
                </div>
            </div>
        </form>

    </div>
</div>

@endsection
