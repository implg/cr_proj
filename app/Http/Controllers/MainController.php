<?php

namespace App\Http\Controllers;

use App\GroupsCompany;
use Illuminate\Http\Request;

use App\Http\Requests;

class MainController extends Controller
{

    public function __construct(
        BranchesController $branchesController,
        GroupsController $groupsCompany
    )
    {
        $this->branches = $branchesController;
        $this->groups = $groupsCompany;
    }

    public function index()
    {
        $branches = $this->branches->getBranches();
        $groups = $this->groups->getGroups();

        return view('main-module.index', [
            'branches' => $branches,
            'groups' => $groups
        ]);
    }

}
