<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Check User Role
    private function checkUserRole()
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, [1, 2])) {
            abort(
                403,
                "Unauthorized access. You do not have the necessary role to access this!"
            );
        }
    }
    // Show index page of products
    public function Product()
    {
        $this->checkUserRole();
        return view("admin.products.index");
    }

    // Value in datatables
    public function ProductList()
    {
        $this->checkUserRole();

        $products = Product::with("subcategory:id,name")
            ->select(
                "id",
                "subcategory_id",
                "name",
                "price",
                "description",
                "image",
                "created_at"
            )
            ->get();

        return response()->json($products);
    }

    // Show add product page
    public function AddProductPage()
    {
        $this->checkUserRole();
        $subcategories = Subcategory::all();
        return view("admin.products.addproduct", compact("subcategories"));
    }

    public function AddProduct(Request $request)
    {
        $this->checkUserRole();
        $request->validate([
            "name" => "required|string|unique:products,name",
            "subcategory_id" => "required|exists:subcategories,id",
            "price" => "required|numeric",
            "description" => "required|nullable|string",
            "image.*" =>
                "required|image|mimes:webp,jpeg,png,jpg,gif,svg|max:128000",
        ]);

        // Check if at least one image is uploaded
        if (
            !$request->hasFile("image") ||
            count($request->file("image")) == 0
        ) {
            return redirect()
                ->back()
                ->withErrors(["image" => "At least one image is required."])
                ->withInput();
        }

        // Handle multiple image uploads
        $imagePaths = [];
        $productName = $request->name;

        foreach ($request->file("image") as $key => $image) {
            // Generate a unique filename based on timestamp
            $fileName =
                time() . $key . "." . $image->getClientOriginalExtension();
            $image->storeAs("public/ProductIMG", $fileName);
            $imagePaths[] = $fileName;
        }

        $data = [
            "name" => $productName,
            "subcategory_id" => $request->subcategory_id,
            "price" => $request->price,
            "description" => $request->description,
        ];

        // Store image paths in the database
        $data["image"] = implode(",", $imagePaths);

        $product = Product::create($data);

        if (!$product) {
            return redirect()
                ->route("AddProductPage")
                ->with("error", "Something went wrong")
                ->withInput();
        }

        return redirect()
            ->route("Product")
            ->with("success", "Product added successfully");
    }

    // View product
    public function ViewProduct($id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();
        // Include both 'subcategory' and 'subcategory.productCategory' relationships
        $product = Product::with([
            "subcategory:id,name,product_category_id",
            "subcategory.productCategory:id,name",
        ])->find($id);

        if ($product) {
            return view("admin.products.viewproduct", compact("product"));
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Product not found",
            ]);
        }
    }

    // Show edit product page
    public function EditProduct($id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();
        $product = Product::with("subcategory:id,name")->find($id);

        if ($product) {
            $subcategories = Subcategory::all();
            return view(
                "admin.products.editproduct",
                compact("product", "subcategories")
            );
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Product not found",
            ]);
        }
    }

    // Update product details
    public function UpdateProduct(Request $request, $id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();
        $product = Product::find($id);

        if (!$product) {
            return redirect()
                ->route("Product")
                ->with("error", "Product not found");
        }

        $request->validate([
            "name" => "required|string|unique:products,name," . $product->id,
            "subcategory_id" => "required|exists:subcategories,id",
            "price" => "required|numeric",
            "description" => "required|string",
            "images.*" =>
                "nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:128000",
        ]);

        // Update other product details
        $product->name = $request->name;
        $product->subcategory_id = $request->subcategory_id;
        $product->price = $request->price;
        $product->description = $request->description;

        // Handle multiple image uploads
        if ($request->hasFile("image")) {
            $imagePaths = [];
            $productName = $request->name;

            foreach ($request->file("image") as $key => $image) {
                // Generate a unique filename based on timestamp
                $fileName =
                    time() . $key . "." . $image->getClientOriginalExtension();
                $image->storeAs("public/ProductIMG", $fileName);
                $imagePaths[] = $fileName;
            }

            // Update image paths
            $product->image = implode(",", $imagePaths);
        }
        $product->save();

        return redirect()
            ->route("Product")
            ->with("success", "Product updated successfully");
    }

    // Delete product details
    public function DeleteProduct(Request $request)
    {
        $this->checkUserRole();
        $id = $request->input("id");
        $product = Product::find($id);

        if ($product) {
            // Delete image files
            $imagePaths = explode(",", $product->image);
            foreach ($imagePaths as $imagePath) {
                Storage::delete("public/ProductIMG/" . $imagePath);
            }

            $product->delete();
            return response()->json([
                "status" => "success",
                "message" => "Product deleted successfully",
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Product not found",
            ]);
        }
    }
}
