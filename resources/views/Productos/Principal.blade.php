@extends('Maestra')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Productos</title>
@endsection

@section('contenido')
<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Productos</li>
    </ol>
</div>
<table id="example" class="table table-striped display nowrap" cellspacing="0" style="width:100%">
    <thead class="bg-primary text-light">
        <tr>
            <th>Codigo</th>
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
</table>
<!-- Modal -->
<div class="modal fade" id="productos-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aztualizar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-none">
                    <input type="text" id="txtId" value="0">
                </div>
                <form id="formulario-productos-editar" class="form-row">
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
                            <select class="form-select" aria-label="Default select example" id="txtProveedor" name="idProveedor" disabled>
                                <option selected>Open this select menu</option>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="idProveedor">Categoria</label>
                            <select class="form-select" aria-label="Default select example" id="txtCategoria" name="idCategoria" disabled>
                                <option selected>Open this select menu</option>

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" id="btnactualizar">Actualizar</button>
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
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#example').DataTable({
            responsive: true,
            /*  processing:true,
              serveSider:true,*/
            "ajax": "{{route('productos-tabla')}}",
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
                    data: 'PrecioCompra'
                },
                {
                    data: 'PrecioVenta'
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
                    data: 'op'
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
            }


        });

    });
</script>
<script>
    function editar(d) {
        let id = d;
        $.ajax({
            type: 'GET',
            url: 'productos/modal/' + id,
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
            data: update,
            success: function(response) {
                console.log(response);
                $('#example').DataTable().ajax.reload();
                $('#productos-modal').modal('hide');
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
        $.ajax({
            type: 'POST',
            url: 'productos/eliminar/' + id,
            success: function(response) {
                $('#example').DataTable().ajax.reload();
                console.log(response.Mensaje);
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

    function limpiar() {
        $('#txtNombre').val('');
        $('#txtApellido').val('');
        $('#txtAlias').val('');
        $('#txtDireccion').val('');
        $('#txtTelefono').val('');
    }
</script>
@endsection