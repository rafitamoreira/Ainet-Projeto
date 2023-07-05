<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Http\Requests\UserPostRequest;
use App\Http\Requests\UserEditPostRequest;
use App\Http\Requests\UserCreatePostRequest;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $key = trim($request->get('user')) ?? '';
        $user_type = $request->user_type ?? '';

        $users = User::query();

        if ($key != "" && $user_type != '*') {
            $users = $users->where('user_type', $user_type)
                ->where('name', 'like', "%$key%")
                ->orWhere('email', 'like', "%$key%")
                ->where('tipo', $user_type);
        }
        if ($key != "") {
            $users = $users->where('name', 'like', "%$key%")->orWhere('email', 'like', "%$key%");
        }

        if ($user_type != '') {
            $users = $users->where('user_type', "$user_type");
        }

        $users = $users->paginate(15);
        if ($user_type == '*' && $key == "") {
            $users = User::paginate(15);
        }

        return view('back_page.users', compact(['users', 'user_type', 'key']));
    }

    public function search(Request $request)
{
    $user_type = $request->user_type ?? '';
    $searchTerm = $request->input('search');

    $users = User::where('name', 'like', "%$searchTerm%")
                ->paginate(10);

    return view('back_page.users', compact('users', 'user_type'));
}

    public function getUserType()
    {
        $user_id = auth()->id();
        $user = User::find($user_id);
        return $user->user_type;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User;
        return view('back_page.create', compact('user'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreatePostRequest $request)
    {
        $validated_data = $request->validated();
        $newUser = new User;
        $newUser->name = $validated_data['name'];
        $newUser->email = $validated_data['email'];
        $newUser->password = Hash::make($validated_data['password']);
        $newUser->user_type = $validated_data['tipo'];
        $newUser->blocked = $validated_data['bloqueado'];
        if (isset($validated_data['photo_url'])) {
            $newUser->photo_url = $validated_data['photo_url'];
        }
        $newUser->save();
        ///return redirect('/admin/users')->with('success', 'Utilizador criado com sucesso');
        $url = route('users.show', ['user' => $newUser]);
        $htmlMessage = "User <a href='$url'>#{$newUser->id}</a> <strong>\"{$newUser->name}\"</strong> foi criado com sucesso!";

        return redirect()->route('users.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        ///
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('back_page.users_edit', compact('user'));
    }

    public function edit_front()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        return view('front_page.profile_user', compact('user'));
    }

    public function update(UserEditPostRequest $request, User $user)
    {
        $validated_data = $request->validated();
        $user->name = $validated_data['name'];
        $user->email = $validated_data['email'];
        if ($validated_data['password'] != null) {
            if (strlen($validated_data['password']) >= 8) {
                $user->password = Hash::make($validated_data['password']);
            } else {
                return redirect()->back()->with('error', 'Password tem de ter no minimo 8 caracteres');
            }
        }
        $user->tipo = $validated_data['tipo'];
        $user->bloqueado = $validated_data['bloqueado'];

        if (isset($validated_data['foto_url'])) {
            Storage::delete('public/fotos/' . $user->foto_url);
            $file = $request->file('foto_url');
            $file_name = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/fotos', $file_name);
            $user->foto_url = $file_name;
        }

        $user->save();
        return redirect()->back()->with('success', 'Utilizador atualizado com sucesso');
    }


    public function update_front(UserPostRequest $request, User $user)
    {
        $cliente = $user->customer;
        $validated_data = $request->validated();
        $user->name = $validated_data['name'];
        if ($validated_data['endereco'] != null) {
            $cliente->address = $validated_data['endereco'];
        }
        if ($validated_data['nif'] != null) {
            $cliente->nif = $validated_data['nif'];
        }

        if (isset($validated_data['img'])) {
            Storage::delete('public/photos/' . $user->photo_url);
            $file = $request->file('img');
            $file_name = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/photos', $file_name);
            $user->photo_url = $file_name;
        }
        if ($validated_data['password'] != null) {
            $user->password = Hash::make($validated_data['password']);
        }
        $user->save();
        if ($cliente != null) {
            $cliente->save();
        }
        return Redirect()->back()->with('success', 'Utilizador atualizado com sucesso');
    }



    /**
     * Show the form for editing the specified resource.
     */



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return Redirect()->back()->with('success', 'Utilizador removido com sucesso');
    }

    public function update_state(Request $request)
    {
        $user = User::find($request->id);
        $user->blocked = !$user->blocked;
        $user->timestamps = false;
        $user->save();
        return Redirect()->back()->with('success', 'Estado do utilizador atualizado com sucesso');
    }
}
