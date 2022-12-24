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
        <div>
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div class="col-12 col-md-6 ">
        <div class="w-100 border p-3">
            <h5 class="mb-1 text-center fw-bold">VENTAS </h5>
            <h6 class="mb-1">Canceladas</h6>
            <p class="mb-1">COL $ <span id="contadoA"></span> | USD $ <span id="creditoA"></span> </p>
            <h6 class="mb-1">Crédito </h6>
            <p class="mb-2">COL $ <span id="contadoB"></span> | USD $ <span id="creditoB"></span></p>
            <h5 class="mb-1 text-center fw-bold">INVENTARIO </h5>
            <p class="mb-2">El monto de productos existentes COL <span id="inventario"></span> </p>
            <h5 class="mb-2 text-center fw-bold">ÚLTIMOS PEDIDOS </h5>
            <div id="pedidos" class="px-4">

            </div>
        </div>
    </div>
    <div>
        <div class="d-flex justify-content-center">
            <div class="" role="status" id="spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</div>
<script>
    var capital = [];
    $(document).ready(function() {
        cargarventas();

    });

    function cargarventas() {
        $.ajax({
            type: 'GET',
            url: "{{route('home.ventas')}}",
            dataType: 'json',
            success: function(response) {
                console.log(response);
                $('#contadoA').html(response.ventas[0].TotalA.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
                $('#contadoB').html(response.ventas[1].TotalA.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
                $('#creditoA').html(response.ventas[0].TotalB.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
                $('#creditoB').html(response.ventas[1].TotalB.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
                $('#inventario').html(response.inventario[0].Inventario.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
                capital.push(response.inventario[0].Inventario);
                datoCobranza();
                console.log(capital);
            }
        });
    }

    function datoCobranza() {
        $.ajax({
            type: 'GET',
            url: "{{route('home.grafico')}}",
            dataType: 'json',
            beforeSend: function(response) {
                $('#spinner').addClass('spinner-border');
            },
            success: function(response) {
                capital.push(response.grafico[0].CobranzaA);
                capital.push(response.grafico[0].CobranzaB);
                console.log(capital);

                grafico();
                lista = '';
                $('#spinner').removeClass('spinner-border')
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

    function grafico() {
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Inventario', 'CobranzaCOL', 'CobranzaUSD'],
                datasets: [{
                    data: capital,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            }
        });
    }
</script>

@endsection