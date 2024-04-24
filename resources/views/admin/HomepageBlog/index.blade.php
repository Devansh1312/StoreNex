@extends('admin.layouts.app')
@section('content')

<div class="wrapper">
    <div class="content-wrapper"style="padding: 10px">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3 class="m-0">
                <b>Home Page Blogs</b>
              </h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item ml-auto">
                  <button class="btn btn-primary" onclick="window.location='{{ route('AddHomeBlogPage') }}'">Add</button>
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
                  <th>Title</th>
                  <th>Sub-Title</th>
                  <th>Image</th>
                  <th>Created On</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="HomepageBlog"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<script>
     $(document).ready(function () {
      HomeblogList();
    });

    function formatDate(dateString) {
    // Use moment.js to format the date
    
    return moment(dateString).format('DD-MMM-YYYY hh:mm A').toUpperCase();
}

function HomeblogList() {
        $.ajax({
            type: 'GET',
            url: "{{ route('HomeblogList') }}",
            success: function (response) {
                var tr = '';
                for (var i = 0; i < response.length; i++) {
                    var id = response[i].id;
                    var title = response[i].title;
                    var subtitle = response[i]['sub-title']; // Access sub-title using quotes
                    var image = '<img src="{{ asset("storage/HomepageBlogImg") }}/' + response[i].image + '" style="max-width: 100px; max-height: 100px;" class="img-fluid img-radius mx-auto d-block" alt="Image">';
                    var created_at = formatDate(response[i].created_at);
                    tr += '<tr>';
                    tr += '<td>' + id + '</td>';
                    tr += '<td>' + title + '</td>';
                    tr += '<td>' + subtitle + '</td>';
                    tr += '<td>' + image + '</td>';
                    tr += '<td>' + created_at + '</td>';
                    tr += '<td><div class="d-flex">';
                    tr += '<a href="javascript:void(0);" onclick="ViewHomepageBlog(' + id + ')" data-toggle="tooltip" title="View"><i class="material-icons">visibility</i><span style="margin-left:10px"></span></a>';
                    tr += '<a href="javascript:void(0);" onclick="EditHomepageBlog(' + id + ')" data-toggle="tooltip" title="Edit"><i class="material-icons">&#xE254;</i><span style="margin-left:10px"></span></a>';
                    tr += '<a href="javascript:void(0);" onclick="DeleteHomepageBlog(' + id + ')"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i><span style="margin-left:10px"></span></a>';
                    tr += '</div></td>';
                    tr += '</tr>';
                }
                $('.loading').hide();
                $('#HomepageBlog').html(tr);

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
    function ViewHomepageBlog(id) {
      // Convert the id to a string and encode it in base64
      var encodedId = btoa(id.toString());

      // Redirect to the view page with the base64 encoded id
      window.location = "{{ url('view-Blog') }}/" + encodedId;
    }

    function EditHomepageBlog(id) {
      // Convert the id to a string and encode it in base64
      var encodedId = btoa(id.toString());

      // Redirect to the edit page with the base64 encoded id
      window.location = "{{ url('edit-Blog') }}/" + encodedId;
    }

    function DeleteHomepageBlog(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this category!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'post',
                    url: "{{ route('DeleteHomepageBlog') }}",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                          HomeblogList();
                            Swal.fire({
                                icon: 'success',
                                title: 'Blog deleted successfully!',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            HomeblogList();
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error deleting category!',
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