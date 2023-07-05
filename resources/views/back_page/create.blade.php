@extends('back_layout.template')
@section('content')
    <div class="app-content pt-3 p-md-3 p-lg-4">
        @include('back_layout.flash-message')
        <div class="container-xl">

            <!-- DataTales Example -->

            <h1 class="app-page-title">Users</h1>

            <div class="card-body">
                <div class="row gy-4">
                    <div class="col-12 col-lg-6">

                        <form method="POST" action="{{ route('users.store') }}" class="form-group">
                            @csrf
                            <div class="form-group">
                                <h1 class="app-page-title">Users</h1>
                                <label for="inputNome">Nome</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Email</label>
                                <input type="text" class="form-control" name="email" id="email"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">Password</label>
                                <input type="password" class="form-control" name="password" id="password">
                                @error('password')
                                    <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputTipo">Tipo de utilizador:</label>
                                <select name="tipo" id="tipo">
                                    <option value="A" {{ old('tipo', $user->user_type) == 'A' ? 'selected' : '' }}>
                                        Administrador
                                    </option>
                                    <option value="F" {{ old('tipo', $user->user_type) == 'E' ? 'selected' : '' }}>
                                        Funcionário
                                    </option>
                                </select>
                                @error('tipo')
                                    <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div>Bloqueado</div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="inputSim" name="bloqueado"
                                        value="1" {{ old('bloqueado', $user->blocked) == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inputSim">Sim</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="inputNao" name="bloqueado"
                                        value="0" {{ old('bloqueado', $user->blocked) == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inputNao">Não</label>
                                </div>
                                @error('bloqueado')
                                    <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputFoto">Foto</label>
                                <input type="file" class="form-control" name="foto_url" id="inputFoto"
                                    value="{{ old('foto_url', $user->foto_url) }}">
                                @error('foto_url')
                                    <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (isset($user->foto_url))
                                <img src="{{ asset("storage/fotos/$user->foto_url") }}" />
                            @endif
                            <div class="form-group">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-success" name="ok">Save</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
    @endsection
