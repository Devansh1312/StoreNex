@extends('admin.layouts.app')
@section('content')

<div class="wrapper">
    <div class="content-wrapper" style="padding: 10px">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">
                            <b>Subcategory</b>
                        </h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item ml-auto">
                                <button class="btn btn-primary"
                                    onclick="window.location='{{ route('AddSubCategoryPage') }}'">Add</button>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Created On</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="Subcategory_data"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        SubcategoriesList();
    });

    function formatDate(dateString) {
        // Use moment.js to format the date
        return moment(dateString).format('DD-MMM-YYYY hh:mm A').toUpperCase();
    }

    function SubcategoriesList() {
        $.ajax({
            type: 'get',
            url: "{{ url('SubcategoriesList') }}",
            success: function (response) {
                console.log(response);
                var tr = '';
                for (var i = 0; i < response.length; i++) {
                    var id = response[i].id;
                    var name = response[i].name;
                    var categoryName = response[i].category.name; // Assuming you have a 'category' relationship in Subcategory model
                    var created_at = formatDate(response[i].created_at); // Format the date
                    var imageBaseUrl = "{{ asset('storage/subcategory_images') }}";
                    var image = '<img src="' + imageBaseUrl + '/' + response[i].image + '" style="max-width: 100px; max-height: 100px;" class="img-fluid img-radius mx-auto d-block" alt="Image">';
                    tr += '<tr>';
                    tr += '<td>' + id + '</td>';
                    tr += '<td>' + name + '</td>';
                    tr += '<td>' + categoryName + '</td>';
                    tr += '<td>' + created_at + '</td>';
                    tr += '<td>' + image + '</td>';
                    tr += '<td><div class="d-flex">';
                    tr += '<a href="javascript:void(0);" onclick="ViewSubcategory(' + id + ')" data-toggle="tooltip" title="View"><i class="material-icons">visibility</i><span style="margin-left:10px"></span></a>';
                    tr += '<a href="javascript:void(0);" onclick="EditSubCategory(' + id + ')" data-toggle="tooltip" title="Edit"><i class="material-icons">&#xE254;</i><span style="margin-left:10px"></span></a>';
                    tr += '<a href="javascript:void(0);" onclick="DeleteSubCategory(' + id + ')"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i><span style="margin-left:10px"></span></a>';
                    tr += '</div></td>';
                    tr += '</tr>';
                }
                $('.loading').hide();
                $('#Subcategory_data').html(tr);

                // Destroy existing DataTable instance (if any)
                if ($.fn.dataTable.isDataTable('#example2')) {
                    $('#example2').DataTable().destroy();
                }

                // Initialize DataTable
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            }
        });
    }

    function ViewSubcategory(id) {
        // Convert the id to a string and encode it in base64
        var encodedId = btoa(id.toString());

        // Redirect to the view subcategory page with the base64 encoded id
        window.location = "{{ url('view-SubCategory') }}/" + encodedId;
    }

    function EditSubCategory(id) {
        // Convert the id to a string and encode it in base64
        var encodedId = btoa(id.toString());

        // Redirect to the edit subcategory page with the base64 encoded id
        window.location = "{{ url('edit-SubCategory') }}/" + encodedId;
    }

    function DeleteSubCategory(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this subcategory!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: 'post',
                url: "{{ url('delete-SubCategory') }}/" + id,
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id // Add this line to send the subcategory ID
                },
                success: function (response) {
                    if (response.status === 'success') {
                        SubcategoriesList();
                        Swal.fire({
                            icon: 'success',
                            title: 'Subcategory deleted successfully!',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error deleting subcategory!',
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
