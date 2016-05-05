<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Sentry;

use App\Http\Requests;

class CompanyController extends Controller
{

    /**
     * CompanyController constructor.
     * @param BranchesController $branchesController
     * @param GroupsController $groupsCompany
     * @param \App\Http\Controllers\UsersController $usersController
     */
    public function __construct(
        BranchesController $branchesController,
        GroupsController $groupsCompany,
        UsersController $usersController
    )
    {
        $this->branches = $branchesController;
        $this->groups = $groupsCompany;
        $this->users = $usersController;
        $this->userId = Sentry::getUser()->id;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Sentry::getUser()->hasAccess('admin')) {
            $companies = DB::table('company')
                ->leftJoin('branches', 'company.branch_id', '=', 'branches.id')
                ->leftJoin('groups_company', 'company.group_id', '=', 'groups_company.id')
                ->leftJoin('users', 'company.manager_id', '=', 'users.id')
                ->select([
                    'company.id',
                    'company.name',
                    'branches.name as branch_name',
                    'groups_company.name as group_name',
                    DB::raw('concat(users.first_name, " ", users.last_name) as full_name'),
                    'company.status',
                    'company.phones',
                    'company.director',
                    'company.email'
                ]);
        } else {
            $userBranch = User::find($this->userId)->branches;

            if(Sentry::getUser()->hasAccess('manager')) {
                $companies = DB::table('company')
                    ->whereIn('branch_id', $userBranch->lists('id'))
                    ->leftJoin('branches', 'company.branch_id', '=', 'branches.id')
                    ->leftJoin('groups_company', 'company.group_id', '=', 'groups_company.id')
                    ->where('groups_company.name', '=', 'Поставщик')
                    ->leftJoin('users', 'company.manager_id', '=', 'users.id')
                    ->select([
                        'company.id',
                        'company.name',
                        'branches.name as branch_name',
                        'groups_company.name as group_name',
                        DB::raw('concat(users.first_name, " ", users.last_name) as full_name'),
                        'company.status',
                        'company.phones',
                        'company.director',
                        'company.email'
                    ]);
            } else {
                $companies = DB::table('company')
                    ->whereIn('branch_id', $userBranch->lists('id'))
                    ->leftJoin('branches', 'company.branch_id', '=', 'branches.id')
                    ->leftJoin('groups_company', 'company.group_id', '=', 'groups_company.id')
                    ->leftJoin('users', 'company.manager_id', '=', 'users.id')
                    ->select([
                        'company.id',
                        'company.name',
                        'branches.id',
                        'branches.name as branch_name',
                        'groups_company.id',
                        'groups_company.name as group_name',
                        DB::raw('concat(users.first_name, " ", users.last_name) as full_name'),
                        'company.status',
                        'company.phones',
                        'company.director',
                        'company.email'
                    ]);
            }


        }

        return Datatables::of($companies)
            ->filter(function ($query) use ($request) {
                if ($request->has('branch_id')) {
                    $query->where('branches.name', '=', $request->get('branch_id'));
                }
                if ($request->has('group_id')) {
                    $query->where('groups_company.name', '=', $request->get('group_id'));
                }
                if ($request->has('status')) {
                    $query->where('company.status', '=', $request->get('status'));
                }
            })

            ->addColumn('action', function ($company) {
                return '
                    <a href="/company/' . $company->id . '/edit" class="btn btn-primary btn-fab btn-fab-mini "><i class="material-icons">mode_edit</i></a>
                    <form action="/company/' . $company->id . '" method="POST" onsubmit="deleteName(this);return false;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <button class="btn btn-fab btn-fab-mini btn-danger" type="submit"><i class="material-icons">delete</i></button>
                    </form>
                ';
            })
            ->setRowClass('company')
            ->setRowAttr([
                'data-id' => '{{$id}}',
            ])
            ->editColumn('status', function ($company) {
                $status = $this->getStatus($company->status);
                return $status;
            })
            ->make(true);

    }


    /**
     * @param $statusId
     * @return string
     */
    public function getStatus($statusId) {
        switch ($statusId) {
            case 1:
                $status = '<img src="/images/status/1.png" title="Черный список"> - Черный список';
                break;
            case 2:
                $status = '<img src="/images/status/2.png" title="Налаживаем контакт"> - Налаживаем контакт';
                break;
            case 3:
                $status = '<img src="/images/status/3.png" title="Работаем"> - Работаем';
                break;
            case 4:
                $status = '<img src="/images/status/4.png" title="VIP"> - VIP';
                break;
            default:
                $status = '<img src="/images/status/0.png" title="Без статуса"> - Без статуса';
        }
        return $status;
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
        $users = $this->users->getAllUser();
        return view('main-module/company.create', [
            'branches' => $branches,
            'groups' => $groups,
            'users' => $users
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
        LogsController::store($this->userId, 'Создание предприятия "' . $company->name . '"');
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
        $users = $this->users->getAllUser();
        return view('main-module/company.update', [
            'branches' => $branches,
            'groups' => $groups,
            'company' => $company,
            'users' => $users
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
        LogsController::store($this->userId, 'Изменение предприятия "' . $company->name . '"');
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
        Company::destroy($id);
        $request->session()->flash('success', 'Предприятие успешно удалено!');
        LogsController::store($this->userId, 'Удаление предприятия ID: '. $id);
        return redirect(route('home'));
    }
}
