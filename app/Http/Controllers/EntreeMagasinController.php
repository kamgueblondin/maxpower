<?php

namespace App\Http\Controllers;
use App\Http\Requests\EntreeMagasinRequest;
use App\Boutique;
use App\Magasin;
use App\MagasinStock;
use App\MagasinJour;
use App\EntreeMagasin;
use App\MagasinHistorique;
use App\Produit;
use App\User;
use Illuminate\Http\Request;
use DB;

class EntreeMagasinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:magasin-entree-list|magasin-entree-create|magasin-entree-edit|magasin-entree-delete', ['only' => ['index','store','entreesMagasin']]);
         $this->middleware('permission:magasin-entree-create', ['only' => ['create','store','entreesCreated']]);
         $this->middleware('permission:magasin-entree-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:magasin-entree-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(EntreeMagasinRequest $request)
    {
        if($request->stocks>0){
            DB::beginTransaction();
            $historique=new MagasinHistorique;
            $historique->magasin_jour_id=$request->magasin_jour_id;
            $historique->user_id=auth()->user()->getId();
            $historique->magasin_id=$request->magasin_id;
            $historique->description="Création des entrées.";
            $historique->entite="Entrée";
            $historique->save();
            foreach ($request->stocks as $key => $stock){
                if (empty($request->quantites[$key])) {
                    return redirect()->back()->withError(__('Une erreur est survenue!! Des données vides ont été soumis. veiller recommencer!!'));
                }
                $stock=MagasinStock::find($request->stocks[$key]);
                $stock->valeur+=$request->quantites[$key];
                $stock->initial=$stock->valeur;
                $stock->save();
                $entree=new EntreeMagasin;
                $entree->magasin_jour_id=$request->magasin_jour_id;
                $entree->magasin_id=$request->magasin_id;
                $entree->magasin_stock_id=$stock->id;
                $entree->quantite=$request->quantites[$key];
                $entree->user_id=auth()->user()->getId();
                $entree->save();
            }
            DB::commit();
        }
        return redirect()->route('days.entrees',$request->magasin_jour_id)->withStatus(__('Entrées successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entree=EntreeMagasin::find($id);
        return view('magasins.magasin.jours.entrees.show',compact('entree'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entree=EntreeMagasin::find($id);
        return view('magasins.magasin.jours.entrees.edit',compact('entree'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EntreeMagasinRequest $request, $id)
    {
        DB::beginTransaction();
        $entree=EntreeMagasin::find($id);
        $stock=$entree->stock;
        if($entree->quantite>$stock->valeur){
           return redirect()->route('days.entrees',$entree->magasin_jour_id)->withError(__('Cette Entée ne peut être modifier car des actions ont eu lieux sur le stock.')); 
        }
        $historique=new MagasinHistorique;
        $historique->magasin_jour_id=$entree->magasin_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->magasin_id=$entree->magasin_id;
        $historique->description="Modification de entrée du produit :".$stock->produit->nom." de ".$entree->quantite." par ".$request->quantites;
        $historique->entite="Entrée";
        $historique->save();
        $stock->valeur-=$entree->quantite;
        $stock->valeur+=$request->quantites;
        $stock->initial=$stock->valeur;
        $stock->save();
        $entree->quantite=$request->quantites;
        $entree->save();
        DB::commit();
        return redirect()->route('days.entrees',$entree->magasin_jour_id)->withStatus(__('Entée successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entree=EntreeMagasin::find($id);
        $stock=$entree->stock;
        if($entree->quantite>$stock->valeur){
           return redirect()->route('days.entrees',$entree->magasin_jour_id)->withStatus(__('Cette Entée ne peut être supprimer car des actions ont eu lieux sur le stock.')); 
        }
        $stock->valeur-=$entree->quantite;
        $stock->initial=$stock->valeur;
        $stock->save();
        $historique=new MagasinHistorique;
        $historique->magasin_jour_id=$entree->magasin_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->magasin_id=$entree->magasin_id;
        $historique->description="Suppréssion de l'entrée du produit :".$stock->produit->nom." de ".$entree->quantite;
        $historique->entite="Entrée";
        $historique->save();
        DB::table("entree_magasins")->where('id',$id)->delete();
        return redirect()->route('days.entrees',$entree->magasin_jour_id)->withStatus(__('Entée successfully deleted.'));
    }
    public function entreesMagasin($id){
        $jour=MagasinJour::find($id);
        $magasin=Magasin::find($jour->magasin_id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                return view('magasins.magasin.jours.entrees.index',compact('jour','magasin'));
            }
        }
        return redirect()->route('home');
    }
    public function entreesCreateMagasin($id){
        $jour=MagasinJour::find($id);
        $magasin=Magasin::find($jour->magasin_id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                return view('magasins.magasin.jours.entrees.create',compact('jour','magasin'));
            }
        }
        return redirect()->route('home');
    }
}
