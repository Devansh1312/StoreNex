<?php

namespace App\Http\Controllers;

use App\Models\Cms_page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CmsController extends Controller
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
    //show index page of CMS
    public function cms()
    {
        $this->checkUserRole();
        $user = Auth::user();
        if (!$user) {
            return redirect()
                ->route("admin.login")
                ->with("error", "  You are not logged in.  ");
        }
        return view("admin.cms.index", ["cms" => $user]);
    }

    //value in datatables
    function CmsList()
    {
        $this->checkUserRole();
        return Cms_page::get();
    }

    // View CMS
    public function ViewCms($id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();
        $user = Auth::user();
        if (!$user) {
            return redirect()
                ->route("admin.login")
                ->with("error", "  You are not logged in.  ");
        }
        $Cms_page = Cms_page::find($id);

        if ($Cms_page) {
            return view("admin.cms.viewcms", compact("Cms_page"));
        } else {
            return redirect()
                ->route("cms")
                ->with("error", "  CMS page not found  ");
        }
    }

    // edit CMS details
    public function EditCms($id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();
        $user = Auth::user();
        if (!$user) {
            return redirect()
                ->route("admin.login")
                ->with("error", "  You are not logged in.  ");
        }
        $Cms_page = Cms_page::find($id);

        if ($Cms_page) {
            return view("admin.cms.editcms", compact("Cms_page"));
        } else {
            return redirect()
                ->route("cms")
                ->with("error", "  CMS page not found  ");
        }
    }

    //update Staff details
    public function UpdateCms(Request $request, $id)
    {
        $id = base64_decode($id);
        $this->checkUserRole();
        $user = Auth::user();
        if (!$user) {
            return redirect()
                ->route("admin.login")
                ->with("error", "  You are not logged in.  ");
        }
        $Cms_page = Cms_page::find($id);

        if (!$Cms_page) {
            return redirect()
                ->route("cms")
                ->with("error", "  CMS page not found  ");
        }

        $request->validate([
            "edit_title" => "required|string",
            "edit_content" => "required|string",
        ]);

        $Cms_page->title = $request->input("edit_title");
        $Cms_page->content = $request->input("edit_content");

        $Cms_page->save();
        return redirect()
            ->route("cms")
            ->with("success", "CMS updated successfully");
    }
}
