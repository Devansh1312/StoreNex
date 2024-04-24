<?php

namespace App\Http\Controllers;

use App\Models\HomePageBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomePageBlogController extends Controller
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
    public function HomeBlog()
    {
        $this->checkUserRole();
        $user = Auth::user();
        return view("admin.HomepageBlog.index", ["HomeBlog" => $user]);
    }

    //value in datatables
    function HomeblogList()
    {
        $this->checkUserRole();

        $blogs = HomePageBlog::all();

        return response()->json($blogs);
    }

    // staff add page
    public function AddHomeBlogPage()
    {
        $this->checkUserRole();
        return view("admin.HomepageBlog.addblog");
    }

    //add new Category
    public function AddHomepageBlog(Request $request)
    {
        $this->checkUserRole();

        $request->validate([
            "title" => "required|string|unique:home_page_blogs,title",
            "sub-title" => "required|string",
            "image" =>
                "required|image|mimes:webp,jpeg,png,jpg,gif,svg|max:128000",
        ]);

        $blogtitle = $request->title;

        $fileName =
            $blogtitle . "." . $request->image->getClientOriginalExtension();

        // Store the image in the public/CategoryIMG folder using storage path
        Storage::putFileAs(
            "public/HomepageBlogImg",
            $request->file("image"),
            $fileName
        );

        $blogtitle = $request->title;
        $blogsubtitle = $request->input("sub-title");
        $data["title"] = $blogtitle;
        $data["sub-title"] = $blogsubtitle;
        $data["image"] = $fileName;
        // dd($data);
        $data = HomePageBlog::create($data);

        if (!$data) {
            return redirect()
                ->route("HomePageBlog")
                ->with("error", "Something went wrong");
        }

        return redirect()
            ->route("HomePageBlog")
            ->with("success", "Blog added successfully");
    }

    // view ProductCategory
    public function ViewHomepageBlog($id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();
        $HomepageBlog = HomePageBlog::find($id);

        if ($HomepageBlog) {
            // return response()->json([
            //     $productCategory
            // ]);
            return view("admin.HomepageBlog.viewblog", compact("HomepageBlog"));
        } else {
            return response()->json([
                "status" => "error",
                "message" => "productCategory not found",
            ]);
        }
    }

    // edit ProductCategory details
    public function EditHomepageBlog($id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();
        $HomepageBlog = HomePageBlog::find($id);

        if ($HomepageBlog) {
            return view("admin.HomepageBlog.editblog", compact("HomepageBlog"));
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Blog not found",
            ]);
        }
    }

    //update ProductCategory details
    public function UpdateHomepageBlog(Request $request, $id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();
        $HomepageBlog = HomePageBlog::find($id);

        if (!$HomepageBlog) {
            return redirect()
                ->route("HomepageBlog")
                ->with("error", "Blog not found");
        }

        $request->validate([
            "title" =>
                "required|string|unique:home_page_blogs,title," .
                $HomepageBlog->id,
            "sub-title" => "required|string",
            "image" =>
                "nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:128000",
        ]);

        $blogtitle = $request->input("title");
        $HomepageBlog->title = $blogtitle;

        if ($request->hasFile("image")) {
            // Delete old image if exists
            Storage::delete("public/HomepageBlogImg/" . $HomepageBlog->image);

            // Store the new image with the category name as the file name
            $fileName =
                $blogtitle .
                "." .
                $request->file("image")->getClientOriginalExtension();
            Storage::putFileAs(
                "public/HomepageBlogImg/",
                $request->file("image"),
                $fileName
            );
            $HomepageBlog->image = $fileName;
        }

        $HomepageBlog->{'sub-title'} = $request->input("sub-title");
        $HomepageBlog->save();
        return redirect()
            ->route("HomePageBlog")
            ->with("success", "Blog updated successfully");
    }

    //delete ProductCategory detail
    public function DeleteHomepageBlog(Request $request)
    {
        $this->checkUserRole();
        $id = $request->input("id");
        $HomepageBlog = HomePageBlog::find($id);

        if ($HomepageBlog) {
            // Delete image file
            Storage::delete("public/HomepageBlogImg" . $HomepageBlog->image);

            $HomepageBlog->delete();
            return response()->json([
                "status" => "success",
                "message" => "blog deleted successfully",
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Blog Category not found",
            ]);
        }
    }
}

// Update Blog details
// public function UpdateHomepageBlog(Request $request, $id)
// {
//     $user = Auth::user();
//     if (!$user || $user->role != 1) {
//         return redirect()->route("admin.login")->with("error", "You are not logged in.");
//     }

//     $HomepageBlog = HomePageBlog::find($id);

//     if (!$HomepageBlog) {
//         return redirect()->route("HomePageBlog")->with("error", "Blog not found");
//     }

//     $request->validate([
//         "title" => "required|string|unique:home_page_blogs,title," . $HomepageBlog->id,
//         "sub-title" => "required|string",
//         "image" => "nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:128000",
//     ]);

//     $title = $request->input("title");
//     $subTitle = $request->input("sub-title");

//     // Check if a new image is provided
//     if ($request->hasFile("image")) {
//         // Delete old image if exists
//         Storage::delete("public/HomepageBlogImg/" . $HomepageBlog->image);

//         // Store the new image with the category name as the file name
//         $fileName = $title . "." . $request->file("image")->getClientOriginalExtension();
//         Storage::putFileAs("public/HomepageBlogImg", $request->file("image"), $fileName);
//         $HomepageBlog->image = $fileName;
//     }

//     $HomepageBlog->title = $title;
//     $HomepageBlog->{'sub-title'} = $subTitle;
//     $HomepageBlog->save();

//     return redirect()->route("HomePageBlog")->with("success", "Blog updated successfully");
// }
