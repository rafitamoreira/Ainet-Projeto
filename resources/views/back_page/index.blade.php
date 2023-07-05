@extends('back_layout.template')

@section('content')
    <div class="app-wrapper">

        <!-- Inclua o jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <div class="app-content pt-3 p-md-3 p-lg-4">
            @include('back_layout.flash-message')
            <div class="container-xl">

                <h1 class="app-page-title">Overview</h1>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="app-card app-card-stat shadow-sm h-100">
                        <div class="app-card-body p-3 p-lg-4">
                            <h4 class="stats-type mb-1">Total Encomendas</h4>
                            <div class="stats-figure">
                                {{ $encomendas }}
                            </div>
                            <div class="stats-meta text-success">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                                </svg>
                            </div>
                        </div>
                        <!--//app-card-body-->
                        <a class="app-card-link-mask" href="/admin/encomendas"></a>
                    </div>
                    <!--//app-card-->
                </div>
                <!--//col-->


                <div class="col-12 col-md-6 col-lg-3">
                    <div class="app-card app-card-stat shadow-sm h-100">
                        <div class="app-card-body p-3 p-lg-4">
                            <h4 class="stats-type mb-1">Total Users</h4>
                            <div class="stats-figure">{{ $users }}</div>
                            <div class="stats-meta text-success">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z" />
                                </svg>
                            </div>
                        </div>
                        <!--//app-card-body-->
                        <a class="app-card-link-mask" href="/admin/users"></a>
                    </div>
                    <!--//app-card-->
                </div>
                <!--//col-->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="app-card app-card-stat shadow-sm h-100">
                        <div class="app-card-body p-3 p-lg-4">
                            <h4 class="stats-type mb-1">Total Estampas</h4>
                            <div class="stats-figure">{{ $estampas }}</div>
                            <div class="stats-meta">
                            </div>
                        </div>
                        <!--//app-card-body-->
                        <a class="app-card-link-mask" href="/admin/estampas"></a>
                    </div>
                    <!--//app-card-->
                </div>
                <!--//col-->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="app-card app-card-stat shadow-sm h-100">
                        <div class="app-card-body p-3 p-lg-4">
                            <h4 class="stats-type mb-1">Total Customers</h4>
                            <div class="stats-figure">{{ $clientes }}</div>
                        </div>
                        <!--//app-card-body-->
                        <a class="app-card-link-mask" href="/admin/clientes"></a>
                    </div>
                    <!--//app-card-->
                </div>
                <!--//col-->
            </div>
            <!--//row-->
            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-12">
                    <div class="app-card app-card-chart h-100 shadow-sm">
                        <div class="app-card-header p-3">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h4 class="app-card-title">Gráficos</h4>
                                </div>
                            </div>
                            <!--//row-->
                        </div>
                        <!--//app-card-header-->
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="card shadow mb-4">
                                    <h5 class="card-header bg-dark text-light">Receita por Mês</h5>
                                    <div class="card-body">
                                        <canvas id="revenuePerMonth"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="card shadow mb-4">
                                    <h5 class="card-header bg-dark text-light">Pedidos por Mês</h5>
                                    <div class="card-body">
                                        <canvas id="ordersPerMonth"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--//col-->


            <!--//app-wrapper-->
        @section('scripts')
            <script>
                $.ajax({
                    url: "{{ route('statistics.ordersPerMonth') }}",
                    method: 'GET',
                    success: function(data) {
                        var ctx = document.getElementById('ordersPerMonth').getContext('2d');
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.map(function(item) {
                                    return item.month;
                                }),
                                datasets: [{
                                    label: 'Orders per Month',
                                    data: data.map(function(item) {
                                        return item.count;
                                    }),
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }
                });

                $.ajax({
                    url: "{{ route('statistics.revenuePerMonth') }}",
                    method: 'GET',
                    success: function(data) {
                        var ctx = document.getElementById('revenuePerMonth').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.map(function(item) {
                                    return item.month;
                                }),
                                datasets: [{
                                    label: 'Revenue per Month',
                                    data: data.map(function(item) {
                                        return item.total;
                                    }),
                                    backgroundColor: 'rgba(203, 6, 6, 0.2)',
                                    borderColor: 'rgba(203, 6, 6, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }
                });

                $.ajax({
                    url: "{{ route('statistics.registeredUsers') }}",
                    method: 'GET',
                    success: function(data) {
                        $('#registeredUsers').text('Registered Users: ' + data.registered_users);
                    }
                });

                $.ajax({
                    url: "{{ route('statistics.orderStatusCount') }}",
                    method: 'GET',
                    success: function(data) {
                        $('#pendingOrders').text('Orders: ' + data.pending);
                        $('#paidOrders').text('Orders: ' + data.paid);
                        $('#closedOrders').text('Orders: ' + data.closed);
                        $('#canceledOrders').text('Orders: ' + data.canceled);
                    }
                });
            </script>
        @endsection
    @endsection
