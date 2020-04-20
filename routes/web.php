<?php

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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'UserController');
    Route::put('user/{user}/password', 'UserController@updatePassword')->name('users.update.pass');
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
    Route::resource('roles','RoleController');
    Route::resource('shops','BoutiqueController');
    Route::patch('slogo/{id}','BoutiqueController@updateLogo')->name('shop.update.logo');
    Route::post('shops/inventaires','BoutiqueController@inventaireShops')->name('shops.inventaire');
    Route::get('shops/{id}/show/','BoutiqueController@showUserShops')->name('users.shops');
    Route::get('shops/{id}/stocks/','BoutiqueController@stocksUserShops')->name('stocks.shops');
    Route::get('shops/{id}/inventaires/','BoutiqueController@inventaireUserShops')->name('inventaire.shops');
    Route::get('shops/{id}/ventes/','BoutiqueController@ventesUserShops')->name('ventes.shops');
    Route::get('shops/{id}/soldes/','BoutiqueController@soldesUserShops')->name('soldes.shops');
    Route::get('shops/{id}/sorties-magasin/','BoutiqueController@sortiesUserShops')->name('sorties.shops');
    Route::get('shops/{id}/charges/','BoutiqueController@chargesUserShops')->name('charges.shops');
    Route::get('shops/{id}/tontines/','BoutiqueController@tontinesUserShops')->name('tontines.shops');
    Route::get('shops/{id}/versements/','BoutiqueController@versementsUserShops')->name('versements.shops');
    Route::get('shops/{id}/dettes/','BoutiqueController@dettesUserShops')->name('dettes.shops');
    Route::get('shops/{id}/historiques/','BoutiqueController@historiquesUserShops')->name('historiques.shops');
    //print shop
    Route::get('shops/print/{id}/historiques','BoutiqueController@historiqueShopsPrintsJours')->name('historiques.shops.print.jours');
    Route::get('shops/print/{id}/ventes','BoutiqueController@venteShopsPrintsJours')->name('ventes.shops.print.jours');
    Route::get('shops/print/{id}/soldes','BoutiqueController@soldeShopsPrintsJours')->name('soldes.shops.print.jours');
    Route::get('shops/print/{id}/sorties','BoutiqueController@sortiesShopsPrintsJours')->name('sorties.shops.print.jours');
    Route::get('shops/print/{id}/charges','BoutiqueController@chargesShopsPrintsJours')->name('charges.shops.print.jours');
    Route::get('shops/print/{id}/tontines','BoutiqueController@tontinesShopsPrintsJours')->name('tontines.shops.print.jours');
    Route::get('shops/print/{id}/versements','BoutiqueController@versementsShopsPrintsJours')->name('versements.shops.print.jours');
    Route::get('shops/print/{id}/dettes','BoutiqueController@dettesShopsPrintsJours')->name('dettes.shops.print.jours');
    Route::get('shops/print/{id}/stocks','BoutiqueController@stocksShopsPrintsJours')->name('stocks.shops.print.jours');


    //boutique impréssions
    Route::get('shops/print/{id}/ventes/jours','BoutiqueJourController@venteShopsPrintsJours')->name('ventes.shops.print');
    Route::get('shops/print/{id}/soldes/jours','BoutiqueJourController@soldeShopsPrintsJours')->name('soldes.shops.print');
    Route::get('shops/print/{id}/sorties/jours','BoutiqueJourController@sortiesShopsPrintsJours')->name('sorties.shops.print');
    Route::get('shops/print/{id}/charges/jours','BoutiqueJourController@chargesShopsPrintsJours')->name('charges.shops.print');
    Route::get('shops/print/{id}/journal/jours','BoutiqueJourController@journalShopsPrintsJours')->name('journal.shops.print');
    Route::get('shops/print/{id}/tontines/jours','BoutiqueJourController@tontinesShopsPrintsJours')->name('tontines.shops.print');
    Route::get('shops/print/{id}/versements/jours','BoutiqueJourController@versementsShopsPrintsJours')->name('versements.shops.print');
    Route::get('shops/print/{id}/dettes/jours','BoutiqueJourController@dettesShopsPrintsJours')->name('dettes.shops.print');
    //magasin impréssions
    Route::get('magasins/print/{id}/historiques','MagasinController@historiqueMagasinsPrints')->name('historiques.magasins.print');
    Route::get('magasins/print/{id}/entrees','MagasinController@entreesMagasinsPrints')->name('entres.magasins.print');
    Route::get('magasins/print/{id}/stocks','MagasinController@stocksMagasinsPrints')->name('stocks.magasins.print');
    Route::get('magasins/print/{id}/sorties/boutique','MagasinController@sortiesBoutiqueMagasinsPrints')->name('sorties.boutique.magasins.print');
    Route::get('magasins/print/{id}/sorties/magasin','MagasinController@sortiesMagasinMagasinsPrints')->name('sorties.magasin.magasins.print');
    //getion jounaliere
    Route::get('magasins/print/{id}/entrees/jour','MagasinJourController@entreesMagasinsPrints')->name('entres.magasins.print.jour');
    Route::get('magasins/print/{id}/sorties/boutique/jour','MagasinJourController@sortiesBoutiqueMagasinsPrints')->name('sorties.boutique.magasins.print.jour');
    Route::get('magasins/print/{id}/sorties/magasin/jour','MagasinJourController@sortiesMagasinMagasinsPrints')->name('sorties.magasin.magasins.print.jour');


    Route::resource('magasins','MagasinController');
    Route::get('magasins/{id}/show/','MagasinController@showUserMagasin')->name('users.magasins');
    Route::get('magasins/{id}/stocks/','MagasinController@stocksUserMagasin')->name('stocks.magasins');
    Route::get('magasins/{id}/inventaires/','MagasinController@inventaireUserMagasin')->name('inventaire.magasins');
    Route::get('magasins/{id}/historiques/','MagasinController@historiqueMagasin')->name('historiques.magasins');
    Route::get('magasins/{id}/entrees/','MagasinController@entreeMagasin')->name('entrees.magasins');
    Route::get('magasins/{id}/sorties-boutiques/','MagasinController@sortieBoutiqueMagasin')->name('sortie-boutique.magasins');
    Route::get('magasins/{id}/sorties-magasins/','MagasinController@sortieMagasinMagasin')->name('sortie-magasin.magasins');
    Route::post('magasins/inventaires','MagasinController@inventaireMagasins')->name('magasins.inventaire');
    Route::resource('categories','CategorieController');
    Route::resource('produits','ProduitController');
    Route::resource('days','MagasinJourController');
    Route::resource('enters','EntreeMagasinController');
    Route::resource('magasins-sorties','SortieMagasinMagasinController');
    Route::resource('boutiques-sorties','SortieMagasinBoutiqueController');
    Route::get('/days/{id}/actions', 'MagasinJourController@daysActionc')->name('days.actionc');
    Route::get('/days/{id}/action', 'MagasinJourController@daysActiono')->name('days.actiono');
    Route::get('/days/{id}/create', 'MagasinJourController@daysCeated')->name('days.ceated');
    Route::get('/days/{id}/entrees', 'EntreeMagasinController@entreesMagasin')->name('days.entrees');
    Route::get('/days/{id}/magasins/sorties', 'SortieMagasinMagasinController@sortiesMagasinMagasin')->name('days.magasins.magasins.sorties');
    Route::get('/days/{id}/boutiques/sorties', 'SortieMagasinBoutiqueController@sortiesMagasinBoutique')->name('days.magasins.boutiques.sorties');
    Route::get('/days/{id}/magasins/sorties/create', 'SortieMagasinMagasinController@sortiesMagasinMagasinCreated')->name('days.magasins.magasins.sorties.create');
    Route::get('/days/{id}/boutiques/sorties/create', 'SortieMagasinBoutiqueController@sortiesMagasinBoutiqueCreated')->name('days.magasins.boutiques.sorties.create');
    Route::get('/days/{id}/entrees/create', 'EntreeMagasinController@entreesCreateMagasin')->name('days.entrees.create');

    Route::resource('jours','BoutiqueJourController');
    Route::get('/jours/{id}/create', 'BoutiqueJourController@joursCeated')->name('jours.ceated');
    Route::get('/jours/{id}/actions', 'BoutiqueJourController@daysActiono')->name('jours.actiono');
    Route::get('/jours/{id}/action', 'BoutiqueJourController@daysActionc')->name('jours.actionc');
    Route::get('/jours/{id}/magasins/sorties', 'SortieBoutiqueMagasinController@sortiesBoutiqueMagasin')->name('jours.boutiques.magasins.sorties');
    Route::get('/jours/{id}/magasins/sorties/create', 'SortieBoutiqueMagasinController@sortiesBoutiqueMagasinCreated')->name('jours.boutiques.magasins.sorties.create');
    Route::resource('boutique-magasins-sorties','SortieBoutiqueMagasinController');

    //ventes
    Route::get('/jours/{id}/boutiques/ventes', 'VenteBoutiqueController@ventesBoutique')->name('jours.boutiques.ventes');
    Route::get('/jours/{id}/boutiques/ventes/create', 'VenteBoutiqueController@ventesBoutiqueCreated')->name('jours.boutiques.ventes.create');
     Route::get('/jours/{id}/boutiques/ventes/create', 'VenteBoutiqueController@ventesBoutiqueCreated')->name('jours.boutiques.ventes.create');
    Route::resource('boutique-ventes','VenteBoutiqueController');
    //soldes
    Route::get('/jours/{id}/boutiques/soldes', 'SoldeBoutiqueController@soldesBoutique')->name('jours.boutiques.soldes');
    Route::get('/jours/{id}/boutiques/soldes/create', 'SoldeBoutiqueController@soldesBoutiqueCreated')->name('jours.boutiques.soldes.create');
     Route::get('/jours/{id}/boutiques/soldes/create', 'SoldeBoutiqueController@soldesBoutiqueCreated')->name('jours.boutiques.soldes.create');
    Route::resource('boutique-soldes','SoldeBoutiqueController');
    //charges
    Route::get('/jours/{id}/boutiques/charges', 'ChargeBoutiqueController@chargesBoutique')->name('jours.boutiques.charges');
    Route::get('/jours/{id}/boutiques/charges/create', 'ChargeBoutiqueController@chargesBoutiqueCreated')->name('jours.boutiques.charges.create');
    Route::resource('boutique-charges','ChargeBoutiqueController');

    //tontines
    Route::get('/jours/{id}/boutiques/tontines', 'TontineBoutiqueController@tontinesBoutique')->name('jours.boutiques.tontines');
    Route::get('/jours/{id}/boutiques/tontines/create', 'TontineBoutiqueController@tontinesBoutiqueCreated')->name('jours.boutiques.tontines.create');
    Route::get('/facture/{id}', 'VenteBoutiqueController@printFactures')->name('print.facture');
    Route::get('/factures/{id}', 'SoldeBoutiqueController@printFactures')->name('print.facture.solde');
    Route::resource('boutique-tontines','TontineBoutiqueController');
    
    //versements
    Route::get('/jours/{id}/boutiques/versements', 'VersementBoutiqueController@VersementsBoutique')->name('jours.boutiques.versements');
    Route::get('/jours/{id}/boutiques/versements/create', 'VersementBoutiqueController@VersementsBoutiqueCreated')->name('jours.boutiques.versements.create');
    Route::resource('boutique-versements','VersementBoutiqueController');

    //dettes
    Route::get('/jours/{id}/boutiques/dettes', 'DetteBoutiqueController@dettesBoutique')->name('jours.boutiques.dettes');
    Route::get('/jours/{id}/boutiques/dettes/create', 'DetteBoutiqueController@dettesBoutiqueCreated')->name('jours.boutiques.dettes.create');

    Route::resource('boutique-dettes','DetteBoutiqueController');
    Route::post('versement-dettes','DetteBoutiqueController@versementStore')->name('versement.dettes');
    Route::get('versement-dettes/destroy/{id}','DetteBoutiqueController@dettesVersementDestroy')->name('versement.dettes.destroy');
    //méssage
    Route::get('/messages', 'ContactsController@index')->name('message.index');
    Route::post('/messages', 'ContactsController@store')->name('message.store');
    Route::get('/messages/{id}', 'ContactsController@getMessageByUser');
    Route::get('/refresh_message/{id}', 'ContactsController@refreshMessage');
    Route::get('/refresh_contact/{id}', 'ContactsController@refreshContact');

});

