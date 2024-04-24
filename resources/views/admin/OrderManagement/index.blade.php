@extends('admin.layouts.app')

@section('content')
    <div class="wrapper">
        <div class="content-wrapper" style="padding: 10px">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h3 class="m-0">
                                <b>Transactions</b>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="transactionTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Order Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="transaction_data"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
      $(document).ready(function () {
          fetchTransactionList();
      });
  
      function formatDate(dateString) {
          return moment(dateString).format('DD-MMM-YYYY hh:mm A').toUpperCase();
      }
  
      function fetchTransactionList() {
          $.ajax({
              type: 'get',
              url: "{{ route('transactionList') }}",
              success: function (response) {
                  console.log(response);
                  var tr = '';
                  for (var i = 0; i < response.length; i++) {
                      var transaction = response[i];
                      var id = transaction.id;
                      var name = transaction.name;
                      var email = transaction.email;
                      var phone = transaction.phone;
                      var address = ''; // Concatenate address components as required
                      if (transaction.addressline1) address += transaction.addressline1 + ', ';
                      if (transaction.addressline2) address += transaction.addressline2 + ', ';
                      if (transaction.city) address += transaction.city + ', ';
                      if (transaction.district) address += transaction.district + ', ';
                      if (transaction.zip_code) address += transaction.zip_code;
                      var status = transaction.status;
                      var order_status = transaction.order_status;
                      var orderDate = formatDate(transaction.created_at);
  
                      // Determine badge class based on status
                      var badgeClass1 = '';
                      switch (order_status) {
                          case 'Pending':
                              badgeClass1 = 'badge-secondary';
                              break;
                          case 'Accepted':
                              badgeClass1 = 'badge-success';
                              break;
                          case 'Canceled':
                              badgeClass1 = 'badge-danger';
                              break;
                          default:
                              badgeClass1 = 'badge-secondary';
                              break;
                      }
                      // Determine badge class based on status
                      var badgeClass = '';
                      switch (status) {
                          case 'Pending':
                              badgeClass = 'badge-secondary';
                              break;
                          case 'Paid':
                              badgeClass = 'badge-success';
                              break;
                          case 'Canceled':
                              badgeClass = 'badge-danger';
                              break;
                          default:
                              badgeClass = 'badge-secondary';
                              break;
                      }
  
                      tr += '<tr>';
                      tr += '<td>' + id + '</td>';
                      tr += '<td>' + name + '</td>';
                      tr += '<td>' + email + '</td>';
                      tr += '<td>' + phone + '</td>';
                      tr += '<td>' + address + '</td>';
                      tr += '<td><span class="badge ' + badgeClass + '">' + status + '</span></td>'; // Status badge
                      tr += '<td><span class="badge ' + badgeClass1 + '">' + order_status + '</span></td>'; // order_status badge
                      tr += '<td>' + orderDate + '</td>';
                      tr += '<td>';
                      tr += '<div class="d-flex">';
                      tr += '<a href="javascript:void(0);" onclick="viewTransaction(' + id + ')" data-toggle="tooltip" title="View"><i class="material-icons">visibility</i><span style="margin-left:10px"></span></a>';
                      tr += '<a href="javascript:void(0);" onclick="editTransaction(' + id + ')" data-toggle="tooltip" title="Edit"><i class="material-icons">&#xE254;</i><span style="margin-left:10px"></span></a>';
                      tr += '</div>';
                      tr += '</td>';
                      tr += '</tr>';
                  }
  
                  $('#transaction_data').html(tr);
  
                  // Destroy existing DataTable instance (if any)
                  if ($.fn.dataTable.isDataTable('#transactionTable')) {
                      $('#transactionTable').DataTable().destroy();
                  }
  
                  // Initialize DataTable
                  $('#transactionTable').DataTable({
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
  
    function viewTransaction(id) {
        // Convert the id to a string and encode it in base64
        var encodedId = btoa(id.toString());

        // Redirect to the view page with the base64 encoded id
        window.location = "{{ url('view-transaction') }}/" + encodedId;
    }

  
    function editTransaction(id) {
        // Convert the id to a string and encode it in base64
        var encodedId = btoa(id.toString());

        // Redirect to the edit page with the base64 encoded id
        window.location = "{{ url('edit-transaction') }}/" + encodedId;
    }

  </script>
@endsection
