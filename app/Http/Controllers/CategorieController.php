<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategorieRequest;
use App\Categorie;
use App\User;
use Illuminate\Http\Request;
use DB;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:categorie-list|categorie-create|categorie-edit|categorie-delete', ['only' => ['index','store']]);
         $this->middleware('permission:categorie-create', ['only' => ['create','store']]);
         $this->middleware('permission:categorie-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:categorie-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model=Categorie::all();
        return view('categories.index', ['categories' => $model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategorieRequest $request, Categorie $model)
    {
        $model->create(($request->all()));
        return redirect()->route('categories.index')->withStatus(__('Categories successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categorie=Categorie::find($id);
        return view('categories.show',compact('categorie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categorie=Categorie::find($id);
        return view('categories.edit',compact('categorie'));
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
        DB::beginTransaction();
        $categorie=Categorie::find($id);
        $categorie->nom=$request->nom;
        $categorie->description=$request->description;
        $categorie->save();
        DB::commit();
        return redirect()->route('categories.index')->withStatus(__('Categorie successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("categories")->where('id',$id)->delete();
        return redirect()->route('categories.index')->withStatus(__('Categories successfully deleted.'));
    }
}
