<?php

namespace App\Http\Controllers;
use App\Http\Requests\MagasinJourRequest;
use App\Boutique;
use App\Magasin;
use App\MagasinStock;
use App\MagasinJour;
use App\MagasinHistorique;
use App\Produit;
use App\User;
use Illuminate\Http\Request;
use DB;

class MagasinJourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:magasin-jour-list|magasin-jour-create|magasin-jour-edit|magasin-jour-open|magasin-jour-close|magasin-jour-delete', ['only' => ['index','store']]);
         $this->middleware('permission:magasin-jour-create', ['only' => ['create','store']]);
         $this->middleware('permission:magasin-jour-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:magasin-jour-delete', ['only' => ['destroy']]);
         $this->middleware('permission:magasin-jour-open', ['only' => ['daysActiono']]);
         $this->middleware('permission:magasin-jour-close', ['only' => ['daysActionc']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MagasinJour $model)
    {
        return view('magasins.magasin.index', ['magasins' => $model]);
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
    public function store(MagasinJourRequest  $request, MagasinJour $model)
    {
        DB::beginTransaction();
        $listes=MagasinJour::where('magasin_id','=',$request->magasin_id)->get();
        foreach ($listes as $key => $value) {
            $value->actif=false;
            $value->save();
        }
        $magasinJour=$model->create(($request->all()));
        $historique=new MagasinHistorique;
        $historique->magasin_jour_id=$magasinJour->id;
        $historique->user_id=auth()->user()->getId();
        $historique->magasin_id=$magasinJour->magasin_id;
        $historique->description="Création de la journée ".$magasinJour->created_at;
        $historique->entite="Journée";
        $historique->save();
        DB::commit();
        return redirect()->route('users.magasins',$magasinJour->magasin_id)->withStatus(__('Journée successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        DB::beginTransaction();
        $jour=MagasinJour::find($id);
        $magasin=Magasin::find($jour->magasin_id);
        $historique=new MagasinHistorique;
        $historique->magasin_jour_id=$jour->id;
        $historique->user_id=auth()->user()->getId();
        $historique->magasin_id=$magasin->id;
        $historique->description="Visite de la journée ".$jour->created_at;
        $historique->entite="Journée";
        $historique->save();
        DB::commit();
        return view('magasins.magasin.jours.index',compact('jour','magasin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jour=MagasinJour::find($id);
        $magasin=Magasin::find($jour->magasin_id);
        return view('magasins.magasin.jours.edit',compact('jour','magasin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MagasinJourRequest $request, $id)
    {
        DB::beginTransaction();
        $jour=MagasinJour::find($id);
        $jour->description=$request->description;
        $jour->save();
        $historique=new MagasinHistorique;
        $historique->magasin_jour_id=$jour->id;
        $historique->user_id=auth()->user()->getId();
        $historique->magasin_id=$jour->magasin_id;
        $historique->description="Modification de la journée ".$jour->created_at;
        $historique->entite="Journée";
        $historique->save();
        DB::commit();
        return redirect()->route('users.magasins',$jour->magasin_id)->withStatus(__('Journée successfully updated.'));
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
        $jour=MagasinJour::find($id);
        DB::table("magasin_jours")->where('id',$id)->delete();
        $historique=new MagasinHistorique;
        $historique->user_id=auth()->user()->getId();
        $historique->magasin_id=$jour->magasin_id;
        $historique->description="Suppréssion de la journée ".$jour->created_at;
        $historique->entite="Journée";
        $historique->save();
        DB::commit();
        return redirect()->route('users.magasins',$jour->magasin_id)->withStatus(__('Journée successfully deleted.'));
    }
    public function daysCeated($id){
        $magasin=Magasin::find($id);
        return view('magasins.magasin.jours.create', ['magasin' => $magasin]);
    }
    public function daysActiono($id){
        $jour=MagasinJour::find($id);
        if($jour->actif==true){
            $jour->actif=false;
        }else{
            $jour->actif=true;
        }
         $jour->save();
        return redirect()->route('users.magasins',$jour->magasin_id)->withStatus(__('Journée successfully'));
    }
    public function daysActionc($id){
        $jour=MagasinJour::find($id);
        if($jour->actif==true){
            $jour->actif=false;
        }else{
            $jour->actif=true;
        }
         $jour->save();
        return redirect()->route('users.magasins',$jour->magasin_id)->withStatus(__('Journée successfully'));
    }

    public function entreesMagasinsPrints($id){
        $magasin=Magasin::find($id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_entreesMagasinsPrints_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    function convert_entreesMagasinsPrints_data_to_html($id)
    {
        $jour=MagasinJour::find($id);
        $magasin=Magasin::find($jour->magasin_id);
        
        $nbre_code = $magasin->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) Entées dans le magasin '.$magasin->nom.' '.$magasin->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at.'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Reference</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Produit</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Catégorie</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Quantité</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($jour->entrees as $key => $entre)
        {
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$entre->stock->produit->reference.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$entre->stock->produit->nom.'</td>
              <td style="border: 1px solid; padding:5px;">'.$entre->stock->produit->categorie->nom.'</td>
               <td style="border: 1px solid; padding:5px;">'.$entre->quantite.'</td>
              <td style="border: 1px solid; padding:5px;">'.$entre->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '</table>';
        return $output;
    }

    public function sortiesBoutiqueMagasinsPrints($id){
        $jour=MagasinJour::find($id);
        $magasin=Magasin::find($jour->magasin_id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_sortiesBoutiqueMagasinsPrints_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    function convert_sortiesBoutiqueMagasinsPrints_data_to_html($id)
    {

        $jour=MagasinJour::find($id);
        $magasin=Magasin::find($jour->magasin_id);
        
        $nbre_code = $magasin->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s)   sorties vers boutiques du '.$magasin->nom.' '.$magasin->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at.'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Reference</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Produit</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Catégorie</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Quantité</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Boutique destination</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($jour->sortieBoutiques as $key => $sortie)
        {
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->stock->produit->reference.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->stock->produit->nom.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->stock->produit->categorie->nom.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->quantite.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->autherBoutique->nom.' '.$sortie->autherBoutique->localisation.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '</table>';
        return $output;
    }
    public function sortiesMagasinMagasinsPrints($id){
        $jour=MagasinJour::find($id);
        $magasin=Magasin::find($jour->magasin_id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_sortiesMagasinMagasinsPrints_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    function convert_sortiesMagasinMagasinsPrints_data_to_html($id)
    {

        $jour=MagasinJour::find($id);
        $magasin=Magasin::find($jour->magasin_id);
        
        $nbre_code = $magasin->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s)   sorties vers Magasins du magasin '.$magasin->nom.' '.$magasin->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at.'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Reference</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Produit</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Catégorie</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Quantité</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Magasin destination</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($jour->sortieMagasins as $key => $sortie)
        {
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->stock->produit->reference.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->stock->produit->nom.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->stock->produit->categorie->nom.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->quantite.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->autherMagasin->nom.' '.$sortie->autherMagasin->localisation.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '</table>';
        return $output;
    }
}
