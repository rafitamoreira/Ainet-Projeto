<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyIfIsMyEstampa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $encomenda = Order::find($request->route()->encomenda);
        $user = Auth::User();
        if ($user->user_type == 'A') {
            return $next($request);
        } else {

            if ($encomenda->customer_id == $user->id) {
                return $next($request);
            } else {
                return redirect()->route('minhasencomendas');
            }
        }
    }
}
