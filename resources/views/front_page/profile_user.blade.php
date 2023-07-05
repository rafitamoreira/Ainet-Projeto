@extends('front_layout.template')

@section('content')
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <h5>Profile</h5>

                    @if (Auth::user()->photo_url != null)
                        <img src="{{ asset('storage/photos/' . Auth::user()->photo_url) }}" alt="User_Pic"alt="User_Pic"
                            class="rounded-circle" style="width: 100px;" alt="Avatar" style="float: left;">
                    @else
                        <img src="https://icon-library.com/images/default-user-icon/default-user-icon-13.jpg" alt="User_Pic"
                            class="rounded-circle" style="width: 100px;" alt="Avatar" style="float: left;">
                    @endif

                    <form method="POST" action="{{ route('profile_update', $user) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Name <span>*</span></p>
                                    <input type="text" class="form-control" value="{{ $user->name }}" name="name"
                                        id="name" placeholder="Enter full name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Email <span>*</span></p>
                                    <input type="email" class="form-control" value="{{ $user->email }}" name="email"
                                        id="email" placeholder="Enter email" readonly>
                                </div>
                            </div>
                            @if (Auth::User()->customer != null)
                                <div class="col-lg-12">
                                    <div class="checkout__form__input">
                                        <label for="website">Morada</label>
                                        <input type="text" class="form-control" value="{{ $user->customer->address }}"
                                            id="endereco" name="endereco" placeholder="Enter adress">
                                    </div>
                                    <div class="checkout__form__input">
                                        <label for="phone">NIF</label>
                                        <input type="text" class="form-control" value="{{ $user->customer->nif }}"
                                            name="nif" id="nif" placeholder="Enter NIF">
                                    </div>
                                @else
                                    <div class="col-lg-12">
                                        <div class="checkout__form__input">
                                            <label for="website" hidden>Morada</label>
                                            <input type="text" class="form-control" value="" id="endereco"
                                                name="endereco" placeholder="Enter address" hidden>
                                        </div>
                                        <div class="checkout__form__input">
                                            <label for="phone" hidden>NIF</label>
                                            <input type="text" class="form-control" value="" name="nif"
                                                id="nif" placeholder="Enter NIF" hidden>
                                        </div>
                                    </div>
                            @endif
                            <div class="form-group">
                                <label for="phone">Alterar Imagem</label>
                                <input type="file" class="form-control" name="img" id="img"
                                    placeholder="Enter photo">
                            </div>
                            <div class="checkout__form__input">
                                <label for="phone">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Enter password">
                            </div>
                            <div class="checkout__form__input">
                                <label for="phone">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="password_confirmation" placeholder="Enter password again">
                            </div>
                            <div class="col-lg-20 col-md-6 col-sm-6">
                                <div class="text-right">
                                    <button type="submit" id="submit" name="submit"
                                        class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
