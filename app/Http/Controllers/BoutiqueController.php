<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Http\Requests\InventaireRequest;
use App\BoutiqueHistorique;
use App\Boutique;
use App\BoutiqueStock;
use App\User;
use App\Produit;
use Illuminate\Http\Request;
use DB;

class BoutiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:boutique-list|boutique-create|boutique-edit|boutique-delete', ['only' => ['index','store']]);
         $this->middleware('permission:boutique-create', ['only' => ['create','store']]);
         $this->middleware('permission:boutique-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:boutique-delete', ['only' => ['destroy']]);
         $this->middleware('permission:boutique-inventaire-list', ['only' => ['inventaireViewShops','avantInventaireUserShops','apresInventaireUserShops']]);
         $this->middleware('permission:boutique-comptabilite', ['only' => ['inventaireShops','inventaireUserShops']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model=Boutique::all();
        return view('shops.index', ['shops'=>$model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $boutiques = Boutique::all();
        $users = User::all();
        return view('shops.create',compact('users','boutiques'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopRequest $request, Boutique $model)
    {
        DB::beginTransaction();
        $path = 'logos';
        $nomFichier = uploadImage($request->logo, $path);
        $boutique=$model->create(($request->all()));
        $boutique->logo=$nomFichier;
        $boutique->save();
        $boutique->users()->attach($request->input('utilisateurs'));
        $boutique->boutiques()->attach($request->input('boutiques'));
        $produits=Produit::all();
        if ($produits->count()>0) {
            foreach ($produits as $p) {
              $stock=new BoutiqueStock;
              $stock->produit_id=$p->id;
              $stock->boutique_id=$boutique->id;
              $stock->initial=0;
              $stock->valeur=0;
              $stock->save();
            }
        }
        DB::commit();
        return redirect()->route('shops.index')->withStatus(__('Shop successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Boutique  $boutique
     * @return \Illuminate\Http\Response
     */
    public function show(Boutique $shop)
    {
        return view('shops.show',compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Boutique  $boutique
     * @return \Illuminate\Http\Response
     */
    public function edit(Boutique $shop)
    {
        $boutiques = Boutique::all();
        $users=User::all();
        return view('shops.edit',compact('shop','users','boutiques'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Boutique  $boutique
     * @return \Illuminate\Http\Response
     */
    public function update(ShopRequest $request, $id)
    {
        DB::beginTransaction();
        $boutique=Boutique::find($id);
        $boutique->nom=$request->nom;
        $boutique->localisation=$request->localisation;
        $boutique->slogan=$request->slogan;
        $boutique->adresse=$request->adresse;
        $boutique->telephone_1=$request->telephone_1;
        $boutique->telephone_2=$request->telephone_2;
        $boutique->email=$request->email;
        $boutique->numero_rc=$request->numero_rc;
        $boutique->save();
        DB::table('user_boutiques')->where('boutique_id',$boutique->id)->delete();
        DB::table('boutique_boutiques')->where('boutique',$boutique->id)->delete();
        $boutique->users()->attach($request->input('utilisateurs'));
        $boutique->boutiques()->attach($request->input('boutiques'));
        DB::commit();
        return redirect()->route('shops.index')->withStatus(__('Shop successfully updated.'));
    }
    public function updateLogo(Request $request, $id)
    {
        DB::beginTransaction();
        $path = 'logos';
        $nomFichier = uploadImage($request->logo, $path);
        $boutique=Boutique::find($id);
        $boutique->logo=$nomFichier;
        $boutique->save();
        DB::commit();
        return redirect()->route('shops.index')->withStatus(__('Logo successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Boutique  $boutique
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("boutiques")->where('id',$id)->delete();
        return redirect()->route('shops.index')->withStatus(__('Shop successfully deleted.'));
    }
    public function showUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.index',compact('boutique'));
            }
        }
        return redirect()->route('home');
    }
    public function stocksUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.stocks',compact('boutique'));
            }
        }
        return redirect()->route('home');
    }

    public function inventaireViewShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.inventaire-view',compact('boutique'));
            }
        }
        return redirect()->route('home');
    }

    public function ventesUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.ventes',compact('boutique'));
            }
        }
        return redirect()->route('home');
    }

    public function soldesUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.soldes',compact('boutique'));
            }
        }
        return redirect()->route('home');
    }

    public function sortiesUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.sorties',compact('boutique'));
            }
        }
        return redirect()->route('home');
    }

    public function chargesUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.charges',compact('boutique'));
            }
        }
        return redirect()->route('home');
    }

    public function tontinesUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.tontines',compact('boutique'));
            }
        }
        return redirect()->route('home');
    }

    public function inventaireUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.inventaire',compact('boutique'));
            }
        }
        return redirect()->route('home');
    }

    public function versementsUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.versements',compact('boutique'));
            }
        }
        return redirect()->route('home');
    }

    public function dettesUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.dettes',compact('boutique'));
            }
        }
        return redirect()->route('home');
    }

    public function historiquesUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.historiques',compact('boutique'));
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    public function historiqueShopsPrintsJours($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_historiqueShopsPrintsJours_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    
    /**
     * @return string
     */
    function convert_historiqueShopsPrintsJours_data_to_html($id)
    {

        $boutique=Boutique::find($id);
        
        $nbre_code = $boutique->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s)   ligne(s) d\'historique(s) dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Action</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Auteur</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Description</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($boutique->historiques as $key => $jour)
        {
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$jour->entite.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$jour->user->name.'</td>
              <td style="border: 1px solid; padding:5px;">'.$jour->description.'</td>
              <td style="border: 1px solid; padding:5px;">'.$jour->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '</table>';
        return $output;
    }

    /**
     * @return string
     */
    public function venteShopsPrintsJours($id){
        $boutique=Boutique::find($id);
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

        $boutique=Boutique::find($id);
        
        $nbre_code = $boutique->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) ligne(s) de vente(s) dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Facture</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Produits</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Catégorie</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Quantité</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Prix de vente</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Sous total</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($boutique->ventes as $key => $sortie)
        {
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->facture->nom.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->stock->produit->nom.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->stock->produit->categorie->nom .'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->quantite.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->prix.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->prix * $sortie->quantite.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '</table>';
        return $output;
    }
    //
    /**
     * @return string
     */
    public function soldeShopsPrintsJours($id){
        $boutique=Boutique::find($id);
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

        $boutique=Boutique::find($id);
        
        $nbre_code = $boutique->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) ligne(s) de vente(s) en solde dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Facture</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Produits</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Catégorie</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Quantité</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Prix de vente</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Sous total</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($boutique->soldes as $key => $sortie)
        {
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->facture->nom.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$sortie->stock->produit->nom.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->stock->produit->categorie->nom .'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->quantite.'</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->prix.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->prix * $sortie->quantite.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$sortie->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '</table>';
        return $output;
    }
    public function sortiesShopsPrintsJours($id){
        $boutique=Boutique::find($id);
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

        $boutique=Boutique::find($id);
        
        $nbre_code = $boutique->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) ligne(s) de sortie(s) vers les magasin(s) dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
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
        foreach($boutique->sortieMagasins as $key => $sortie)
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
        $boutique=Boutique::find($id);
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

        $boutique=Boutique::find($id);
        
        $nbre_code = $boutique->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) charges dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Auteur</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Description</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Montant</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($boutique->charges as $key => $charge)
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
        $boutique=Boutique::find($id);
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

        $boutique=Boutique::find($id);
        
        $nbre_code = $boutique->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) versements vers les tontines dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
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
        foreach($boutique->tontines as $key => $tontine)
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
        $boutique=Boutique::find($id);
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

        $boutique=Boutique::find($id);
        
        $nbre_code = $boutique->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) versements divers dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
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
        foreach($boutique->versements as $key => $versement)
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
        $boutique=Boutique::find($id);
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

        $boutique=Boutique::find($id);
        
        $nbre_code = $boutique->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) dettes dans la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Auteur</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Partenaire</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Description</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Montant</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($boutique->dettes as $key => $dette)
        {
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$dette->user->name.'</td>
              <td style="border: 1px solid; padding:5px;">'.$dette->partenaire .'</td>
              <td style="border: 1px solid; padding:5px;">'.$dette->description .'</td>
              <td style="border: 1px solid; padding:5px;">'.$dette->montant.' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$dette->created_at->format('d/m/Y H:i').'</td>
              </tr>
              ';
        }
        $output .= '</table>';
        return $output;
    }
    //salavation
    public function stocksShopsPrintsJours($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_stocksShopsPrintsJours_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string 
     */
    function convert_stocksShopsPrintsJours_data_to_html($id)
    {

        $boutique=Boutique::find($id);
        
        $nbre_code = $boutique->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Le stocks de la  boutique '.$boutique->nom.' '.$boutique->localisation.'</h3>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Référence</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Nom</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Catégorie</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Stocks initial</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Stocks réel</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Prix</th>
              </tr>
            ';
        foreach($boutique->stocks as $key => $stock)
        {
            if ($stock->valeur>(20*$stock->initial)/100) {
            $output .= '
              <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$stock->produit->reference.'</td>
              <td style="border: 1px solid; padding:5px;">'.$stock->produit->nom .'</td>
              <td style="border: 1px solid; padding:5px;">'.$stock->produit->categorie->nom.'</td>
              <td style="border: 1px solid; padding:5px;">'.$stock->initial.'</td>
              <td style="border: 1px solid; padding:5px;">'.$stock->valeur.'</td>
              <td style="border: 1px solid; padding:5px;">'.$stock->produit->prix.'  Fcfa</td>
              </tr>
              ';
        }else{
             $output .= '
              <tr style="color:red;">
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$stock->produit->reference.'</td>
              <td style="border: 1px solid; padding:5px;">'.$stock->produit->nom .'</td>
              <td style="border: 1px solid; padding:5px;">'.$stock->produit->categorie->nom.'</td>
              <td style="border: 1px solid; padding:5px;">'.$stock->initial.'</td>
              <td style="border: 1px solid; padding:5px;">'.$stock->valeur.'</td>
              <td style="border: 1px solid; padding:5px;">'.$stock->produit->prix.'  Fcfa</td>
              </tr>
              ';
        }}
        $output .= '</table>';
        return $output;
    }

    public function avantInventaireUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
            DB::beginTransaction();
            $historique=new BoutiqueHistorique;
            $historique->user_id=auth()->user()->getId();
            $historique->boutique_id=$id;
            $historique->description="Stocks en machine avant comptage et Stocks trouvés après comptage à zéro";
            $historique->entite="Inventaire";
            $historique->save();
            foreach ($boutique->stocks as $stock){
                $stock->avant_inventaire=null;
                $stock->apres_inventaire=null;
                $stock->save();
            }
            DB::commit();
            return redirect()->route('view.inventaire.shops',$id)->withStatus(__('Reseted Successfully.'));
            }
        }
        return redirect()->route('home');
    }
	
	
	public function inventaireShops(InventaireRequest $request){
        $boutique=Boutique::find($request->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                if($request->stocks>0){
            DB::beginTransaction();
            $historique=new BoutiqueHistorique;
            $historique->user_id=auth()->user()->getId();
            $historique->boutique_id=$request->boutique_id;
            $historique->description="Inventaire";
            $historique->entite="Inventaire";
            $historique->save();
            foreach ($request->stocks as $key => $stock){
                $stock=BoutiqueStock::find($request->stocks[$key]);
                $stock->avant_inventaire=$stock->valeur;
                $stock->apres_inventaire=$request->quantites[$key];
                $stock->valeur=$request->quantites[$key];
                //$stock->initial=$stock->valeur;
                $stock->save();
            }
            DB::commit();
        }
        return redirect()->route('view.inventaire.shops',$request->boutique_id)->withStatus(__('Inventaires successfully created.'));
            }
        }
        return redirect()->route('home');
    }

    public function apresInventaireUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
            DB::beginTransaction();
            $historique=new BoutiqueHistorique;
            $historique->user_id=auth()->user()->getId();
            $historique->boutique_id=$id;
            $historique->description="Adapter les stocks réels en fonction des Stocks trouvés après comptage saisies en réduisant à zéro";
            $historique->entite="Inventaire";
            $historique->save();
            foreach ($boutique->stocks as $stock){
                if($stock->apres_inventaire==null || $stock->apres_inventaire==0){
                    $stock->avant_inventaire=$stock->valeur;
                    $stock->apres_inventaire=0;
                    $stock->valeur=0;
                    $stock->save();
                }
            }
            DB::commit();
            return redirect()->route('view.inventaire.shops',$id)->withStatus(__('Adapter Successfully.'));
            }
        }
        return redirect()->route('home');
    }
	
	public function inventaireUserShops($id){
        $boutique=Boutique::find($id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.inventaire',compact('boutique'));
            }
        }
        return redirect()->route('home');
    }
}
