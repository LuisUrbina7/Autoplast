@extends('Maestra')

@section('css')

<link rel="stylesheet" href="{{ asset('EasyAutocomplete/easy-autocomplete.min.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Proveedores</title>
@endsection

@section('contenido')
<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('pedidos')}}">Pedidos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Procesadas</li>
    </ol>
</div>
@if ( session('success') )
<div class="alert alert-success" role="alert">
    <strong>Felicidades!</strong> {{ session('success') }}
</div>
@endif
<div class="row">
    <div class="col-12">


        <form class="mt-3" id="form-procesar" action="{{route('pedidos.procesar')}}" method="POST" enctype="multipart/form-data">
            @csrf

            @if (!$Numero)
            @php
            $Factura=0;
            @endphp
            @else
            @php

            $Factura=$Numero;
            @endphp
            @endif


            <input type="hidden" name="user" id="idUsuario" value="{{$Dinfo[0]->idUsuario}}">
            <input type="hidden" name="numero" value="{{$Dinfo[0]->id}}">
            <div class="w-100 text-end  justify-content-end mb-3 row">
                <div class="col-3">

                    <label for="Factura">Prox factura:</label>
                    <input readonly type="text" class="form-control" name="Factura" id="Factura" value="{{$Factura+1}}">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Cliente</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control" placeholder="Nombre" value="{{$Dinfo[0]->Cliente}}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Confirmar Cliente :</label>
                <div class="col-sm-10">
                    <select class="form-select form-control-sm" id="txtCliente" name="idCliente" required>
                        <option selected disabled >--General--</option>
                        @foreach ($Clientes as $cliente )
                        <option value="{{$cliente->id}}">{{$cliente->Nombre}} | {{$cliente->Identificador}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Fecha del Pedido:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="Fecha" name="Fecha" value="{{$Dinfo[0]->Fecha}}">
                </div>
            </div>
            @if ($Dinfo[0]->Estado == 'Procesada')
            <div class="row">
                <div class="col-12 text-center mb-3">
                    <span class="bg-danger text-white py-2 px-4  border rounded-43"> Pedido Procesado.</span>
                </div>
                <div class="col-md-5 mb-3 ">
                    <div class="input-group">
                        <label for="txtDetalles">Descripcion</label>
                        <input type="text" disabled class="form-control form-control-sm" id="txtDetalles" placeholder="Nombre">

                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="txtcantidad">Cantidad</label>
                    <input type="number" disabled class="form-control form-control-sm" id="txtcantidad">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="txtPrecioVenta">Precio</label>
                    <input type="text" disabled class="form-control form-control-sm" id="txtPrecioVenta">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="txtTotal">Total</label>
                    <input type="numer" class="form-control form-control-sm" disabled id="txtTotal">
                </div>
                <div class="col-md-12 mb-3">
                    <caption value="">Detalles de la venta</caption>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="h6">#</th>
                                <th class="h6 ">Detalles</th>
                                <th class="h6 d-none">Codigo</th>
                                <th class="h6 c">Cantidad</th>
                                <th class="h6">Precio</th>
                                <th class="h6">Total</th>

                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @php
                            $x=0;
                            @endphp
                            @foreach ($Dinfo as $Detalles )
                            @php
                            $x++;
                            @endphp
                            <tr>
                                <td class="d-none"><input class="form-control idDetalles " type="number" readonly name="Codigo[]" value="{{$Detalles->idProducto}}"></td>
                                <td>{{$x}}</td>
                                <td><input class="form-control" type="text" readonly name="Detalles[]" value="{{$Detalles->DetallesTem }}"></td>
                                <td><input class="form-control" type="number" readonly name="Cantidad[]" value="{{$Detalles->Cantidad }}"> </td>
                                <td><input class="form-control" type="number" readonly name="Precio[]" value="{{$Detalles->Precio }}"></td>
                                <td> <input type="text" readonly name="Total[]" class="form-control monto-total" value="{{$Detalles->Total }}"></td>

                            </tr>

                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td>Subtotal :</td>
                                <td> <input type="text" readonly class="form-control" id="valor-suma" value=""></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>%iva :</td>
                                <td><input type="text" readonly class="form-control" id="valor-iva" value="0"></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>Total :</td>
                                <td><input type="text" readonly class="form-control" id="valor-total" name="valor-total" value=""></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-12 mb-3 text-center">
                    <div class="btn-group">
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-5 row mb-3 ">
                    <label for="txtDetalles">Descripcion</label>
                    <div class="col-10">
                            <input type="text" class="form-control form-control-sm" id="txtDetalles" placeholder="Nombre">
                    </div>
                    <div class="col-2"><a class="btn btn-info py-1" href="{{route('agregar-productos-vista')}}">v</a></div>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="txtcantidad">Cantidad</label>
                    <input type="number" class="form-control form-control-sm" id="txtcantidad">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="txtPrecioVenta">Precio</label>
                    <input type="text" class="form-control form-control-sm" id="txtPrecioVenta">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="txtTotal">Total</label>
                    <input type="numer" class="form-control form-control-sm" readonly id="txtTotal">
                </div>
                <div class="col-md-12 mb-3">
                    <caption value="">Detalles de la venta</caption>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="h6">#</th>
                                <th class="h6 ">Detalles</th>
                                <th class="h6 d-none">Codigo</th>
                                <th class="h6 c">Cantidad</th>
                                <th class="h6">Precio</th>
                                <th class="h6">Total</th>
                                <th class="h6">Borrar</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @php
                            $x=0;
                            @endphp
                            @foreach ($Dinfo as $Detalles )
                            @php
                            $x++;
                            @endphp
                            <tr>
                                <td class="d-none"><input class="form-control d-n" type="number" name="Codigo[]" value="{{$Detalles->idProducto}}"></td>
                                <td class="d-none idDetalles ">{{$Detalles->idDetalles}}</td>
                                <td>{{$x}}</td>
                                <td><input class="form-control" type="text" readonly name="Detalles[]" value="{{$Detalles->DetallesTem }}"></td>
                                <td><input class="form-control itemCantidad" type="number" name="Cantidad[]" value="{{$Detalles->Cantidad }}"> </td>
                                <td><input class="form-control itemPrecio" type="number" name="Precio[]" value="{{$Detalles->Precio }}"></td>
                                <td> <input type="text" readonly name="Total[]" class="form-control monto-total" value="{{$Detalles->Total }}"></td>
                                <td><a class="btn btn-danger tabla-borra">Borrar</a></td>
                            </tr>

                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td>Subtotal :</td>
                                <td> <input type="text" readonly class="form-control" id="valor-suma" value="{{$Dinfo[0]->Monto}}"></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>%iva :</td>
                                <td><input type="text" readonly class="form-control" id="valor-iva" value="0"></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>Total :</td>
                                <td><input type="text" readonly class="form-control" id="valor-total" name="valor-total" value="0"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-12 mb-3 text-center">
                    <div class="btn-group">
                        <button class="btn btn-success" type="button" onclick="procesar()">
                            <span class=" spinner-border-sm" id="btnprocesar" role="status" aria-hidden="true"></span>
                            Procesar a factura
                        </button>

                    </div>
                </div>
            </div>
            @endif

        </form>
    </div>
</div>
@endsection

@section('js')

<script src="{{ asset('EasyAutocomplete/jquery.easy-autocomplete.min.js') }}"></script>
<script>
    var tasa = 1;

    var options = {
        url: function(phrase) {
            return "{{route('autocompletado')}}?nombre=" + phrase;
        },

        getValue: "Detalles",
        list: {

            onSelectItemEvent: function() {
                var value = {
                    precio: $("#txtDetalles").getSelectedItemData().PrecioVenta,
                    codigo: $("#txtDetalles").getSelectedItemData().id,
                }
                $("#txtStock").val(value.texto).trigger("change");
                $("#txtPrecioVenta").val(value.precio).trigger("change");
                $("#txtCodigo").val(value.codigo).trigger("change");
            },
        }
    };

    $("#txtDetalles").easyAutocomplete(options);
</script>
<script>
    var total = 0;
    var abono = 0;
    var deuda = 0;
    $(document).ready(function() {
        sumnarTodo();
        $("form").submit(function(e) {
            e.preventDefault();
            return false;
        });

        $('#txtcantidad').keyup(function(e) {
            e.preventDefault();
            calculo(e);
        });
        $('#txtPrecioVenta').keyup(function(e) {
            e.preventDefault();
            calculo(e);
        });

    });
    $('#table-body').on('click', '.tabla-borra', function(e) {
        total = $('#valor-total').val();
        Swal.fire({
            title: '¿Estas Seguro de Elminar?',
            text: "Se borrará el producto seleccionado!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, borrar!'
        }).then((result) => {
            if (result.isConfirmed) {
                let fila = $(this).parents("tr");
                let valor = fila.find(".monto-total").val();
                let id = fila.find(".idDetalles").html();
                console.log(valor); 
                 borrarElemento(id);
                total -= parseFloat(valor);
                $('#valor-suma').val(total);
                $('#valor-total').val(total);
                fila.remove();
            }
        })


    });
    $('#table-body').on('keyup', '.itemCantidad', function(e) {
        item(this);
    });
    $('#table-body').on('keyup', '.itemPrecio', function(e) {
        item(this);
    });

    function item(item) {
        let fila = $(item).parents("tr");
        let itemCantidad = fila.find(".itemCantidad").val();
        let itemPrecio = fila.find(".itemPrecio").val();
        console.log(itemCantidad);
        fila.find(".monto-total").val(itemCantidad * itemPrecio);
        sumnarTodo() ;
    }

    function sumnarTodo() {
        var sum = 0;
        $('.monto-total').each(function() {
            sum += parseFloat($(this).val().replace(/,/g, ''), 10);
        });
        $('#valor-suma').val(sum);
         $('#valor-total').val(sum);
    }

    function borrarElemento(idDetalles) {
        var urlborrar = "{{route('pedidos.borrarElemento','0')}}";
        var nuevaborrar = urlborrar.replace('0', idDetalles);
        console.log(nuevaborrar);
        $.ajax({
            type: 'GET',
            url: nuevaborrar,
            dataType: 'json',
            success: function(response) {
                Swal.fire(
                    'Borrado!',
                    'Articulo borrado.',
                    'success'
                )
            },
            error: function(response) {
                Swal.fire(
                    'Error!',
                    'No hay datos.',
                    'error'
                );
            }
        });
    }

    function procesar() {
        var urlprocesar = "{{route('pedidos.procesar')}}";
        var datos = $('#form-procesar').serialize();
        console.log($('#txtCliente').val());

if($('#txtCliente').val()!=null){
   
    $.ajax({
        type: 'POST',
        url: urlprocesar,
        data: datos,
        dataType: 'json',
        beforeSend: function(response) {
            $('#btnprocesar').addClass('spinner-border');

        },
        success: function(response) {
            $('#btnprocesar').removeClass('spinner-border');

            if (response.Estado == 'Error') {
                Swal.fire(
                    'Error!',
                    response.Mensaje,
                    'warning'
                )
            }
            if (response.Estado == 'success') {
                Swal.fire(
                    'Excelente!',
                    response.Mensaje,
                    'success'
                )
                window.location.reload() ;
            }
            if (response.resultado) {

                Swal.fire(
                    'Respuesta!',
                    response.resultado,
                    'error'
                )
            }
            console.log(response);
        },
        error: function(response) {
            $('#btnprocesar').removeClass('spinner-border');
            Swal.fire(
                'Error!',
                'No hay datos.',
                'error'
            );
        }
    }); 
}else{
    Swal.fire(
                'Error!',
                'Confirmar cliente.',
                'error'
            );
}
    }
</script>
@endsection