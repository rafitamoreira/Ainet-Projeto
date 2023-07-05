@extends('front_layout.template')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="../"><i class="fa fa-home"></i> Home</a>
                        <a href="./">Products</a>
                        <span>{{ $product->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <form method="GET" action="{{ route('addToCart', ['id' => $product->id]) }}">
                <div class="row">
                    <div class="col-lg-6">
                        <input id="image_url" hidden value="{{ $product->image_url }}">
                        <div class="product__details__pic">
                            <div class="product__details__slider__content">
                                <div class="product__details__pic__slider owl-carousel">

                                    <img data-hash="product-1" class="product__big__img"
                                        @if ($product->customer_id == null) src="{{ asset("storage/tshirt_images/$product->image_url") }}"
                                    @else
                                    src="{{ route('estampas.privadas', $product) }}" id="privada" @endif
                                        alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="product__details__text">
                            <h3>{{ $product->name }}</h3>
                            <div class="product__details__price">
                                @if ($product->customer_id == null)
                                    {{ $preco->unit_price_catalog }}€
                                @else
                                    {{ $preco->unit_price_own }}€
                                @endif

                            </div>
                            <p>{{ $product->description }}</p>
                            <div class="product__details__button">
                                <div class="quantity">
                                    <span>Quantity:</span>
                                    <div class="pro-qty">
                                        <input type="text" value="1">
                                    </div>
                                </div>


                                <button type="submit" href="#" class="cart-btn"><span class="icon_bag_alt"></span>
                                    Add to cart</a>
                            </div>
                            <div class="product__details__widget">
                                <div class="col-12 col-lg-6 ">
                                    <button style="padding: 16px 28px 14px;margin-right: 6px;margin-bottom: 5px;"
                                        onclick="preview()" type="button" class="btn btn-primary btn-block"
                                        data-toggle="modal" data-target="#preview">
                                        Preview
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 d-flex">
                                        <select name="cor" id="cor" class="form-control form-control-lg"
                                            style="padding: 10px; border-radius: 5px; background-color: #f2f2f2; color: #333; margin-right: 10px;">
                                            @foreach ($cores as $cor)
                                                <option value="{{ $cor->code }}">{{ $cor->name }}</option>
                                            @endforeach
                                        </select>

                                        <select name="tamanho" id="tamanho" class="form-control form-control-lg"
                                            style="padding: 10px; border-radius: 5px; background-color: #f2f2f2; color: #333;">
                                            <option value="XS">XS</option>
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="product__details__tab">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tabs-1"
                                            role="tab">Description</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                        <p>{{ $product->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
            </form>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="related__title">
                    <h5>RELATED PRODUCTS</h5>
                </div>
            </div>
            @foreach ($productsRelated as $productRelated)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg"
                            data-setbg="{{ asset("storage/tshirt_images/$productRelated->image_url") }}">
                            <ul class="product__hover">
                                <li><a href="../img/product/related/rp-1.jpg" class="image-popup"><span
                                            class="arrow_expand"></span></a></li>
                                <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">{{ $productRelated->name }}</a></h6>
                            <div class="product__price">
                                @if ($productRelated->customer_id == null)
                                    {{ $preco->unit_price_catalog }}€
                                @else
                                    {{ $preco->unit_price_own }}€
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </section>
    <div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="position: relative; top: 0; left: 0;">
                    <img id="tshirt" src="" style="position: relative; top: 0; left: 0;" />
                    @if ($product->customer_id == null)
                        <img id="tshirtTeste" src="{{ asset("storage/tshirt_images/$product->image_url") }}"
                            style=" position: absolute;top: 18%; left: 34%; width: 35%;" />
                    @else
                        <img src="{{ route('estampas.privadas', $product) }}"
                            style=" position: absolute;top: 18%; left: 34%; width: 35%;" />
                    @endif
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script>
        function preview() {

            var tshirt = document.getElementById("tshirt")
            var tshirtTeste = document.getElementById("tshirtTeste")
            var image_url = document.getElementById("image_url").value

            var cor = document.getElementById("cor").value
            tshirt.src = '{{ asset('storage/tshirt_base/') }}/' + cor + '.jpg'
            tshirtTeste.src = '{{ asset('storage/tshirt_images/') }}/' + image_url
        }
    </script>
@endsection

@endsection
