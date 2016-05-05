<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Sentry;

class LogsController extends Controller
{

    /**
     * LogsController constructor.
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
        return view('logs.index');
    }

    public function getData(Request $request)
    {
        if (Sentry::getUser()->hasAccess('admin')) {
            $logs = DB::table('logs')
                ->leftJoin('users', 'logs.user_id', '=', 'users.id')
                ->select([
                    'logs.id',
                    'logs.created_at',
                    DB::raw('concat(users.first_name, " ", users.last_name) as full_name'),
                    'logs.action']);
        } else {
            $logs = DB::table('logs')
                ->leftJoin('users', 'logs.user_id', '=', 'users.id')
                ->where('logs.user_id', $this->userId)
                ->select([
                    'logs.id',
                    'logs.created_at',
                    DB::raw('concat(users.first_name, " ", users.last_name) as full_name'),
                    'logs.action']);
        }

        return Datatables::of($logs)
            ->filter(function ($query) use ($request) {
                if ($request->has('dateStart') and $request->has('dateEnd')) {
                    $query->whereBetween('logs.created_at', [$request->get('dateStart'), $request->get('dateEnd')]);
                }
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store($userId, $action)
    {
        $log = new Log;
        $log->user_id = $userId;
        $log->action = $action;
        $log->save();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
