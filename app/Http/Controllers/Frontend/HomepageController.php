<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\HomePageBlog;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HomepageController extends Controller
{
    // Show Home Page Of Customer
    public function welcome()
    {
        
        $bannerproduct = Subcategory::inRandomOrder()->get();
        $latestproduct = Product::inRandomOrder()
            ->limit(8)
            ->get();
        $commingproduct = Product::inRandomOrder()
            ->limit(8)
            ->get();
        $products = Product::inRandomOrder()
            ->limit(9)
            ->get();
        $blogs = HomePageBlog::all();
        $category = ProductCategory::inRandomOrder()
            ->limit(4)
            ->get();

        return view("welcome", [
            "bannerproduct" => $bannerproduct,
            "latestproduct" => $latestproduct,
            "commingproduct" => $commingproduct,
            "products" => $products,
            "category" => $category,
            "blogs" => $blogs,
        ]);
    }

    // Show Single Product Page With Product Details
    public function show($id)
    {
        $id = base64_decode($id);
        $product = Product::findOrFail($id); // Retrieve the product or fail

        // Fetch related products based on the subcategory of the currently viewed product
        $relatedProducts = Product::whereHas("subcategory", function (
            $query
        ) use ($product) {
            $query->where("id", $product->subcategory->id);
        })
            ->where("id", "!=", $product->id) // Exclude the current product
            ->inRandomOrder()
            ->limit(9)
            ->get();

        // Return the single-product view with the product details and related products
        return view("frontend.Product.single-product", [
            "product" => $product,
            "relatedProducts" => $relatedProducts,
        ]);
    }

    // Show Subcategory product Listing page 
    public function showSubcategoryProducts(Request $request, $id)
    {
        $id = base64_decode($id);

        $categories = ProductCategory::with([
            "subcategories" => function ($query) {
                $query->withCount("products");
            },
        ])->get();

        $subcategory = Subcategory::findOrFail($id);
        $perPage = $request->input("perPage", 6);

        $query = Product::where("subcategory_id", $subcategory->id);

        // Apply price filter if provided
        if ($request->has("min_price") && $request->has("max_price")) {
            $minPrice = $request->input("min_price");
            $maxPrice = $request->input("max_price");
            $query->whereBetween("price", [$minPrice, $maxPrice]);
        }

        // Apply sorting based on the request parameter
        switch ($request->input("sort")) {
            case "latest":
                $query->orderBy("created_at", "desc");
                break;
            case "oldest":
                $query->orderBy("created_at", "asc");
                break;
            case "price_asc":
                $query->orderBy("price", "asc");
                break;
            case "price_desc":
                $query->orderBy("price", "desc");
                break;
            case "name_asc":
                $query->orderBy("name", "asc");
                break;
            case "name_desc":
                $query->orderBy("name", "desc");
                break;
            default:
                // Default sorting option, if none is provided
                $query->orderBy("created_at", "desc");
                break;
        }

        // Retrieve paginated products with query string including applied filters and sorting options
        $products = $query->paginate($perPage)->appends($request->query());

        // Generate URL for subcategory with current filter parameters
        // This seems to be correctly handled in your code, just ensure it's consistent
        $subcategoryUrl = route('subcategory.products', ['id' => base64_encode($subcategory->id)]) . '?' . http_build_query($request->query());


        return view("frontend.Product.subproductlisting", [
            "subcategory" => $subcategory,
            "products" => $products,
            "perPage" => $perPage,
            "categories" => $categories,
            "request" => $request, // Pass the $request variable to the view
            "subcategoryUrl" => $subcategoryUrl, // Pass the subcategory URL with filters to the view
        ]);
    }


    // ShowAll Products If Search Then That Products Only 
    public function showAllProducts(Request $request)
    {
        $searchQuery = $request->input('s');
        $perPage = $request->input("perPage", 6);

        // Retrieve categories for navigation
        $categories = ProductCategory::with([
            "subcategories" => function ($query) {
                $query->withCount("products");
            },
        ])->get();

        // Start building the query
        $query = Product::query();

        // Apply search filter
        if ($searchQuery) {
            $query->where('name', 'like', '%' . $searchQuery . '%');
        }

        // Apply price filter if provided
        if ($request->has("min_price") && $request->has("max_price")) {
            $minPrice = $request->input("min_price");
            $maxPrice = $request->input("max_price");
            $query->whereBetween("price", [$minPrice, $maxPrice]);
        }

        // Apply sorting based on the request parameter
        switch ($request->input("sort")) {
            case "latest":
                $query->orderBy("created_at", "desc");
                break;
            case "oldest":
                $query->orderBy("created_at", "asc");
                break;
            case "price_asc":
                $query->orderBy("price", "asc");
                break;
            case "price_desc":
                $query->orderBy("price", "desc");
                break;
            case "name_asc":
                $query->orderBy("name", "asc");
                break;
            case "name_desc":
                $query->orderBy("name", "desc");
                break;
            default:
                // Default sorting option, if none is provided
                $query->orderBy("created_at", "desc");
                break;
        }

        // Retrieve paginated products with query string including applied filters and sorting options
        $products = $query->paginate($perPage)->appends($request->query());

        // Example of applying filters
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Example of applying sorting
        $sortBy = $request->input('sort_by', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        // Retrieve paginated products with query string including applied filters and sorting options
        $products = $query->paginate($perPage)->appends($request->query());

        // Get the wishlist status for each product if the user is authenticated
        $isWishlisted = [];
        if (Auth::check()) {
            $userId = Auth::id();
            foreach ($products as $product) {
                $isWishlisted[$product->id] = $product->wishlists()->where('user_id', $userId)->exists();
            }
        }
        
        return view("frontend.Product.AllProductListingPage", [
            "products" => $products,
            "perPage" => $perPage,
            "categories" => $categories,
            "request" => $request, // Pass the $request variable to the view for pagination links
            "isWishlisted" => $isWishlisted,
        ]);
    }
}
