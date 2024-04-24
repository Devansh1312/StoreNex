<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
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
    //show index page of ProductCategory
    public function ProductCategory()
    {
        $user = Auth::user();
        $this->checkUserRole();

        return view("admin.ProductCategory.index", [
            "ProductCategory" => $user,
        ]);
    }

    //value in datatables
    function ProductCategoryList()
    {
        $this->checkUserRole();

        return ProductCategory::get();
    }

    // staff add page
    public function AddCategoryPage()
    {
        $this->checkUserRole();

        return view("admin.ProductCategory.addcategory");
    }

    //add new Category
    public function AddCategory(Request $request)
    {
        $this->checkUserRole();

        $request->validate([
            "name" => "required|string|unique:product_categories,name",
            "image" =>
                "required|image|mimes:webp,jpeg,png,jpg,gif,svg|max:128000",
        ]);

        $categoryName = $request->name;
        $fileName =
            $categoryName . "." . $request->image->getClientOriginalExtension();

        // Store the image in the public/CategoryIMG folder using storage path
        Storage::putFileAs(
            "public/CategoryIMG",
            $request->file("image"),
            $fileName
        );

        $data["name"] = $categoryName;
        $data["image"] = $fileName;

        $productCategory = ProductCategory::create($data);

        if (!$productCategory) {
            return redirect()
                ->route("ProductCategory")
                ->with("error", "Something went wrong");
        }

        return redirect()
            ->route("ProductCategory")
            ->with("success", "Product category added successfully");
    }

    // view ProductCategory
    public function ViewCategory($id)
    {
        $this->checkUserRole();
        $id = base64_decode($id);

        $productCategory = ProductCategory::find($id);

        if ($productCategory) {
            // return response()->json([
            //     $productCategory
            // ]);
            return view(
                "admin.ProductCategory.viewcategory",
                compact("productCategory")
            );
        } else {
            return response()->json([
                "status" => "error",
                "message" => "productCategory not found",
            ]);
        }
    }

    // edit ProductCategory details
    public function EditCategory($id)
    {
        $this->checkUserRole();
        $id = base64_decode($id);
        $productCategory = ProductCategory::find($id);

        if ($productCategory) {
            return view(
                "admin.ProductCategory.editcategory",
                compact("productCategory")
            );
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Product Category not found",
            ]);
        }
    }

    //update ProductCategory details
    public function UpdateCategory(Request $request, $id)
    {
        $this->checkUserRole();
        $id = base64_decode($id);
        $productCategory = ProductCategory::find($id);

        if (!$productCategory) {
            return redirect()
                ->route("ProductCategory")
                ->with("error", "Product Category not found");
        }

        $request->validate([
            "edit_name" =>
                "required|string|unique:product_categories,name," .
                $productCategory->id,
            "edit_image" =>
                "nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:128000",
        ]);

        $categoryName = $request->input("edit_name");
        $productCategory->name = $categoryName;

        if ($request->hasFile("edit_image")) {
            // Delete old image if exists
            Storage::delete("public/CategoryIMG/" . $productCategory->image);

            // Store the new image with the category name as the file name
            $fileName =
                $categoryName .
                "." .
                $request->file("edit_image")->getClientOriginalExtension();
            Storage::putFileAs(
                "public/CategoryIMG",
                $request->file("edit_image"),
                $fileName
            );
            $productCategory->image = $fileName;
        }

        $productCategory->save();
        return redirect()
            ->route("ProductCategory")
            ->with("success", "Product Category updated successfully");
    }

    //delete ProductCategory detail
    public function DeleteCategory(Request $request)
    {
        $this->checkUserRole();

        $id = $request->input("id");
        $productCategory = ProductCategory::find($id);

        if ($productCategory) {
            // Delete image file
            Storage::delete("public/CategoryIMG/" . $productCategory->image);

            $productCategory->delete();
            return response()->json([
                "status" => "success",
                "message" => "Product Category deleted successfully",
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Product Category not found",
            ]);
        }
    }
}
