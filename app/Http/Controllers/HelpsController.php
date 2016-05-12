<?php

namespace App\Http\Controllers;

use App\Help;
use Illuminate\Http\Request;
use Sentry;

use App\Http\Requests;

class HelpsController extends Controller
{
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

        if (Sentry::getUser()->hasAccess('admin')) {
            $articles = Help::all();
        } else {
            $articles = Help::where('addressee', $this->userId)->orWhere('addressee', 0)->get();
        }

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
        $article = Help::create($request->except('_token'));
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
        return view('help.edit', ['article' => $article]);
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
        $article->update($request->except('_token'));;
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
