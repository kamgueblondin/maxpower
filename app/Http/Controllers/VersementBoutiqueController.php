<?php

namespace App\Http\Controllers;
use App\Http\Requests\VersementBoutiqueRequest;
use App\Boutique;
use App\Magasin;
use App\BoutiqueStock;
use App\BoutiqueJour;
use App\EntreeMagasin;
use App\VersementBoutique;
use App\FactureBoutique;
use App\SortieBoutiqueMagasin;
use App\BoutiqueHistorique;
use App\MagasinHistorique;
use App\Produit;
use App\User;
use Illuminate\Http\Request;
use DB;

class VersementBoutiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:versement-boutique-list|versement-boutique-create|versement-boutique-edit|versement-boutique-delete', ['only' => ['index','store','versementsBoutique']]);
         $this->middleware('permission:versement-boutique-create', ['only' => ['create','store','versementsBoutiqueCreated']]);
         $this->middleware('permission:versement-boutique-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:versement-boutique-delete', ['only' => ['destroy']]);
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
    public function store(Request $request)
    {
        DB::beginTransaction();
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$request->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$request->boutique_id;
        $historique->description="Création d'un versement vers ".$request->destination;
        $historique->entite="Versement";
        $historique->save();
        $tontine=new VersementBoutique;
        $tontine->boutique_jour_id=$request->boutique_jour_id;
        $tontine->boutique_id=$request->boutique_id;
        $tontine->montant=$request->montant;
        $tontine->description=$request->description;
        $tontine->destination=$request->destination;
        $tontine->user_id=auth()->user()->getId();
        $tontine->save();
        DB::commit();

        return redirect()->route('jours.boutiques.versements',$request->boutique_jour_id)->withStatus(__('Versement successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $versement=VersementBoutique::find($id);
        return view('shops.shop.jours.versements.show',compact('versement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $versement=VersementBoutique::find($id);
        return view('shops.shop.jours.versements.edit',compact('versement'));
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
        $versement=VersementBoutique::find($id);
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$request->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$request->boutique_id;
        $historique->description="Modification du versement vers: ".$versement->destination." de ". $versement->montant." par ".$request->montant;
        $historique->entite="versement";
        $historique->save();
        $versement->montant=$request->montant;
        $versement->destination=$request->destination;
        $versement->description=$request->description;
        $versement->save();
        DB::commit();
            
        return redirect()->route('jours.boutiques.versements',$versement->boutique_jour_id)->withStatus(__('Versement successfully updated.'));
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
        $versement=VersementBoutique::find($id);
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$versement->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$versement->boutique_id;
        $historique->description="Suppréssion du versement :".$versement->destination." de ".$versement->montant." fcfa";
        $historique->entite="Versement";
        $historique->save();
        DB::table("versement_boutiques")->where('id',$id)->delete();
        DB::commit();
        return redirect()->route('jours.boutiques.versements',$versement->boutique_jour_id)->withStatus(__('Tontine successfully deleted.'));
    }
    public function versementsBoutique($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.jours.versements.index',compact('jour','boutique'));
            }
        }
        return redirect()->route('home');
    }
    public function versementsBoutiqueCreated($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.jours.versements.create',compact('jour','boutique'));
            }
        }
        return redirect()->route('home');
    }
}
