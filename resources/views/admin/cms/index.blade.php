@extends('admin.layouts.app')
@section('content')
<style>
  .card-body {
      padding: 20px; /* You can adjust the value as needed */
  }
  .read-more
  {
      color: blue;
      cursor: pointer;
  }
</style>
<div class="wrapper">
    <div class="content-wrapper" style="padding: 10px">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3 class="m-0">
                <b>CMS PAGES</b>
              </h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  {{-- <button class="btn btn-primary" onclick="window.location='{{ route('AddCmsPage') }}'">Add</button> --}}
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
                <th>Title</th>
                <th>content</th>
                <th>Created On</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="cms_data"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<script>
   $(document).ready(function () {
    CmsList();
    });

    function formatDate(dateString) {
    // Use moment.js to format the date
    return moment(dateString).format('DD-MMM-YYYY hh:mm A').toUpperCase();
}

    function CmsList() {
        $.ajax({
            type: 'get',
            url: "{{ url('CmsList') }}",
            success: function (response) {
                console.log(response);
                var tr = '';
                for (var i = 0; i < response.length; i++) {
                    var id = response[i].id;
                    var title = response[i].title;
                    var content = response[i].content;
                    var truncatedContent = content.length > 100 ? content.substring(0, 100) + '' : content;
                    var created_at = formatDate(response[i].created_at); // Format the date
                    tr += '<tr>';
                    tr += '<td>' + id + '</td>';
                    tr += '<td>' + title + '</td>';
                    tr += '<td>';
                    tr += '<span class="description-text">';
                    tr += '<span class="truncated">' + truncatedContent + '</span>';
                    if (content.length > 100) {
                        tr += '<span class="read-more" onclick="ViewCms(' + id + ')">  Read More...</span>';
                    }
                    tr += '</span>';
                    tr += '</td>';                    
                    tr += '<td>' + created_at + '</td>';
                    tr += '<td><div class="d-flex">';
                    tr += '<a href="javascript:void(0);" onclick="ViewCms(' + id + ')" data-toggle="tooltip" title="View"><i class="material-icons">visibility</i><span style="margin-left:10px"></span></a>';
                    tr += '<a href="javascript:void(0);" onclick="EditCms(' + id + ')" data-toggle="tooltip" title="Edit"><i class="material-icons">&#xE254;</i><span style="margin-left:10px"></span></a>';
                    // tr += '<a href="javascript:void(0);" onclick="DeleteCms(' + id + ')"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i><span style="margin-left:10px"></span></a>';
                    tr += '</div></td>';
                    tr += '</tr>';
                }
                $('.loading').hide();
                $('#cms_data').html(tr);

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

    function ViewCms(id) {
        // Convert the id to a string and encode it in base64
        var encodedId = btoa(id.toString());

        // Redirect to the edit page with the base64 encoded id
        window.location = "{{ url('view-cms') }}/" + encodedId;
    }

    function EditCms(id) {
    // Convert the id to a string and encode it in base64
    var encodedId = btoa(id.toString());

    // Redirect to the edit page with the base64 encoded id
    window.location = "{{ url('edit-cms') }}/" + encodedId;
}
    
    function DeleteCms(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this Content!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'post',
                    url: "",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Content deleted successfully!',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            location.reload();
                            CmsList(); // Reload the Content list after deletion
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error deleting Content!',
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