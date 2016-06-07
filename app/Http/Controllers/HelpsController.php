<?php

namespace App\Http\Controllers;

use App\Help;
use App\HelpUser;
use App\User;
use Illuminate\Http\Request;
use Sentry;

use App\Http\Requests;

class HelpsController extends Controller
{
    /**
     * HelpsController constructor.
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

        //if (Sentry::getUser()->hasAccess('admin')) {
            $articles = Help::orderBy('id', 'desc')->get();
//        } else {
//            $articlesForAll = Help::where('addressee', 1)->get();
//            $articles = $articlesForAll->merge(User::find($this->userId)->helps);
//            $articles->all();
//        }

        return view('help.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('help.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->addressee);
        $article = new Help;
        $article->created_user = $request->created_user;
        $article->title = $request->title;
        $article->text = $request->text;
        $article->addressee = $request->addressee ? 1 : 0;
        $article->save();

        if ($request->addressee) {
            $helpUser = Help::find($article->id);
            $helpUser->users()->attach($request->addressee);
        }

        $request->session()->flash('success', 'Статья успешно создана!');
        LogsController::store($this->userId, 'Создание статьи "' . $article->title . '"');
        return redirect(route('help.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Help::findOrFail($id);

        $helpUser = HelpUser::where('help_id', $id)->where('user_id', $this->userId)->first();
        if ($helpUser and $helpUser->views == 0) {
            $helpUser->views = 1;
            $helpUser->save();
        }

        return view('help.show', ['article' => $article]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Help::findOrFail($id);
        $articleUsers = Help::find($id)->users;
        return view('help.edit', ['article' => $article, 'articleUsers' => $articleUsers]);
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
        $article = Help::findOrFail($id);
        $article->created_user = $request->created_user;
        $article->title = $request->title;
        $article->text = $request->text;


        if($request->addressee) {
            Help::find($id)->users()->sync($request->addressee);
            $article->addressee = 0;
        } else {
            Help::find($id)->users()->detach();
            $article->addressee = 1;
        }
        $article->save();

        $request->session()->flash('success', 'Статья успешно изменена!');
        LogsController::store($this->userId, 'Изменение статьи "' . $article->title . '"');
        return redirect(route('help.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Help::destroy($id);
        $request->session()->flash('success', 'Статья успешно удалена!');
        LogsController::store($this->userId, 'Удаление статьи ID: ' . $id);
        return redirect(route('help.index'));
    }
}
