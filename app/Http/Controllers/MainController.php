<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Order;
use App\Models\Preco;
use App\Models\Tshirt_image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bebidasLogo = Tshirt_image::where('id', 157)->pluck('imagem_url')->first();
        $coolLogo = Tshirt_image::where('id', 35)->pluck('imagem_url')->first();
        $abstratosLogo = Tshirt_image::where('id', 22)->pluck('imagem_url')->first();
        $desportosLogo = Tshirt_image::where('id', 205)->pluck('imagem_url')->first();
        $engracadasLogo = Tshirt_image::where('id', 36)->pluck('imagem_url')->first();
        $filmesLogo = Tshirt_image::where('id', 11)->pluck('imagem_url')->first();
        $frasesLogo = Tshirt_image::where('id', 254)->pluck('imagem_url')->first();
        $estampas = Tshirt_image::whereNull('cliente_id')->inRandomOrder()->limit(8)->get();
        $preco = Preco::find(1);
        return view('front_pages.index', compact('estampas', 'bebidasLogo', 'coolLogo', 'abstratosLogo', 'desportosLogo', 'engracadasLogo', 'filmesLogo', 'frasesLogo', 'preco'));
    }

    public function maisVendidas(Request $request)
    {
        $preco = Preco::find(1);
        $search = request('search');
        if ($search) {
            $products = Tshirt_image::where([
                ['name', 'like', '%' . $search . '%']
            ])->paginate(9);
        } else {
            $products = Tshirt_image::paginate(9);
        }
        return view('front_page.products', ['products' => $products, 'search' => $search]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function ordersPerMonth()
    {
        $ordersPerMonth = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('month')
            ->get();


        return response()->json($ordersPerMonth);
    }

    public function averageOrderValue()
    {
        $averageOrderValue = Order::where('created_at', '>=', Carbon::now()->subYear())
            ->average('total_price');

        return response()->json(['average_order_value' => $averageOrderValue]);
    }



    public function shopdetails($id)
    {
        $product = Tshirt_image::findOrFail($id);
        $preco = Preco::find(1);
        $productsRelated = Tshirt_image::whereNull('customer_id')->inRandomOrder()->where('category_id', $product->category_id)->limit(4)->get();
        $cores = Color::all();
        return view('front_page.product_details', compact('product', 'productsRelated', 'preco', 'cores'));
    }

    public function revenuePerMonth()
    {
        $revenuePerMonth = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('month')
            ->get();

        return response()->json($revenuePerMonth);
    }

    public function contact()
    {
        return view('front_page.contact');
    }

    public function contact_email(Request $request){
        return redirect()->back()->with('success','Obrigado por nos ter contactado');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
