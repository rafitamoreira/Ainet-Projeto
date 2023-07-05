<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Customer::paginate(15);
        return view('back_page.clientes', compact('clientes'));
    }

    public function searchCustomers(Request $request)
{

    $searchTerm = $request->input('search');

    $clientes = Customer::join('users', 'customers.id', '=', 'users.id')
                ->where('customers.id', 'like', "%{$searchTerm}%")
                ->orWhere('users.name', 'like', "%{$searchTerm}%")
                ->whereNull('customers.deleted_at')
                ->select('customers.id', 'users.name')
                ->paginate(15);
    
    return view('back_page.clientes', compact('clientes'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        $cliente = Customer::findOrFail($id);
        return view('back_page.cliente_show', compact('cliente'));
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
        $client = Customer::findOrFail($id); //If client exists
        $client->delete(); //Remove client

        return Redirect()->back()->with('success', 'Cliente removido com sucesso');
    }
}
