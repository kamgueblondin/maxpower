<?php

namespace App\Http\Controllers;

use App\Boutique;
use App\Magasin;
use App\User;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:voir-administration', ['only' => ['dashboard']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('shop');
    }
    public function dashboard(){
        $boutiques=Boutique::all();
        $utilisateurs=User::all();
        $magasins=Magasin::all();
        return view('dashboard',compact('boutiques','utilisateurs','magasins'));
    }
    public function boutique($id){
        return view('shops.shop.index');
    }
}
