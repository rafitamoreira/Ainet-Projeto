@extends('back_layout.template')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

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
        <div class="container-fluid">
            <!-- DataTales Example -->
            <div class="container">
                @include('back_layout.flash-message')
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dados da Encomenda</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Numero de encomenda</label>
                        <input type="text" value="{{ $order->id }}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <input type="text" value="{{ $order->status }}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Data de order</label>
                        <input type="text" value="{{ $order->date }}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Valor da order</label>
                        <input type="text" value="{{ $order->total_price }}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Descrição</label>
                        @if ($order->notas == null)
                            <input type="text" value="Sem descrição" class="form-control" disabled>
                        @else
                            <input type="text" value="{{ $order->notes }}" class="form-control" disabled>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Número de cliente</label>
                        <input type="text" value="{{ $order->customer_id }}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Nome do cliente</label>
                        <input type="text" value="{{ $order->customer->user->name }}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Número de Identificação Fiscal</label>
                        <input type="text" value="{{ $order->nif }}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Endereço de envio</label>
                        <input type="text" value="{{ $order->address }}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Tipo de pagamento</label>
                        <input type="text" value="{{ $order->payment_type }}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Referência para pagamento</label>
                        <input type="text" value="{{ $order->payment_ref }}" class="form-control" disabled>
                    </div>
                    @if ($order->estado == 'fechada')
                        <div>
                            <span class="font-weight-bold mb-3">Recibo:</span>
                            <p class="font-weight-normal"><a href="{{ route('minhasorders.show.pdf', $order) }}">Clique
                                    aqui</a></p>
                        </div>
                    @endif
                    <div class="row">
                        <div class="card-body">
                            <span class="font-weight-bold mb-3">encomenda:</span>
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nome Da Estampa</th>
                                        <th>Cor</th>
                                        <th>Tamanho</th>
                                        <th>Quantidade</th>
                                        <th>Preço por Unidade</th>
                                        <th>Preço Total</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($order->Order_item as $tshirt)
                                        @php($estampa = App\Models\Tshirt_image::where('id', $tshirt->id)->first())
                                        @php($cor = App\Models\Color::where('code', $tshirt->color_code)->first())
                                        <tr>
                                            <td>
                                                @if ($estampa != null)
                                                    <img @if ($estampa->cliente_id == null) src="{{ asset('storage/tshirt_images/' . $estampa->image_url) }}"
                                            @else
                                            src="{{ route('tshirt_images_private', $estampa->image_url) }}" @endif
                                                        alt="" width="100px">
                                                @endif
                                            </td>
                                            <td>
                                                @if ($estampa != null)
                                                    {{ $estampa->name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($cor != null)
                                                    {{ $cor->name }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $tshirt->size }}
                                            </td>
                                            <td>
                                                {{ $tshirt->qty }}
                                            </td>
                                            <td>
                                                {{ $tshirt->unit_price }}€
                                            </td>
                                            <td>
                                                {{ $tshirt->sub_total }}€
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        @switch($order->status)
                            @case('pendente')
                                <div class="col-6">
                                    <div class="form-group text-left">
                                        <label>Marcar a encomenda como</label>
                                        <a href="{{ route('encomendas.changeEncomendaEstado', [$encomenda, 1]) }}"
                                            class="btn btn-primary form-control">Pagar Encomenda</a>
                                    </div>
                                </div>
                            @break

                            @case('paga')
                                <div class="col-6">
                                    <div class="form-group text-left">
                                        <label>Marcar a encomenda como</label>
                                        <a href="{{ route('encomendas.changeEncomendaEstado', [$encomenda, 2]) }}"
                                            class="btn btn-primary form-control">Fechar Encomenda</a>
                                    </div>
                                </div>
                            @break

                            @default
                        @endswitch
                        @if ($order->status != 'anulada' && Auth::User()->user_type != 'E')
                            <div class="col-6" style="top: 8px;">
                                <div class="form-group text-right">
                                    <label></label>
                                    <a href="{{ route('encomendas.changeEncomendaEstado', [$order, 3]) }}"
                                        class="btn btn-danger form-control">Anular Encomenda</a>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="form-group text-right">
                        <a href="{{ route('encomendas.index') }}" class="btn btn-primary">Voltar</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
    @endsection
