@extends('Maestra')

@section('css')
<link rel="stylesheet" href="{{ asset('EasyAutocomplete/easy-autocomplete.min.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Entrada</title>
@endsection

@section('contenido')

@php
$Fecha =date("Y-m-d");
@endphp

<div class="d-flex">
    <h3 class="text-dark">Compras..</h3>
    <div class="px-2">
        <select class="form-select" id="ruta" onchange="autocompletado(value)">
            <option selected disabled>--Seleccione--</option>
            <option value="1"> Ruta A</option>
            <option value="2"> Ruta B</option>
        </select>
    </div>
</div>
<form id="formulario-entrada" method="POST" enctype="multipart/form-data" action="{{ route('agregar-entrada')}}">
    <div class="row g-2">
        @csrf
        <div class="col-md-5 mb-3">
            <label for="txtProveedor">Proveedor</label>
            <select class="form-select " id="txtProveedor" name="idProveedor" required>
                <option selected disabled>--Seleccione--</option>
                @foreach ($proveedores as $proveedor )
                <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5 mb-3">
            <label for="txtFecha">Fecha</label>
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="las la-calendar fs-4"></i></span>
                </div>
                <input type="date" class="form-control " id="txtFecha" name="Fecha" value="{{$Fecha}}">
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <label for="txtFactura">Factura #:</label>
            <input type="text" class="form-control " id="txtFactura" name="Factura" readonly value="{{$Numero['indice'] }}">

        </div>
        <div class="col-md-5 mb-3 ">
            <label for="txtDetalles">Descripcion</label>
            <input type="text" class="form-control" id="txtDetalles" placeholder="Nombre" disabled>
        </div>
        <div class="col-md-1 mb-3">
            <label for="txtStock">Stock</label>
            <input type="text" class="form-control " readonly id="txtStock" placeholder="Stock" disabled>
        </div>
        <div class="col-md-2 mb-3">
            <label for="txtcantidad">Cantidad</label>
            <input type="number" class="form-control " id="txtcantidad" disabled>
        </div>
        <div class="col-md-2 mb-3">
            <label for="txtPrecioVenta">Precio</label>
            <input type="text" class="form-control " id="txtPrecio" disabled>
        </div>
        <div class="col-md-2 mb-3">
            <label for="txtTotal">Total</label>
            <input type="numer" class="form-control " readonly id="txtTotal">
        </div>

        <input type="hidden" class="form-control form-control-sm" name="idUsuario" value="{{Auth::user()->id }}">
        <input type="hidden" class="form-control form-control-sm" id="txtCodigo">
        <input type="hidden" class="form-control form-control-sm" id="txtunidad">
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
                <input class="form-check-input" type="radio" name="Moneda" id="USD" value="USD">
                <label class="form-check-label" for="inlineRadio2">
                    USD</label>
            </div>
        </div>
        <div class="col-12 table-responsive">
            <caption value="">Detalles de la Comra</caption>
            <table class="table table-striped table-hover table-bordered">
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
                        precio: $("#txtDetalles").getSelectedItemData().costo,
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

        $("#txtPrecio").prop('disabled', false);
        $("#txtDetalles").prop('disabled', false);
        $("#txtcantidad").prop('disabled', false);
        $("#txtDetalles").easyAutocomplete(options);

        if (id_ruta == 2) {
            document.querySelector('#USD').checked = true;
        } else {
            document.querySelector('#COL').checked = true;
        }
    }
</script>
<script>
    var total = 0;
    var abono = 0;
    var deuda = 0;
    $(document).ready(function() {
        $('#txtPrecio').keyup(function(e) {
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
                alert(precio);
                if ($('#txtDetalles').val() == '' || parseInt($('#txtTotal').val()) == 0) {
                    Swal.fire(
                        'Error!',
                        'Revisa los datos.!',
                        'warning'
                    );
                } else {

                    total += pxc;
                    $('#valor-suma').val(total.toFixed(2));
                    $('#valor-total').val(total.toFixed(2));
                    sumar();
                    agregarfila();
                    $('#txtTotal').val(0);
                    $('#txtcantidad').val(0);
                    $(this).val(0);

                }
            };
        });

    });

    $('#btn-submit').click(function(e) {
        e.preventDefault();

        if ($("input[name='Codigo[]']").val() == null || $('#txtProveedor').val() == null) {
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
                )
                let fila = $(this).parents("tr");
                let valor = fila.find(".monto-total").val();
                console.log(total);
                total -= valor.replace(',', '');
                $('#valor-suma').val(total);
                $('#valor-total').val(total);
                restar(fila);
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
            Precio: $('#txtPrecio').val(),
            txtTotal: $('#txtTotal').val(),

        };
        let tabla = $('#table-body').html();
        let llenado = '<tr><td><a class="btn btn-danger tabla-borra"><i class="las la-trash fs-5"></i></a></td><td><input type="text"  readonly class="form-control-plaintext " value="' + datos.Detalles + '"></td><td class="d-none" ><input type="text" name="Codigo[]" readonly class="form-control-plaintext sumar-codigo " value="' + datos.Codigo + '"></td><td><input type="text" name="Cantidad[]" readonly class="form-control-plaintext monto-cantidad" value="' + datos.Cantidad + '"></td><td><input type="text" readonly class="form-control-plaintext monto-cantidad" value="' + datos.Unidad + '"></td><td><input type="text" name="Precio[]" readonly class="form-control-plaintext" value="' + datos.Precio + '"></td><td><input type="text" name="Total[]" readonly class="form-control-plaintext monto-total" value="' + datos.txtTotal + '"></td></tr>';
        $('#table-body').html(tabla + llenado);
        limpiar();
    }

    function guardar() {

        var vf = parseInt($('#txtFactura').val());
        let url = $('#formulario-entrada').attr('action');
        let datos = $('#formulario-entrada').serialize();

        console.log(datos);
        $.ajax({
            type: 'POST',
            url: url,
            data: datos,
            dataType: 'json',
            success: function(response) {
                console.log(response.Mensaje);
                limpiarTabla();
                vf++;
                $('#txtFactura').val(vf);
                Swal.fire(
                    'Guardado!',
                    'La factura ha sido cargada',
                    'success'
                );

            },
            error: function(response) {
                console.log(response.Mensaje);
                Swal.fire(
                    'Error!',
                    'Datos inválidos, inténtalo de nuevo',
                    'error'
                );
            }
        });
    }

    function restar(fila) {
        let nuevaFila = fila,
            nuevaCantidad = nuevaFila.find(".monto-cantidad").val(),
            nuevaCodigo = nuevaFila.find(".sumar-codigo").val();
        dato = {
            Cantidad: nuevaCantidad,
        };

        var urlsumar = "{{route('restar.salida',['codigo'])}}";
        urlsumar = urlsumar.replace('codigo', nuevaCodigo);

        $.ajax({
            type: 'GET',
            url: urlsumar,
            data: dato,
            dataType: 'json',
            success: function(response) {
                console.log(response.Mensaje);

            }
        });
    }

    function sumar() {
        let codigo = $('#txtCodigo').val(),
            dato = {
                Cantidad: $('#txtcantidad').val(),
            };
        let urlrestar = "{{route('sumar.entrada',['codigo'])}}";
        urlrestar = urlrestar.replace('codigo', codigo);
        console.log(dato.Cantidad);
        $.ajax({
            type: 'GET',
            url: urlrestar,
            data: dato,
            dataType: 'json',
            success: function(response) {
                console.log(response.Mensaje);

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
        /*   console.log(datos); */
        if (Cantidad[0] >= 0) {
            Swal.fire({
                title: 'Seguro?',
                text: "Borrar los detalles restará los productos  !",
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
                        url: "{{route('devolver.entrada')}}",
                        data: datos,
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            limpiarTabla();
                        },
                        error: function(response) {
                            console.log(response);
                            Swal.fire(
                                'Error!',
                                'Algo ocurrió en la resta de inventario ',
                                'error'
                            );
                        }
                    });

                }
            });
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
</script>
@endsection