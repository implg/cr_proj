<?php

namespace App\Http\Controllers;

use App\Branch;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Sentry;

class BranchesController extends Controller
{

    /**
     * BranchesController constructor.
     */
    public function __construct()
    {
        $this->userId = Sentry::getUser()->id;
    }

    /**
     * Get all the branches opened by the user
     *
     * @return string
     */
    public function getBranches()
    {

        if(Sentry::getUser()->hasAccess('admin')) {
            $branches = Branch::all();
        } else {
            $branches = User::find($this->userId)->branches;
        }

        return $branches;
    }

    /**
     * Create new branch
     * @param Request $request
     */
    public function createBranch(Request $request)
    {
        $this->validate($request, [
            'branchName' => 'required'
        ]);

        $branch = new Branch;
        $branch->name = $request->branchName;
        $branch->save();
        $request->session()->flash('success', 'Филлиал успешно создан!');
        return redirect()->back();
    }
}
