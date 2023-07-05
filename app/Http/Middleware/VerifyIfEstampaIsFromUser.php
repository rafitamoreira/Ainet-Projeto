<?php

namespace App\Http\Middleware;


use App\Models\Tshirt_image;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyIfEstampaIsFromUser
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
        $user = Auth::User();
        $id = $request->route()->parameter('id');
        $estampa = Tshirt_image::find($id);
        if ($estampa == null) {
            $id = $request->route()->parameter('estampa');
            $estampa = Tshirt_image::find($id);
        }
        if ($estampa == null) {
            return redirect()->route('minhasEstampas')->with('error', 'Estampa não existe');
        }
        if ($estampa->customer_id != null) {
            if ($user == null || $user->id != $estampa->customer_id) {
                return redirect()->route('minhasEstampas')->with('error', 'Nao pode aceder a essa estampa');
            }
        }
        return $next($request);
    }
}
