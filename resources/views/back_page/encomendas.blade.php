@extends('back_layout.template')
@section('content')
    <!-- Begin Page Content -->

    <div class="app-wrapper">

        <style>
            div .p {
                position: absolute;
                top: 30%;
                left: 55%;
                transform: translate(-50%, -50%);
                width: 80%;
                height: 50%;
            }
        </style>

        <!-- DataTales Example -->
        <div class="p">
            <div class="app-content pt-3 p-md-3 p-lg-4 mt-5">
                @include('back_layout.flash-message')
                <div class="container-xl">
                    <div class="row g-3 mb-4 align-items-center justify-content-between">
                        <h1 class="app-page-title mb-0">Lista de encomendas</h1>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('encomendas.create') }}"><button type="button" class="btn btn-success"
                                style="position: relative;margin-bottom: 17px;"> Criar Encomenda</button></a>
                        <form form action="{{ route('encomendas.index') }}" method="GET" role="search"
                            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <select name="status" id="status">
                                    <option value="*">Todos</option>
                                    <option value="pending" {{ old('status', $status) == 'pending' ? 'selected' : '' }}>
                                        Pendente
                                    </option>
                                    <option value="paid" {{ old('status', $status) == 'paid' ? 'selected' : '' }}>Paga
                                    </option>
                                    @if (Auth::User()->status != 'E')
                                        <option value="closed" {{ old('status', $status) == 'closed' ? 'selected' : '' }}>
                                            Fechada
                                        </option>
                                        <option value="canceled"
                                            {{ old('status', $status) == 'canceled' ? 'selected' : '' }}>
                                            Anulada
                                        </option>
                                    @endif
                                </select>
                                @if (Auth::User()->status == 'A')
                                    <select name="data" id="data">
                                        @foreach (range(date('Y') - 3, date('Y')) as $y)
                                            <option value="{{ $y }}"
                                                @if ($data == $y) selected @endif>
                                                {{ $y }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="cell">Numero de Encomenda</th>
                                        <th class="cell">Data</th>
                                        <th class="cell">Ref</th>
                                        <th class="cell">Preço</th>
                                        <th class="cell">Estado</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="cell">Numero de Encomenda</th>
                                        <th class="cell">Data</th>
                                        <th class="cell">Ref</th>
                                        <th class="cell">Preço</th>
                                        <th class="cell">Estado</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="cell">{{ $order->customer_id }}</td>
                                            <td class="cell">{{ $order->date }}</td>
                                            <td class="cell">{{ $order->payment_ref }}</td>
                                            <td class="cell">{{ $order->total_price }}</td>
                                            <td class="cell">{{ $order->status }}</td>
                                            <td style="vertical-align: middle;">
                                                <a href="{{ route('encomendas.show', ['encomenda' => $order->id]) }}"
                                                    class="btn btn-primary btn-sm" role="button"
                                                    aria-pressed="true">Ver</a>
                                            </td>
                                            <td class="cell">
                                                <a href="{{ route('encomendas.edit', ['encomenda' => $order->id]) }}"
                                                    class="btn btn-primary btn-sm" role="button"
                                                    aria-pressed="true">Alterar</a>
                                            </td>
                                            <td class="cell">
                                                <form
                                                    action="{{ route('encomendas.destroy', ['encomenda' => $order->id]) }}"
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
                            {{ $orders->appends(request()->query())->links() }}
                        </div>

                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
    @endsection
