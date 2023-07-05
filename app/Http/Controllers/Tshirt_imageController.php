<?php

namespace App\Http\Controllers;

use App\Http\Requests\criarEstampaPostRequest;
use App\Models\Cart;
use App\Models\Color;
use App\Models\Tshirt_image;
use App\Models\Categorie;
use App\Models\Preco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Tshirt_imageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Tshirt_image::whereNull('customer_id')->paginate(9);
        $categories = Categorie::all();
        $filterByCategoria = $request->id ?? '';
        $filterByNome = $request->nome ?? '';
        $tshirtImagesQuery = Tshirt_Image::query();

        if ($filterByCategoria !== '') {
            $tshirtImagesQuery->where('category_id', $filterByCategoria);
        }
        if ($filterByCategoria === '') {
            $filterByCategoria = null;
        }
        if ($filterByNome !== '') {
            $tshirtImagesId = Tshirt_Image::where('name', 'like', "%$filterByNome%")->pluck('id');
            $tshirtImagesQuery->whereIntegerInRaw('id', $tshirtImagesId);
        }
        $products = $tshirtImagesQuery->with('category')->whereNull('customer_id')->paginate(9);

        $price = Preco::all()[0]->unit_price_catalog;
        $preco = Preco::all()[0]->unit_price_own;
        // dd($request->id);

        return view('front_page.products', compact('preco', 'price', 'filterByCategoria', 'categories', 'filterByNome', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categorie::get();
        return view('front_page.criarEstampa', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(criarEstampaPostRequest $request, Tshirt_image $estampa)
    {
        $validated_data = $request->validated();
        if (!isset($validated_data['imagem_url'])) {
            return redirect()->back();
        }
        $user = Auth::user();
        $estampa->customer_id = $user->id;
        $estampa->category_id = (int)$validated_data['categoria'];
        $estampa->name = $validated_data['nome'];
        $estampa->description = $validated_data['descricao'];
        $file = $request->file('imagem_url');
        $file_name = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('tshirt_images_private', $file_name);
        $estampa->image_url = $file_name;
        $estampa->save();
        return redirect()->route('minhasEstampas')->with('success', 'Estampa Criada com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        
        $product = Tshirt_image::where("id", $id)->first();
        if ($product == null) {
            return redirect()->back()->with('error', 'Essa estampa não existe');          
        }
        $productsRelated = Tshirt_image::whereNull('customer_id')->inRandomOrder()->where('category_id', $product->category_id)->limit(4)->get();
        // if ($product->customer_id != null) {
        //     $product->customer_id == Auth::user();
        // }
        $preco = Preco::find(1);
        $cores = Color::all();
        return view('front_page.product_details', compact('product', 'productsRelated',  'preco', 'cores'));
    }

    public function search(Request $request)
    {
        $preco = Preco::find(1);
        $categories = Categorie::all();
        $filterByCategoria = $request->id ?? '';
        $price = Preco::all()[0]->unit_price_catalog;
        $preco = Preco::all()[0]->unit_price_own;
        $search = request('search');
        if ($search) {
            $products = Tshirt_image::where([
                ['name', 'like', '%' . $search . '%']
            ])->paginate(9);
        } else {
            $products = Tshirt_image::paginate(9);
        }
        return view('front_page.products', ['products' => $products, 'search' => $search, 'categories' => $categories, 'filterByCategoria' => $filterByCategoria, 'preco' => $preco, 'price' => $price]);
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
    public function update(Request $request, Tshirt_image $estampa)
    {
        $user = Auth::user();
        $estampa->category_id = (int)$request->categoria;
        $estampa->nome = $request->nome;
        $estampa->description = $request->descricao;
        if ($request->file != null) {
            $file = $request->file('imagem_url');
            $file_name = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('tshirt_images_private', $file_name);
            $estampa->image_url = $file_name;
        }
        $estampa->extra_info = $request->informacao_extra;
        $estampa->save();
        return Redirect()->back()->with('success', 'Estampa atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estampa = Tshirt_image::findOrFail($id); //If Estampa exists
        $estampa->delete(); //Remove Estampa

        return Redirect()->back()->with('success', 'Estampa removida com sucesso');
    }

    public function destroy_privadas($id)
    {
        $estampa = Tshirt_image::findOrFail($id); //If Estampa exists
        $estampa->delete(); //Remove Estampa

        return Redirect()->back()->with('success', 'Estampa removida com sucesso');
    }
    public function edit_privadas($id)
    {
        $estampa = Tshirt_image::findOrFail($id);
        $categorias = Categorie::all();
        return view('front_page.estampas_edit', compact('estampa', 'categorias'));
    }

    public function update_privadas(Request $request, Tshirt_image $estampa)
    {
        $user = Auth::user();
        $estampa->category_id = $request->categoria;
        $estampa->name = $request->nome;
        $estampa->description = $request->descricao;
        $estampa->save();
        return redirect('/minhasEstampas')->with('success', 'Estampa alterada com sucesso');
    }

    public function minhasEstampas()
    {

        $user = Auth::user();
        $estampas = Tshirt_image::where("customer_id", $user->id)->paginate(15);
        return view('front_page.minhasEstampas', compact('estampas'));
    }

    public function mostrarEstampasAdmin()
    {

        $estampas = Tshirt_image::paginate(15);
        return view('back_page.estampas', compact('estampas'));
    }

    public function getEstampaPrivada(Tshirt_image $estampa)
    {
        if ($estampa->image_url) {
            $path = storage_path('app/tshirt_images_private/' . $estampa->image_url);
            if (file_exists($path)) {
                return response()->file($path);
            }
        }

        return response()->json(['message' => 'Imagem não encontrada.']);
    }
}
