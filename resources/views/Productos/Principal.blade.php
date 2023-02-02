@extends('Maestra')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Productos</title>
@endsection

@section('contenido')
<div aria-label="breadcrumb" class=" d-flex justify-content-between mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Productos</li>
    </ol>
    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modal_importar"><i class="las la-file-csv fs-4"></i></button>
</div>
@if ( session('Excelente') )
<div class="alert alert-success" role="alert">
    <strong>Felicitaciones, </strong>
    Datos agregados correctamente..
</div>
@endif
@if ( session('Error') )
<div class="alert alert-danger" role="alert">
    <strong>Error, </strong>
    ocurrió un error en la carga.
</div>
@endif
<div class="mb-3 row">
    <label class="col-form-label col-sm-2 text-end"> Ingrese la zona : </label>
    <div class="col-sm-5">

        <select class="form-select" onchange="indice_ruta(value)">
            <option value="1" selected>Ruta A (Panamericana) </option>
            <option value="2">Ruta B (Barinas)</option>
        </select>
    </div>
</div>
<table id="example" class="table table-hover" cellspacing="0" style="width:100%">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Detalles</th>
            <th>Stock</th>
            <th>Costo</th>
            <th>Precio</th>
            <th>Unidad</th>
            <th>Proveedor</th>
            <th>Categoria</th>
            <th>op</th>
        </tr>
        </tr>
    </thead>
    <tbody id="tabla-productos">

    </tbody>
    <tfoot>
        <tr class="bg-primary text-white">
            <td colspan="2">Total : </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
        </tr>
    </tfoot>
</table>
<!-- Modal -->
<div class="modal fade" id="productos-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-none">
                    <input type="text" id="txtId" value="0">
                </div>
                <form id="formulario-productos-editar" class="form-row">
                    @csrf
                    <div class="row">

                        <div class="col-md-7 mb-3">
                            <label for="validationDefault01">Descripcion</label>
                            <input type="text" class="form-control" id="txtDetalles" placeholder="Nombre" name="Detalles" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="idUnidad">Unidad :</label>
                            <select class="form-select" id="idUnidad" name="idUnidad">
                                <option value="Millar">--Millar--</option>
                                <option value="Tiras">--Tiras--</option>
                                <option value="Bulto">--Bulto--</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationDefault02">Stock</label>
                            <input type="text" class="form-control" id="txtStock" placeholder="Apellido" name="Stock" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault02">Costo</label>
                            <input type="text" class="form-control" id="txtPrecioCompra" placeholder="Precio de costo" name="PrecioCompra" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault02">Precio </label>
                            <input type="text" class="form-control" id="txtPrecioVenta" placeholder="Precio de costo" name="PrecioVenta" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationDefaultUsername">Fecha</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                </div>
                                <input type="date" class="form-control" id="txtFecha" name="Fecha" aria-describedby="inputGroupPrepend2" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="idProveedor">Proveedor</label>
                            <select class="form-select" aria-label="Default select example" id="txtProveedor" name="idProveedor">
                                @foreach ($Proveedores as $Proveedor )
                                <option value="{{$Proveedor->id}}">{{$Proveedor->Nombre}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="idProveedor">Categoria</label>
                            <select class="form-select" aria-label="Default select example" id="txtCategoria" name="idCategoria">

                                @foreach ($Categorias as $Categoria )
                                <option value="{{$Categoria->id}}">{{$Categoria->Descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" id="btnactualizar">Actualizar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- ----Modal importar --------- -->
<div class="modal fade" id="modal_importar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-light">
                <h5 class="modal-title" id="exampleModalLabel">Archivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>

            </div>
            <div class="modal-body">
                <form action="{{route('productos.importar')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="importar" class="form-label">Selecciona el Archivo : </label>
                        <input type="file" class="form-control" name="importar">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        indice_ruta();
        /*  console.log(t.ajax.se); */
    });

    function indice_ruta(referencia) {
        let url_ini = "{{route('productos-tabla',1)}}";
        let url_def = url_ini.replace("1", referencia);

        if (referencia == null) {
            url_def = "{{route('productos-tabla',1)}}";
        }
        console.log(url_def);
        $('#example').dataTable().fnDestroy();
        var t = $('#example').DataTable({
            responsive: true,
            "ajax": url_def,
            "columns": [{
                    data: 'id',
                },
                {
                    data: 'Detalles'
                },
                {
                    data: 'Stock'
                },
                {
                    data: 'PrecioCompra',
                    render: $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    data: 'PrecioVenta',
                    render: $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    data: 'Unidad'
                },
                {
                    data: 'Nombre'
                },
                {
                    data: 'Descripcion'
                },
                {
                    data: 'opciones'
                },
            ],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No hay datos - Disculpa",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtrado por _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"

                },
            },
            "order": [
                [1, 'asc']
            ],
            "footerCallback": function(row, data, start, end, display) {

                total_pesos = this.api()
                    .column(3) //numero de columna a sumar
                    //.column(1, {page: 'current'})//para sumar solo la pagina actual
                    .data()
                    .reduce(function(a, b) {
                        if (typeof a === 'string') {
                            a = a.replace(/[^\d.-]/g, '') * 1;
                        }
                        if (typeof b === 'string') {
                            b = b.replace(/[^\d.-]/g, '') * 1;
                        }

                        return a + b;

                    }, 0);
                total_dolar = this.api()
                    .column(4)
                    .data()
                    .reduce(function(a, b) {
                        if (typeof a === 'string') {
                            a = a.replace(/[^\d.-]/g, '') * 1;
                        }
                        if (typeof b === 'string') {
                            b = b.replace(/[^\d.-]/g, '') * 1;
                        }

                        return a + b;

                    }, 0);

                $(this.api().column(3).footer()).html(total_pesos.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
                $(this.api().column(4).footer()).html(total_dolar.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));

            }


        });
        t.on('order.dt search.dt', function() {
            let i = 1;

            t.cells(null, 0, {
                search: 'applied',
                order: 'applied'
            }).every(function(cell) {
                this.data(i++);
            });
        }).draw();

    }
</script>
<script>
    function editar(d) {
        let id = d;
        $.ajax({
            type: 'GET',
            url: 'productos/modal/' + id,
            dataType: 'json',
            success: function(response) {
                console.log(response.Mensaje);
                console.log(response.Mensaje.Nombre);
                $('#txtId').val(id);
                $('#txtDetalles').val(response.Mensaje.Detalles);
                $('#txtStock').val(response.Mensaje.Stock);
                $('#txtPrecioCompra').val(response.Mensaje.PrecioCompra);
                $('#txtPrecioVenta').val(response.Mensaje.PrecioVenta);
                $('#txtFecha').val(response.Mensaje.Fecha);
                $('#txtProveedor').val(response.Mensaje.idProveedor);
                $('#txtCategoria').val(response.Mensaje.idCategoria);
                $('#idUnidad').val(response.Mensaje.Unidad);

            },
            error: function(response) {
                console.log(response);
                Swal.fire(
                    'Error!',
                    'Algo ocurrió. ',
                    'error'
                );
            }
        });
    }

    $('#btnactualizar').on('click', function(e) {
        e.preventDefault();
        let id = $('#txtId').val();
        let update = $('#formulario-productos-editar').serialize();

        console.log(id);

        $.ajax({
            type: 'POST',
            url: 'productos/actualizar/' + id,
            dataType: 'json',
            data: update,
            success: function(response) {
                console.log(response);
                $('#example').DataTable().ajax.reload();
                cerrar_modal('#productos-modal');
                Swal.fire(
                    'Excelente!',
                    'Modificado correctamente.',
                    'success',
                );
                limpiar();
            },
            error: function(response) {
                console.log(response);
                Swal.fire(
                    'Error!',
                    'Algo ocurrió. ',
                    'error'
                );
            }
        });

    })

    function borrar(d) {
        let id = d;

        Swal.fire({
            title: 'Éstas Seguro?',
            text: "Se borrarán los datos.!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: 'productos/eliminar/' + id,
                    dataType: 'json',
                    success: function(response) {
                        $('#example').DataTable().ajax.reload();
                        Swal.fire(
                            'Excelente!',
                            'Se borraron con éxito.',
                            'success'
                        );
                    },
                    error: function(response) {
                        Swal.fire(
                            'Error!',
                            'Algo ocurrió. ',
                            'error'
                        );
                    }
                });
            }
        });

    }

    function cerrar_modal(modal) {
        $(modal).hide();
        $('.modal-backdrop').remove();
        $('body').css('padding-right', '');
        $('body').removeClass('modal-open');
    }

    function limpiar() {
        $('#txtNombre').val('');
        $('#txtApellido').val('');
        $('#txtAlias').val('');
        $('#txtDireccion').val('');
        $('#txtTelefono').val('');
    }
</script>
@endsection