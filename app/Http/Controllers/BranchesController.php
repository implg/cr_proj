<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Sentry;

class BranchesController extends Controller
{

    /**
     * Get all the branches opened by the user
     *
     * @return string
     */
    public function getBranches()
    {
        $userId = Sentry::getUser()->id;
        $branches = User::find($userId)->branches;
        //dd($branches);
        return view('main-module.index');
    }

    /**
     * Create new branch
     */
    public function createBranch()
    {


    }
}
