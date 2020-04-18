<?php

namespace App\Http\Controllers;
use App\Http\Requests\SortieMagasinMagasinRequest;
use App\Boutique;
use App\Magasin;
use App\MagasinStock;
use App\MagasinJour;
use App\EntreeMagasin;
use App\SortieMagasinMagasin;
use App\MagasinHistorique;
use App\Produit;
use App\User;
use Illuminate\Http\Request;
use DB;

class SortieMagasinMagasinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:magasin-magasin-sortie-list|magasin-magasin-sortie-create|magasin-magasin-sortie-edit|magasin-magasin-sortie-delete', ['only' => ['index','store','sortiesMagasinMagasin']]);
         $this->middleware('permission:magasin-magasin-sortie-create', ['only' => ['create','store','sortiesMagasinMagasinCreated']]);
         $this->middleware('permission:magasin-magasin-sortie-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:magasin-magasin-sortie-delete', ['only' => ['destroy']]);
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
    public function store(SortieMagasinMagasinRequest $request)
    {
        DB::beginTransaction();
        if($request->stocks>0){
            $historique=new MagasinHistorique;
            $historique->magasin_jour_id=$request->magasin_jour_id;
            $historique->user_id=auth()->user()->getId();
            $historique->magasin_id=$request->magasin_id;
            $historique->description="Création des sorties vers magasin.";
            $historique->entite="Sortie";
            $historique->save();
            $autherMagasin=Magasin::find($request->magasin);
            foreach ($request->stocks as $key => $stock){
                if (empty($request->quantites[$key])) {
                    return redirect()->back()->withError(__('Une erreur est survenue!! Des données vides ont été soumis. veiller recommencer!!'));
                }
                $stock=MagasinStock::find($request->stocks[$key]);
                if($stock->valeur>=$request->quantites[$key]){
                    $stock->valeur-=$request->quantites[$key];
                    $stock->save();
                    /*foreach ($autherMagasin->stocks as $autherStock){
                        if($autherStock->produit->id===$stock->produit->id){
                            $autherStock->valeur+=$request->quantites[$key];
                            $autherStock->initial=$autherStock->valeur;
                            $autherStock->save();
                        }
                    }*/
                    $sortie=new SortieMagasinMagasin;
                    $sortie->magasin_jour_id=$request->magasin_jour_id;
                    $sortie->magasin=$request->magasin;
                    $sortie->magasin_id=$request->magasin_id;
                    $sortie->magasin_stock_id=$stock->id;
                    $sortie->quantite=$request->quantites[$key];
                    $sortie->user_id=auth()->user()->getId();
                    $sortie->save();
                }else{
                  return redirect()->back()->withError(__('Une erreur est survenue!! une ou plusieurs quantités supérieurs au stock normale ont/à été soumis. veiller recommencer!!'));
                }
            }
            /*
            $historique=new MagasinHistorique;
            $historique->user_id=auth()->user()->getId();
            $historique->magasin_id=$autherMagasin->id;
            $historique->description="Création des entrées venant du magasin ".Magasin::find($request->magasin_id)->nom." ".Magasin::find($request->magasin_id)->localisation;
            $historique->entite="Entees";
            $historique->save();*/
        }

        DB::commit();
        return redirect()->route('days.magasins.magasins.sorties',$request->magasin_jour_id)->withStatus(__('Sorties successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sortie=SortieMagasinMagasin::find($id);
        return view('magasins.magasin.jours.sorties-magasins.show',compact('sortie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sortie=SortieMagasinMagasin::find($id);
        return view('magasins.magasin.jours.sorties-magasins.edit',compact('sortie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SortieMagasinMagasinRequest $request, $id)
    {
        DB::beginTransaction();
        $sortie=SortieMagasinMagasin::find($id);
        $stock=$sortie->stock;
        if($sortie->stock->valeur-$request->quantites<0){
           return redirect()->route('days.magasins.magasins.sorties',$sortie->magasin_jour_id)->withError(__('Cette sortie ne peut être modifier car des actions ont eu lieux sur le stock.')); 
        }
        $autherMagasin=Magasin::find($request->magasin);
        /*foreach ($autherMagasin->stocks as $autherStock){
            if($autherStock->produit->id===$stock->produit->id){
                if($autherStock->valeur-$request->quantites<0){
                   return redirect()->route('days.magasins.magasins.sorties',$sortie->magasin_jour_id)->withStatus(__('Cette sortie ne peut être modifier car des actions ont eu lieux sur le stock.')); 
                }
                $autherStock->valeur-=$sortie->quantite;
                $autherStock->valeur+=$request->quantites;
                $autherStock->initial=$autherStock->valeur;
                $autherStock->save();
            }
        }*/
        $historique=new MagasinHistorique;
        $historique->magasin_jour_id=$sortie->magasin_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->magasin_id=$sortie->magasin_id;
        $historique->description="Modification de la sortie du produit :".$stock->produit->nom." de ".$sortie->quantite." par ".$request->quantites;
        $historique->entite="Sortie";
        $historique->save();
        $stock->valeur+=$sortie->quantite;
        $stock->save();
        $stock->valeur-=$request->quantites;
        //$stock->initial=$stock->valeur;
        $stock->save();
        $sortie->quantite=$request->quantites;
        $sortie->save();
        DB::commit();
        return redirect()->route('days.magasins.magasins.sorties',$sortie->magasin_jour_id)->withStatus(__('Sortie successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $sortie=SortieMagasinMagasin::find($id);
        $stock=$sortie->stock;
        /*foreach ($sortie->autherMagasin->stocks as $autherStock){
            if($autherStock->produit->id===$stock->produit->id){
                if($autherStock->valeur-$sortie->quantite<0){
                   return redirect()->route('days.magasins.magasins.sorties',$sortie->magasin_jour_id)->withStatus(__('Cette sortie ne peut être supprimer car des actions ont eu lieux sur le stock.')); 
                }
                $autherStock->valeur-=$sortie->quantite;
                $autherStock->initial=$autherStock->valeur;
                $autherStock->save();
            }
        }*/
        $stock->valeur+=$sortie->quantite;
        $stock->initial=$stock->valeur;
        $stock->save();
        $historique=new MagasinHistorique;
        $historique->magasin_jour_id=$sortie->magasin_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->magasin_id=$sortie->magasin_id;
        $historique->description="Suppréssion de la sortie du produit :".$stock->produit->nom." de ".$sortie->quantite;
        $historique->entite="Sortie";
        $historique->save();
        DB::table("sortie_magasin_magasins")->where('id',$id)->delete();
        DB::commit();
        return redirect()->route('days.magasins.magasins.sorties',$sortie->magasin_jour_id)->withStatus(__('sortie successfully deleted.'));
    }
    public function sortiesMagasinMagasin($id){
        $jour=MagasinJour::find($id);
        $magasin=Magasin::find($jour->magasin_id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                return view('magasins.magasin.jours.sorties-magasins.index',compact('jour','magasin'));
            }
        }
        return redirect()->route('home');
    }
    public function sortiesMagasinMagasinCreated($id){
        $jour=MagasinJour::find($id);
        $magasin=Magasin::find($jour->magasin_id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                return view('magasins.magasin.jours.sorties-magasins.create',compact('jour','magasin'));
            }
        }
        return redirect()->route('home');
    }
}
