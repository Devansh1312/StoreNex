@extends('admin.layouts.app')

@section('content')
    <div class="wrapper">
        <div class="content-wrapper" style="padding: 10px">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h3 class="m-0">
                                <b>Products</b>
                            </h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('AddProductPage') }}" class="btn btn-primary">Add</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="productTable" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Subcategory</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody id="Product_data"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    

    <script>
        $(document).ready(function () {
            ProductsList();
        });

        function formatDate(dateString) {
            return moment(dateString).format('DD-MMM-YYYY hh:mm A').toUpperCase();
        }

        function ProductsList() {
            $.ajax({
                type: 'get',
                url: "{{ url('ProductList') }}",
                success: function (response) {
                    console.log(response);
                    var tr = '';
                    for (var i = 0; i < response.length; i++) {
                        var product = response[i];
                        var id = product.id;
                        var name = product.name;
                        var subcategoryName = product.subcategory ? product.subcategory.name : 'N/A'; // Uncommented this line
                        var price = product.price;
                        var description = product.description;
                        var truncatedDescription = description.length > 100 ? description.substring(0, 100) + '' : description;
                        var assetPath = '{{ asset("storage/ProductIMG/") }}';
                        var images = product.image.split(',');
                        var lastImage = images.length > 0 ? images[images.length - 1] : '';

                        tr += '<tr>';
                        tr += '<td>' + id + '</td>';
                        tr += '<td>' + name + '</td>';
                        tr += '<td>' + subcategoryName + '</td>'; // Display subcategory name in the table
                        tr += '<td>' + price + '₹</td>';
                        tr += '<td>';
                        tr += '<span class="description-text">';
                        tr += '<span class="truncated">' + truncatedDescription + '</span>';
                        if (description.length > 100) {
                            tr += '<span class="read-more" onclick="ViewProduct(' + id + ')">  Read More...</span>';
                        }
                        tr += '</span>';
                        tr += '</td>';
                        tr += '<td>';
                        tr += '<img src="' + assetPath + '/' + lastImage + '" style="max-width: 100px; max-height: 100px;" class="img-fluid img-radius mx-auto d-block" alt="Image">';
                        tr += '</td>';
                        tr += '<td>';
                        tr += '<div class="d-flex">';
                        tr += '<a href="javascript:void(0);" onclick="ViewProduct(' + id + ')" data-toggle="tooltip" title="View"><i class="material-icons">visibility</i><span style="margin-left:10px"></span></a>';
                        tr += '<a href="javascript:void(0);" onclick="EditProduct(' + id + ')" data-toggle="tooltip" title="Edit"><i class="material-icons">&#xE254;</i><span style="margin-left:10px"></span></a>';
                        tr += '<a href="javascript:void(0);" onclick="DeleteProduct(' + id + ')"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i><span style="margin-left:10px"></span></a>';
                        tr += '</div>';
                        tr += '</td>';
                        tr += '</tr>';
                    }

                    $('.loading').hide();
                    $('#Product_data').html(tr);

                    // Destroy existing DataTable instance (if any)
                    if ($.fn.dataTable.isDataTable('#productTable')) {
                        $('#productTable').DataTable().destroy();
                    }

                    // Initialize DataTable
                    $('#productTable').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                    });
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        function ViewProduct(id) {
            // Convert the id to a string and encode it in base64
            var encodedId = btoa(id.toString());

            // Redirect to the view product page with the base64 encoded id
            window.location = "{{ url('view-product') }}/" + encodedId;
        }


        function EditProduct(id) {
            // Convert the id to a string and encode it in base64
            var encodedId = btoa(id.toString());

            // Redirect to the edit product page with the base64 encoded id
            window.location = "{{ url('edit-product') }}/" + encodedId;
        }


        function DeleteProduct(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this Product!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'post',
                        url: "{{ route('DeleteProduct') }}",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                ProductsList();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Product deleted successfully!',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                location.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error deleting Product!',
                                    text: response.message,
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>

@endsection
