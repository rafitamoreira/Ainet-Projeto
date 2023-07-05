@extends('back_layout.template')
@section('content')
    <style>
        div .p {
            position: absolute;
            top: 30%;
            left: 55%;
            transform: translate(-50%, -50%);
            width: 90%;
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
                        <h1 class="app-page-title mb-0">Tabela de Estampas</h1>
                    </div>
                    <div class="col-auto">
                        <div class="page-utilities">
                        </div>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Categoria</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Foto</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($estampas as $estampa)
                                    <tr>
                                        <td style="vertical-align: middle;">
                                            @if ($estampa->categorias != null)
                                                {{ $estampa->categoeries->name }}
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">{{ $estampa->name }}</td>
                                        <td style="vertical-align: middle;">{{ $estampa->description }}</td>
                                        <td><img @if ($estampa->customer_id == null) src="{{ asset('storage/tshirt_images/' . $estampa->image_url) }}"
                                                    @else
                                                    src="{{ route('estampas.privadas', $estampa) }}" @endif
                                                alt="" width="100px" height="100px">
                                        </td>
                                        @if (Auth::User()->tipo == 'A')
                                            <td style="vertical-align: middle;">
                                                <a href="{{ route('estampas.edit', ['estampa' => $estampa->id]) }}"
                                                    class="btn btn-primary btn-sm" role="button"
                                                    aria-pressed="true">Alterar</a>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <form action="{{ route('estampas.destroy', ['estampa' => $estampa->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 d-flex justify-content-center pt-4" class="li: { list-style: none; }">
                        {{ $estampas->links() }}
                    </div>

                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
@endsection
