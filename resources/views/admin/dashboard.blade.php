@extends('admin.layouts.app') 
@section('content') 
<!-- Add these scripts to your HTML -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
    .box1,
    .box2,
    .box3,
    .box4,
    .box5,
    .box6
    .box7,
    .box8,
    .box9,
    .box10 {
      color: #fff;
      /* Set text color to white */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      /* Add a subtle glossy effect */
    }
  
    .box1, .box8 {
      background: linear-gradient(to right, #d41928, #ff4b5a);
    }
  
    .box2 , .box9 {
      background: linear-gradient(to right, #12ad12, #0ded0d);
    }
  
    .box3 , .box10 {
      background: linear-gradient(to right, #a91173, #ea1ba1);
    }
    
    .box4 {
      background: linear-gradient(to right, #77059e, #c430f6);
    }

    .box5 {
      background: linear-gradient(to right, #1212b2, #3939d6);
    }
  
    .box6 {
      background: linear-gradient(to right, #909a04, #ecf753);
    }

    .box7 {
      background: linear-gradient(to right, #ff6600, #ff9900);
    }

    .box .icon {
      color: #fff;
      /* Set icon color to white */
    }
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <div class="content-wrapper">
      <br>
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <div class="row">
            <!-- Box 1 -->
            <div class="col-lg-3 col-6">
              <div class="small-box box1 draggable-box">
                <div class="inner">
                  <h3>{{ $TotalOrder }} </h3>
                  <p>Total-Orders</p>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-bag"></i> <!-- Shopping Bag Icon -->
                  <!-- Icon for Order -->
                </div>
                <a href="{{ route('OrderManagement') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- Box 2 -->
            <div class="col-lg-3 col-6">
              <div class="small-box box2 draggable-box">
                <div class="inner">
                  <h3>₹{{ number_format( $CurrentIncome, 2) }}</h3>
                  <p>Total Completed Order</p>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-bag"></i> <!-- Shopping Bag Icon -->
                  <!-- Icon for Order -->
                </div>
                <a href="{{ route('OrderManagement') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- Box 3 -->
            <div class="col-lg-3 col-6">
              <div class="small-box box3 draggable-box">
                <div class="inner">
                  <h3>₹{{ number_format( $CurrentPendingIncome, 2) }}</h3>
                  <p>Total Pending Order</p>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-bag"></i> <!-- Shopping Bag Icon -->
                  <!-- Icon for Order -->
                </div>
                <a href="{{ route('OrderManagement') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- Box 4 -->
            <div class="col-lg-3 col-6">
              <div class="small-box box4 draggable-box">
                <div class="inner">
                  <h3>{{ $totalProduct }} </h3>
                  <p>Total-Products</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i> <!-- Shopping Cart Icon -->
                    <!-- Icon for Total-Products -->
                </div>
                <a href="{{ route('Product') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- Box 5 -->
            <div class="col-lg-3 col-6">
              <div class="small-box box5 draggable-box">
                <div class="inner">
                  <h3>{{ $totalProductCategories }}
                    <sup style="font-size: 20px"></sup>
                  </h3>
                  <p>Product-Categories</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tags"></i> <!-- Tags Icon -->
                    <!-- Icon for Product-Categories -->
                </div>
                <a href="{{ route('ProductCategory') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

            {{-- BOX 6 --}}
            <div class="col-lg-3 col-6">
              <div class="small-box box6 draggable-box">
                <div class="inner">
                  <h3>{{ $totalProductSubCategories }}
                    <sup style="font-size: 20px"></sup>
                  </h3>
                  <p>Sub-Categories</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tags"></i> <!-- Tags Icon -->
                    <!-- Icon for Product-Categories -->
                </div>
                <a href="{{ route('Subcategories') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

            <!-- Box 7 -->
            <div class="col-lg-3 col-6">
              <div class="small-box box7 draggable-box">
                <div class="inner">
                  <h3>{{$totalUsers}}</h3>
                  <p>Total-Users</p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-plus"></i>
                  <!-- Icon for Total-Users -->
                </div>
                <a href="{{ route('Staff') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- Box 8 -->
            <div class="col-lg-3 col-6">
              <div class="small-box box8 draggable-box">
                <div class="inner">
                  <h3>{{$totalCustomer}}</h3>
                  <p>Total-Customer</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-friends"></i>
                    <!-- Icon for Total-Customer -->
                </div>
                <a href="{{ route('Customer') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- Box 9 -->
            <div class="col-lg-3 col-6">
              <div class="small-box box9 draggable-box">
                <div class="inner">
                  <h3>{{ $totalCMS }} </h3>
                  <p>Total CMS Pages</p>
                </div>
                <div class="icon">
                  <i class="fas fa-file-alt"></i>
                  <!-- Icon for Total CMS Pages -->
                </div>
                <a href="{{ route('cms') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- Box 10 -->
            <div class="col-lg-3 col-6">
              <div class="small-box box10 draggable-box">
                <div class="inner">
                  <h3>{{ $totalInquiries }} </h3>
                  <p>Total Inquiries/Feedback</p>
                </div>
                <div class="icon">
                  <i class="fas fa-bullhorn"></i>
                  <!-- Icon for Total Inquiries/Feedback -->
                </div>
                <a href="{{ route('Inquiries') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
    </div>
    <!-- /.content-wrapper --> 
    <script>
      $(function () {
        $(".draggable-box").draggable({
          revert: true, // Snap back to original position if not dropped in a droppable area
          zIndex: 100,
          cursor: "move",
        });
    
        $(".content-wrapper").droppable({
          accept: ".draggable-box",
          drop: function (event, ui) {
            // Handle the drop event here if needed
          },
        });
      });
    </script>
    
@endsection