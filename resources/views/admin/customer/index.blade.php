@extends('admin.layouts.app')
@section('content')

<div class="wrapper">
    <div class="content-wrapper" style="padding: 10px">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3 class="m-0">
                <b>Customer</b>
              </h3>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email(s)</th>
                <th>Phone</th>
                <th>Created On</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="customer_data"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

<script>
   $(document).ready(function () {
    CustomerList();
    });

    function formatDate(dateString) {
    // Use moment.js to format the date
    return moment(dateString).format('DD-MMM-YYYY hh:mm A').toUpperCase();
}

    function CustomerList() {
        $.ajax({
            type: 'get',
            url: "{{ url('CustomerList') }}",
            success: function (response) {
                console.log(response);
                var tr = '';
                for (var i = 0; i < response.length; i++) {
                    var id = response[i].id;
                    var name = response[i].name;
                    var email = response[i].email;
                    var phone = response[i].phone;
                    var created_at = formatDate(response[i].created_at); // Format the date
                    tr += '<tr>';
                    tr += '<td>' + id + '</td>';
                    tr += '<td>' + name + '</td>';
                    tr += '<td>' + email + '</td>';
                    tr += '<td>' + phone + '</td>';
                    tr += '<td>' + created_at + '</td>';
                    tr += '<td><div class="d-flex">';
                    tr += '<a href="javascript:void(0);" onclick="ViewCustomer(' + id + ')" data-toggle="tooltip" title="View"><i class="material-icons">visibility</i><span style="margin-left:10px"></span></a>';
                    tr += '<a href="javascript:void(0);" onclick="DeleteCustomer(' + id + ')"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i><span style="margin-left:10px"></span></a>';
                    tr += '</div></td>';
                    tr += '</tr>';
                }
                $('.loading').hide();
                $('#customer_data').html(tr);

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
    function ViewCustomer(id) {
        // Convert the id to a string and encode it in base64
        var encodedId = btoa(id.toString());

        // Redirect to the view page with the base64 encoded id
        window.location = "{{ url('view-customer') }}/" + encodedId;
    }


    function DeleteCustomer(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this Customer!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'post',
                    url: "{{ route('DeleteCustomer') }}",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Customer deleted successfully!',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            location.reload();
                            CustomerList(); // Reload the Customer list after deletion
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error deleting Customer',
                                text: response.message,
                            });
                        }
                    }
                });
            } 
            // else if (result.dismiss === Swal.DismissReason.cancel) {
            //     Swal.fire('Cancelled', 'Staff member is safe :)', 'info');
            // }
        });
    }

    
</script>

@endsection