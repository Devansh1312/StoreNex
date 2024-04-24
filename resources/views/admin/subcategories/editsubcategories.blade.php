@extends('admin.layouts.app')
@section('content')

<div class="wrapper">
    <div class="content-wrapper" style="padding:10px">
        <div class="content-header">
            <div class="container-fluid">
                <!-- Content Header (Page header) -->
            </div>
        </div>

        <form action="{{ route('UpdateSubCategory', base64_encode($subcategory->id)) }}" method="POST" 
            name="editSubcategoryForm" id="editSubcategoryForm" enctype="multipart/form-data">
            @csrf
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Subcategory</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="edit_name" placeholder="Enter the subcategory name" 
                            value="{{ old('edit_name', $subcategory->name) }}" />
                        @error('edit_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category:</label>
                        <select class="form-control" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ ($category->id == $subcategory->category_id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
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
                    <button type="submit" class="btn btn-primary" id="updateSubcategoryBtn">UPDATE</button>
                    <a href="{{route('Subcategories')}}">
                        <button type="button" class="btn btn-secondary">Close</button>
                    </a>
                </div>
            </div>
        </form>

    </div>
</div>

@endsection
