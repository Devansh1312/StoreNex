@extends('admin.layouts.app')
<meta charset="UTF-8">

@section('content')
<div class="wrapper">
    <div class="content-wrapper" style="padding: 10px">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0"><b>Order Report</b></h3>
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
                            <select class="form-control" id="order_status">
                                <option value="">Select Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Accepted">Accepted</option>
                                <option value="Canceled">Canceled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Payment Status:</label>
                            <select class="form-control" id="status">
                                <option value="">Select Status</option>
                                <option value="Paid">Paid</option>
                                <option value="COD">COD</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" class="form-control" id="start_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" class="form-control" id="end_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top: 25px;">
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
                            <th>Total</th>
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
    var dataTable;

    $(document).ready(function() {
        // Initialize DataTable
        initializeDataTable();

        // Fetch all data initially
        fetchTransactionList();

        // Apply filters on click of apply button
        $(document).on('click', '#applyBtn', function() {
            applyFilters();
        });

        // Reset filters on click of cancel button
        $(document).on('click', '#cancelBtn', function() {
            resetFilters();
        });

        // Download CSV on click of download button
        $('#downloadCsvBtn').on('click', function() {
            downloadCsv();
        });

        $('#downloadPdfBtn').on('click', function() {
            generatePdf();
        });

    });

    function initializeDataTable() {
        dataTable = $('#transactionTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "dom": 'Bfrtip', // Add buttons to the default DOM
            "buttons": [
                'csv', // Add CSV button
            ]
        });
    }

    function applyFilters() {
        var orderStatus = $('#order_status').val();
        var status = $('#status').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();

        fetchTransactionList(orderStatus,status, startDate, endDate);
    }

    function resetFilters() {
        $('#status').val('');
        $('#order_status').val('');
        $('#start_date').val('');
        $('#end_date').val('');
        fetchTransactionList(); // Fetch all data again when filters are reset
    }

    function fetchTransactionList(orderStatus = '', status = '', startDate = '', endDate = '') {
    $.ajax({
        type: 'get',
        url: "{{ route('Orders') }}",
        data: {
            order_status: orderStatus,
            status: status,
            start_date: startDate,
            end_date: endDate
        },
        success: function(response) {
            // Clear existing data
            dataTable.clear().draw();

            // Populate table with new data
            response.forEach(function(transaction) {
                // Determine badge class based on status
                var badgeClass = '';
                switch (transaction.status) {
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
                
                // Determine badge class based on order status
                var orderBadgeClass = '';
                switch (transaction.order_status) {
                    case 'Pending':
                        orderBadgeClass = 'badge-secondary';
                        break;
                    case 'Accepted':
                        orderBadgeClass = 'badge-success';
                        break;
                    case 'Canceled':
                        orderBadgeClass = 'badge-danger';
                        break;
                    default:
                        orderBadgeClass = 'badge-secondary';
                        break;
                }

                dataTable.row.add([
                transaction.id,
                transaction.name,
                transaction.email,
                transaction.phone,
                formatFullAddress(
                    transaction.addressline1, 
                    transaction.addressline2,
                    transaction.city,
                    transaction.district,
                    transaction.zip_code,
                ),
                '<th style="font-family: Arial, sans-serif;">' +  number_format(transaction.total, 2) + '</th>', // Format total with currency symbol and 2 decimal places
                '<span class="badge ' + badgeClass + '">' + transaction.status + '</span>',
                '<span class="badge ' + orderBadgeClass + '">' + transaction.order_status + '</span>',
                formatDate(transaction.created_at)
            ]).draw();  

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

    function formatFullAddress(address1, address2, city, district, zip) {
        const parts = [address1, address2, city, district, zip];
        const cleanParts = parts.filter(part => part); // Remove any undefined or empty strings
        return cleanParts.join(', '); // Join all parts with a comma and space
    }

    function downloadCsv() {
        // Trigger CSV download using DataTables buttons extension
        dataTable.button('.buttons-csv').trigger();
    }
    function number_format(number, decimals, dec_point, thousands_sep) {
    // Set default values if not provided
    decimals = decimals || 0;
    dec_point = dec_point || '.';
    thousands_sep = thousands_sep || ',';

    // Convert to number
    number = parseFloat(number);

    // Check if the number is finite
    if (!isFinite(number) || (!number && number !== 0)) {
        return '';
    }

    // Convert number to string
    var str = number.toFixed(decimals);

    // Split the integer and decimal parts
    var parts = str.split('.');

    // Format the integer part with thousand separators
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);

    // Join the integer and decimal parts
    return parts.join(dec_point);
}

</script>
@endsection
