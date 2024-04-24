@extends('admin.layouts.app')

@section('content')
<div class="wrapper">
    <div class="content-wrapper" style="padding: 10px">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">
                            <b>Order Report</b>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="order_status">Order Status:</label>
                            <select class="form-control" name="order_status" id="order_status">
                                <option value="">Select Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Accepted">Accepted</option>
                                <option value="Canceled">Canceled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" class="form-control" name="start_date" id="start_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" class="form-control" name="end_date" id="end_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group d-flex justify-content-end">
                            <button id="applyBtn" class="btn btn-primary mr-2">Apply</button>
                            <button id="cancelBtn" class="btn btn-secondary">Cancel</button>
                        </div>
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
                        </tr>
                    </thead>
                    <tbody id="transaction_data"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        fetchTransactionList(); // Fetch all data initially

        // Apply button click event handler
        $('#applyBtn').click(function() {
            applyFilters();
        });

        // Cancel button click event handler
        $('#cancelBtn').click(function() {
            resetFilters();
        });
    });

    function applyFilters() {
        var orderStatus = $('#order_status').val(); // Get selected order status
        var startDate = $('#start_date').val(); // Get selected start date
        var endDate = $('#end_date').val(); // Get selected end date

        // Fetch data based on selected order status and date range
        fetchTransactionList(orderStatus, startDate, endDate);
    }

    function resetFilters() {
        // Reset form fields
        $('#order_status').val('');
        $('#start_date').val('');
        $('#end_date').val('');

        // Fetch all data
        fetchTransactionList();
    }

    function fetchTransactionList(orderStatus = null, startDate = null, endDate = null) {
        $.ajax({
            type: 'get',
            url: "{{ route('Orders') }}",
            data: {
                order_status: orderStatus, // Pass selected order status
                start_date: startDate, // Pass selected start date
                end_date: endDate // Pass selected end date
            },
            success: function(response) {
                var tr = '';
                for (var i = 0; i < response.length; i++) {
                    var transaction = response[i];
                    var id = transaction.id;
                    var name = transaction.name;
                    var email = transaction.email;
                    var phone = transaction.phone;
                    var address = '';
                    if (transaction.addressline1) address += transaction.addressline1 + ', ';
                    if (transaction.addressline2) address += transaction.addressline2 + ', ';
                    if (transaction.city) address += transaction.city + ', ';
                    if (transaction.district) address += transaction.district + ', ';
                    if (transaction.zip_code) address += transaction.zip_code;
                    var status = transaction.status;
                    var order_status = transaction.order_status;
                    var orderDate = formatDate(transaction.created_at);

                    var badgeClass = getStatusBadgeClass(status);
                    var badgeClass1 = getOrderStatusBadgeClass(order_status);

                    tr += '<tr>';
                    tr += '<td>' + id + '</td>';
                    tr += '<td>' + name + '</td>';
                    tr += '<td>' + email + '</td>';
                    tr += '<td>' + phone + '</td>';
                    tr += '<td>' + address + '</td>';
                    tr += '<td><span class="badge ' + badgeClass + '">' + status + '</span></td>';
                    tr += '<td><span class="badge ' + badgeClass1 + '">' + order_status + '</span></td>';
                    tr += '<td>' + orderDate + '</td>';
                    tr += '</tr>';
                }

                $('#transaction_data').html(tr);

                if ($.fn.dataTable.isDataTable('#transactionTable')) {
                    $('#transactionTable').DataTable().destroy();
                }

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
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    function formatDate(dateString) {
        return moment(dateString).format('DD-MMM-YYYY hh:mm A').toUpperCase();
    }

    function getStatusBadgeClass(status) {
        switch (status) {
            case 'Pending':
                return 'badge-secondary';
            case 'Paid':
                return 'badge-success';
            case 'Canceled':
                return 'badge-danger';
            default:
                return 'badge-secondary';
        }
    }

    function getOrderStatusBadgeClass(orderStatus) {
        switch (orderStatus) {
            case 'Pending':
                return 'badge-secondary';
            case 'Accepted':
                return 'badge-success';
            case 'Canceled':
                return 'badge-danger';
            default:
                return 'badge-secondary';
        }
    }
</script>
@endsection
