<?php

namespace App\Http\Controllers;

use App\Mail\MailEncomenda;
use App\Mail\MailRegisto;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Tshirt_image;
use App\Models\Customer;
use App\Models\User;
use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Session::has('cart')) {

            return view('front_page.shoping-cart', ['items' => null]);
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('front_page.shoping-cart', ['items' => $cart->items, 'totalPrice' => $cart->totalPrice()]);
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
        //
    }
    public function addToCart(Request $request, $id)
    {

        if ($request->qty == null) {
            $request->qty = 1;
        }
        $estampa = Tshirt_image::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($estampa, $estampa->id, $request->qty, $request->tamanho, $request->cor);
        $request->session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Estampa adicionada com sucesso ao carrinho');
    }
    public function removeFromCart(Request $request, $index)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->remove($index);

        $request->session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Estampa removida do carrinho');
    }
    public function editItemFromCart(Request $request, $index, $operator)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->editQuantity($index, $operator);

        $request->session()->put('cart', $cart);
        if ($operator == "+") {
            return redirect()->back()->with('success', 'Quantidade da estampa aumentada com sucesso');
        } elseif ($operator == "-") {
            return redirect()->back()->with('success', 'Quantidade da estampa diminuida com sucesso');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function totalPrice()
    {
        $totalPrice = 0;
        foreach ($this->items as $item) {
            $totalPrice += $item['price'];
        }
        return $totalPrice;
    }

    public function totalQty()
    {
        $totalQty = 0;
        foreach ($this->items as $item) {
            $totalQty += $item['qty'];
        }
        return $totalQty;
    }

    public function edit(string $id)
    {
        //
    }

    public function checkout(Request $request)
    {
        if (!Session::has('cart')) {
            return view('front_page.checkout', ['items' => null]);
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('front_page.checkout', ['items' => $cart->items, 'totalPrice' => $cart->totalPrice()]);
    }

    public function checkoutCart(Request $request)
    {

        //verificar se user é logado ou nao
        $user = Auth::User();
        $oldCart = Session::get('cart');
        $preco_total = Session::get('cart')->totalPrice();

        if ($user == null) {

            if ($request->name == null || $request->email == null || $request->endereco1 == null || $request->endereco2 == null || $request->endereco3 == null || $request->nif == null || $request->payment_ref == null || $request->password == null) {

                return redirect()->back()->with('error', 'Tem de preencher todos os campos');
            } else {
                // criar o user / Cliente
                $newUser = new User();
                $newCliente = new Customer();
                $newUser->name = $request->name;
                $newUser->email = $request->email;
                $newUser->password = Hash::make($request->password);
                $newUser->user_type = 'C';
                $newUser->blocked = 0;
                $newUser->save();
                $newCliente->id = $newUser->id;
                $newCliente->nif = $request->nif;
                $newCliente->address = $request->endereco1 . ", " . $request->endereco2 . ", " . $request->endereco3;
                $newCliente->default_payment_ref = $request->payment_ref;
                $newCliente->default_payment_type = $request->payment_type;

                $newCliente->save();
                $user = $newUser;
                Auth::login($user);
                Mail::to($user->email)->send(new MailRegisto($user));
            }
        }

        //gerar Econmenda
        $encomenda = new Order();
        $encomenda->status = "pending";
        $encomenda->customer_id = $user->id;
        $encomenda->date = Carbon::now()->toDateTimeString();
        $encomenda->total_price = $preco_total;
        if ($user->customer->nif == null) {
            $encomenda->nif = $request->nif;
        }else {
            $encomenda->nif = $user->customer->nif;
        }
    
        if ($user->customer->address == null) {
            $encomenda->address = $request->endereco1;
        }else {
            $encomenda->address = $user->customer->address;
        }

        if ($user->customer->payment_type == NULL) {
            $encomenda->payment_type = $request->payment_type;
        } else {
            $encomenda->payment_type = $user->customer->default_payment_type;
        }
        if ($user->customer->default_payment_ref == NULL) {
            $encomenda->payment_ref = $request->payment_ref;
        } else {
            $encomenda->payment_ref = $user->customer->default_payment_ref;
        }
        $encomenda->save();





        // Gerar TSHIRTS
        foreach ($oldCart->items as $item) {
            $tshirt = new Order_item();
            $tshirt->order_id = $encomenda->id;
            $tshirt->tshirt_image_id = $item['id'];
            $tshirt->color_code = $item['cor'];
            $tshirt->size = $item['tamanho'];
            $tshirt->qty = $item['qty'];
            $tshirt->unit_price = $item['price'] / $item['qty'];
            $tshirt->sub_total = $item['price'];
            $tshirt->timestamps = false;
            $tshirt->save();
        }


        // Gerar PDF

        //apagar sessao
        Session::forget('cart');
        Mail::to($user->email)->send(new MailEncomenda($encomenda));

        return redirect()->route('minhasencomendas')->with('success', 'Encomenda criada com sucesso');
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
