<?php

namespace App\Http\Controllers;
use App\Http\Requests\DetteBoutiqueRequest;
use App\Boutique;
use App\Magasin;
use App\BoutiqueStock;
use App\BoutiqueJour;
use App\EntreeMagasin;
use App\DetteBoutique;
use App\FactureBoutique;
use App\SortieBoutiqueMagasin;
use App\BoutiqueHistorique;
use App\MagasinHistorique;
use App\Produit;
use App\User;
use App\VersementDette;
use App\Http\Requests\VersementDetteRequest;
use Illuminate\Http\Request;
use DB;

class DetteBoutiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:dette-boutique-list|dette-boutique-create|dette-boutique-edit|dette-boutique-delete', ['only' => ['index','store','dettesBoutique']]);
         $this->middleware('permission:dette-boutique-create', ['only' => ['create','store','dettesBoutiqueCreated']]);
         $this->middleware('permission:dette-boutique-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:dette-boutique-delete', ['only' => ['destroy']]);
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
    public function store(DetteBoutiqueRequest $request)
    {
        DB::beginTransaction();
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$request->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$request->boutique_id;
        $historique->description="Création d'une dette. du partenaire :".$request->partenaire." Montant: ".$request->montant;
        $historique->entite="Dêtte";
        $historique->save();
        $dette=new DetteBoutique;
        $dette->boutique_jour_id=$request->boutique_jour_id;
        $dette->boutique_id=$request->boutique_id;
        $dette->montant=$request->montant;
        $dette->description=$request->description;
        $dette->partenaire=$request->partenaire;
        $dette->user_id=auth()->user()->getId();
        $dette->save();
        DB::commit();    
        return redirect()->route('jours.boutiques.dettes',$request->boutique_jour_id)->withStatus(__('Dette successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dette=DetteBoutique::find($id);
        return view('shops.shop.jours.dettes.versement',compact('dette'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dette=DetteBoutique::find($id);
        return view('shops.shop.jours.dettes.edit',compact('dette'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DetteBoutiqueRequest $request, $id)
    {
        DB::beginTransaction();
        $dette=DetteBoutique::find($id);
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$request->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$request->boutique_id;
        $historique->description="Modification du versement vers la dette du partenaire: ".$dette->partenaire." de ". $dette->montant." par ".$request->montant;
        $historique->entite="Dette";
        $historique->save();
        $dette->montant=$request->montant;
        $dette->partenaire=$request->partenaire;
        $dette->description=$request->description;
        $dette->save();
        DB::commit();
            
        return redirect()->route('jours.boutiques.dettes',$dette->boutique_jour_id)->withStatus(__('dette successfully updated.'));
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
        $dette=DetteBoutique::find($id);
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$dette->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$dette->boutique_id;
        $historique->description="Suppréssion de la dette du partenaire :".$dette->partenaire." de ".$dette->montant." fcfa";
        $historique->entite="Dette";
        $historique->save();
        DB::table("dette_boutiques")->where('id',$id)->delete();
        DB::commit();
        return redirect()->route('jours.boutiques.dettes',$dette->boutique_jour_id)->withStatus(__('dette successfully deleted.'));
    }

    public function versementStore(VersementDetteRequest $request){
        $tota=0;
        $dette=DetteBoutique::find($request->dette_boutique_id);
        foreach($dette->versements as $va)
        {
            $tota+=$va->montant;
        }
        if( $tota+$request->montant > $dette->montant ){
            return redirect()->back()->withError(__('Désoler vous avez entré un montant suppérieure au montant de la dette.'));
        }
        DB::beginTransaction();
        $versement=new VersementDette;
        $versement->dette_boutique_id=$request->dette_boutique_id;
        $versement->montant=$request->montant;
        $versement->description=$request->description;
        $versement->user_id=auth()->user()->getId();
        $versement->save();
        DB::commit();
        return redirect()->back()->withStatus(__('versement dette successfully created.'));

    }

    public function dettesBoutique($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.jours.dettes.index',compact('jour','boutique'));
            }
        }
        return redirect()->route('home');
    }
    public function dettesBoutiqueCreated($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.jours.dettes.create',compact('jour','boutique'));
            }
        }
        return redirect()->route('home');
    }
    public function dettesVersementDestroy($id)
    {
        DB::beginTransaction();
        DB::table("versement_dettes")->where('id',$id)->delete();
        DB::commit();
        return redirect()->back()->withStatus(__('Versement successfully deleted.'));
    }
}
