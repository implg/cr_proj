<?php

namespace App\Http\Controllers;

use App\Branch;
use App\User;
use Illuminate\Http\Request;
use Sentry;
use App\Http\Controllers\LogsController;

use App\Http\Requests;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::all();

        return view('main-module/branches.index', ['branches' => $branches]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $branch = new Branch;
        $branch->name = $request->name;
        $branch->save();
        $request->session()->flash('success', 'Филлиал успешно создан!');
        LogsController::store($this->userId, 'Создание нового филиала');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        return view('main-module/branches.update', ['branch' => $branch]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $branch = Branch::find($id);
        $branch->name = $request->name;
        $branch->save();
        $request->session()->flash('success', 'Филиал "' . $branch->name . '" успешно изменен!');
        LogsController::store($this->userId, 'Изменение филиала "' . $branch->name . '"');
        return redirect(route('branches.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Branch::destroy($id);
        $request->session()->flash('success', 'Филиал успешно удален!');
        LogsController::store($this->userId, 'Удаление филиала: ID ' . $id);
        return redirect()->back();
    }
}
