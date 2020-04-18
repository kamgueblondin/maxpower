<?php

namespace App\Http\Controllers;
use App\Http\Requests\VenteBoutiqueRequest;
use App\Boutique;
use App\Magasin;
use App\BoutiqueStock;
use App\BoutiqueJour;
use App\EntreeMagasin;
use App\VenteBoutique;
use App\FactureBoutique;
use App\SortieBoutiqueMagasin;
use App\BoutiqueHistorique;
use App\MagasinHistorique;
use App\Produit;
use App\User;
use Illuminate\Http\Request;
use DB;

class VenteBoutiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:vente-boutique-list|vente-boutique-create|vente-boutique-edit|vente-boutique-delete', ['only' => ['index','store','ventesBoutique']]);
         $this->middleware('permission:vente-boutique-create', ['only' => ['create','store','ventesBoutiqueCreated']]);
         $this->middleware('permission:vente-boutique-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:vente-boutique-delete', ['only' => ['destroy']]);
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
    public function store(VenteBoutiqueRequest $request)
    {
        DB::beginTransaction();
        if($request->stocks>0){
            $boutique=Boutique::find($request->boutique_id);
            $historique=new BoutiqueHistorique;
            $historique->boutique_jour_id=$request->boutique_jour_id;
            $historique->user_id=auth()->user()->getId();
            $historique->boutique_id=$request->boutique_id;
            $historique->description="Création des ventes.";
            $historique->entite="Vente";
            $historique->save();
            $facture=new FactureBoutique;
            $facture->nom="Facture";
            $facture->boutique_id=$request->boutique_id;
            $facture->client=$request->client;
            $facture->description="bla bla";
            $facture->numero=$boutique->factures->count()+1;
            $facture->save();
            $montant=0;
            foreach ($request->stocks as $key => $stock){
               if (empty($request->quantites[$key])) {
                    return redirect()->back()->withError(__('Une erreur est survenue!! Des données vides ont été soumis. veiller recommencer!!'));
                }
                $stock=BoutiqueStock::find($request->stocks[$key]);
                if($stock->valeur>=$request->quantites[$key]){
                    $stock->valeur-=$request->quantites[$key];
                    $stock->save();
                    $sortie=new VenteBoutique;
                    $sortie->boutique_jour_id=$request->boutique_jour_id;
                    $sortie->boutique_id=$request->boutique_id;
                    $sortie->facture_boutique_id=$facture->id;
                    if ($stock->produit->prix>$request->pvs[$key]) {
                      return redirect()->back()->withError(__('Une erreur est survenue!! un ou plusieurs montants inférieurs à la normale ont/à été soumis. veiller recommencer!!'));
                    }else{
                      $sortie->prix=$request->pvs[$key];
                    }
                    $sortie->boutique_stock_id=$stock->id;
                    $sortie->quantite=$request->quantites[$key];
                    $sortie->user_id=auth()->user()->getId();
                    $sortie->save();
                    if ($stock->produit->prix>$request->pvs[$key]) {
                      $montant+=$request->quantites[$key]*$stock->produit->prix;
                    }else{
                      $montant+=$request->quantites[$key]*$request->pvs[$key];
                    }
                }else{
                  return redirect()->back()->withError(__('Une erreur est survenue!! une ou plusieurs quantités supérieurs au stock normale ont/à été soumis. veiller recommencer!!'));
                }
            }
            $facture->nom = str_pad($facture->numero, 9, '0', STR_PAD_LEFT);
            $facture->description=" Somme totale: ".$montant." FCFA, en lettre :".$this->asLetters($montant);
            $facture->save();
        }
        DB::commit();
        return redirect()->route('jours.boutiques.ventes',$request->boutique_jour_id)->withStatus(__('Ventes successfully created.'))->withFacture($facture);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sortie=VenteBoutique::find($id);
        return view('shops.shop.jours.ventes.show',compact('sortie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sortie=VenteBoutique::find($id);
        return view('shops.shop.jours.ventes.edit',compact('sortie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VenteBoutiqueRequest $request, $id)
    {
        DB::beginTransaction();
        $sortie=VenteBoutique::find($id);
        $stock=$sortie->stock;
        if($stock->valeur-$request->quantites<0){
           return redirect()->route('jours.boutiques.ventes',$sortie->boutique_jour_id)->withError(__('Cette Ventes ne peut être modifier car des actions ont eu lieux sur le stock.')); 
        }
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$sortie->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$sortie->boutique_id;
        $historique->description="Modification de la vente du produit :".$stock->produit->nom." de ".$sortie->quantite." par ".$request->quantites;
        $historique->entite="Vente";
        $historique->save();
        $stock->valeur+=$sortie->quantite;
        $stock->save();
        $stock->valeur-=$request->quantites;
        //$stock->initial=$stock->valeur;
        $stock->save();
        $sortie->quantite=$request->quantites;
        $sortie->prix=$request->pvs;
        $sortie->save();
        DB::commit();
        return redirect()->route('jours.boutiques.ventes',$sortie->boutique_jour_id)->withStatus(__('Vente successfully updated.'));
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
        $sortie=VenteBoutique::find($id);
        $stock=$sortie->stock;
        $stock->valeur+=$sortie->quantite;
        //$stock->initial=$stock->valeur;
        $stock->save();
        $historique=new BoutiqueHistorique;
        $historique->boutique_jour_id=$sortie->boutique_jour_id;
        $historique->user_id=auth()->user()->getId();
        $historique->boutique_id=$sortie->boutique_id;
        $historique->description="Suppréssion de la vente du produit :".$stock->produit->nom." de ".$sortie->quantite;
        $historique->entite="Vente";
        $historique->save();
        DB::table("vente_boutiques")->where('id',$id)->delete();
        DB::commit();
        return redirect()->route('jours.boutiques.ventes',$sortie->boutique_jour_id)->withStatus(__('Vente successfully deleted.'));
    }

    public function ventesBoutique($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.jours.ventes.index',compact('jour','boutique'));
            }
        }
        return redirect()->route('home');
    }
    public function ventesBoutiqueCreated($id){
        $jour=BoutiqueJour::find($id);
        $boutique=Boutique::find($jour->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                return view('shops.shop.jours.ventes.create',compact('jour','boutique'));
            }
        }
        return redirect()->route('home');
    }

    function asLetters($number,$separateur=",") {
        $convert = explode($separateur, $number);
        $num[17] = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit',
                         'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize');
                          
        $num[100] = array(20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
                          60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingt', 90 => 'quatre-vingt-dix');
                                          
        if (isset($convert[1]) && $convert[1] != '') {
          return $this->asLetters($convert[0]).' et '.$this->asLetters($convert[1]);
        }
        if ($number < 0) return 'moins '.$this->asLetters(-$number);
        if ($number < 17) {
          return $num[17][$number];
        }
        elseif ($number < 20) {
          return 'dix-'.$this->asLetters($number-10);
        }
        elseif ($number < 100) {
          if ($number%10 == 0) {
            return $num[100][$number];
          }
          elseif (substr($number, -1) == 1) {
            if( ((int)($number/10)*10)<70 ){
              return $this->asLetters((int)($number/10)*10).'-et-un';
            }
            elseif ($number == 71) {
              return 'soixante-et-onze';
            }
            elseif ($number == 81) {
              return 'quatre-vingt-un';
            }
            elseif ($number == 91) {
              return 'quatre-vingt-onze';
            }
          }
          elseif ($number < 70) {
            return $this->asLetters($number-$number%10).'-'.$this->asLetters($number%10);
          }
          elseif ($number < 80) {
            return $this->asLetters(60).'-'.$this->asLetters($number%20);
          }
          else {
            return $this->asLetters(80).'-'.$this->asLetters($number%20);
          }
        }
        elseif ($number == 100) {
          return 'cent';
        }
        elseif ($number < 200) {
          return $this->asLetters(100).' '.$this->asLetters($number%100);
        }
        elseif ($number < 1000) {
          return $this->asLetters((int)($number/100)).' '.$this->asLetters(100).($number%100 > 0 ? ' '.$this->asLetters($number%100): '');
        }
        elseif ($number == 1000){
          return 'mille';
        }
        elseif ($number < 2000) {
          return $this->asLetters(1000).' '.$this->asLetters($number%1000).' ';
        }
        elseif ($number < 1000000) {
          return $this->asLetters((int)($number/1000)).' '.$this->asLetters(1000).($number%1000 > 0 ? ' '.$this->asLetters($number%1000): '');
        }
        elseif ($number == 1000000) {
          return 'millions';
        }
        elseif ($number < 2000000) {
          return $this->asLetters(1000000).' '.$this->asLetters($number%1000000);
        }
        elseif ($number < 1000000000) {
          return $this->asLetters((int)($number/1000000)).' '.$this->asLetters(1000000).($number%1000000 > 0 ? ' '.$this->asLetters($number%1000000): '');
        }
    }
    public function printFactures($id){
        $facture=FactureBoutique::find($id);
        $vente=VenteBoutique::where("facture_boutique_id","=",$facture->id)->first();
        $boutique=Boutique::find($vente->boutique_id);
        $boutiques=auth()->user()->boutiques;
        foreach ($boutiques as $b) {
            if($b->id==$boutique->id){
                    $pdf = \App::make('dompdf.wrapper');
        
                    $pdf->loadHTML($this->convert_printFactures_data_to_html($id));
                   
                    return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }
    /**
     * @return string
     */
    function convert_printFactures_data_to_html($id)
    {
        $facture=FactureBoutique::find($id);
        $vente=VenteBoutique::where("facture_boutique_id","=",$facture->id)->first();
        $boutique=Boutique::find($vente->boutique_id);
        $somme=0;
        foreach ($facture->ventes as $key => $value) {
            $somme+=$value->quantite*$value->prix;
        }
        $ordre = 1;
        $output ='<!-- Blondin Kamgue -->
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta charset="utf-8"/>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <title></title>
        </head>
        <body>
        <br>
        <center><table>
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
        </center>
        <center><font align="center" color="green" size="30px">Facture n° <span>'.$facture->nom.'</span></font></center>
        <table class="table" width="100%" style="border-collapse: collapse; border: 0px;">
            <thead>
            <tr>
                <th>#</th>
                <th>Articles</th>
                <th>Quantités</th>
                <th>P.U</th>
                <th>Sous Totaux</th>
            </tr>
            </thead>
            <tbody>
            ';
        foreach($facture->ventes as $key => $vente)
        {
            $output .= '
             <tr>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$ordre++.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$vente->stock->produit->nom.'</td>
              <td style="border: 1px solid; padding:5px; text-align: center;">'.$vente->quantite.'</td>
              <td style="border: 1px solid; padding:5px;">'.$vente->prix .' Fcfa</td>
              <td style="border: 1px solid; padding:5px;">'.$vente->prix * $vente->quantite.' Fcfa</td>
              </tr>
              ';
        }
        $output .= '</tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2" style="text-align:center"><h3>Nom du client : </h3></td>
                        <td colspan="3">'.$facture->client.'</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center"><h3>Net à payer : </h3></td>
                        <td colspan="3"><h3><span>'.$somme.'</span> Fcfa</h3></td>
                    </tr>
                    <tr>
                    <td colspan="2">Date <span>'.$facture->created_at->format('d/m/Y H:i').'</span></td>
                        <td colspan="3" style="text-align:center">
                            <center>
                                <div  style="background-color:silver;border-color:gold;border-width:1px;border-style:solid">&nbsp;<span>'.$this->asLetters($somme).'</span> FCFA</div>
                            </center>
                        </td>
                    </tr>
                    </tfoot>
                </table>
                </body>
                </html>';
        return $output;
    }

}
