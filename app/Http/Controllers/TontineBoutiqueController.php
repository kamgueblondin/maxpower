<?php

namespace App\Http\Controllers;
use App\Http\Requests\TontineBoutiqueRequest;
use App\Boutique;
use App\Magasin;
use App\BoutiqueStock;
use App\BoutiqueJour;
use App\EntreeMagasin;
use App\TontineBoutique;
use App\FactureBoutique;
use App\SortieBoutiqueMagasin;
use App\BoutiqueHistorique;
use App\MagasinHistorique;
use App\Produit;
use App\User;
use Illuminate\Http\Request;
use DB;

class TontineBoutiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:tontine-boutique-list|tontine-boutique-create|tontine-boutique-edit|tontine-boutique-delete', ['only' => ['index','store','tontinesBoutique']]);
         $this->middleware('permission:tontine-boutique-create', ['only' => ['create','store','tontinesBoutiqueCreated']]);
         $this->middleware('permission:tontine-boutique-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:tontine-boutique-delete', ['only' => ['destroy']]);
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
    public function store(TontineBoutiqueRequest $request)
    {
        DB::beginTransaction();
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$request->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$request->boutique_id;
        $historique->description="Création d'un versement vers une tontine.";
        $historique->entite="Tontine";
        $historique->save();
        $tontine=new TontineBoutique;
        $tontine->boutique_jour_id=$request->boutique_jour_id;
        $tontine->boutique_id=$request->boutique_id;
        $tontine->montant=$request->montant;
        $tontine->description=$request->description;
        $tontine->nom=$request->nom;
        $tontine->user_id=auth()->user()->getId();
        $tontine->save();
        DB::commit();
            
        return redirect()->route('jours.boutiques.tontines',$request->boutique_jour_id)->withStatus(__('Tontine successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tontine=TontineBoutique::find($id);
        return view('shops.shop.jours.tontines.show',compact('tontine'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tontine=TontineBoutique::find($id);
        return view('shops.shop.jours.tontines.edit',compact('tontine'));
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
        $tontine=TontineBoutique::find($id);
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$request->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$request->boutique_id;
        $historique->description="Modification du versement vers la tontine: ".$tontine->nom." de ". $tontine->montant." par ".$request->montant;
        $historique->entite="tontine";
        $historique->save();
        $tontine->montant=$request->montant;
        $tontine->nom=$request->nom;
        $tontine->description=$request->description;
        $tontine->save();
        DB::commit();
            
        return redirect()->route('jours.boutiques.tontines',$tontine->boutique_jour_id)->withStatus(__('Tontine successfully updated.'));
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
        $tontine=TontineBoutique::find($id);
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$tontine->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$tontine->boutique_id;
        $historique->description="Suppréssion du versement vers la tontine :".$tontine->nom." de ".$tontine->montant." fcfa";
        $historique->entite="Tontine";
        $historique->save();
        DB::table("tontine_boutiques")->where('id',$id)->delete();
        DB::commit();
        return redirect()->route('jours.boutiques.tontines',$tontine->boutique_jour_id)->withStatus(__('Tontine successfully deleted.'));
    }
    public function tontinesBoutique($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.jours.tontines.index',compact('jour','boutique'));
            }
        }
        return redirect()->route('home');
    }
    public function tontinesBoutiqueCreated($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.jours.tontines.create',compact('jour','boutique'));
            }
        }
        return redirect()->route('home');
    }
}
