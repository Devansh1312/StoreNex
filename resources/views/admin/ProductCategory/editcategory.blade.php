@extends('admin.layouts.app')
@section('content')

<div class="wrapper">
    <div class="content-wrapper" style="padding:10px">
        <div class="content-header">
            <div class="container-fluid">
                <!-- Content Header (Page header) -->
            </div>
        </div>

        <form action="{{ route('UpdateCategory',base64_encode($productCategory->id)) }}" method="POST" 
            name="editCategoryForm" id="editCategoryForm" enctype="multipart/form-data">
            @csrf
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Category</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="edit_name" placeholder="Enter the category name" 
                            value="{{old('edit_name', $productCategory->name )}}" />
                        @error('edit_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Image:</label>
                        <input type="file" class="form-control-file" accept="image" name="edit_image" />
                        <p class="text-info">Leave it empty if you don't want to change the image.</p>
                        @error('edit_image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="updateCategoryBtn">UPDATE</button>
                    <a href="{{route('ProductCategory')}}">
                        <button type="button" class="btn btn-secondary">Close</button>
                    </a>
                </div>
            </div>
        </form>

    </div>
</div>

@endsection
