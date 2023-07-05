@extends('front_layout.template')


@section('content')
    <style>
        .button-categories {
            background-color: rgb(237, 237, 237);
            text-align: center;
            margin: 3px;
            border: none;
            padding: 3px;
            font-size: 14px;
            border-radius: 50px;

        }

        .button-categories:hover,
        .button-categores:focus {
            opacity: .75;
        }
    </style>



    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="../"><i class="fa fa-home"></i> Home</a>
                        <span>Products</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Section Begin -->


    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="shop__sidebar">
                        <div class="sidebar__categories">
                            @isset($search)
                                <div class="section-title">
                                    <h4>Pesquisa: {{ $search }}</h4>
                                </div>
                            @endisset
                            <div class="section-title">
                                <h4>Categories</h4>
                            </div>
                            <ul>
                                <form id="filterForm" method="GET" action="{{ route('product.index') }}">
                                    @foreach ($categories as $category)
                                        <button type="submit" name="id" class="button-categories"
                                            {{ $filterByCategoria == $category->id ? 'selected' : '' }}
                                            value="{{ $category->id }}">{{ $category->name }}</button>
                                    @endforeach
                                </form>
                            </ul>
                            <div class="categories__accordion">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-heading active">

                                        </div>
                                        <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                            <div class="card-body">

                                                {{-- <form id="filterForm" method="GET" action="{{ route('product.index') }}">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <select class="form-select btn btn-dark" name="id"
                                                                id="categorySelect" style="font-size: 29px">
                                                                <option {{ $filterByCategoria === '' ? 'selected' : '' }}
                                                                    value="">Todas as Categorias</option>
                                                                @foreach ($categories as $category)
                                                                    <option
                                                                        {{ $filterByCategoria == $category->id ? 'selected' : '' }}
                                                                        value="{{ $category->id }}">{{ $category->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <div class="mb-3 me-2 flex-grow-1 ">
                                                                <input type="text" class="btn btn-dark"
                                                                    style="font-size: 29px ; border: 1px solid white;width: 100% ;"
                                                                    placeholder="Nome" class="form-control" name="nome"
                                                                    id="inputNome" value="{{ $filterByNome }}">
                                                            </div> 
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <button type="submit" class="btn btn-dark"
                                                                style="font-size: 29px ; width: 100%">Search</button>
                                                        </div>
                                                    </div>
                                                </form> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg"
                                        data-setbg="{{ asset("storage/tshirt_images/$product->image_url") }}">
                                        <ul class="product__hover">
                                            <li><a href="{{ asset("storage/tshirt_images/$product->image_url") }}"
                                                    class="image-popup"><span class="arrow_expand"></span></a></li>
                                            <li><a href="/product/{{ $product->id }}"><span
                                                        class="icon_search_alt"></span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="/product/{{ $product->id }}">{{ $product->name }}</a></h6>
                                        <div class="product__price">
                                            @if ($product->customer_id == null)
                                                <h5>{{ $price }}€</h5>
                                            @else
                                                <h5>{{ $preco }}€</h5>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-lg-12 text-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
@endsection
