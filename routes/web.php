<?php
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\BoutiqueJourController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ChargeBoutiqueController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DetteBoutiqueController;
use App\Http\Controllers\EntreeMagasinController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MagasinController;
use App\Http\Controllers\MagasinJourController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SoldeBoutiqueController;
use App\Http\Controllers\SortieBoutiqueMagasinController;
use App\Http\Controllers\SortieMagasinBoutiqueController;
use App\Http\Controllers\SortieMagasinMagasinController;
use App\Http\Controllers\TontineBoutiqueController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenteBoutiqueController;
use App\Http\Controllers\VersementBoutiqueController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', UserController::class);
    Route::put('user/{user}/password', [UserController::class, 'updatePassword'])->name('users.update.pass');
	Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::resource('roles', RoleController::class);
    Route::resource('shops', BoutiqueController::class);
    Route::patch('slogo/{id}', [BoutiqueController::class, 'updateLogo'])->name('shop.update.logo');
    Route::post('shops/inventaires', [BoutiqueController::class, 'inventaireShops'])->name('shops.inventaire');
    Route::get('shops/{id}/show/', [BoutiqueController::class, 'showUserShops'])->name('users.shops');
    Route::get('shops/{id}/stocks/', [BoutiqueController::class, 'stocksUserShops'])->name('stocks.shops');
    Route::get('shops/{id}/inventaires/', [BoutiqueController::class, 'inventaireUserShops'])->name('inventaire.shops');
    Route::get('shops/{id}/ventes/', [BoutiqueController::class, 'ventesUserShops'])->name('ventes.shops');
    Route::get('shops/{id}/soldes/', [BoutiqueController::class, 'soldesUserShops'])->name('soldes.shops');
    Route::get('shops/{id}/sorties-magasin/', [BoutiqueController::class, 'sortiesUserShops'])->name('sorties.shops');
    Route::get('shops/{id}/charges/', [BoutiqueController::class, 'chargesUserShops'])->name('charges.shops');
    Route::get('shops/{id}/tontines/', [BoutiqueController::class, 'tontinesUserShops'])->name('tontines.shops');
    Route::get('shops/{id}/versements/', [BoutiqueController::class, 'versementsUserShops'])->name('versements.shops');
    Route::get('shops/{id}/dettes/', [BoutiqueController::class, 'dettesUserShops'])->name('dettes.shops');
    Route::get('shops/{id}/historiques/', [BoutiqueController::class, 'historiquesUserShops'])->name('historiques.shops');
    //print shop
    Route::get('shops/print/{id}/historiques', [BoutiqueController::class, 'historiqueShopsPrintsJours'])->name('historiques.shops.print.jours');
    Route::get('shops/print/{id}/ventes', [BoutiqueController::class, 'venteShopsPrintsJours'])->name('ventes.shops.print.jours');
    Route::get('shops/print/{id}/soldes', [BoutiqueController::class, 'soldeShopsPrintsJours'])->name('soldes.shops.print.jours');
    Route::get('shops/print/{id}/sorties', [BoutiqueController::class, 'sortiesShopsPrintsJours'])->name('sorties.shops.print.jours');
    Route::get('shops/print/{id}/charges', [BoutiqueController::class, 'chargesShopsPrintsJours'])->name('charges.shops.print.jours');
    Route::get('shops/print/{id}/tontines', [BoutiqueController::class, 'tontinesShopsPrintsJours'])->name('tontines.shops.print.jours');
    Route::get('shops/print/{id}/versements', [BoutiqueController::class, 'versementsShopsPrintsJours'])->name('versements.shops.print.jours');
    Route::get('shops/print/{id}/dettes', [BoutiqueController::class, 'dettesShopsPrintsJours'])->name('dettes.shops.print.jours');
    Route::get('shops/print/{id}/stocks', [BoutiqueController::class, 'stocksShopsPrintsJours'])->name('stocks.shops.print.jours');


    //boutique impréssions
    Route::get('shops/print/{id}/ventes/jours', [BoutiqueJourController::class, 'venteShopsPrintsJours'])->name('ventes.shops.print');
    Route::get('shops/print/{id}/soldes/jours', [BoutiqueJourController::class, 'soldeShopsPrintsJours'])->name('soldes.shops.print');
    Route::get('shops/print/{id}/sorties/jours', [BoutiqueJourController::class, 'sortiesShopsPrintsJours'])->name('sorties.shops.print');
    Route::get('shops/print/{id}/charges/jours', [BoutiqueJourController::class, 'chargesShopsPrintsJours'])->name('charges.shops.print');
    Route::get('shops/print/{id}/journal/jours', [BoutiqueJourController::class, 'journalShopsPrintsJours'])->name('journal.shops.print');
    Route::get('shops/print/{id}/tontines/jours', [BoutiqueJourController::class, 'tontinesShopsPrintsJours'])->name('tontines.shops.print');
    Route::get('shops/print/{id}/versements/jours', [BoutiqueJourController::class, 'versementsShopsPrintsJours'])->name('versements.shops.print');
    Route::get('shops/print/{id}/dettes/jours', [BoutiqueJourController::class, 'dettesShopsPrintsJours'])->name('dettes.shops.print');
    //magasin impréssions
    Route::get('magasins/print/{id}/historiques', [MagasinController::class, 'historiqueMagasinsPrints'])->name('historiques.magasins.print');
    Route::get('magasins/print/{id}/entrees', [MagasinController::class, 'entreesMagasinsPrints'])->name('entres.magasins.print');
    Route::get('magasins/print/{id}/stocks', [MagasinController::class, 'stocksMagasinsPrints'])->name('stocks.magasins.print');
    Route::get('magasins/print/{id}/sorties/boutique', [MagasinController::class, 'sortiesBoutiqueMagasinsPrints'])->name('sorties.boutique.magasins.print');
    Route::get('magasins/print/{id}/sorties/magasin', [MagasinController::class, 'sortiesMagasinMagasinsPrints'])->name('sorties.magasin.magasins.print');
    //getion jounaliere
    Route::get('magasins/print/{id}/entrees/jour', [MagasinJourController::class, 'entreesMagasinsPrints'])->name('entres.magasins.print.jour');
    Route::get('magasins/print/{id}/sorties/boutique/jour', [MagasinJourController::class, 'sortiesBoutiqueMagasinsPrints'])->name('sorties.boutique.magasins.print.jour');
    Route::get('magasins/print/{id}/sorties/magasin/jour', [MagasinJourController::class, 'sortiesMagasinMagasinsPrints'])->name('sorties.magasin.magasins.print.jour');


    Route::resource('magasins', MagasinController::class);
    Route::get('magasins/{id}/show/', [MagasinController::class, 'showUserMagasin'])->name('users.magasins');
    Route::get('magasins/{id}/stocks/', [MagasinController::class, 'stocksUserMagasin'])->name('stocks.magasins');
    Route::get('magasins/{id}/inventaires/', [MagasinController::class, 'inventaireUserMagasin'])->name('inventaire.magasins');
    Route::get('magasins/{id}/historiques/', [MagasinController::class, 'historiqueMagasin'])->name('historiques.magasins');
    Route::get('magasins/{id}/entrees/', [MagasinController::class, 'entreeMagasin'])->name('entrees.magasins');
    Route::get('magasins/{id}/sorties-boutiques/', [MagasinController::class, 'sortieBoutiqueMagasin'])->name('sortie-boutique.magasins');
    Route::get('magasins/{id}/sorties-magasins/', [MagasinController::class, 'sortieMagasinMagasin'])->name('sortie-magasin.magasins');
    Route::post('magasins/inventaires', [MagasinController::class, 'inventaireMagasins'])->name('magasins.inventaire');
    Route::resource('categories', CategorieController::class);
    Route::resource('produits', ProduitController::class);
    Route::resource('days', MagasinJourController::class);
    Route::resource('enters', EntreeMagasinController::class);
    Route::resource('magasins-sorties', SortieMagasinMagasinController::class);
    Route::resource('boutiques-sorties', SortieMagasinBoutiqueController::class);
    Route::get('/days/{id}/actions', [MagasinJourController::class, 'daysActionc'])->name('days.actionc');
    Route::get('/days/{id}/action', [MagasinJourController::class, 'daysActiono'])->name('days.actiono');
    Route::get('/days/{id}/create', [MagasinJourController::class, 'daysCeated'])->name('days.ceated');
    Route::get('/days/{id}/entrees', [EntreeMagasinController::class, 'entreesMagasin'])->name('days.entrees');
    Route::get('/days/{id}/magasins/sorties', [SortieMagasinMagasinController::class, 'sortiesMagasinMagasin'])->name('days.magasins.magasins.sorties');
    Route::get('/days/{id}/boutiques/sorties', [SortieMagasinBoutiqueController::class, 'sortiesMagasinBoutique'])->name('days.magasins.boutiques.sorties');
    Route::get('/days/{id}/magasins/sorties/create', [SortieMagasinMagasinController::class, 'sortiesMagasinMagasinCreated'])->name('days.magasins.magasins.sorties.create');
    Route::get('/days/{id}/boutiques/sorties/create', [SortieMagasinBoutiqueController::class, 'sortiesMagasinBoutiqueCreated'])->name('days.magasins.boutiques.sorties.create');
    Route::get('/days/{id}/entrees/create', [EntreeMagasinController::class, 'entreesCreateMagasin'])->name('days.entrees.create');

    Route::resource('jours', BoutiqueJourController::class);
    Route::get('/jours/{id}/create', [BoutiqueJourController::class, 'joursCeated'])->name('jours.ceated');
    Route::get('/jours/{id}/actions', [BoutiqueJourController::class, 'daysActiono'])->name('jours.actiono');
    Route::get('/jours/{id}/action', [BoutiqueJourController::class, 'daysActionc'])->name('jours.actionc');
    Route::get('/jours/{id}/magasins/sorties', [SortieBoutiqueMagasinController::class, 'sortiesBoutiqueMagasin'])->name('jours.boutiques.magasins.sorties');
    Route::get('/jours/{id}/magasins/sorties/create', [SortieBoutiqueMagasinController::class, 'sortiesBoutiqueMagasinCreated'])->name('jours.boutiques.magasins.sorties.create');
    Route::resource('boutique-magasins-sorties', SortieBoutiqueMagasinController::class);

    //ventes
    Route::get('/jours/{id}/boutiques/ventes', [VenteBoutiqueController::class, 'ventesBoutique'])->name('jours.boutiques.ventes');
    Route::get('/jours/{id}/boutiques/ventes/create', [VenteBoutiqueController::class, 'ventesBoutiqueCreated'])->name('jours.boutiques.ventes.create');
    Route::get('/jours/{id}/boutiques/ventes/create', [VenteBoutiqueController::class, 'ventesBoutiqueCreated'])->name('jours.boutiques.ventes.create');
    Route::resource('boutique-ventes', VenteBoutiqueController::class);
    //soldes
    Route::get('/jours/{id}/boutiques/soldes', [SoldeBoutiqueController::class, 'soldesBoutique'])->name('jours.boutiques.soldes');
    Route::get('/jours/{id}/boutiques/soldes/create', [SoldeBoutiqueController::class, 'soldesBoutiqueCreated'])->name('jours.boutiques.soldes.create');
    Route::get('/jours/{id}/boutiques/soldes/create', [SoldeBoutiqueController::class, 'soldesBoutiqueCreated'])->name('jours.boutiques.soldes.create');
    Route::resource('boutique-soldes', SoldeBoutiqueController::class);
    //charges
    Route::get('/jours/{id}/boutiques/charges', [ChargeBoutiqueController::class, 'chargesBoutique'])->name('jours.boutiques.charges');
    Route::get('/jours/{id}/boutiques/charges/create', [ChargeBoutiqueController::class, 'chargesBoutiqueCreated'])->name('jours.boutiques.charges.create');
    Route::resource('boutique-charges', ChargeBoutiqueController::class);

    //tontines
    Route::get('/jours/{id}/boutiques/tontines', [TontineBoutiqueController::class, 'tontinesBoutique'])->name('jours.boutiques.tontines');
	Route::get('/jours/{id}/boutiques/tontines/create', [TontineBoutiqueController::class, 'tontinesBoutiqueCreated'])->name('jours.boutiques.tontines.create');
    Route::get('/facture/{id}', [VenteBoutiqueController::class, 'printFactures'])->name('print.facture');
    Route::get('/factures/{id}', [SoldeBoutiqueController::class, 'printFactures'])->name('print.facture.solde');
    Route::resource('boutique-tontines', TontineBoutiqueController::class);
    //versements
    Route::get('/jours/{id}/boutiques/versements', [VersementBoutiqueController::class, 'VersementsBoutique'])->name('jours.boutiques.versements');
    Route::get('/jours/{id}/boutiques/versements/create', [VersementBoutiqueController::class, 'VersementsBoutiqueCreated'])->name('jours.boutiques.versements.create');
    Route::resource('boutique-versements', VersementBoutiqueController::class);

    //dettes
    Route::get('/jours/{id}/boutiques/dettes', [DetteBoutiqueController::class, 'dettesBoutique'])->name('jours.boutiques.dettes');
    Route::get('/jours/{id}/boutiques/dettes/create', [DetteBoutiqueController::class, 'dettesBoutiqueCreated'])->name('jours.boutiques.dettes.create');

    Route::resource('boutique-dettes', DetteBoutiqueController::class);
    Route::post('versement-dettes', [DetteBoutiqueController::class, 'versementStore'])->name('versement.dettes');
    Route::get('versement-dettes/destroy/{id}', [DetteBoutiqueController::class, 'dettesVersementDestroy'])->name('versement.dettes.destroy');

    Route::get('/messages', [ContactsController::class, 'index'])->name('message.index');
    Route::post('/messages', [ContactsController::class, 'store'])->name('message.store');
    Route::get('/messages/{id}', [ContactsController::class, 'getMessageByUser']);
    Route::get('/refresh_message/{id}', [ContactsController::class, 'refreshMessage']);
    Route::get('/refresh_contact/{id}', [ContactsController::class, 'refreshContact']);

});
