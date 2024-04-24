@extends('admin.layouts.app')

@section('content')
    <div class="wrapper">
        <div class="content-wrapper" style="padding: 10px">
            <div class="content-header">
                <div class="container-fluid">
                    <!-- Content Header (Page header) -->
                </div>
            </div>
            <form action="{{ route('AddProduct') }}" method="POST" name="addProductForm" id="addProductForm" enctype="multipart/form-data">
                @csrf
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Product</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter the product name" value="{{ old('name') }}" />
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="subcat_id" class="form-label">Subcategory:</label>
                            <select class="form-control" name="subcategory_id"> <!-- Updated name attribute here -->
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                            @error('subcategory_id') <!-- Updated error check here -->
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price:</label>
                            <input type="text" class="form-control" name="price" placeholder="Enter the product price" value="{{ old('price') }}" />
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Enter the product description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Images:</label>
                            <input type="file" class="form-control-file" name="image[]" accept="image/*" multiple />
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="addProductBtn">ADD</button>
                        <a href="{{route('Product')}}">
                            <button type="button" class="btn btn-secondary">Close</button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.tiny.cloud/1/3k9vt8e8ipgy1d3vjzd53hthgkpfdctedew2zg2jh8xvu3r0/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#description',
        height: 400,
        plugins: 'link image code',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code'
    });
</script>
@endsection
