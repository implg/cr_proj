<?php

namespace App\Http\Controllers;

use App\GroupsCompany;
use Illuminate\Http\Request;

use App\Http\Requests;

class GroupsController extends Controller
{

    /**
     * Get all the groups
     *
     * @return string
     */
    public function getGroups()
    {
        $groups = GroupsCompany::all();

        return $groups;
    }

    public function createGroup(Request $request)
    {
        $this->validate($request, [
            'groupName' => 'required'
        ]);

        $branch = new GroupsCompany;
        $branch->name = $request->groupName;
        $branch->save();
        $request->session()->flash('success', 'Группа успешно создана!');
        return redirect()->back();
    }
}
