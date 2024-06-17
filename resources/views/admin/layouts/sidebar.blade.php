<style>
    .custom-logo {
        max-width: 100%;
        height: auto;
        background-color: transparent;
        border: none;
    }

    .nav-icon {
        margin-right: 10px;
    }
</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo, now using flexbox for centering -->
    <div class="sidebar-brand" style="margin-top: 10px; display: flex; justify-content: center; align-items: center;">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('storage/SystemSetting/StoreNex1.png') }}" class="custom-logo" height="50px"
                width="170px">
        </a>
    </div>
    <span class="brand-link"></span>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>
                {{-- Staff --}}
                @if(Auth::user()->role == 1)
                <li class="nav-item">
                    <a href="{{ route('Staff') }}"
                        class="nav-link {{ Request::is('Staff*','edit-staf*', 'add-staff', 'view-staff*','delete-staff') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p> Staff </p>
                    </a>
                </li>
                @endif
                {{-- customer --}}
                <li class="nav-item">
                    <a href="{{ route('Customer') }}"
                        class="nav-link {{ Request::is('Customer*','view-customer*','edit-customer*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p> Customer </p>
                    </a>
                </li>
                {{-- ProductCategory --}}
                <li class="nav-item">
                    <a href="{{ route('ProductCategory') }}"
                        class="nav-link {{ Request::is('ProductCategory*','view-category*','edit-category*','add-category') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cube"></i>
                        <p> Product Category </p>
                    </a>
                </li>
                {{-- Product SUB-Category --}}
                <li class="nav-item">
                    <a href="{{ route('Subcategories') }}"
                        class="nav-link {{ Request::is('Subcategories*','SubcategoriesList','view-SubCategory*','edit-SubCategory*','add-SubCategory') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p> Product Sub-Category </p>
                    </a>
                </li>
                {{-- Product --}}
                <li class="nav-item">
                    <a href="{{ route('Product') }}"
                        class="nav-link {{ Request::is('Product','view-product*','edit-product*','add-product') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p> Products </p>
                    </a>
                </li>
                {{--Order Management--}}
                <li class="nav-item" style="position: relative;">
                    @php
                        // Assuming you have a Transaction model related to transactions table
                        $totalPendingOrders = \App\Models\Transaction::where('order_status', 'pending')->count();
                    @endphp
                    <a href="{{ route('OrderManagement') }}" class="nav-link {{ Request::is('Order-Management','view-transaction*','edit-transaction*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart" style="position: relative;">
                            @if ($totalPendingOrders > 0)
                                <span class="badge" style="background-color: red; color: white; font-size: 0.8em; position: absolute; top: -10px; right: -10px; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">
                                    {{ $totalPendingOrders }}
                                </span>
                            @endif
                        </i>
                        <p style="margin:5px;">Order Management</p>
                    </a>
                </li>                                             
                {{--Order Management--}}
                 <li class="nav-item">
                    <a href="{{route('OrderReports')}}"
                        class="nav-link {{ Request::is('Order-Report','Orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p> Order Reports </p>
                    </a>
                </li>
                {{-- Inquiries --}}
                <li class="nav-item">
                    <a href="{{ route('Inquiries') }}"
                        class="nav-link {{ Request::is('Inquiries','view-Inquiries*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p> Inquiries </p>
                    </a>
                </li>
                {{-- CMS --}}
                <li class="nav-item">
                    <a href="{{ route('cms') }}"
                        class="nav-link {{ Request::is('cms','view-cms*','edit-cms*','add-cms') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p> CMS </p>
                    </a>
                </li>

                {{--Home Blog Setting--}}
                <li class="nav-item">
                    <a href="{{ route('HomePageBlog') }}"
                        class="nav-link {{ Request::is('Home-Page-Blog','view-Blog*','add-Blog','edit-Blog*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Blogs</p>
                    </a>
                </li>

                {{--System Setting--}}
                <li class="nav-item">
                    <a href="{{ route('SystemSetting') }}"
                        class="nav-link {{ Request::is('SystemSetting',) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p> System Setting </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>