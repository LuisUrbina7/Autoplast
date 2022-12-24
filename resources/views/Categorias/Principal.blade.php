@extends('Maestra')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Proveedores</title>
@endsection

@section('contenido')
<div class="d-flex py-3 justify-content-between">
    <div aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Categorías </li>
        </ol>
    </div>
    <button data-toggle="modal" data-target="#categorias-modal1" class="btn btn-primary"><i class="las la-plus-circle fs-3"></i></button>
</div>
<table id="example" class="table table-striped display nowrap" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Descripcion</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody id="tabla-categorias">
    </tbody>
</table>
<!-- Modal Insertar-->
<div class="modal fade" id="categorias-modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario-categorias" class="form-row">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="intCategoria">Nombre de la Categoria</label>
                            <input type="text" class="form-control" id="nombre_categoria" placeholder="Nombre" name="Descripcion" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" id="btnguardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Actualizar-->
<div class="modal fade" id="categorias-modal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-none">
                    <input type="text" id="txtId" value="0">
                </div>
                <form id="formulario-categorias-editar" class="form-row">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationDefault01">Nombre de la Categoria</label>
                            <input type="text" class="form-control" id="actCategoria" placeholder="Nombre" name="Descripcion" required>
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
            "ajax": "{{route('categorias-tabla')}}",
            "columns": [{
                    data: 'id',
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
            }
        });
    });
</script>
<script>
    $('#btnguardar').on('click', function(e) {
        e.preventDefault();
        let datos = $('#formulario-categorias').serialize();

        $.ajax({
            type: 'POST',
            url: 'categorias/agregar',
            data: datos,
            success: function(response) {
                $('#intCategoria').val('');
                $('#example').DataTable().ajax.reload();
                cerrar_modal('#categorias-modal1');
                Swal.fire(
                    'Excelente!',
                    'Modificado correctamente.',
                    'success',
                );

            },
            error: function(response) {
                Swal.fire(
                    'Ops!',
                    'Ocurrió un error',
                    'error',
                );
            }
        });
    })


    $('#btnactualizar').on('click', function(e) {
        e.preventDefault();
        let id = $('#txtId').val();
        let update = $('#formulario-categorias-editar').serialize();

        console.log(id);
        console.log(update);
        $.ajax({
            type: 'POST',
            url: 'categorias/actualizar/' + id,
            data: update,
            success: function(response) {
                console.log(response.Mensaje);
                $('#example').DataTable().ajax.reload();
                cerrar_modal('#categorias-modal2');
                limpiar();
                Swal.fire(
                    'Excelente!',
                    'Modificado correctamente.',
                    'success',
                );
            },
            error: function(response) {
                Swal.fire(
                    'Ops!',
                    'Ocurrió un error',
                    'error',
                );
            }
        });
    });

    function editar(d) {
        let id = d;
        $.ajax({
            type: 'GET',
            url: 'categorias/modal/' + id,
            success: function(response) {
                console.log(response.Mensaje);
                console.log(response.Mensaje.Nombre);
                $('#txtId').val(id);
                $('#actCategoria').val(response.Mensaje.Descripcion);
            },
            error: function(response) {
                Swal.fire(
                    'Ops!',
                    'Ocurrió un error',
                    'error',
                );
            }
        });
    }

    function borrar(e) {
        let id = e;
        Swal.fire({
            title: 'Seguro?',
            text: "Borrar categorias !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, quiero hacerlo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: 'categorias/eliminar/' + id,
                    success: function(response) {
                        $('#example').DataTable().ajax.reload();
                        Swal.fire(
                            'Excelente!',
                            'Borrado correctamente.',
                            'success',
                        );
                        
                    },
                    error: function(response) {
                        Swal.fire(
                            'Ops!',
                            'Ocurrió un error',
                            'error',
                        );
                    }
                });
            }
        });

    }

    function limpiar() {
        $('#nombre_categoria').val('');
    }

    function cerrar_modal(modal) {
        $(modal).hide();
        $('.modal-backdrop').remove();
        $('body').css('padding-right', '');
        $('body').removeClass('modal-open');
    }
</script>
@endsection