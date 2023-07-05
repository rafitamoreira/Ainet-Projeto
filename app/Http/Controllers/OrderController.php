<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCriarPostRequest;
use App\Mail\MailorderFechada;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Tshirt;
use App\Models\User;
use Facade\FlareClient\Http\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Support\Facades\DB;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->status ?? '';
        $data = $request->date ?? '';

        $user = Auth::User();
        // if ($user->user_type == 'F') {
        //     if ($status == "pending" || $status == "paid") {
        //         $orders = Order::where('status', $status)->paginate(15);
        //     } else {
        //         $orders = Order::where('status', 'pending')->orWhere('status', 'paid')->paginate(15);
        //     }
        // } elseif ($user->user_type == 'A') {
        //     if ($status != "*" && $data != '') {
        //         $orders = Order::where('status', $status)->where(DB::raw("DATE_FORMAT(created_at,'%Y')"), $data)->paginate(15);
        //     } else {
        //         if ($data == '') {
        //             $orders = Order::paginate(15);
        //         } else {
        //             $orders = Order::where(DB::raw("DATE_FORMAT(created_at,'%Y')"), $data)->paginate(15);
        //         }
        //     }
        // }

        if ($status == "*" || $status == null) $orders = Order::paginate(15);
        else $orders = Order::where('status', $status)->paginate(15);

        return view('back_page.encomendas', compact('orders', 'status', 'data'));
    }

    public function index_front()
    {

        $user = Auth::user();
        $encomendas = Order::where('customer_id', $user->id)->paginate(15);
        return view('front_page.minhasEncomendas', compact('encomendas'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orders = new Order();
        return view('back_page.encomendas_create', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderCriarPostRequest $request)
    {
        $validated_data = $request->validated();
        $cliente = Customer::find($validated_data['numero']);
        if ($cliente == null) {
            return redirect()->back();
        }
        $neworder = new Order;
        $neworder->status = "pendente";
        $neworder->customer_id = $validated_data['numero'];
        $neworder->total_price = $validated_data['preco'];
        if ($validated_data['notes'] != null) {
            $neworder->notes = $validated_data['notes'];
        }
        $neworder->data = Carbon::now()->toDateTimeString();
        $neworder->nif = $cliente->nif;
        $neworder->address = $cliente->address;
        $neworder->payment_type = $cliente->payment_type;
        $neworder->payment_ref = $cliente->payment_ref;
        $neworder->save();
        return redirect()->back()->with('success', 'order criada com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('back_page.encomendas_show', compact('order'));
    }
    public function show_front($id)
    {
        $order = Order::findOrFail($id);
        $tshirts = Order_item::where('order_id', $id)->get();
        return view('front_page.minhasordersDetalhes', compact('order', 'tshirts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('back_page.encomendas_edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $order)
    {
        $order = Order::find($order);
        if ($request->status != null) {
            $order->status = $request->status;
        }
        if ($request->valor != null) {
            $order->total_price = $request->valor;
        }

        if ($request->notes  != null) {
            $order->notes = $request->notes;
        }
        if ($request->address != null) {
            $order->address = $request->address;
        }
        if ($request->payment_type != null) {
            $order->payment_type = $request->payment_type;
        }
        if ($request->ref != null) {
            $order->payment_ref = $request->ref;
        }
    
        if ($request->status == "closed") {
            $order->status = "closed";
               $tshirts = Order_item::where('order_id', $order->id)->get();
                $pdf = PDF::loadView('pdf.minhasordersDetalhes', compact('order', 'tshirts'));
                $content = $pdf->download()->getOriginalContent();
                Storage::put('pdf_receipts/' . $order->id . '.pdf', $content);
                $order->receipt_url = $order->id . '.pdf';
                $order->save();
                 $user = User::find($order->customer_id);
                 Mail::to($user->email)->send(new MailorderFechada($order));
        }


        $order->save();

        return redirect()->back()->with('success', 'Encomenda alterada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id); //If order exists
        $order->delete(); //Remove order

        return Redirect()->back()->with('success', 'order removida com sucesso');
    }



    public function show_front_pdf($id)
    {
        $order = Order::findOrFail($id);
        $tshirts = Order_item::where('order_id', $id)->get();
        $pdf = PDF::loadView('pdf.minhasordersDetalhes', compact('order','tshirts'));
        return $pdf->download("teste.pdf");
        return response()->file(storage_path() . '/app/pdf_receipts/' . $order->receipt_url);
    }

     public function changeorderEstado($order, $estado)
     {
         $order = Order::find($order);
         switch ($estado) {
             case 1:
                 $order->status = "paid";
                $order->save();
                break;
             case 2:
                $order->status = "closed";
               $tshirts = Order_item::where('order_id', $order->id)->get();
                $pdf = PDF::loadView('pdf.minhasordersDetalhes', compact('order', 'tshirts'));
                $content = $pdf->download()->getOriginalContent();
                Storage::put('pdf_receipts/' . $order->id . '.pdf', $content);
                $order->receipt_url = $order->id . '.pdf';
                $order->save();
                 $user = User::find($order->cliente_id);
                 Mail::to($user->email)->send(new MailorderFechada($order));
                break;

             case 3:
                 $order->status = "canceled";
                 $order->save();
                 break;
         }
         return redirect()->back()->with('success', 'Estado da order alterado com sucesso');
     }
}
