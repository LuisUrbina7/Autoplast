@extends('Maestra')

@section('css')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<title>Inicio</title>
@endsection

@section('contenido')
<div class="row mb-2 g-2">
    <div class="col-md-4">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-2 shadow-sm  position-relative">
            <div class="col-12 col-md-5 d-none d-lg-block bg-danger">
                <div class="d-flex align-items-center justify-content-center h-100 fs-1 text-light">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                </div>


            </div>
            <div class="col-12 col-md-7 p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary">Usuarios</strong>
                <h3 class="mb-0">@php
                    echo $Usuarios
                    @endphp</h3>
                <a href="#" class="stretched-link badge bg-danger">Toma un atajo..</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-2 shadow-sm  position-relative">
            <div class="col-12 col-md-5 d-none d-lg-block bg-dark">
                <div class="d-flex align-items-center justify-content-center h-100 fs-1 text-light">
                    <i class="fa fa-linode" aria-hidden="true"></i>
                </div>
            </div>
            <div class="col-12 col-md-7 p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-success">Productos</strong>
                <h3 class="mb-0">@php
                    echo $Productos
                    @endphp</h3>

                <a href="{{route('productos')}}" class="stretched-link badge bg-dark">Toma un atajo..</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-2 shadow-sm  position-relative">
            <div class="col-12 col-md-5 d-none d-lg-block bg-info bg-gradient">
                <div class="d-flex align-items-center justify-content-center h-100 fs-1 text-light">
                    <i class="fa fa-book" aria-hidden="true"></i>
                </div>


            </div>
            <div class="col-12 col-md-7 p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-success">Clientes</strong>
                <h3 class="mb-0">@php
                    echo $Clientes
                    @endphp</h3>
                <a href="{{route('clientes')}}" class="stretched-link badge bg-primary">Toma un atajo..</a>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="h-50">

            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div class="col-12 col-md-6 h-50 px-3">
        <div class="list-group mb-3">
            <a href="#" class="list-group-item text-secondary list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Ventas realizadas a contado. </h5>
                    <small>Hoy</small>
                </div>
                <p class="mb-1">Moneda COL $<span id="contadoA"></span></p>
                <p class="mb-1">Moneda USD $<span id="contadoB"></span></p>
            </a>
            <a href="#" class="list-group-item list-group-item-action text-secondary">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Ventas realizadas a credito.</h5>
                    <small class="text-muted">Hoy</small>
                </div>
                <p class="mb-1">Moneda COL $<span id="creditoA"></span></p>
                <p class="mb-1">Moneda USD $<span id="creditoB"></span></p>
            </a>
        </div>
        <div class="card text-light mb-3" style="background-color: #009ce2c4;">
            <div class="card-header">Inventario</div>
            <div class="card-body">
                <h5 class="card-title">Capital en inventario</h5>
                <p class="card-text">El monto de productos existentes COL <span id="inventario"></span> </p>
            </div>
        </div>
    </div>
    <div>
        <div class="d-flex justify-content-center">
            <div class="" role="status" id="spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div id="pedidos" class="px-4">

        </div>
    </div>
</div>
<script>

</script>
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
                console.log(response.inventario[0].Inventario);
                $('#contadoA').html(response.ventas[0].TotalA.toFixed(2));
                $('#contadoB').html(response.ventas[1].TotalA.toFixed(2));
                $('#creditoA').html(response.ventas[0].TotalB.toFixed(2));
                $('#creditoB').html(response.ventas[1].TotalB.toFixed(2));
                $('#inventario').html(response.inventario[0].Inventario.toFixed(2));
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

                    lista += '<ol class="list-group list-group">\
                        <li class= "list-group-item d-flex justify-content-between align-items-start" >\
                        <div class = "ms-2 me-auto" >\
                        <div class = "fw-bold" >'+item.Cliente + '</div>\
                    '+item.Fecha+' \
                        </div>\
                        <span class= "badge bg-primary rounded-pill" > '+item.name + '</span> \
                        </li>\
                        </ol>';
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
                labels: ['Inventario', 'CobranzaCOL','CobranzaUSD'],
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