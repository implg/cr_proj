<?php

namespace App\Http\Controllers;

use App\Company;
use App\Event;
use Illuminate\Http\Request;

use App\Http\Requests;
use Sentry;
use App\Http\Controllers\UsersController;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Get a events for company.
     *
     * @param $companyId
     * @return \Illuminate\Http\Response
     */
    public function getEvents($companyId)
    {
        $events = Company::find($companyId)->events;

        if (count($events)) {
            $res = '<table class="table table-bordered dataTable no-footer" id="events-table">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Создатель</td>
                    <td>Время задания</td>
                    <td>Ответственный</td>
                    <td>Описание</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>';
            foreach ($events as $event) {
                $res .= '<tr>';
                $res .= '<td>' . $event['id'] . '</td>';
                $res .= '<td>' . UsersController::getUserName($event['user_id']) . '</td>';
                $res .= '<td>' . $event['date'] . '</td>';
                $res .= '<td>' . UsersController::getUserName($event['responsible_id']) . '</td>';
                $res .= '<td>' . $event['text'] . '</td>';
                $res .= '<td align="center">
                        <a class="btn btn-fab btn-fab-mini btn-danger event-destroy"
                            href="#"
                            data-event-id="' . $event['id'] . '">
                            <i class="material-icons">delete</i>
                        </a></td>';
                $res .= '</tr>';
            }

            $res .= '</tbody></table>';
        } else {
            $res = 'Нет событий';
        }


        return $res;
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
        $event = new Event;
        $event->user_id = Sentry::getUser()->id;
        $event->responsible_id = $request->responsible_id;
        $event->company_id = $request->company_id;
        $event->text = $request->text;
        $event->date = $request->date;
        $event->reminder = $request->reminder;
        $event->save();

        return 'Событие успешно создано!';
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
        Event::destroy($id);
        return 'Событие удалено';
    }
}
