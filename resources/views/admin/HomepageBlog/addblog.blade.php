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
                <form action="{{ route('AddHomepageBlog') }}" method="POST" name="addBlogForm" id="quickForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Home Page Blog</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" class="form-control" name="title" placeholder="Enter blog title" value="{{ old('title') }}" />
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="sub-title" class="form-label">Subtitle:</label>
                                <input type="text" class="form-control" name="sub-title" placeholder="Enter blog subtitle" value="{{ old('sub-title') }}" />
                                @error('sub-title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image:</label>
                                <input type="file" class="form-control-file" name="image" accept="image/*" />
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">ADD</button>
                            <a href="{{route('HomePageBlog')}}">
                                <button type="button" class="btn btn-secondary">Close</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
