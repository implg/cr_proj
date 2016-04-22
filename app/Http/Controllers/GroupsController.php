<?php

namespace App\Http\Controllers;

use App\GroupsCompany;
use Illuminate\Http\Request;

use App\Http\Requests;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = GroupsCompany::all();

        return view('main-module/groups-company.index', ['groups' => $groups]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getGroups()
    {
        $groups = GroupsCompany::all();
        return $groups;
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

        $branch = new GroupsCompany;
        $branch->name = $request->name;
        $branch->save();
        $request->session()->flash('success', 'Группа успешно создана!');
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
        $group = GroupsCompany::findOrFail($id);
        return view('main-module/groups-company.update', ['group' => $group]);
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
        $group = GroupsCompany::find($id);
        $group->name = $request->name;
        $group->save();
        $request->session()->flash('success', 'Группа "' . $group->name . '" успешно изменена!');
        return redirect(route('groups-company.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        GroupsCompany::destroy($id);
        $request->session()->flash('success', 'Группа успешно удалена!');
        return redirect()->back();
    }
}
