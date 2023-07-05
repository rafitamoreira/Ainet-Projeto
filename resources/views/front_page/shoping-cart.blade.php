@extends('front_layout.template')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <span>Shopping cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Preço</th>
                                    <th>Tamanho</th>
                                    <th>Cor</th>
                                    <th>Quantidade</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (Session::has('cart'))
                                    @foreach ($items as $key => $item)
                                        <tr>
                                            {{-- <td class="cart__product__item">
                                                <img src="img/shop-cart/cp-3.jpg" alt="">
                                                <div class="cart__product__item__title">
                                                    <h6>Black jean</h6>
                                                    <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                            </td> --}}
                                            <td class="shoping__cart__item">

                                                <img @if ($item['item']['customer_id'] == null) src="{{ asset('storage/tshirt_images/' . $item['item']['image_url']) }}"
                                                @else
                                                src="{{ route('estampas.privadas', $item['item']) }}" @endif
                                                    alt="" width="100px">
                                                <h5><a
                                                        href="{{ route('shopdetails', $item['item']['id']) }}">{{ $item['item']['nome'] }}</a>
                                                </h5>
                                            </td>
                                            <td class="cart__price"> {{ $item['price'] / $item['qty'] }}€</td>
                                            <td class="shoping__cart__price">
                                                {{ $item['tamanho'] }}
                                            </td>
                                            <td class="cart__total">@php($cor = App\Models\Color::where('code', $item['cor'])->first())
                                                @if (isset($cor->name))
                                                    {{ $cor->name }}
                                                @endif
                                            </td>
                                            <td class="cart__quantity">
                                                <div class="pro-qty">
                                                    <input type="text" value="1">
                                                </div>
                                            </td>
                                            {{-- <td class="shoping__cart__quantity">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <a
                                                            href="{{ route('editItemFromCart', ['id' => $key, 'operator' => '-']) }}"><span
                                                                class="dec qtybtn">-</span></a>
                                                        <input type="text" value="{{ $item['qty'] }}" disabled>
                                                        <a
                                                            href="{{ route('editItemFromCart', ['id' => $key, 'operator' => '+']) }}"><span
                                                                class="inc qtybtn">+</span></a>
                                                    </div>
                                                </div>
                                            </td> --}}

                                            <td>
                                                {{ $item['price'] }}€
                                            </td>
                                            <td class="cart__close"><a
                                                    href="{{ route('removeFromCart', ['id' => $key]) }}"><span
                                                        class="icon_close"></span></a>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="/product">Continue Shopping</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn update__btn">
                        <a href="#"><span class="icon_loading"></span> Update cart</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 offset-lg-2">
                <div class="cart__total__procced">
                    <h6>Cart total</h6>
                    <ul>
                        <li>Total <span>
                                @if (Session::has('cart')){{ $totalPrice }}
                                @else
                                    0 @endif€
                            </span></li>
                    </ul>
                    <a li href="{{ route('checkout') }}" class="primary-btn"
                        @if (Session::has('cart')) @if ($totalPrice <= 0)
                        style="pointer-events: none;
                        cursor: default;" @endif
                    @else style="pointer-events: none;
                cursor: default;" @endif>Proceed to checkout</a>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Shop Cart Section End -->
@endsection
