<?php

namespace App\Http\Middleware;

use App\Models\Tshirt_image;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEstampasPrivadasEdit
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
        $estampa = $request->route()->estampa;
        $estampa = Tshirt_image::Find($estampa);
        $user = Auth::User();
        if ($estampa == null) {
            return redirect()->route('minhasEstampas')->with('error', 'Estampa não existe');
        }
        if ($user->id != $estampa->customer_id) {
            return redirect()->route('minhasEstampas')->with('error', 'Nao pode aceder a essa estampa');
        } else {
            return $next($request);
        }
    }
}
