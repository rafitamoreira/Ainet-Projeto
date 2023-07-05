@extends('back_layout.template')

@section('content')
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
    <div class="app-wrapper">

        <!-- DataTales Example -->
        <div class="p">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Editar order</h6>
            </div>
            <div class="card-body">
                @include('back_layout.flash-message')
                <form method="POST" action="{{ route('encomendas.update', $order) }}" class="form-group">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label>Numero de order</label>
                        <input type="text" value="{{ $order->id }}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="status">Estado da order</label>
                        <select name="status" id="status" class="form-control">
                            <option value="paid" {{ old('status', $order->status) == 'paid' ? 'selected' : '' }}>paid
                            </option>
                            <option value="canceled" {{ old('status', $order->status) == 'canceled' ? 'selected' : '' }}>
                                canceled</option>
                            <option value="closed" {{ old('status', $order->status) == 'closed' ? 'selected' : '' }}>
                                closed</option>
                            <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>
                                pending</option>
                            <!-- Opção para o status atual da order -->
                            {{-- <option value="{{ $order->status }}" selected>{{ ucfirst($order->status) }}</option> --}}
                        </select>
                        @error('status')
                            <div class="small text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Valor da order</label>
                        <input type="text" name="valor" value="{{ $order->total_price }}" class="form-control">
                    </div>
                    @error('valor')
                        <div class="small text-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label>Descrição</label>
                        @if ($order->notes == null)
                            <input type="text" name="notes" value="Sem descrição" class="form-control">
                        @else
                            <input type="text" name="notes" value="{{ $order->notes }}" class="form-control">
                        @endif
                    </div>
                    @error('notes')
                        <div class="small text-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label>Número de cliente</label>
                        <input type="text" value="{{ $order->customer_id }}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Nome do cliente</label>
                        @isset($order->customer->user->name)
                            <input type="text" value="{{ $order->customer->user->name }}" class="form-control" disabled>
                        @else
                            <input type="text" value="" class="form-control" disabled>
                        @endisset
                    </div>
                    <div class="form-group">
                        <label>Número de Identificação Fiscal</label>
                        <input type="text" value="{{ $order->nif }}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Endereço de envio</label>
                        <input type="text" name="address" value="{{ $order->address }}" class="form-control">
                    </div>
                    @error('address')
                        <div class="small text-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label>Tipo de pagamento</label>
                        <select name="payment_type" id="payment_type">
                            <option value="VISA" {{ old('estado', $order->payment_type) == 'VISA' ? 'selected' : '' }}>
                                Visa
                            </option>
                            <option value="MC" {{ old('estado', $order->payment_type) == 'MC' ? 'selected' : '' }}>
                                Cartão
                                de crédito</option>
                            <option value="PAYPAL" {{ old('estado', $order->payment_type) == 'PAYPAL' ? 'selected' : '' }}>
                                PayPal</option>
                        </select>
                    </div>
                    @error('payment_type')
                        <div class="small text-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label>Referência para pagamento</label>
                        <input type="text" name="payment_ref" value="{{ $order->payment_ref }}" class="form-control">
                    </div>
                    @error('payment_ref')
                        <div class="small text-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="inputRecibo">Recibo</label>
                        <input type="file" class="form-control" name="receipt_url" id="inputRecibo"
                            value="{{ old('receipt_url', $order->receipt_url) }}">
                        @error('recibo_url')
                            <div class="small text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @if (isset($user->foto_url))
                        <img src="{{ asset("storage/pdf_recibos/$order->receipt_url") }}" />
                    @endif
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success" name="ok">Save</button>
                        <a href="{{ route('encomendas.index') }}" class="btn btn-primary">Voltar</a>
                    </div>
                    @foreach ($errors->all() as $error)
                        <li> {{ $error }} </li>
                    @endforeach
                </form>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
@endsection
