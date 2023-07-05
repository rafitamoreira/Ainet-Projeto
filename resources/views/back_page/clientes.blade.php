@extends('back_layout.template')
@section('content')
    <!-- Begin Page Content -->

    <div class="app-wrapper">

        <!-- DataTales Example -->

        <div class="app-content pt-3 p-md-3 p-lg-4 mt-5">
            @include('back_layout.flash-message')
            <div class="container-xl">
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0">Clientes</h1>
                    </div>
                    <form action="{{ route('admin.clientes.search') }}" method="GET"
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input class="form-control search-input w-auto" type="text" name="search" placeholder="Nome"
                                value="{{ request('search') }}">
                            <button class="btn app-btn-secondary" type="submit">Procurar</button>
                        </div>
                    </form>
                    <div class="app-card-body">
                        {{-- <a href="{{ route('clientes.create') }}"><button type="button" class="btn btn-success" style="position: relative;margin-bottom: 17px;"> Criar Cliente</button></a>  --}}
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="cell">Numero de Cliente</th>
                                        <th class="cell">Nome do Cliente</th>
                                        <th class="cell">Nif</th>
                                        <th class="cell">Endereço</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="cell">Numero de Cliente</th>
                                        <th class="cell">Nome do Cliente</th>
                                        <th class="cell">Nif</th>
                                        <th class="cell">Endereço</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                            @if ($cliente->user != null)
                                                <td class="cell"><a
                                                        href="{{ route('users.edit', ['user' => $cliente->id]) }}">{{ $cliente->id }}</a>
                                                </td>

                                                <td class="cell">{{ $cliente->user->name }}</td>
                                            @else
                                                <td class="cell">{{ $cliente->id }}</td>
                                                <td class="cell"></td>
                                            @endif
                                            <td class="cell">{{ $cliente->nif }}</td>
                                            <td class="cell">{{ $cliente->address }}</td>
                                            <td class="cell">
                                                <a href="{{ route('clientes.show', ['cliente' => $cliente->id]) }}"
                                                    class="btn btn-primary btn-sm" role="button"
                                                    aria-pressed="true">Ver</a>
                                            </td>
                                            {{-- <td style="vertical-align: middle;">
                                                    <a href="{{route('clientes.edit', ['cliente' => $cliente->id])}}"
                                                        class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
                                                </td> --}}
                                            <td class="cell">
                                                <form action="{{ route('clientes.destroy', ['cliente' => $cliente->id]) }}"
                                                    method="POST">
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
                        <div class="col-12 d-flex justify-content-center pt-4" class="li: { list-style: none; }">
                            {{ $clientes->links() }}
                        </div>

                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
    @endsection
