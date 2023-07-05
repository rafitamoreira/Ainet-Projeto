<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Tshirt_imageController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EstampaController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\VerifyIsAdmin;
use App\Http\Middleware\VerifyIfIsUser;
use App\Http\Middleware\VerifyIsFuncionario;
use App\Http\Middleware\VerifyIfEstampaIsFromUser;

use Illuminate\Support\Facades\DB;




use App\Models\User;
use App\Models\Customer;
use App\Models\Order_item;
use App\Models\Tshirt_image;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

///Route::get('/', function () {
 
   // return view('front_page.index');
///});

Route::resource('/', HomeController::class);




Route::get('/search', [Tshirt_imageController::class, 'search'])->name('search');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



///ROTAS DE ADMIN 

Route::middleware([VerifyIsAdmin::class])->group(function () {
    Route::get('/admin', function () {
        $users = User::count();
        $clientes = Customer::count();
        $encomendas = Order_item::count();
        $estampas = Tshirt_image::count();
        $year = ['2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023'];

        $encomendas_data = [];
        foreach ($year as $key => $value) {
            $encomendas_data[] = Tshirt_image::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"), $value)->count();
        }

        $user = [];
        foreach ($year as $value) {
            $user[] = User::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"), $value)->count();
        }
        $clientes_data = [];
        foreach ($year as $value) {
            $clientes_data[] = Customer::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"), $value)->count();
        }
        $estampas_data = [];
        foreach ($year as $value) {
            $estampas_data[] = Tshirt_image::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"), $value)->count();
        }

        return view('back_page.index', compact('users', 'clientes', 'encomendas', 'estampas'))
            ->with('year', json_encode($year, JSON_NUMERIC_CHECK))
            ->with('encomendas_data', json_encode($encomendas_data, JSON_NUMERIC_CHECK))
            ->with('user', json_encode($user, JSON_NUMERIC_CHECK))
            ->with('clientes_data', json_encode($clientes_data, JSON_NUMERIC_CHECK))
            ->with('estampas_data', json_encode($estampas_data, JSON_NUMERIC_CHECK));

    })->name('admin');

    Route::resource('admin/users', UserController::class);
    Route::get('admin/estampas', [Tshirt_imageController::class, 'mostrarEstampasAdmin']);
    //Route::resource('admin/estampas', Tshirt_image::class);
    Route::resource('admin/encomendas', OrderController::class);
    Route::resource('admin/clientes', CustomerController::class);
    Route::resource('admin/categorias', CategoriaController::class);
    Route::resource('admin/cores', CorController::class);
    Route::resource('admin/precos', PrecoController::class);
    Route::get('admin/search', [UserController::class, 'search'])->name('admin.search');
    Route::get('admin/procurarclientes', [CustomerController::class, 'searchCustomers'])->name('admin.clientes.search');

    /// Route::get('/chart', [MainController::class, 'ordersPerMonth']);
    Route::get('/statistics/orders-per-month', [StatisticsController::class, 'ordersPerMonth'])->name('statistics.ordersPerMonth');
    Route::get('/statistics/orderStatusCount', [StatisticsController::class, 'orderStatusCount'])->name('statistics.orderStatusCount');
    Route::get('/statistics/registeredUsers', [StatisticsController::class, 'registeredUsers'])->name('statistics.registeredUsers');
    Route::get('/statistics/revenuePerMonth', [StatisticsController::class, 'revenuePerMonth'])->name('statistics.revenuePerMonth');

    Route::get('/admin/client_state', [UserController::class, 'update_state'])->name('client_state');
    Route::get('/admin/encomendas/state/{encomenda}{estado}', [OrderController::class, 'changeEncomendaEstado'])->name('encomendas.changeEncomendaEstado');
});

///Route::get('/shopdetails/{id}', [MainController::class, 'shopdetails'])->name('shopdetails')->middleware('VerifyIfEstampaIsFromUser');
Route::get('/shoppingcart', [CartController::class, 'index'])->name('shoppingcart');


// ROTAS DE USER
Route::middleware([VerifyIsFuncionario::class])->group(function () {

    Route::get('/profile', [UserController::class, 'edit_front'])->name('profile');
    Route::put('/profile/{user}', [UserController::class, 'update_front'])->name('profile_update');
});
///Route::get('/', [MainController::class, 'index'])->name('homeT');
Route::get('/contact', [MainController::class, 'contact'])->name('contact');
Route::resource("product", Tshirt_imageController::class);
Route::get('/shopdetails/{id}', [Tshirt_imageController::class, 'show'])->name('shopdetails')->middleware('VerifyIfEstampaIsFromUser');

///CART 
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('addToCart');
Route::get('/remove-From-Cart/{id}', [CartController::class, 'removeFromCart'])->name('removeFromCart');
Route::get('/edit-item-From-Cart/{id}{operator}', [CartController::class, 'editItemFromCart'])->name('editItemFromCart');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkoutcart', [CartController::class, 'checkoutCart'])->name('checkoutCart');

Route::get('verify-mail', function () {

    $user = Auth::user();
    $user->email_verified_at= Carbon::now()->toDateTimeString();
    $user->save();
    return redirect()->back();
})->name('verify_email');

Route::middleware([VerifyIfIsUser::class])->group(function () {
    Route::get('/criarEstampa', [Tshirt_imageController::class, 'create'])->name('createEstampa');
    Route::post('/criarEstampa', [Tshirt_imageController::class, 'store'])->name('storeEstampa');
    Route::get('/minhasEstampas', [Tshirt_imageController::class, 'minhasEstampas'])->name('minhasEstampas');
});

//Route::get('/minhasEstampas', [Tshirt_imageController::class, 'minhasEstampas'])->name('minhasEstampas');

Route::get('/estampas/{estampa}/imagem', [Tshirt_imageController::class, 'getEstampaPrivada'])->name('estampas.privadas');

Route::middleware([VerifyIfEstampaIsFromUser::class])->group(function () {
    Route::delete('/estampas/{estampa}', [Tshirt_imageController::class, 'destroy_privadas'])->name('estampas.privadas.destroy');
    Route::get('/estampas/{estampa}/edit', [Tshirt_imageController::class, 'edit_privadas'])->name('estampas.privadas.edit');
});
Route::PATCH('/estampas/{estampa}', [Tshirt_imageController::class, 'update_privadas'])->name('estampas.privadas.update'); ///->middleware('VerifyEstampasPrivadasEdit');


Route::get('/minhasencomendas', [OrderController::class, 'index_front'])->name('minhasencomendas');

Route::middleware([VerifyIfIsMyEstampa::class])->group(function () {
    Route::get('/minhasencomendas/{encomenda}', [OrderController::class, 'show_front'])->name('minhasencomendas.show');
    Route::get('/minhasencomendas/{encomenda}/pdf', [OrderController::class, 'show_front_pdf'])->name('minhasencomendas.show.pdf');
    
});



Route::post('/contact_email', [MainController::class, 'contact_email'])->name('contact_email');

