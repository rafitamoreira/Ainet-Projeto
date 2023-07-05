@extends('back_layout.template')
@section('content')
    <!-- Begin Page Content -->
    <div class="app-wrapper">

        <!-- DataTales Example -->
        <div class="app-content pt-3 p-md-3 p-lg-4 mt-5">
            @include('back_layout.flash-message')
            <div class="container-xl">
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <h1 class="app-page-title mb-0">Lista de Cores</h1>
                </div>
                <div class="card-body">
                    @if (Auth::User()->tipo == 'A')
                        <a href="{{ route('cores.create') }}"><button type="button" class="btn btn-success"
                                style="position: relative;margin-bottom: 17px;"> Adicionar Cor</button></a>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Código</th>
                                    <th>Imagem da cor</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>Código</th>
                                    <th>Imagem da cor</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($cores as $cor)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $cor->name }}</td>
                                        <td style="vertical-align: middle;">{{ $cor->code }}</td>
                                        <td>
                                            <div
                                                style=" float: left; width: 60px; height: 60px; margin: 5px; border: 1px solid rgba(0, 0, 0, .2); background: #{{ $cor->code }};">
                                            </div>
                                        </td>
                                        @if (Auth::User()->tipo == 'A')
                                            <td>
                                                <a href="{{ route('cores.edit', ['core' => $cor->code]) }}"
                                                    class="btn btn-primary btn-sm" role="button"
                                                    aria-pressed="true">Alterar</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('cores.destroy', ['core' => $cor->code]) }}"
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
                        {{ $cores->links() }}
                    </div>

                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
@endsection
