<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProduitRequest;
use App\Categorie;
use App\Produit;
use App\Boutique;
use App\Magasin;
use App\MagasinStock;
use App\BoutiqueStock;
use App\User;
use Illuminate\Http\Request;
use DB;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:produit-list|produit-create|produit-edit|produit-delete', ['only' => ['index','store']]);
         $this->middleware('permission:produit-create', ['only' => ['create','store']]);
         $this->middleware('permission:produit-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:produit-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model=Produit::all();
        return view('produits.index', ['produits' => $model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categorie::all();
        return view('produits.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProduitRequest $request, Produit $model)
    {
        DB::beginTransaction();
        $produit=$model->create(($request->all()));
        $boutiques=Boutique::all();
        $magasins=Magasin::all();
        if($boutiques->count()>0){
            foreach ($boutiques as $b) {
                $bstock=new BoutiqueStock;
                $bstock->produit_id=$produit->id;
                $bstock->boutique_id=$b->id;
                $bstock->initial=0;
                $bstock->valeur=0;
                $bstock->save();
            }
        }
        if($magasins->count()>0){
            foreach ($magasins as $m) {
                $mstock=new MagasinStock;
                $mstock->produit_id=$produit->id;
                $mstock->magasin_id=$m->id;
                $mstock->initial=0;
                $mstock->valeur=0;
                $mstock->save();
            }
        }
        DB::commit();
        return redirect()->route('produits.index')->withStatus(__('Produits successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produit=Produit::find($id);
        return view('produits.show',compact('produit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produit=Produit::find($id);
        $categories=Categorie::all();
        return view('produits.edit',compact('categories','produit'));
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
        $produit=Produit::find($id);
        $produit->reference=$request->reference;
        $produit->nom=$request->nom;
        $produit->description=$request->description;
        $produit->prix_achat=$request->prix_achat;
        $produit->prix=$request->prix;
        $produit->categorie_id=$request->categorie_id;
        $produit->save();
        DB::commit();
        return redirect()->route('produits.index')->withStatus(__('Produit successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("produits")->where('id',$id)->delete();
        return redirect()->route('produits.index')->withStatus(__('Produit successfully deleted.'));
    }
}
