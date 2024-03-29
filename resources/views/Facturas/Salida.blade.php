@extends('Maestra')

@section('css')
<link rel="stylesheet" href="{{ asset('EasyAutocomplete/easy-autocomplete.min.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Salida</title>
@endsection

@section('contenido')

@php
$Fecha =date("Y-m-d");
@endphp


<div class="d-flex">
    <h3 class="text-dark">Ventas</h3> 
    <div class="px-2">
        <select class="form-select" id="ruta" onchange="autocompletado(value)">
            <option selected disabled>--Seleccione--</option>
            <option value="1" onclick="autocompletado(1)"> Ruta A</option>
            <option value="2" onclick="autocompletado(2)"> Ruta B</option>
        </select>
    </div>
</div>
<form id="formulario-salida" method="POST" enctype="multipart/form-data" action="{{ route('agregar-salida')}}">
    <div class="row g-2">
        @csrf
        <div class="col-md-5 mb-3">
            <label for="txtCliente">Cliente</label>
            <select class="form-select " id="txtCliente" name="idCliente" required>
                <option selected disabled>--Seleccione--</option>
                @foreach ($Clientes as $cliente )
                <option value="{{$cliente->id}}">{{$cliente->nombre}} || {{$cliente->identificador}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5 mb-3">
            <label for="txtFecha">Fecha</label>
            <div class="input-group ">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupPrepend2"><i class="las la-calendar fs-4"></i></span>
                </div>
                <input type="date" class="form-control " id="txtFecha" name="Fecha" value="{{$Fecha}}">
            </div>
        </div>

        <div class="col-md-2 mb-3">
            <label for="txtFactura">Factura #:</label>
            <input type="text" class="form-control " id="txtFactura" name="Factura" readonly value="{{$Numero['indice']}}">

        </div>
        <div class="col-md-5 mb-3 ">
            <label for="txtDetalles">Descripcion</label>
            <input type="text" class="form-control" id="txtDetalles" placeholder="Nombre" disabled>
        </div>
        <div class="col-md-1 mb-3">
            <label for="txtStock">Stock</label>
            <input type="text" class="form-control " readonly id="txtStock" placeholder="Stock">
        </div>
        <div class="col-md-2 mb-3">
            <label for="txtcantidad">Cantidad</label>
            <input type="number" class="form-control " id="txtcantidad" disabled>
        </div>
        <div class="col-md-2 mb-3">
            <label for="txtPrecioVenta">Precio</label>
            <input type="number" class="form-control "  id="txtPrecioVenta" disabled>
        </div>
        <div class="col-md-2 mb-3">
            <label for="txtTotal">Total</label>
            <input type="numer" class="form-control " readonly id="txtTotal">
        </div>

        <input type="hidden" class="form-control" id="txtCodigo">
        <input type="hidden" class="form-control" id="txtunidad">
        <input type="hidden" class="form-control" name="idUsuario" value="{{Auth::user()->id }}">
        <div class="col-6 text-center">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="Estado" id="Debito" value="Debito" onclick="debito()" checked>
                <label class="form-check-label" for="inlineRadio1"><i class="fa fa-money" aria-hidden="true"></i>
                    Pago Debito</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="Estado" id="Credito" value="Credito" onclick="credito()">
                <label class="form-check-label" for="inlineRadio2"><i class="fa fa-credit-card" aria-hidden="true"></i>
                    Pago Credito</label>
            </div>
        </div>
        <div class="col-6 text-center">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="Moneda" id="COL" value="COL" checked>
                <label class="form-check-label" for="inlineRadio1">
                    COL</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="Moneda" id="USD" value="USD" onclick="usd()">
                <label class="form-check-label" for="inlineRadio2">
                    USD</label>
            </div>
        </div>
        <div class="col-12 ">
            <div class="table-responsive">
                <caption value="">Detalles de la venta</caption>
                <table class="table table-striped table-hover table-bordered" id="tabla-salida">
                    <thead>
                        <tr>
                            <th class="h6">#</th>
                            <th class="h6 tb-detalles">Detalles</th>
                            <th class="h6 d-none">Codigo</th>
                            <th class="h6 tb-cc">Cantidad</th>
                            <th class="h6 tb-cc">Unidad</th>
                            <th class="h6">Precio</th>
                            <th class="h6">Total</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                    </tbody>
                    <tfoot>
                        <tr>
                        </tr>

                    </tfoot>
                </table>
            </div>
            <div class="col-12">
                <div class="row mb-3 text-end justify-content-end">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Subtotal</label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control" id="valor-suma" value="0">
                    </div>
                </div>
               <!--  <div class="row mb-3 text-end justify-content-end">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">%iva :</label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control" id="valor-iva" value="0">
                    </div>
                </div> -->
                <div class="row mb-3 text-end justify-content-end">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Total :</label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control" id="valor-total" name="valor-total" value="0">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="text-center">
                <a class="btn btn-danger w-100 mb-2" onclick="devolver()">Cancelar</a>
                <a id="btn-submit" class="btn btn-success w-100 ">Enviar</a>
            </div>


        </div>
        <div class="col-12 col-md-4 text-end">
            <label for="valor-total">Abonado : </label>
            <input type="text" disabled class="form-control" id="valor-abono" name="valor-abono" value="0">
            <hr>
            <label for="valor-total">Deuda : </label>
            <input type="text" readonly class="form-control" id="valor-deuda" value="0">

        </div>
    </div>
</form>

@endsection
@section('js')
<script src="{{ asset('EasyAutocomplete/jquery.easy-autocomplete.min.js') }}"></script>
<script>
    var tasa = 1;
    
    function autocompletado(id_ruta) {
        
        var url_inicial_autocompletado = "{{route('autocompletado',1)}}?nombre=";
        var url_final_autocompletado = url_inicial_autocompletado.replace('1', id_ruta);
        var options = {
            url: function(phrase) {
                return url_final_autocompletado + phrase;
            },

            getValue: "detalles",
            list: {

                onSelectItemEvent: function() {
                    var value = {
                        texto: $("#txtDetalles").getSelectedItemData().stock,
                        precio: $("#txtDetalles").getSelectedItemData().venta,
                        codigo: $("#txtDetalles").getSelectedItemData().id,
                        unidad: $("#txtDetalles").getSelectedItemData().unidad,
                    }

                    $("#txtStock").val(value.texto).trigger("change");
                    if ($('#USD').is(':checked')) {
                        $("#txtPrecioVenta").val((value.precio / tasa).toFixed(2)).trigger("change");
                    } else {
                        $("#txtPrecioVenta").val(value.precio).trigger("change");
                    }

                    $("#txtunidad").val(value.unidad).trigger("change");
                    $("#txtCodigo").val(value.codigo).trigger("change");

                },
            }
        };
     
        $("#txtDetalles").prop('disabled', false);
        $("#txtcantidad").prop('disabled', false);
        $("#txtPrecioVenta").prop('disabled', false);
        $("#txtDetalles").easyAutocomplete(options);
        
        if(id_ruta == 2){
            document.querySelector('#USD').checked = true;
        }else{
            document.querySelector('#COL').checked = true;
        }
    }
</script>
<script>
    var total = 0;
    var abono = 0;
    var deuda = 0;
    $(document).ready(function() {
        sumnarTodo();
        $('#txtcantidad').keyup(function(e) {
            e.preventDefault();
            let pxc = 0;
            let cantidad = 0;
            let precio = 0;
            let Stock = $('#txtStock').val();
            cantidad = $(this).val();
            precio = $('#txtPrecioVenta').val();
            pxc = cantidad * precio;
            $('#txtTotal').val(pxc.toFixed(2));


            if (e.key == 'Enter') {

                if ($('#txtDetalles').val() == '') {
                    Swal.fire(
                        'Error!',
                        'No existe el producto!',
                        'warning'
                    );
                } else {
                  
                    if (parseInt(Stock) < parseInt(cantidad) || parseInt(Stock) == 0) {
                        Swal.fire(
                            'Error!',
                            'La cantidad es mayor!',
                            'error'
                        );
                    } else {
                        total += pxc;
                        $('#valor-suma').val(total.toFixed(2));
                        $('#valor-total').val(total.toFixed(2));
                        restar();
                        agregarfila();
                    }
                }


            };
        });
        $('#txtPrecioVenta').keyup(function(e) {
            e.preventDefault();
            let pxc = 0;
            let cantidad = 0;
            let precio = 0;
            let Stock = $('#txtStock').val();
            cantidad = $('#txtcantidad').val();
            precio = $(this).val();
            pxc = cantidad * precio;
            $('#txtTotal').val(pxc.toFixed(2));


            if (e.key == 'Enter') {

                if ($('#txtDetalles').val() == '') {
                    Swal.fire(
                        'Error!',
                        'No existe el producto!',
                        'warning'
                    );
                } else {
                  
                    if (parseInt(Stock) < parseInt(cantidad) || parseInt(Stock) == 0) {
                        Swal.fire(
                            'Error!',
                            'La cantidad es mayor!',
                            'error'
                        );
                    } else {
                        total += pxc;
                        $('#valor-suma').val(total.toFixed(2));
                        $('#valor-total').val(total.toFixed(2));
                        restar();
                        agregarfila();
                    }
                }


            };
        });

    });

    $('#btn-submit').click(function(e) {
        e.preventDefault();

        if ($("input[name='Codigo[]']").val() == null || $('#txtCliente').val() == null) {
            Swal.fire(
                'Error !',
                'Los Campos están vacios.',
                'error'
            );
        } else {
            guardar();
        }
    });

    $('#valor-abono').keyup(function(e) {
        e.preventDefault();

        abono = $(this).val();
        deuda = total - abono;
        $('#valor-deuda').val(deuda);

    });

    $(document).on('click', '.tabla-borra', function(e) {
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
                Swal.fire(
                    'Borrado!',
                    'Articulo borrado.',
                    'success'
                );
                let fila = $(this).parents("tr");
                let valor = fila.find(".monto-total").val();
                /*     console.log(total); */
                total -= valor.replace(',', '');
                $('#valor-suma').val(total);
                $('#valor-total').val(total);
                sumar(fila);
                fila.remove();
            }
        })


    });

    function credito() {
        $('#valor-abono').prop('disabled', false);
    }

    function debito() {
        $('#valor-abono').prop('disabled', true);
        $('#valor-abono').val(0);
    }

    function agregarfila() {

        var datos = {
            Codigo: $('#txtCodigo').val(),
            Detalles: $('#txtDetalles').val(),
            Cantidad: $('#txtcantidad').val(),
            Unidad: $('#txtunidad').val(),
            PrecioVenta: $('#txtPrecioVenta').val(),
            txtTotal: $('#txtTotal').val(),

        };
        console.log(datos.txtTotal);
        let tabla = $('#table-body').html();
        let llenado = '<tr><td><a class="btn btn-danger tabla-borra"><i class="las la-trash fs-5"></i></a></td><td><input type="text"  readonly class="form-control-plaintext " value="' + datos.Detalles + '"></td><td class="d-none" ><input type="text" name="Codigo[]" readonly class="form-control-plaintext sumar-codigo " value="' + datos.Codigo + '"></td><td><input type="text" name="Cantidad[]" readonly class="form-control-plaintext monto-cantidad" value="' + datos.Cantidad + '"></td><td><input type="text" name="Unidad[]" readonly class="form-control-plaintext" value="' + datos.Unidad + '"></td><td><input type="text" name="Precio[]" readonly class="form-control-plaintext" value="' + datos.PrecioVenta + '"></td><td><input type="text" name="Total[]" readonly class="form-control-plaintext monto-total" value="' + datos.txtTotal + '"></td></tr>';
        $('#table-body').html(tabla + llenado);
        limpiar();
    }

    function guardar() {

        var vf = parseInt($('#txtFactura').val());
        let url = $('#formulario-salida').attr('action');
        let datos = $('#formulario-salida').serialize();



        $.ajax({
            type: 'POST',
            url: url,
            data: datos,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                Swal.fire(
                    'Guardado!',
                    'La factura ha sido cargada',
                    'success'
                );
                vf++;
                $('#txtFactura').val(vf);

                limpiarTabla();
            },
            error: function(response) {
                console.log(response);
                Swal.fire(
                    'Error!',
                    'Datos inválidos, inténtalo de nuevo',
                    'error'
                );
            }
        });
    }

    function sumar(fila) {
        let nuevaFila = fila,
            nuevaCantidad = nuevaFila.find(".monto-cantidad").val(),
            nuevaCodigo = nuevaFila.find(".sumar-codigo").val();
        dato = {
            Cantidad: nuevaCantidad,
        };

        var urlsumar = "{{route('sumar.entrada',['codigo'])}}";
        urlsumar = urlsumar.replace('codigo', nuevaCodigo);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            url: urlsumar,
            data: dato,
            dataType: 'json',
            success: function(response) {
                console.log(response.Mensaje);

            },
            error: function() {
                Swal.fire(
                    'Error!',
                    'Algo ocurrió en la suma de inventario ',
                    'error'
                );
            }
        });
    }

    function restar() {
        let codigo = $('#txtCodigo').val(),
            dato = {
                Cantidad: $('#txtcantidad').val(),
            };
        let urlrestar = "{{route('restar.salida',['codigo'])}}";
        urlrestar = urlrestar.replace('codigo', codigo);
        console.log(dato.Cantidad);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            url: urlrestar,
            data: dato,
            dataType: 'json',
            success: function(response) {
                console.log(response.Mensaje);
                if (response.Estado == 0) {
                    Swal.fire(
                        'Error!',
                        response.Mensaje,
                        'error'
                    );
                }

            },
            error: function() {
                Swal.fire(
                    'Error!',
                    'Algo ocurrió en la resta de inventario ',
                    'error'
                );
            }
        });
    }

    function devolver() {
        let datos = [];
        let Codigo = [];
        let Cantidad = [];
        $(".monto-cantidad").each(function() {
            Cantidad.push($(this).val());
        });
        $(".sumar-codigo").each(function() {
            Codigo.push($(this).val());
        });
        datos = {
            vCantidad: Cantidad,
            vCodigo: Codigo
        };

        if (Cantidad[0] >= 0) {
            Swal.fire({
                title: 'Seguro?',
                text: "Borrar los detalles  regresará los productos !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, quiero hacerlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    $.ajax({
                        type: 'POST',
                        url: "{{route('devolver.salida')}}",
                        data: datos,
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            limpiarTabla();
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Algo ocurrió en la resta de inventario ',
                                'error'
                            );
                        }
                    });

                }
            })

        }
    }

    function limpiar() {
        $('#txtCodigo').val('');
        $('#txtDetalles').val('').focus();
        $('#txtcantidad').val('');
        $('#txtStock').val('');
        $('#txtPrecioVenta').val('');
        $('#txtMontoVendido').val('');
        $('#txtMontoPagado').val('');
        $('#txtTotal').val(0);

    }

    function sumnarTodo() {
        var sum = 0;
        $('.monto-total').each(function() {
            sum += parseFloat($(this).val().replace(/,/g, ''), 10);
        });
        $('#valor-suma').val(sum);
        $('#valor-total').val(sum);
    }

    function limpiarTabla() {
        limpiar();
        $('#valor-suma').val('0');
        $('#valor-total').val('0');
        $('#table-body').each(function() {
            $(this).find('tr').remove();
        });
        total = 0;
    }

    function usd() {
        var vrtasa = parseInt(prompt('Tasa'));
        tasa = vrtasa;
    }
</script>
@endsection