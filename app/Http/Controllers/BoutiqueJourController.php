<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoutiqueJourRequest;
use App\Boutique;
use App\BoutiqueJour;
use App\BoutiqueHistorique;
use App\User;
use App\Produit;
use App\FactureBoutique;
use App\VenteBoutique;
use App\SortieBoutiqueMagasin;
use Illuminate\Http\Request;
use DB;

class BoutiqueJourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:boutique-jour-list|boutique-jour-create|boutique-jour-edit|boutique-jour-open|boutique-jour-close|boutique-jour-delete', ['only' => ['index','store']]);
         $this->middleware('permission:boutique-jour-create', ['only' => ['create','store','joursCeated']]);
         $this->middleware('permission:boutique-jour-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:boutique-jour-delete', ['only' => ['destroy']]);
         $this->middleware('permission:magasin-jour-open', ['only' => ['daysActiono']]);
         $this->middleware('permission:magasin-jour-close', ['only' => ['daysActionc']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BoutiqueJour $model)
    {
        return view('shops.shop.index', ['boutiques' => $model->paginate(10)]);
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
    public function store(BoutiqueJourRequest $request, BoutiqueJour $model)
    {
        DB::beginTransaction();
        $listes=BoutiqueJour::where('boutique_id','=',$request->boutique_id)->get();
        foreach ($listes as $key => $value) {
            $value->actif=false;
            $value->save();
        }
        $boutiqueJour=$model->create(($request->all()));
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$boutiqueJour->id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$boutiqueJour->boutique_id;
        $historique->description="Création de la journée ".$boutiqueJour->created_at;
        $historique->entite="Journée";
        $historique->save();
        DB::commit();
        return redirect()->route('users.shops',$boutiqueJour->boutique_id)->withStatus(__('Journée successfully created.'));
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
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$jour->id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$boutique->id;
        $historique->description="Visite de la journée ".$jour->created_at;
        $historique->entite="Journée";
        $historique->save();
        DB::commit();
        return view('shops.shop.jours.index',compact('jour','boutique'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        return view('shops.shop.jours.edit',compact('jour','boutique'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BoutiqueJourRequest $request, $id)
    {
        DB::beginTransaction();
        $jour=BoutiqueJour::find($id);
        $jour->description=$request->description;
        $jour->save();
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$jour->id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$jour->boutique_id;
        $historique->description="Modification de la journée ".$jour->created_at;
        $historique->entite="Journée";
        $historique->save();
        DB::commit();
        return redirect()->route('users.shops',$jour->boutique_id)->withStatus(__('Journée successfully updated.'));
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
        $jour=BoutiqueJour::find($id);
        DB::table("boutique_jours")->where('id',$id)->delete();
        $historique=new BoutiqueHistorique;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$jour->boutique_id;
        $historique->description="Suppréssion de la journée ".$jour->created_at;
        $historique->entite="Journée";
        $historique->save();
        DB::commit();
        return redirect()->route('users.shops',$jour->boutique_id)->withStatus(__('Journée successfully deleted.'));
    }
    public function joursCeated($id){
        $boutique=Boutique::find($id);
        return view('shops.shop.jours.create', ['boutique' => $boutique]);
    }
    public function daysActionc($id){
        $jour=BoutiqueJour::find($id);
        if($jour->actif==true){
            $jour->actif=false;
        }else{
            $jour->actif=true;
        }
         $jour->save();
        return redirect()->route('users.shops',$jour->boutique_id)->withStatus(__('Journée successfully'));
    }
    public function daysActiono($id){
        $jour=BoutiqueJour::find($id);
        if($jour->actif==true){
            $jour->actif=false;
        }else{
            $jour->actif=true;
        }
         $jour->save();
        return redirect()->route('users.shops',$jour->boutique_id)->withStatus(__('Journée successfully'));
    }
    public function venteShopsPrintsJours($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_venteShopsPrintsJours_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    function convert_venteShopsPrintsJours_data_to_html($id)
    {

        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $somme=0;
        $ventes=0;
        $nbre_code = $jour->ventes->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) ligne(s) de vente(s) dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at.'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Facture</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Produits</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Catégorie</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">P.A/th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Quantité</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Prix de vente</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Sous Total P.A</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Sous Total P.V</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Bénéfice</th>
              </tr>
            ';
        foreach($jour->ventes as $key => $sortie)
        {
            $somme+=$sortie->prix * $sortie->quantite;
            $ventes+=($sortie->prix * $sortie->quantite)-(((($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))))*$sortie->quantite);
            $benefice=($sortie->prix * $sortie->quantite)-(((($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))))*$sortie->quantite);
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->facture->nom.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->stock->produit->nom.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->stock->produit->categorie->nom .'</td>
              <td style="border: 1px solid; padding:5px;">'.(($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))).'  FCFA</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->quantite.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->prix.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.((($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))))*$sortie->quantite.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->prix * $sortie->quantite.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$benefice.' Fcfa</td>
              </tr>
              ';
        }
        $output .= '<tfoot><tr><td colspan="2">Montant total des ventes :</td><td colspan="3">'.$somme.' fcfa</td><th colspan="3">Montant total des bénéfices :</th><td colspan="2">'.$ventes.' Fcfa</td></tr></tfoot>
        </table>';
        return $output;
    }
    public function soldeShopsPrintsJours($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_soldeShopsPrintsJours_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    function convert_soldeShopsPrintsJours_data_to_html($id)
    {

        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $somme=0;
        $ventes=0;
        $nbre_code = $jour->ventes->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) ligne(s) de vente(s) solde dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at.'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Facture</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Produits</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Catégorie</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">P.A</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Quantité</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Prix de vente</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Sous Total P.A</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Sous Total P.V</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Bénéfice</th>
              </tr>
            ';
        foreach($jour->soldes as $key => $sortie)
        {
            $somme+=$sortie->prix * $sortie->quantite;
            $ventes+=($sortie->prix * $sortie->quantite)-(((($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))))*$sortie->quantite);
            $benefice=($sortie->prix * $sortie->quantite)-(((($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))))*$sortie->quantite);
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->facture->nom.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->stock->produit->nom.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->stock->produit->categorie->nom .'</td>
              <td style="border: 1px solid; padding:5px;">'.(($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))).'  FCFA</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->quantite.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->prix.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.((($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))))*$sortie->quantite.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->prix * $sortie->quantite.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$benefice.' Fcfa</td>
              </tr>
              ';
        }
        $output .= '<tfoot><tr><td colspan="2">Montant total des ventes :</td><td colspan="3">'.$somme.' fcfa</td><th colspan="3">Montant total des bénéfices :</th><td colspan="2">'.$ventes.' Fcfa</td></tr></tfoot>
        </table>';
        return $output;
    }
    public function sortiesShopsPrintsJours($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_sortiesShopsPrintsJours_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    function convert_sortiesShopsPrintsJours_data_to_html($id)
    {

        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        
        $nbre_code = $jour->sortieMagasins->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) ligne(s) de sortie(s) vers les magasin(s) dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at.'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Reference</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Produits</th>
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
              <td style="border: 1px solid; padding:5px;">'.$sortie->stock->produit->nom .'</td>
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
    public function chargesShopsPrintsJours($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_chargesShopsPrintsJours_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    function convert_chargesShopsPrintsJours_data_to_html($id)
    {

        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        
        $nbre_code = $jour->charges->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) charges dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at.'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Auteur</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Description</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Montant</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($jour->charges as $key => $charge)
        {
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$charge->user->name.'</td>
              <td style="border: 1px solid; padding:5px;">'.$charge->description .'</td>
              <td style="border: 1px solid; padding:5px;">'.$charge->montant.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$charge->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '</table>';
        return $output;
    }
    public function tontinesShopsPrintsJours($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_tontinesShopsPrintsJours_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    function convert_tontinesShopsPrintsJours_data_to_html($id)
    {

        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        
        $nbre_code = $jour->tontines->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) versements vers les tontines dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at.'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Auteur</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Tontine</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Description</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Montant</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($jour->tontines as $key => $tontine)
        {
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$tontine->user->name.'</td>
              <td style="border: 1px solid; padding:5px;">'.$tontine->nom .'</td>
              <td style="border: 1px solid; padding:5px;">'.$tontine->description.'</td>
              <td style="border: 1px solid; padding:5px;">'.$tontine->montant.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$tontine->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '</table>';
        return $output;
    }
    public function versementsShopsPrintsJours($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_versementsShopsPrintsJours_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    function convert_versementsShopsPrintsJours_data_to_html($id)
    {

        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        
        $nbre_code = $jour->versements->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) versements divers dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at.'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Auteur</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Destination du versement</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Description</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Montant</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($jour->versements as $key => $versement)
        {
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$versement->user->name.'</td>
              <td style="border: 1px solid; padding:5px;">'.$versement->destination .'</td>
              <td style="border: 1px solid; padding:5px;">'.$versement->description .'</td>
              <td style="border: 1px solid; padding:5px;">'.$versement->description .'</td>
              <td style="border: 1px solid; padding:5px;">'.$versement->montant.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$versement->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '</table>';
        return $output;
    }

    public function dettesShopsPrintsJours($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);;
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_dettesShopsPrintsJours_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    function convert_dettesShopsPrintsJours_data_to_html($id)
    {

        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        
        $nbre_code = $jour->dettes->count();
        $ordre = 1;
        $tota=0;
        $output ='
            <h3 align="center">Liste de(s) dettes dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at.'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Auteur</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Partenaire</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Description</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Montant</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Etat</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($jour->dettes as $key => $dette)
        {
             $tota+=$dette->montant;
             $message="";
            if( $tota < $dette->montant ){
                $message="incomplèt";
            }
            if( $tota > $dette->montant ){
                $message="soldé avec intérêt";
            }
            if( $tota == $dette->montant ){
                $message="soldé";
            }
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$dette->user->name.'</td>
              <td style="border: 1px solid; padding:5px;">'.$dette->partenaire .'</td>
              <td style="border: 1px solid; padding:5px;">'.$dette->description .'</td>
              <td style="border: 1px solid; padding:5px;">'.$dette->montant.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$message.'</td>
              <td style="border: 1px solid; padding:5px;">'.$dette->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '</table>';
        return $output;
    }
    ///////////////////////////////journal///////////////
    public function journalShopsPrintsJours($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);;
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_journalShopsPrintsJours_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    function convert_journalShopsPrintsJours_data_to_html($id)
    {

        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $output ='<!-- Blondin Kamgue -->
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta charset="utf-8"/>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <title></title>
        </head>
        <body>
        <br>
        <span><table align="center">
        <tr>
        <td rowspan="5">
            <img width="200" heigth="200" class="avatar" src="'.public_path() . '/images/logos/'.$boutique->logo.'">
        </td>
        <td>
            ETS: <span>'.$boutique->nom.'</span>
        </td>
        </tr>
        <tr>
        <td>
            Localisation: <span>'.$boutique->localisation.'</span>
        </td>
        </tr>
        <tr>
        <td>
            Adrèsse: <span>'.$boutique->adresse.'</span>
        </td>
        </tr>
        <tr>
        <td>
            Téléphones: <span>'.$boutique->telephone_1.'/'.$boutique->telephone_2.'</span>
        </td>
        </tr>
        <tr>
        <td>
            Slogan: <span>'.$boutique->slogan.'</span>
        </td>
        </tr>
        </table>
        </span>
        <center><font align="center" color="green" size="30px">Journée du <span>'.$jour->created_at->format('d/m/Y').'</span></font></center>
            ';
        $somme=0;
        $ventes=0;
        $nbre_code = $jour->ventes->count();
        $ordre = 1;
        $output .='
            <h3 align="center">Liste de(s) ligne(s) de vente(s) dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at->format('d/m/Y').'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Facture</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Produits</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Catégorie</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">P.A</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Quantité</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Prix de vente</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Sous Total P.A</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Sous Total P.V</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Bénéfice</th>
              </tr>
            ';
        foreach($jour->ventes as $key => $sortie)
        {
            $somme+=$sortie->prix * $sortie->quantite;
            $ventes+=($sortie->prix * $sortie->quantite)-(((($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))))*$sortie->quantite);
            $benefice=($sortie->prix * $sortie->quantite)-(((($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))))*$sortie->quantite);
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->facture->nom.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->stock->produit->nom.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->stock->produit->categorie->nom .'</td>
              <td style="border: 1px solid; padding:5px;">'.(($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))).'  FCFA</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->quantite.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->prix.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.((($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))))*$sortie->quantite.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->prix * $sortie->quantite.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$benefice.' Fcfa</td>
              </tr>
              ';
        }
        $output .= '<tfoot><tr><td colspan="2">Montant total des ventes :</td><td colspan="3">'.$somme.' fcfa</td><th colspan="3">Montant total des bénéfices :</th><td colspan="2">'.$ventes.' Fcfa</td></tr></tfoot>
        </table>';
        $totalVentes=$somme;
        $totalBenefice=$ventes;
        $somme=0;
        $ventes=0;
        $nbre_code = $jour->ventes->count();
        $ordre = 1;
        $output .='
            <h3 align="center">Liste de(s) ligne(s) de vente(s) solde dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at->format('d/m/Y').'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Facture</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Produits</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Catégorie</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">CMUP P.A</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Quantité</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Prix de vente</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Sous Total P.A</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Sous Total P.V</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Bénéfice</th>
              </tr>
            ';
        foreach($jour->soldes as $key => $sortie)
        {
            $somme+=$sortie->prix * $sortie->quantite;
            $ventes+=($sortie->prix * $sortie->quantite)-(((($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))))*$sortie->quantite);
            $benefice=($sortie->prix * $sortie->quantite)-(((($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))))*$sortie->quantite);
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->facture->nom.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->stock->produit->nom.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->stock->produit->categorie->nom .'</td>
              <td style="border: 1px solid; padding:5px;">'.(($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))).'  FCFA</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->quantite.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->prix.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.((($sortie->stock->produit->prix)-(($sortie->stock->produit->prix_achat))))*$sortie->quantite.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->prix * $sortie->quantite.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$benefice.' Fcfa</td>
              </tr>
              ';
        }
        $output .= '<tfoot><tr><td colspan="2">Montant total des ventes :</td><td colspan="3">'.$somme.' fcfa</td><th colspan="3">Montant total des bénéfices :</th><td colspan="2">'.$ventes.' Fcfa</td></tr></tfoot>
        </table>';
        $totalVentes+=$somme;
        $totalBenefice+=$ventes;
        $nbre_code = $jour->charges->count();
        $ordre = 1;
        $somme = 0;
        $output .='
            <h3 align="center">Liste de(s) charges dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at->format('d/m/Y').'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Auteur</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Description</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Montant</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($jour->charges as $key => $charge)
        {
            $somme+=$charge->montant;
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$charge->user->name.'</td>
              <td style="border: 1px solid; padding:5px;">'.$charge->description .'</td>
              <td style="border: 1px solid; padding:5px;">'.$charge->montant.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$charge->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '<tfoot><tr><td colspan="2">Montant total des charges :</td><td colspan="3">'.$somme.' fcfa</td></tr></tfoot></table>';
        $totalCharge=$somme;
        $tl=$totalVentes-$totalCharge;
        $bt=$totalBenefice-$totalCharge;
        $output .='
            <h3 align="center">Jounal de caisse dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at->format('d/m/Y').'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
              <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Total Charges</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Total Ventes</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Total Ventes-charges</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Total Bénéfices</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Total Bénéfices-charges</th>
              </tr>
              <tr>
                  <td style="border: 1px solid; padding:5px;">'. $totalCharge .' Fcfa</td>
                  <td style="border: 1px solid; padding:5px;">'.$totalVentes.' Fcfa</td>
                  <td style="border: 1px solid; padding:5px;">'.$tl.' Fcfa</td>
                  <td style="border: 1px solid; padding:5px;">'.$totalBenefice.' Fcfa</td>
                  <td style="border: 1px solid; padding:5px;">'.$bt.' Fcfa</td>
              </tr>
            </table>
            ';
    $nbre_code = $jour->tontines->count();
        $ordre = 1;
        $output .='
            <h3 align="center">Liste de(s) versements vers les tontines dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at->format('d/m/Y').'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Auteur</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Tontine</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Description</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Montant</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($jour->tontines as $key => $tontine)
        {
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$tontine->user->name.'</td>
              <td style="border: 1px solid; padding:5px;">'.$tontine->nom .'</td>
              <td style="border: 1px solid; padding:5px;">'.$tontine->description.'</td>
              <td style="border: 1px solid; padding:5px;">'.$tontine->montant.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$tontine->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '</table>';
        $nbre_code = $jour->versements->count();
        $ordre = 1;
        $output .='
            <h3 align="center">Liste de(s) versements divers dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <h5 align="center">Journée: '.$jour->created_at->format('d/m/Y').'</h5>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Auteur</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Destination du versement</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Description</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Montant</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($jour->versements as $key => $versement)
        {
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$versement->user->name.'</td>
              <td style="border: 1px solid; padding:5px;">'.$versement->destination .'</td>
              <td style="border: 1px solid; padding:5px;">'.$versement->description .'</td>
              <td style="border: 1px solid; padding:5px;">'.$versement->description .'</td>
              <td style="border: 1px solid; padding:5px;">'.$versement->montant.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$versement->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '</table>';
        return $output;
    }

}
