@extends('Maestra')

@section('css')

<link rel="stylesheet" href="{{ asset('EasyAutocomplete/easy-autocomplete.min.css') }}">
<title>Proveedores</title>
@endsection

@section('contenido')

<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Pedidos</li>
    </ol>
</div>
<div>
    @if ( session('success') )
    <div class="alert alert-success" role="alert">
        <strong>Felicidades!</strong> {{ session('success') }}
    </div>
    @endif
    @if ( session('error') )
    <div class="alert alert-danger" role="alert">
        <strong>Error!</strong> {{ session('error') }}
    </div>
    @endif
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item pedidos-pestañas" role="presentation">
            <button class="nav-link active w-100" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Todos</button>
        </li>
        <li class="nav-item pedidos-pestañas" role="presentation">
            <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Consultar</button>
        </li>
        <li class="nav-item pedidos-pestañas" role="presentation">
            <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Agregar</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active mt-3" id="home" role="tabpanel" aria-labelledby="home-tab">

            <div class="consulta-total">
                <div class="row g-3 mb-3 mt-3">
                    <div class="col">
                        <label for="FechaInicio1">Fecha Inicio</label>
                        <input type="date" class="form-control" id="FechaInicio1" placeholder="First name" aria-label="First name">
                    </div>
                    <div class="col">
                        <label for="FechaFin1">Fecha Fin</label>
                        <input type="date" class="form-control" id="FechaFin1" placeholder="Last name" aria-label="Last name">
                    </div>
                </div>
                <div class="text-center mb-3">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-primary" onclick="buscarAll()"><i class="las la-crosshairs fs-4"></i></button>
                        <button type="button" class="btn btn-primary" onclick="Allpdf()"><i class="las la-file-pdf fs-4"></i></button>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div role="status" id="cargando-total">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div id="total-pedido"></div>

        </div>
        <div class="tab-pane fade " id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="consulta-pedidos">
                <div class="row g-3 mb-3 mt-3">
                    <div class="col">
                        <label for="FechaInicio">Fecha Inicio</label>
                        <input type="date" class="form-control" id="FechaInicio" placeholder="First name" aria-label="First name">
                    </div>
                    <div class="col">
                        <label for="FechaFin">Fecha Fin</label>
                        <input type="date" class="form-control" id="FechaFin" placeholder="Last name" aria-label="Last name">
                    </div>
                </div>
                <div class="text-center">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-primary" onclick="buscar()"><i class="las la-crosshairs fs-4"></i></button>
                        <button type="button" class="btn btn-primary" onclick="buscarPDF()"><i class="las la-file-pdf fs-4"></i></button>
                    </div>
                </div>
            </div>
            <div class="consulta-tabla">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody id="tabla">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total ;</td>
                            <td></td>
                            <td id="tCantidad"></td>
                            <td>Costo estimado <span id="tCosto"></span></td>

                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="tab-pane fade  justify-content-center px-md-5" id="contact" role="tabpanel" aria-labelledby="contact-tab">

            <form class="mt-3 formulario-pedidos" action="{{route('pedidos.agregar')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user" value="{{Auth::user()->id }}">
                <input type="hidden" name="numero" value="{{$Numero['indice'] }}">
                <input type="hidden" id="txtCodigo">
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Cliente</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="txtCliente" placeholder="Nombre" name="Cliente">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Fecha del Pedido:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="Fecha" name="Fecha">
                    </div>
                </div>
                <div class="row g-2">

                    <div class="col-md-5 mb-3 ">
                        <label for="txtDetalles">Descripcion</label>
                        <input type="text" class="form-control w-100" id="txtDetalles" placeholder="Nombre">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="txtcantidad">Cantidad</label>
                        <input type="number" class="form-control " id="txtcantidad">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="txtPrecioVenta">Precio</label>
                        <input type="number" class="form-control " id="txtPrecioVenta">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="txtTotal">Total</label>
                        <input type="numer" class="form-control " readonly id="txtTotal">
                    </div>
                    <div class="col-md-12 mb-3">
                        <div>

                            <caption value="">Detalles de la venta</caption>
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th class="h6">#</th>
                                        <th class="h6 tb-detalles">Detalles</th>
                                        <th class="h6 d-none">Codigo</th>
                                        <th class="h6 tb-cc">Cantidad</th>
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
                    </div>
                    <div class="col-12 ">
                        <div class="row mb-3 text-end justify-content-end">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Subtotal</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control" id="valor-suma" value="0">
                            </div>
                        </div>
                        <div class="row mb-3 text-end justify-content-end">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">%iva :</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control" id="valor-iva" value="0">
                            </div>
                        </div>
                        <div class="row mb-3 text-end justify-content-end">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Total :</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control" id="valor-total" name="valor-total" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3 text-center">
                        <div class="btn-group">
                            <button class="btn-group btn btn-danger"><i class="las la-window-close fs-4"></i></button>
                            <button   class="btn-group btn btn-success" onclick="submit()"><i class="lar la-check-square fs-4"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>



<!-- Modal -->
<!-- <div class="modal fade" id="proveedores-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-none">
                    <input type="text" id="txtId" value="0">
                </div>

                <form id="formulario-proveedores-editar" class="form-row">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault01">Nombre</label>
                            <input type="text" class="form-control" id="txtNombre" placeholder="Nombre" name="Nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault04">Telefono</label>
                            <input type="text" class="form-control" id="txtTelefono" placeholder="Telefono" name="Telefono" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationDefault03">Direccion</label>
                            <input type="text" class="form-control" id="txtDireccion" placeholder="Direccion" name="Direccion" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button class="btn btn-primary" id="btnactualizar">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->

@endsection

@section('js')

<script src="{{ asset('EasyAutocomplete/jquery.easy-autocomplete.min.js') }}"></script>
<script>
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
        $(".formulario-pedidos").submit(function(e) {
            e.preventDefault();
            return false;
        });
        buscarAll();
    });


    $('#txtcantidad').keyup(function(e) {
        e.preventDefault();

        if ($('#txtcantidad').val() != '' && $('#txtPrecioVenta').val() != '' &&  $("#txtDetalles").val() != '') {

            calculo(e);
        }
    });
    $('#txtPrecioVenta').keyup(function(e) {
        e.preventDefault();
        if ($('#txtcantidad').val() != '' && $('#txtPrecioVenta').val() != '' &&  $("#txtDetalles").val() != '') {

            calculo(e);
        }
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
                fila.remove();
            }
        })


    });

    function submit(e) {
        e.preventDefault();
        if ($("input[name='Codigo[]']").val() == null) {
            Swal.fire(
                'Error !',
                'Los Campos están vacios.',
                'error'
            );
        } else {
          /*   $("form").submit(); */
        }
    }

    function calculo(event) {
        let pxc = 0;
        let cantidad = 0;
        let precio = 0;
        let Stock = $('#txtStock').val();
        cantidad = $('#txtcantidad').val();
        precio = $('#txtPrecioVenta').val();
        pxc = cantidad * precio;
        $('#txtTotal').val(pxc.toFixed(2));

        if (event.key == 'Enter') {
            total += pxc;
            $('#valor-suma').val(total.toFixed(2));
            $('#valor-total').val(total.toFixed(2));
            agregarfila();
            limpiar();
        };
    }

    function agregarfila() {

        var datos = {
            Codigo: $('#txtCodigo').val(),
            Detalles: $('#txtDetalles').val(),
            Cantidad: $('#txtcantidad').val(),
            PrecioVenta: $('#txtPrecioVenta').val(),
            txtTotal: $('#txtTotal').val(),

        };
        let tabla = $('#table-body').html();
        let llenado = '<tr><td><a class="btn btn-danger tabla-borra"><i class="las la-trash fs-5"></i></a></td><td><input type="text"  readonly class="form-control-plaintext " name="Detalles[]" value="' + datos.Detalles + '"></td><td class="d-none" ><input type="text" name="Codigo[]" readonly class="form-control-plaintext sumar-codigo " value="' + datos.Codigo + '"></td><td><input type="text" name="Cantidad[]" readonly class="form-control-plaintext monto-cantidad" value="' + datos.Cantidad + '"></td><td><input type="text" name="Precio[]" readonly class="form-control-plaintext" value="' + datos.PrecioVenta + '"></td><td><input type="text" name="Total[]" readonly class="form-control-plaintext monto-total" value="' + datos.txtTotal + '"></td></tr>';
        $('#table-body').html(tabla + llenado);
    }

    function buscarAll() {
        var Fecha1 = '';
        var Fecha2 = '';
        var url = "{{route('pedidos.buscarAll',['fecha1','fecha2'])}}";
        Fecha1 = $('#FechaInicio1').val();
        Fecha2 = $('#FechaFin1').val();

        if (Fecha1 != '' && Fecha2 != '') {
            url = url.replace('fecha1', Fecha1);
            url = url.replace('fecha2', Fecha2);
        }
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            beforeSend: function(response) {
                $('#cargando-total').addClass('spinner-border');
            },
            success: function(response) {
                $('#cargando-total').removeClass('spinner-border');
                console.log(response);
                card = '';
                $.each(response, (index, item) => {
                    cardEstado = 'success';
                    if (item.Estado == 'Procesada') {
                        cardEstado = 'danger';
                    }
                    card += '   <div class="card mb-3" >\
                <div class="row g-0">\
                    <div class="col-md-2 bg-' + cardEstado + '">\
                        <div class="d-flex justify-content-center align-items-center h-100">\
                        <i class="las la-exclamation fs-1"></i>\
                        </div>\
                    </div>\
                    <div class="col-md-8">\
                        <div class="card-body">\
                            <h5 class="card-title">Para <span>' + item.Cliente + '</span></h5>\
                            <p class="card-text">Monto estimado =</p>\
                            <p class="card-text"> <small class="text-muted">Fecha ; ' + item.Fecha + '</small></p>\
                        </div>\
                    </div>\
                    <div class="col-md-2 d-flex justify-content-center align-items-center">\
                        <a class="btn btn-warning " href="../public/pedidos/actualizar/' + item.id + '"><i class="las la-external-link-alt fs-2"></i></a>\
                    </div>\
                </div>\
            </div>';
                });

                $('#total-pedido').html(card);

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

    function Allpdf() {
        var Fecha1 = '';
        var Fecha2 = '';
        var url = "{{route('pedidos.buscarAllPdf',['fecha1','fecha2'])}}";

        Fecha1 = $('#FechaInicio1').val();
        Fecha2 = $('#FechaFin1').val();
        if (Fecha1 != '' && Fecha2 != '') {
            url = url.replace('fecha1', Fecha1);
            url = url.replace('fecha2', Fecha2);

            window.open(url, '_blank');
        } else {
            window.open(url, '_blank');

        }
    }

    function buscar() {
        var Fecha1 = '';
        var Fecha2 = '';
        var url = "{{route('pedidos.buscar',['fecha1','fecha2'])}}";
        Fecha1 = $('#FechaInicio').val();
        Fecha2 = $('#FechaFin').val();

        if (Fecha1 != '' && Fecha2 != '') {
            url = url.replace('fecha1', Fecha1);
            url = url.replace('fecha2', Fecha2);
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    var contenido = '',
                        tCantidad = 0,
                        Costo = 0;


                    $.each(response, (index, item) => {
                        tCantidad += item.Cantidad;
                        Costo += item.Total;

                        contenido += '<tr><td>' + index + '</td><td>' + item.DetallesTem + '</td><td>' + item.Cantidad + '</td><td>' + item.Total.toLocaleString('en-US',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td><td><a href="../cobranza/zona/detalles/' + item.clientesid + '/' + item.id + '" class="btn btn-info text-white">ver</a></td></tr>';

                        console.log(contenido);
                    });

                    $('#tabla').html(contenido);
                    $('#tCantidad').text(tCantidad);
                    $('#tCosto').text(Costo.toLocaleString('en-US',{minimumFractionDigits: 2, maximumFractionDigits: 2}))

                },
                error: function(response) {
                    Swal.fire(
                        'Error!',
                        'No hay datos.',
                        'error'
                    );
                }
            });
        } else {

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    var contenido = '',
                        tCantidad = 0,
                        Costo = 0;


                    $.each(response, (index, item) => {
                        tCantidad += item.Cantidad;
                        Costo += item.Total;

                        contenido += '<tr><td>' + index + '</td><td>' + item.DetallesTem + '</td><td>' + item.Cantidad + '</td><td>' + item.Total.toLocaleString('en-US',{minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</td><td><a href="../cobranza/zona/detalles/' + item.clientesid + '/' + item.id + '" class="btn btn-info text-white">ver</a></td></tr>';
                    });

                    $('#tabla').html(contenido);
                    $('#tCantidad').text(tCantidad);
                    $('#tCosto').text(Costo.toLocaleString('en-US',{minimumFractionDigits: 2, maximumFractionDigits: 2}))

                },
                error: function(response) {
                    Swal.fire(
                        'Error!',
                        'No hay nada',
                        'error'
                    );
                }
            });
        }



    }

    function buscarPDF() {
        var Fecha1 = '';
        var Fecha2 = '';
        var url = "{{route('pedidos.buscarPdf',['fecha1','fecha2'])}}";

        Fecha1 = $('#FechaInicio').val();
        Fecha2 = $('#FechaFin').val();
        if (Fecha1 != '' && Fecha2 != '') {
            url = url.replace('fecha1', Fecha1);
            url = url.replace('fecha2', Fecha2);

            window.open(url, '_blank');
        } else {
            window.open(url, '_blank');

        }
    }

    function limpiar() {
        $('#txtCodigo').val('');
        $('#txtDetalles').val('').focus();
        $('#txtcantidad').val('');
        $('#txtPrecioVenta').val('');
        $('#txtTotal').val('');

    }
</script>
@endsection