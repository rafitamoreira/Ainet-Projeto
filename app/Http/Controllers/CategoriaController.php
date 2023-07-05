<?php


namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categorie::paginate(14);
        return view('back_page.categorias', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back_page.categorias_create');
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
        $categoria = Categorie::findOrFail($id);
        return view('back_page.categorias_edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categoria)
    {
        if ($request->nome != null) {
            $categoria->name = $request->nome;
            $categoria->timestamps = false;
            $categoria->save();
            return redirect('/admin/categorias')->with('error', 'Categoria alterada com sucesso');
        } else {
            return redirect('/admin/categorias')->with('error', 'Erro ao alterar categoria');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categoria = Categorie::findOrFail($id); //If Encomenda exists
        $categoria->timestamps = false;
        $categoria->delete(); //Remove Encomenda

        return Redirect()->back()->with('success', 'Categoria removida com sucesso');
    }
}
