@extends('back_layout.template')
@section('content')
    <!-- Begin Page Content -->
    <style>
        div .p {
            position: absolute;
            top: 30%;
            left: 55%;
            transform: translate(-50%, -50%);
            width: 85%;
            height: 50%;
        }
    </style>

    <div class="app-wrapper">

        <!-- DataTales Example -->
        <div class="app-content pt-3 p-md-3 p-lg-4 mt-5">
            @include('back_layout.flash-message')
            <div class="container-xl">

                <div class="row g-4 mb-4 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0">Users</h1>
                    </div>
                    <div class="text-center">
                        <form action="{{ route('admin.search') }}" method="GET"
                            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input class="form-control search-input w-auto" type="text" name="search"
                                    placeholder="Nome" value="{{ request('search') }}">
                                <button class="btn app-btn-secondary" type="submit">Procurar</button>
                            </div>
                        </form>
                        <form form action="{{ route('users.index') }}" method="GET" role="search"
                            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <select class="form-select w-auto" name="user_type" id="user_type">
                                    <option value="*">Todos</option>
                                    <option value="A" {{ old('user_type', $user_type) == 'A' ? 'selected' : '' }}>
                                        Administrador</option>
                                    <option value="C" {{ old('user_type', $user_type) == 'C' ? 'selected' : '' }}>
                                        Cliente</option>
                                    <option value="E" {{ old('user_type', $user_type) == 'E' ? 'selected' : '' }}>
                                        Funcionario</option>
                                </select>
                                <button type="submit" class="btn app-btn-secondary">Search</button>
                            </div>
                        </form>
                    </div>

                    <!--//row-->
                </div>
                <!--//table-utilities-->
            </div>
            <!--//col-auto-->
        </div>
        <!--//row-->
        <div>
            <a href="{{ route('users.create') }}"><button type="button" class="btn btn-success"
                    style="position: relative;margin-bottom: 17px;"> Criar Utilizador</button></a>

        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Bloqueado</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Bloqueado</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->user_type }}</td>
                            <td>{{ $user->blocked }}</td>
                            <td>
                                @if ($user->tipo != 'C')
                                    <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                        class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
                                @endif
                            </td>
                            <td>
                                @if ($user->user_type == 'C' && $user->blocked == '1')
                                    <a href="{{ route('client_state', ['id' => $user->id]) }}" method="POST"
                                        class="btn btn-success btn-sm" role="button" aria-pressed="true">Desbloquear</a>
                                @elseif ($user->user_type == 'C' && $user->blocked == '0')
                                    <a href="{{ route('client_state', ['id' => $user->id]) }}" method="POST"
                                        class="btn btn-warning btn-sm" role="button" aria-pressed="true">Bloquear</a>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->appends(request()->query())->links() }}
    </div>
    </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
@endsection
