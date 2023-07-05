@extends('back_layout.template')
@section('content')
    <!-- Begin Page Content -->

    <style>
        div .p {
            position: absolute;
            top: 28%;
            left: 57%;
            transform: translate(-50%, -50%);
            width: 85%;
            height: 50%;
        }
    </style>

    <div class="p">

        <!-- DataTales Example -->
        <div class="p">
            <div class="app-content pt-3 p-md-3 p-lg-5">
                @include('back_layout.flash-message')
                <h4 class="m-0 font-weight-bold text-primary">Lista de Categorias</h6>
            </div>
            <div class="card-body">
                @if (Auth::User()->tipo == 'A')
                    <a href="{{ route('categorias.create') }}"><button type="button" class="btn btn-success"
                            style="position: relative;margin-bottom: 17px;"> Criar Categoria</button></a>
                @endif
                <div class="tab-content" id="orders-table-tab-content">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="cell">id</th>
                                <th class="cell">Nome</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="cell">id</th>
                                <th class="cell">Nome</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($categorias as $categoria)
                                <tr>
                                    <td class="cell">{{ $categoria->id }}</td>
                                    <td class="cell">{{ $categoria->name }}</td>
                                    @if (Auth::User()->user_type == 'A')
                                        <td class="cell">
                                            <a href="{{ route('categorias.edit', ['categoria' => $categoria->id]) }}"
                                                class="btn btn-primary btn-sm" role="button"
                                                aria-pressed="true">Alterar</a>
                                        </td>
                                        <td class="cell">
                                            <form
                                                action="{{ route('categorias.destroy', ['categoria' => $categoria->id]) }}"
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
                    {{ $categorias->links() }}
                </div>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
@endsection
