@extends('front_layout.template')

@section('content')
    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="section-title">
                        {{-- <h4>Produto Pesquisado:{{$product->name}}</h4> --}}
                    </div>
                </div>
                <div class="col-lg-8 col-md-8">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">Algumas Estampas</li>
                    </ul>
                </div>
            </div>
            <div class="row property__gallery">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix women">
                        <div class="product__item">
                            <div class="product__item__pic set-bg"
                                data-setbg="{{ asset('storage/tshirt_images/' . $product->image_url) }}">
                                <ul class="product__hover">
                                    <li><a href="{{ asset('storage/tshirt_images/' . $product->image_url) }}"
                                            class="image-popup"><span class="arrow_expand"></span></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="#">{{ $product->name }}</a></h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection
