@extends('admin.layouts.app')
@section('content')

<div class="wrapper">
    <div class="content-wrapper" style="padding: 10px">
        <form action="{{ route('UpdateProduct', base64_encode($product->id)) }}" method="POST" name="editProductForm" id="editProductForm" enctype="multipart/form-data">
            @csrf
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Product</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter the product name" value="{{ old('name', $product->name) }}" />
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="subcategory_id" class="form-label">Subcategory:</label>
                        <select class="form-control" name="subcategory_id">
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                            @endforeach
                        </select>
                        @error('subcategory_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <input type="text" class="form-control" name="price" placeholder="Enter the product price" value="{{ $product->price }}" />
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Enter the product description">{{ $product->description }}</textarea>
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
                    <div class="mb-3">
                        <label for="current_image" class="form-label">Current Images:</label>
                        @if($product->image)
                            @php
                                $currentImages = explode(',', $product->image);
                            @endphp
                            <div class="row">
                                @foreach($currentImages as $currentImage)
                                    <div class="col-md-3">
                                        <img src="{{ asset('storage/ProductIMG/' . $currentImage) }}" alt="Current Image" class="img-thumbnail">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No images available</p>
                        @endif
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="updateProductBtn">UPDATE</button>
                    <a href="{{route('Product')}}">
                        <button type="button" class="btn btn-secondary">Close</button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Include TinyMCE from CDN -->
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
