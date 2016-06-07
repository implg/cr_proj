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

    public function getData(Request $request)
    {
        if (Sentry::getUser()->hasAccess('admin')) {
            $events = DB::table('events')
                ->leftJoin('users', 'events.user_id', '=', 'users.id')
                ->leftJoin('users as users2', 'events.responsible_id', '=', 'users2.id')
                ->leftJoin('company', 'events.company_id', '=', 'company.id')
                ->where('type', 1)
                ->orderBy('events.created_at', 'desc')
                ->select([
                    'events.id',
                    DB::raw('concat(users.first_name, " ", users.last_name) as full_name'),
                    DB::raw('concat(users2.first_name, " ", users2.last_name) as responsible_name'),
                    'events.status',
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
                ->orderBy('events.created_at', 'desc')
                ->select([
                    'events.id',
                    DB::raw('concat(users.first_name, " ", users.last_name) as full_name'),
                    DB::raw('concat(users2.first_name, " ", users2.last_name) as responsible_name'),
                    'events.status',
                    'company.name',
                    'events.date',
                    'events.text']);
        }

        return Datatables::of($events)
            ->filter(function ($query) use ($request) {
                if ($request->has('userId')) {
                    $query->where('events.user_id', $request->get('userId'));
                }
                if ($request->has('responsibleId')) {
                    $query->where('events.responsible_id', $request->get('responsibleId'));
                }
                if ($request->has('status')) {
                    $query->where('events.status', $request->get('status'));
                }
                if ($request->has('companyId')) {
                    $query->where('events.company_id', $request->get('companyId'));
                }
            })
            ->editColumn('status', function ($company) {
                $status = $this->getStatus($company->status);
                return $status;
            })
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
            ->setRowClass(function ($user) {
                switch ($user->status) {
                    case 1:
                        return 'info-task_in-work';
                        break;
                    case 2:
                        return 'info-task_executed';
                        break;
                    default:
                        return 'info-task_new';
                }
            })
            ->make();
    }

    /**
     * @param $statusId
     * @return string
     */
    public function getStatus($statusId)
    {
        switch ($statusId) {
            case 1:
                $status = 'В работе';
                break;
            case 2:
                $status = 'Выполнена';
                break;
            default:
                $status = 'Новая';
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
