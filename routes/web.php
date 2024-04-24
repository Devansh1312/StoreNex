<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CmsController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InquiriesController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\OrderReportController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\HomePageBlogController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomepageController;
use App\Http\Controllers\Frontend\WishlistController;

Route::get('/create-symlink', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');

    if (!file_exists($link)) {
        // Attempt to create the symbolic link
        try {
            // Using the Storage facade to create the link
            Storage::link('public', $target);
            $message = "The symbolic link has been created successfully at {$link}";
        } catch (\Exception $e) {
            // Catch and report any errors during the link creation
            $message = "Failed to create the symbolic link: " . $e->getMessage();
        }
    } else {
        // If the link already exists, inform the user
        $message = "The symbolic link already exists.";
    }

    return $message;
})->middleware('auth');

Route::get('/optimize-application', function() {
    // Clear cache
    Artisan::call('cache:clear');
    // Clear config cache
    Artisan::call('config:clear');
    // Clear compiled views
    Artisan::call('view:clear');
    // Clear route cache
    Artisan::call('route:clear');
    // Optimize the application (Regenerate framework files for optimization)
    // Note: `optimize` command might not be available in all Laravel versions.
    // Artisan::call('optimize');
    
    return "Application is optimized and cache is cleared";
})->middleware('auth'); // Ensure this route is protected

Route::get('/clear-storage-link', function() {
    // Delete the symbolic link for storage
    if (file_exists(public_path('storage'))) {
        unlink(public_path('storage'));
        return "Storage link cleared successfully";
    } else {
        return "Storage link does not exist";
    }
})->middleware('auth'); // Ensure this route is protected

Route::get('/create-storage-link', function() {
    // Recreate the symbolic link for storage
    Artisan::call('storage:link');
    return "Storage link created successfully";
})->middleware('auth'); // Ensure this route is protected

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
});

// website Home page 
Route::get("/", [HomepageController::class, "welcome"])->name("welcome");

//Admin Login and Logout 
Route::get("/adminlogin", [AdminLoginController::class, "loginpage"])->name("admin.login");
Route::post("/add", [AdminLoginController::class, "adduser"])->name("adduser");
Route::any("/login", [AdminLoginController::class, "login"])->name("login");
Route::post("/logout", [AdminLoginController::class, "logout"])->name("logout");


//dashboard page of admin
Route::any("/dashboard", [AdminLoginController::class, "dashboard"])->name("admin.dashboard");

///  Staff Route
Route::get("/Staff", [StaffController::class, "Staff"])->name("Staff");
Route::get("StaffList", [StaffController::class, "StaffList"]);
Route::get("/add-staff", [StaffController::class, "AddStaffPage"])->name("AddStaffPage");
Route::post("/add-staff", [StaffController::class, "AddStaff"])->name("AddStaff");
Route::post("/delete-staff", [StaffController::class, "DeleteStaff"])->name("DeleteStaff");
Route::get("/edit-staff/{id}", [StaffController::class, "EditStaff"])->name("EditStaff");
Route::post("/update-staff/{id}", [StaffController::class, "UpdateStaff"])->name("UpdateStaff");
Route::get("/view-staff/{id}", [StaffController::class, "ViewStaff"])->name("ViewStaff");


///  customer Route
Route::get("/Customer", [CustomerController::class, "Customer"])->name("Customer");
Route::get("CustomerList", [CustomerController::class, "CustomerList"]);
Route::get("/view-customer/{id}", [CustomerController::class, "ViewCustomer"])->name("ViewCustomer");
Route::post("/delete-customer", [CustomerController::class, "DeleteCustomer"])->name("DeleteCustomer");


///  ProductCategory Route
Route::get("/ProductCategory", [ProductCategoryController::class, "ProductCategory"])->name("ProductCategory");
Route::get("ProductCategoryList", [ProductCategoryController::class, "ProductCategoryList"]);
Route::get("/add-category", [ProductCategoryController::class, "AddCategoryPage"])->name("AddCategoryPage");
Route::post("/add-category", [ProductCategoryController::class, "AddCategory"])->name("AddCategory");
Route::get("/view-category/{id}", [ProductCategoryController::class, "ViewCategory"])->name("ViewCategory");
Route::get("/edit-category/{id}", [ProductCategoryController::class, "EditCategory"])->name("EditCategory");
Route::post("/update-category/{id}", [ProductCategoryController::class, "UpdateCategory"])->name("UpdateCategory");
Route::post("/delete-category", [ProductCategoryController::class, "DeleteCategory"])->name("DeleteCategory");


// Subcategory Routes
Route::get("/Subcategories", [SubcategoryController::class, "Subcategories"])->name("Subcategories");
Route::get("SubcategoriesList", [SubcategoryController::class, "SubcategoriesList"]);
Route::get("/add-SubCategory", [SubcategoryController::class, "AddSubCategoryPage"])->name("AddSubCategoryPage");
Route::post("/add-SubCategory", [SubcategoryController::class, "AddSubCategory"])->name("AddSubCategory");
Route::get("/view-SubCategory/{id}", [SubcategoryController::class, "ViewSubCategory"])->name("ViewSubCategory");
Route::get("/edit-SubCategory/{id}", [SubcategoryController::class, "EditSubCategory"])->name("EditSubCategory");
Route::post("/update-SubCategory/{id}", [SubcategoryController::class, "UpdateSubCategory"])->name("UpdateSubCategory");
Route::post("/delete-SubCategory/{id}", [SubcategoryController::class, "DeleteSubCategory"])->name("DeleteSubCategory");


///  Product Route
Route::get("/Product", [ProductController::class, "Product"])->name("Product");
Route::get("ProductList", [ProductController::class, "ProductList"]);
Route::get("/add-product", [ProductController::class, "AddProductPage"])->name("AddProductPage");
Route::post("/add-product", [ProductController::class, "AddProduct"])->name("AddProduct");
Route::get("/view-product/{id}", [ProductController::class, "ViewProduct"])->name("ViewProduct");
Route::get("/edit-product/{id}", [ProductController::class, "EditProduct"])->name("EditProduct");
Route::post("/update-product/{id}", [ProductController::class, "UpdateProduct"])->name("UpdateProduct");
Route::post("/delete-product", [ProductController::class, "DeleteProduct"])->name("DeleteProduct");


///  OrderManagement Route
Route::get("/Order-Management", [OrderManagementController::class, "OrderManagement"])->name("OrderManagement");
Route::get("/transactions", [OrderManagementController::class, "transactions"])->name("transactionList");
Route::get("/view-transaction/{id}", [OrderManagementController::class, "ViewTransaction"])->name("ViewTransaction");
Route::get("/edit-transaction/{id}", [OrderManagementController::class, "EditTransaction"])->name("EditTransaction");
Route::post("/update-transaction/{id}", [OrderManagementController::class, "UpdateTransaction"])->name("UpdateTransaction");

// Define routes for Order Reports
Route::get('/Order-Report', [OrderReportController::class, 'OrderReports'])->name('OrderReports');
Route::get('/Orders', [OrderReportController::class, 'Orders'])->name('Orders');


///  CMS Route
Route::get("/cms", [CmsController::class, "cms"])->name("cms");
Route::get("CmsList", [CmsController::class, "CmsList"]);
// Route::get("/add-cms", [CmsController::class, "AddCmsPage"])->name("AddCmsPage");
// Route::post("/add-cms", [CmsController::class, "AddCms"])->name("AddCms");
// Route::post("/delete-cms", [CmsController::class, "DeleteCms"])->name("DeleteCms");
Route::get("/edit-cms/{id}", [CmsController::class, "EditCms"])->name("EditCms");
Route::post("/update-cms/{id}", [CmsController::class, "UpdateCms"])->name("UpdateCms");
Route::get("/view-cms/{id}", [CmsController::class, "ViewCms"])->name("ViewCms");

///  Inquiries Route
Route::get("/Inquiries", [InquiriesController::class, "Inquiries"])->name("Inquiries");
Route::get("InquiriesList", [InquiriesController::class, "InquiriesList"]);
Route::post("/delete-Inquiries", [InquiriesController::class, "DeleteInquiries"])->name("DeleteInquiries");
Route::get("/view-Inquiries/{id}", [InquiriesController::class, "ViewInquiries"])->name("ViewInquiries");
Route::post("/Add-Inquiry", [InquiriesController::class, "AddInquiries"])->name("submit.inquiry");


// SystemSetting Routes
Route::get("/SystemSetting", [SystemSettingController::class, "SystemSetting"])->name("SystemSetting");
Route::post("/update-SystemSetting/{id}", [SystemSettingController::class, "UpdateSystemSetting"])->name("UpdateSystemSetting");


///  HomePageBlog Route
Route::get("/Home-Page-Blog", [HomePageBlogController::class, "HomeBlog"])->name("HomePageBlog");
Route::get("HomeblogList", [HomePageBlogController::class, "HomeblogList"])->name("HomeblogList");
Route::get("/add-Blog", [HomePageBlogController::class, "AddHomeBlogPage"])->name("AddHomeBlogPage");
Route::post("/add-Blog", [HomePageBlogController::class, "AddHomepageBlog"])->name("AddHomepageBlog");
Route::get("/view-Blog/{id}", [HomePageBlogController::class, "ViewHomepageBlog"])->name("ViewHomepageBlog");
Route::get("/edit-Blog/{id}", [HomePageBlogController::class, "EditHomepageBlog"])->name("EditHomepageBlog");
Route::post("/update-Blog/{id}", [HomePageBlogController::class, "UpdateHomepageBlog"])->name("UpdateHomepageBlog");
Route::post("/delete-Blog", [HomePageBlogController::class, "DeleteHomepageBlog"])->name("DeleteHomepageBlog");


//Customer Login And Signup Page.
Route::get("/Customer-Login", [AuthController::class, "customerloginpage"])->name("customerloginpage");
Route::get("/Customer-Register", [AuthController::class, "Customerregisterpage"])->name("Customerregisterpage");
Route::post("/Customer-Add", [AuthController::class, "customeradd"])->name("customeradd");
Route::any("/customerlogin", [AuthController::class, "customerlogin"])->name("customerlogin");
Route::post("/Customerlogout", [AuthController::class, "Customerlogout"])->name("Customerlogout");
Route::get('verify/{token}', [AuthController::class,'verify'])->name('verification.verify');
Route::get("/Forgot-Password", [AuthController::class, "ForgotPasswordPage"])->name("ForgotPasswordPage");
Route::post("/Forgot-Password", [AuthController::class, "ForgotPassword"])->name("ForgotPassword");
Route::get("/reset/{token}", [AuthController::class, "reset"])->name("reset");
Route::post("/reset/{token}", [AuthController::class, "ResetPassword"])->name("ResetPassword");


// CMS page Frontend
Route::get("/About-Us", [PageController::class, "AboutUs"])->name("AboutUs");
Route::get("/FAQ", [PageController::class, "FAQ"])->name("FAQ");
Route::get("/Contact-Us", [PageController::class, "ContactUs"])->name("ContactUs");
Route::get("/Terms&Condition", [PageController::class, "TermsAndCondition"])->name("TermsAndCondition");


// Profile Page
Route::get("/Profile", [PageController::class, "Profile"])->name("Profile");
Route::post('/UpdateProfile', [PageController::class,"UpdateProfile"])->name("UpdateProfile");


//Show Single Product
Route::get('/product/{id}', [HomepageController::class, 'show'])->name('product.show');


//Show Subcategory page with product Listing
Route::get('/subcategory/{id}', [HomepageController::class, 'showSubcategoryProducts'])->name('subcategory.products');

//Show All Products Listing page
Route::get('/AllProducts', [HomepageController::class, 'showAllProducts'])->name('showAllProducts');



// Add to cart route
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
// update
Route::post('/update-cart',  [CartController::class, 'updatecart'])->name('cart.update');
// Cart page route
Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

// CheckOut Routes
Route::get('/Checkout', [CheckoutController::class, 'Checkout'])->name('Checkout');
Route::post('/Checkout', [CheckoutController::class, 'ProcessCheckout'])->name('checkout.process');
Route::get('/checkout/verify', [CheckoutController::class, 'verifyPayment'])->name('frontend.order.verifyPayment');
// Route::post('/log-payment-response', [CheckoutController::class, 'logPaymentResponse'])->name('logPaymentResponse');



// Thank You Page
Route::get('/thankyou', [CheckoutController::class, 'thankyou'])->name('thankyou');

// Order History 
Route::get('/order-history', [PageController::class, 'OrderHistory'])->name('OrderHistory');
Route::get('/order/{id}', [PageController::class, 'SingleOrder'])->name('SingleOrder');

// Wishlist add route
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add')->middleware('auth');
// Wishlist remove route
Route::delete('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove')->middleware('auth');
Route::get('/guestuser', [WishlistController::class, 'guestuser'])->name('guestuser');
Route::get('/wishlist', [WishlistController::class, 'getWishlistItems'])->name('wishlist');

