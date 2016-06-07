<?php

namespace App\Http\Controllers;

use App\Event;
use App\Help;
use App\HelpUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Sentry;

use App\Http\Requests;

class NotificationsController extends Controller
{

    public static function helpMessage()
    {
        $articles = User::find(Sentry::getUser()->id)->helps()->where('views', 0)->get();
        if ($articles->count()) {
            return true;
        }
        return false;
    }

    public static function newHelpArticle($id, $userId)
    {
        $article = HelpUser::where('help_id', $id)->where('user_id', $userId)->where('views', 0)->first();
        if ($article) {
            return true;
        }
        return false;
    }

    public static function getTodayTasks()
    {
        $tasks = Event::whereRaw('date(date) = ?', [Carbon::now()->format('Y-m-d')])
            ->where('reminder', 0)
            ->where('responsible_id', Sentry::getUser()->id)
            ->where('status', 0)->get();
        if ($tasks->count()) {
            return true;
        }
        return false;
    }

    public static function getCountTodayTasks()
    {
        $tasks = Event::whereRaw('date(date) = ?', [Carbon::now()->format('Y-m-d')])
            ->where('reminder', 0)
            ->where('responsible_id', Sentry::getUser()->id)
            ->where('status', 0)->get();

        if ($tasks->count()) {
            return $tasks->count();
        }
        return false;
    }

}
