<?php

namespace App\Http\Controllers;

use App\Models\Preco;
use App\Models\Tshirt_image;
use Illuminate\Http\Request;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $preco = Preco::find(1);
        $products = Tshirt_image::whereNull('customer_id')->inRandomOrder()->limit(12)->get();
        return view('front_page.index', ['products' => $products]);
    }
}
