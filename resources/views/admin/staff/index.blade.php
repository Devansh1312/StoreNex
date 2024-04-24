@extends('admin.layouts.app')
@section('content')

<div class="wrapper">
    <div class="content-wrapper" style="padding: 10px">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3 class="m-0">
                <b>Staff</b>
              </h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <button class="btn btn-primary" onclick="window.location='{{ route('AddStaffPage') }}'">Add</button>
                </li>
              </ol>
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
            <tbody id="staff_data"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<script>
	$(document).ready(function() {
		stafflist();
	});

	function formatDate(dateString) {
		// Use moment.js to format the date
		return moment(dateString).format('DD-MMM-YYYY hh:mm A').toUpperCase();
	}

	function stafflist() {
		$.ajax({
			type: 'get',
			url: "{{ url('StaffList') }}",
			success: function(response) {
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
					tr += '<a href="javascript:void(0);" onclick="ViewStaff(' + id + ')" data-toggle="tooltip" title="View"><i class="material-icons">visibility</i><span style="margin-left:10px"></span></a>';
					tr += '<a href="javascript:void(0);" onclick="EditStaff(' + id + ')" data-toggle="tooltip" title="Edit"><i class="material-icons">&#xE254;</i><span style="margin-left:10px"></span></a>';
					tr += '<a href="javascript:void(0);" onclick="DeleteStaff(' + id + ')"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i><span style="margin-left:10px"></span></a>';
					tr += '</div></td>';
					tr += '</tr>';
				}
				$('.loading').hide();
				$('#staff_data').html(tr);

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

	function ViewStaff(id) {
		// Convert the id to a string and encode it in base64
		var encodedId = btoa(id.toString());

		// Redirect to the view staff page with the base64 encoded id
		window.location = "{{ url('view-staff') }}/" + encodedId;
	}

	function EditStaff(id) {
		// Convert the id to a string and encode it in base64
		var encodedId = btoa(id.toString());

		// Redirect to the edit staff page with the base64 encoded id
		window.location = "{{ url('edit-staff') }}/" + encodedId;
	}


	function DeleteStaff(id) {
		Swal.fire({
			title: 'Are you sure?',
			text: 'You will not be able to recover this staff member!',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, delete it!',
			cancelButtonText: 'No, cancel!',
			reverseButtons: true
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: 'post',
					url: "{{ route('DeleteStaff') }}",
					data: {
						id: id,
						_token: "{{ csrf_token() }}"
					},
					success: function(response) {
						if (response.status === 'success') {
							Swal.fire({
								icon: 'success',
								title: 'Staff deleted successfully!',
								showConfirmButton: false,
								timer: 3000
							});
							stafflist(); // Reload the staff list after deletion
							location.reload();
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Error deleting staff!',
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