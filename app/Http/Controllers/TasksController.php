<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Sentry;
use App\Http\Requests;

class TasksController extends Controller
{

    /**
     * TasksController constructor.
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
        return view('tasks.index');
    }

    public function getData()
    {
        if (Sentry::getUser()->hasAccess('admin')) {
            $events = DB::table('events')
                ->leftJoin('users', 'events.user_id', '=', 'users.id')
                ->leftJoin('users as users2', 'events.responsible_id', '=', 'users2.id')
                ->leftJoin('company', 'events.company_id', '=', 'company.id')
                ->where('type', 1)
                ->select([
                    'events.id',
                    DB::raw('concat(users.first_name, " ", users.last_name) as full_name'),
                    DB::raw('concat(users2.first_name, " ", users2.last_name) as responsible_name'),
                    'company.name',
                    'events.date',
                    'events.text']);
        } else {
            $events = DB::table('events')
                ->leftJoin('users', 'events.user_id', '=', 'users.id')
                ->leftJoin('users as users2', 'events.responsible_id', '=', 'users2.id')
                ->leftJoin('company', 'events.company_id', '=', 'company.id')
                ->whereType(1)
                ->where(function ($query) {
                    $query->where('events.user_id', $this->userId)
                        ->orWhere(function ($query) {
                            $query->where('events.responsible_id', $this->userId);
                        });
                })
                ->select([
                    'events.id',
                    DB::raw('concat(users.first_name, " ", users.last_name) as full_name'),
                    DB::raw('concat(users2.first_name, " ", users2.last_name) as responsible_name'),
                    'company.name',
                    'events.date',
                    'events.text']);
        }

        return Datatables::of($events)
            ->addColumn('action', function ($event) {
                return '
                    <a href="#" data-event-id="' . $event->id . '" class="btn btn-primary btn-fab btn-fab-mini event_edit"><i class="material-icons">mode_edit</i></a>
                    <a class="btn btn-fab btn-fab-mini btn-danger event-destroy"
                        href="#"
                        data-event-id="' . $event->id . '">
                        <i class="material-icons">delete</i>
                    </a>
                ';
            })
            ->make();
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
