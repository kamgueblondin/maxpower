<?php

namespace App\Http\Controllers;

use App\Http\Requests\MagasinRequest;
use App\Boutique;
use App\Magasin;
use App\MagasinStock;
use App\Produit;
use App\User;
use Illuminate\Http\Request;
use DB;

class MagasinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:magasin-list|magasin-create|magasin-edit|magasin-delete', ['only' => ['index','store']]);
         $this->middleware('permission:magasin-create', ['only' => ['create','store']]);
         $this->middleware('permission:magasin-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:magasin-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model=Magasin::all();
        return view('magasins.index', ['magasins' => $model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $shops = Boutique::all();
        $magasins = Magasin::all();
        return view('magasins.create',compact('shops','users','magasins'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MagasinRequest $request, Magasin $model)
    {
        DB::beginTransaction();
        $magasin=$model->create(($request->all()));
        $magasin->users()->attach($request->input('utilisateurs'));
        $magasin->boutiques()->attach($request->input('boutiques'));
        $magasin->magasins()->attach($request->input('magasins'));
        $produits=Produit::all();
        if ($produits->count()>0) {
            foreach ($produits as $p) {
              $stock=new MagasinStock;
              $stock->produit_id=$p->id;
              $stock->magasin_id=$magasin->id;
              $stock->initial=0;
              $stock->valeur=0;
              $stock->save();
            }
        }
        DB::commit();
        return redirect()->route('magasins.index')->withStatus(__('Magasin successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Magasin $magasin)
    {
        return view('magasins.show',compact('magasin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Magasin $magasin)
    {
        $users=User::all();
        $shops = Boutique::all();
        $magasins = Magasin::all();
        return view('magasins.edit',compact('magasin','users','shops','magasins'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MagasinRequest $request, $id)
    {
        DB::beginTransaction();
        $magasin=Magasin::find($id);
        $magasin->nom=$request->nom;
        $magasin->localisation=$request->localisation;
        $magasin->slogan=$request->slogan;
        $magasin->adresse=$request->adresse;
        $magasin->save();
        DB::table('user_magasins')->where('magasin_id',$magasin->id)->delete();
        DB::table('magasin_boutiques')->where('magasin_id',$magasin->id)->delete();
        DB::table('magasin_magasins')->where('magasin',$magasin->id)->delete();
        $magasin->users()->attach($request->input('utilisateurs'));
        $magasin->boutiques()->attach($request->input('boutiques'));
        $magasin->magasins()->attach($request->input('magasins'));
        DB::commit();
        return redirect()->route('magasins.index')->withStatus(__('Magasin successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("magasins")->where('id',$id)->delete();
        return redirect()->route('magasins.index')->withStatus(__('Magasin successfully deleted.'));
    }
    public function showUserMagasin($id){
        $magasin=Magasin::find($id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                return view('magasins.magasin.index',compact('magasin'));
            }
        }
        return redirect()->route('home');
    }
    public function stocksUserMagasin($id){
        $magasin=Magasin::find($id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                return view('magasins.magasin.stocks',compact('magasin'));
            }
        }
        return redirect()->route('home');
    }
    public function historiqueMagasin($id){
        $magasin=Magasin::find($id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                return view('magasins.magasin.historiques',compact('magasin'));
            }
        }
        return redirect()->route('home');
    }
    public function entreeMagasin($id){
        $magasin=Magasin::find($id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                return view('magasins.magasin.entrees',compact('magasin'));
            }
        }
        return redirect()->route('home');
    }
    public function sortieBoutiqueMagasin($id){
        $magasin=Magasin::find($id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                return view('magasins.magasin.sorties-boutiques',compact('magasin'));
            }
        }
        return redirect()->route('home');
    }
    public function sortieMagasinMagasin($id){
        $magasin=Magasin::find($id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                return view('magasins.magasin.sorties-magasins',compact('magasin'));
            }
        }
        return redirect()->route('home');
    }
    public function historiqueMagasinsPrints($id){
        $magasin=Magasin::find($id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
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

        $magasin=Magasin::find($id);
        
        $nbre_code = $magasin->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s)   ligne(s) d\'historique(s) dans le magasin '.$magasin->nom.' '.$magasin->localisation.'</h3>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
             <tr>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Numéro</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Action</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Auteur</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Description</th>
                 <th style="border: 1px solid; padding:5px; text-align: center;">Date</th>
              </tr>
            ';
        foreach($magasin->historiques as $key => $jour)
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

        $magasin=Magasin::find($id);
        
        $nbre_code = $magasin->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s) Entées dans le magasin '.$magasin->nom.' '.$magasin->localisation.'</h3>
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
        foreach($magasin->entrees as $key => $entre)
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
    public function stocksMagasinsPrints($id){
        $magasin=Magasin::find($id);
        $magasins=auth()->user()->magasins;
        foreach ($magasins as $m) {
            if($m->id==$magasin->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_stocksMagasinsPrints_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    function convert_stocksMagasinsPrints_data_to_html($id)
    {

        $magasin=Magasin::find($id);
        
        $nbre_code = $magasin->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Le stocks du magasin '.$magasin->nom.' '.$magasin->localisation.'</h3>
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
         foreach($magasin->stocks as $key => $stock)
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
    public function sortiesBoutiqueMagasinsPrints($id){
        $magasin=Magasin::find($id);
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

        $magasin=Magasin::find($id);
        
        $nbre_code = $magasin->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s)   sorties vers boutiques du '.$magasin->nom.' '.$magasin->localisation.'</h3>
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
        foreach($magasin->sortieBoutiques as $key => $sortie)
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
        $magasin=Magasin::find($id);
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

        $magasin=Magasin::find($id);
        
        $nbre_code = $magasin->count();
        $ordre = 1;
        $output ='
            <h3 align="center">Liste de(s)   sorties vers Magasins du magasin '.$magasin->nom.' '.$magasin->localisation.'</h3>
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
        foreach($magasin->sortieMagasins as $key => $sortie)
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
