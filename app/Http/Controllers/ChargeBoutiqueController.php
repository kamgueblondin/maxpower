<?php

namespace App\Http\Controllers;
use App\Http\Requests\ChargeBoutiqueRequest;
use App\Boutique;
use App\Magasin;
use App\BoutiqueStock;
use App\BoutiqueJour;
use App\EntreeMagasin;
use App\ChargeBoutique;
use App\FactureBoutique;
use App\SortieBoutiqueMagasin;
use App\BoutiqueHistorique;
use App\MagasinHistorique;
use App\Produit;
use App\User;
use Illuminate\Http\Request;
use DB;

class ChargeBoutiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:charge-boutique-list|charge-boutique-create|charge-boutique-edit|charge-boutique-delete', ['only' => ['index','store','chargesBoutique']]);
         $this->middleware('permission:charge-boutique-create', ['only' => ['create','store','chargesBoutiqueCreated']]);
         $this->middleware('permission:charge-boutique-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:charge-boutique-delete', ['only' => ['destroy']]);
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
    public function store(ChargeBoutiqueRequest $request)
    {
        DB::beginTransaction();
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$request->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$request->boutique_id;
        $historique->description="Création des charges.";
        $historique->entite="Charge";
        $historique->save();
        $charge=new ChargeBoutique;
        $charge->boutique_jour_id=$request->boutique_jour_id;
        $charge->boutique_id=$request->boutique_id;
        $charge->montant=$request->montant;
        $charge->description=$request->description;
        $charge->user_id=auth()->user()->getId();
        $charge->save();
        DB::commit();
            
        return redirect()->route('jours.boutiques.charges',$request->boutique_jour_id)->withStatus(__('Charge successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $charge=ChargeBoutique::find($id);
        return view('shops.shop.jours.charges.show',compact('charge'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $charge=ChargeBoutique::find($id);
        return view('shops.shop.jours.charges.edit',compact('charge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChargeBoutiqueRequest $request, $id)
    {
        DB::beginTransaction();
        $charge=ChargeBoutique::find($id);
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$request->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$request->boutique_id;
        $historique->description="Modification de la charge :".$charge->description." de ". $charge->montant." par ".$request->montant;
        $historique->entite="Charge";
        $historique->save();
        $charge->montant=$request->montant;
        $charge->description=$request->description;
        $charge->save();
        DB::commit();
            
        return redirect()->route('jours.boutiques.charges',$charge->boutique_jour_id)->withStatus(__('Charge successfully updated.'));
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
        $charge=ChargeBoutique::find($id);
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$charge->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$charge->boutique_id;
        $historique->description="Suppréssion de la charge :".$charge->description." de ".$charge->montant." fcfa";
        $historique->entite="Charge";
        $historique->save();
        DB::table("charge_boutiques")->where('id',$id)->delete();
        DB::commit();
        return redirect()->route('jours.boutiques.charges',$charge->boutique_jour_id)->withStatus(__('Charge successfully deleted.'));
    }
    public function chargesBoutique($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.jours.charges.index',compact('jour','boutique'));
            }
        }
        return redirect()->route('home');
    }
    public function chargesBoutiqueCreated($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.jours.charges.create',compact('jour','boutique'));
            }
        }
        return redirect()->route('home');
    }
}
