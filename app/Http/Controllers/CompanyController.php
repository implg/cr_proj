<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

use App\Http\Requests;

class CompanyController extends Controller
{

    /**
     * CompanyController constructor.
     * @param BranchesController $branchesController
     * @param GroupsController $groupsCompany
     */
    public function __construct(
        BranchesController $branchesController,
        GroupsController $groupsCompany
    )
    {
        $this->branches = $branchesController;
        $this->groups = $groupsCompany;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = DB::table('company')
            ->leftJoin('branches', 'company.branch_id', '=', 'branches.id')
            ->leftJoin('groups_company', 'company.group_id', '=', 'groups_company.id')
            ->select([
                'company.id',
                'company.name',
                'branches.name as branch_name',
                'groups_company.name as group_name',
                'company.status',
                'company.phones',
                'company.director',
                'company.email'
            ]);

        return Datatables::of($companies)
            ->addColumn('action', function ($company) {
                return '
                    <a href="/company/' . $company->id . '/edit" class="btn btn-xs btn-raised btn-primary pull-left"><i class="material-icons">mode_edit</i> Изменить</a>
                    <form action="/company/' . $company->id . '" method="POST" class="pull-left" onsubmit="deleteName(this);return false;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="'. csrf_token() .'">
                        <button class="btn btn-xs btn-raised btn-warning" type="submit">Удалить</button>
                    </form>
                ';
            })
            ->setRowClass('company')
            ->setRowAttr([
                'data-id' => '{{$id}}',
            ])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = $this->branches->getBranches();
        $groups = $this->groups->getGroups();
        return view('main-module/company.create', [
            'branches' => $branches,
            'groups' => $groups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = Company::create($request->except('_token'));
        $request->session()->flash('success', 'Предприятие "' . $company->name . '" успешно создано!');
        return redirect(route('home'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);
        $branches = $this->branches->getBranches();
        $groups = $this->groups->getGroups();
        return view('main-module/company.update', [
            'branches' => $branches,
            'groups' => $groups,
            'company' => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        $company->update($request->except('_token'));
        $request->session()->flash('success', 'Предприятие "' . $company->name . '" успешно изменено!');
        return redirect(route('home'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        dd($id);
        Company::destroy($id);
        $request->session()->flash('success', 'Предприятие успешно Удалено!');
        return redirect(route('home'));
    }
}
