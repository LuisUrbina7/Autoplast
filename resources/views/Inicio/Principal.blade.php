@extends('Maestra')

@section('css')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<title>Inicio</title>
@endsection

@section('contenido')
<div class="row mb-2 g-2">
    <div class="col-md-4">
        <div class="d-flex g-0 flex-md-row mb-2 shadow bg-danger text-light">
            <div class="col-12 col-md-5 d-none d-lg-block ">
                <div class="d-flex align-items-center justify-content-center h-100 fs-1 ">
                    <i class="las la-users fs-1"></i>
                </div>
            </div>
            <div class="col-12 col-md-7 p-4  ">
                <strong class="d-inline-block mb-2">Usuarios</strong>
                <h3 class="mb-0">@php
                    echo $Usuarios
                    @endphp</h3>
                <p class="badge bg-light mb-0 text-danger">Registros existentes.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row g-0 flex-md-row mb-2 shadow bg-dark text-light">
            <div class="col-12 col-md-5 d-none d-lg-block bg-dark">
                <div class="d-flex align-items-center justify-content-center h-100 fs-1 ">
                    <i class="las la-boxes fs-1"></i>
                </div>
            </div>
            <div class="col-12 col-md-7 p-4  ">
                <strong class="d-inline-block mb-2">Productos</strong>
                <h3 class="mb-0">@php
                    echo $Productos
                    @endphp</h3>

                <p class="badge bg-light text-dark mb-0">Registros existentes</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row g-0  mb-2 shadow bg-info text-light">
            <div class="col-12 col-md-5 d-none d-lg-block bg-info">
                <div class="d-flex align-items-center justify-content-center h-100 fs-1">
                    <i class="las la-people-carry fs-1"></i>
                </div>
            </div>
            <div class="col-12 col-md-7 p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 ">Clientes</strong>
                <h3 class="mb-0">@php
                    echo $Clientes
                    @endphp</h3>
                <p class="badge bg-light text-info mb-0">Registros existentes</p>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-12 col-md-6">
        <canvas id="grafico_barras" width="400" height="400"></canvas>

    </div>
    <div class="col-12 col-md-6">

        <canvas id="grafico_circular" width="400" height="400"></canvas>
    </div>

    <div class="col-12 ">
        <div class="px-5 mt-4">
            <div class="w-100 border p-3">
                <h5 class="mb-1 text-center fw-bold">VENTAS </h5>
                <h6 class="mb-1">Canceladas</h6>
                <p class="mb-1">COL $ <span id="cancelada_col"></span> | USD $ <span id="cancelada_usd"></span> </p>
                <h6 class="mb-1">Crédito </h6>
                <p class="mb-2">COL $ <span id="credito_col"></span> | USD $ <span id="credito_usd"></span></p>
                <h5 class="mb-1 text-center fw-bold">INVENTARIO </h5>
                <p class="mb-2"> RUTA A : El monto de productos existentes COL <span id="inventario_col"></span> </p>
                <p class="mb-2"> RUTA B : El monto de productos existentes USD $ <span id="inventario_usd"></span> </p>

                <h5 class="mb-2 text-center fw-bold">ÚLTIMOS PEDIDOS </h5>
                <div class="d-flex justify-content-center">
                    <div class="" role="status" id="spinner">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="pedidos" class="px-4">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const capital_col = [];
    const capital_usd = [];
    var contado = {
        col: 0,
        usd: 0
    };
    var credito = {
        col: 0,
        usd: 0
    };
    $(document).ready(function() {
        cargarventas();
        facturas();
    });

    function cargarventas() {
        $.ajax({
            type: 'GET',
            url: "{{route('home.ventas')}}",
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (!$.isEmptyObject(response.ventas)) {
                    contado['col'] = response.ventas[0].Cancelada;
                    contado['usd'] = response.ventas[0].Credito;

                    if (!$.isEmptyObject(response.ventas[1])) {
                        credito['col'] = response.ventas[1].Cancelada;
                        credito['usd'] = response.ventas[1].Credito;
                    }

                    $('#cancelada_col').html(contado['col'].toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    $('#cancelada_usd').html(contado['usd'].toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    $('#credito_col').html(credito['col'].toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    $('#credito_usd').html(credito['usd'].toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));

                }
                if (!$.isEmptyObject(response.inventario[0])) {
                    $('#inventario_col').html(response.inventario[0].Inventario.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    capital_col.push(response.inventario[0].Inventario);
                    console.log(response.inventario[0].Inventario);
                }
                if (!$.isEmptyObject(response.inventario[1])) {
                    $('#inventario_usd').html(response.inventario[1].Inventario.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    capital_usd.push(response.inventario[1].Inventario);
                }

                cobranza();
                /*   console.log(capital); */
            }
        });
    }

    function cobranza() {
        $.ajax({
            type: 'GET',
            url: "{{route('home.grafico')}}",
            dataType: 'json',
            beforeSend: function(response) {
                $('#spinner').toggleClass('spinner-border');
            },
            success: function(response) {
                console.log(response);
                capital_col.push(response.grafico[0].CobranzaA);
                capital_usd.push(response.grafico[0].CobranzaB);
                /* console.log(capital); */
                grafico(capital_col);


                lista = '';
                $('#spinner').removeClass('spinner-border');
                $.each(response.data, (index, item) => {

                    lista += ' <div class="d-flex align-items-center justify-content-between border p-3">\
                <div> <p class="mb-0"> <span class="fw-bold">Cliente : </span>' + item.Cliente + ' </p>\
                <p class="mb-0"> <span class="fw-bold">Fecha : </span>' + item.Fecha + ' </p></div>\
                <span class="badge bg-danger"> ' + item.name + '</span>\
            </div>';
                });

                $('#pedidos').html(lista);

            }
        });

    }

    function facturas() {

        $.ajax({
            type: 'GET',
            url: "{{route('home.grafico.barras')}}",
            dataType: 'json',
            success: function(response) {
                grafico_barra(response);
                console.log(response);
            }
        })
    }

    function grafico(data) {
        const ctx = document.getElementById('grafico_circular').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Inventario', 'Cobranza en COL'],
                datasets: [{
                    data: data,
                    backgroundColor: [
                        'rgb(255, 99, 130)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            }
        });
    }

    function grafico_barra(data) {
        const ctx = document.getElementById('grafico_barras').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Salidas', 'Entradas'],
                datasets: [{
                    label: '# Facturas',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        maintainAspectRatio: false,
                        beginAtZero: true
                    }
                }
            }
        });


    }
</script>

@endsection