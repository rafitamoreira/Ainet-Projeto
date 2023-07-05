@extends('back_layout.template')

@section('content')
    <!-- Begin Page Content -->
    <div class="app-content pt-3 p-md-3 p-lg-4 mt-5">
        @include('back_layout.flash-message')
        <div class="container-xl">
            <!-- Centralizar horizontalmente -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nova Encomenda</h6>
                </div>
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-12 col-lg-6">
                            <form method="POST" action="{{ route('encomendas.store') }}" class="form-group ">
                                @csrf
                                <div class="form-group">
                                    <label for="inputNumeroCliente">Número de Cliente</label>
                                    <input type="text" class="form-control" name="numero" id="inputNumeroCliente"
                                        value="{{ old('numero', $orders->customer_id) }}">
                                    @error('numero')
                                        <div class="small text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputPreco">Valor da encomenda</label>
                                    <input type="text" class="form-control" name="preco" id="inputPreco"
                                        value="{{ old('preco', $orders->total_price) }}">
                                    @error('preco')
                                        <div class="small text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputNotas">Descrição</label>
                                    <input type="text" class="form-control" name="notas" id="inputNotas"
                                        value="{{ old('notas', $orders->notes) }}">
                                    @error('notas')
                                        <div class="small text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if (isset($user->foto_url))
                                    <img src="{{ asset("storage/pdf_recibos/$orders->receipt_url") }}" />
                                @endif
                                <div class="form-group mt-4">
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-success" name="ok">Save</button>
                                        <a href="{{ route('encomendas.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- End of Main Content -->
@endsection
