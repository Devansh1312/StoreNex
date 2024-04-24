<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubcategoryController extends Controller
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
    // Show index page of SubCategory
    public function Subcategories()
    {
        $this->checkUserRole();

        return view("admin.subcategories.index");
    }

    // Value in datatables
    public function SubcategoriesList()
    {
        $this->checkUserRole();

        $subcategories = Subcategory::with("category")
            ->select("id", "name", "product_category_id", "created_at", "image")
            ->get();
        return response()->json($subcategories);
    }

    // Show add SubCategory page
    public function AddSubCategoryPage()
    {
        $this->checkUserRole();
        $categories = ProductCategory::all();
        return view(
            "admin.subcategories.addsubcategories",
            compact("categories")
        );
    }

    public function AddSubCategory(Request $request)
    {
        $this->checkUserRole();

        $request->validate([
            "name" => "required|string|unique:subcategories,name",
            "product_category_id" => "required|exists:product_categories,id",
            "image" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:128000",
        ]);

        $imageName = time() . "." . $request->image->extension();
        $request->image->storeAs("public/subcategory_images", $imageName);

        $subcategory = [
            "product_category_id" => $request->product_category_id,
            "name" => $request->name,
            "image" => $imageName,
        ];
        $subcategory = Subcategory::create($subcategory);
        if (!$subcategory) {
            return redirect()
                ->route("Subcategories")
                ->with("error", "Something went wrong");
        }

        return redirect()
            ->route("Subcategories")
            ->with("success", "Subcategory added successfully.");
    }

    // View SubCategory
    public function ViewSubCategory($id)
    {
        $this->checkUserRole();
        $id = base64_decode($id);
        $subcategory = Subcategory::find($id);

        if ($subcategory) {
            return view(
                "admin.subcategories.viewsubcategories",
                compact("subcategory")
            );
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Subcategory not found",
            ]);
        }
    }

    // Show edit SubCategory page
    public function EditSubCategory($id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();

        $subcategory = Subcategory::find($id);
        $categories = ProductCategory::all(); // Get all categories for the dropdown
        if (!$subcategory) {
            return redirect()
                ->back()
                ->with("error", "Subcategory not found.");
        }
        return view(
            "admin.subcategories.editsubcategories",
            compact("subcategory", "categories")
        );
    }

    // Update SubCategory details
    public function UpdateSubCategory(Request $request, $id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();

        $request->validate([
            "edit_name" => "required|string|unique:subcategories,name," . $id,
            "category_id" => "required|exists:product_categories,id",
            "edit_image" =>
                "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);

        $subcategory = Subcategory::find($id);
        if (!$subcategory) {
            return redirect()
                ->back()
                ->with("error", "Subcategory not found.");
        }

        $subcategory->name = $request->edit_name;
        $subcategory->product_category_id = $request->category_id;

        if ($request->hasFile("edit_image")) {
            $imageName = time() . "." . $request->edit_image->extension();
            $request->edit_image->storeAs(
                "public/subcategory_images",
                $imageName
            );
            $subcategory->image = $imageName;
        }

        $subcategory->save();

        return redirect()
            ->route("Subcategories")
            ->with("success", "Subcategory updated successfully.");
    }

    // Delete SubCategory details
    public function DeleteSubCategory(Request $request)
    {
        $this->checkUserRole();

        $id = $request->input("id"); // Ensure you're getting the ID correctly
        $subcategory = Subcategory::find($id);
        if ($subcategory) {
            $subcategory->delete();
            return response()->json([
                "status" => "success",
                "message" => "Subcategory deleted successfully",
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Subcategory not found",
            ]);
        }
    }
}
