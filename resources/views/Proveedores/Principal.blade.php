@extends('Maestra')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Proveedores</title>
@endsection

@section('contenido')

<div aria-label="breadcrumb" class="d-flex justify-content-between mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Proveedores</li>
    </ol>
    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modal_importar"><i class="las la-file-csv fs-4"></i></button>
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
<table id="example" class="table table-striped display nowrap" cellspacing="0" style="width:100%">
    <thead class="bg-dark text-light">
        <tr>
            <th></th>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Teléfono</th>
            <th>Prueba</th>
        </tr>
    </thead>
    <tbody id="tabla-clientes">

    </tbody>
</table>

<!-- Modal Actualizar -->
<div class="modal fade" id="proveedores-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario-proveedores-editar" class="form-row">
                    @csrf
                    <input type="hidden" id="txtId" value="0">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault01">Nombre</label>
                            <input type="text" class="form-control" id="txtNombre" placeholder="Nombre" name="Nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault04">Telefono</label>
                            <input type="number" class="form-control" id="txtTelefono" placeholder="Telefono" name="Telefono" required>
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
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">

                </button>

            </div>
            <div class="modal-body">
                <form action="{{route('proveedores.importar')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="importar" class="form-label">Selecciona el Archivo : </label>
                        <input type="file" class="form-control" name="importar">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       var t = $('#example').DataTable({
            responsive: true,
            "ajax": "{{route('proveedores-tabla')}}",
            "columns": [{
                    data: 'id',
                },
                {
                    data: 'Nombre'
                },
                {
                    data: 'Direccion'
                },
                {
                    data: 'Telefono'
                },
                {
                    data: 'Prueba'
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
    });
</script>
<script>
    function editar(d) {
        let id = d;
        $.ajax({
            type: 'GET',
            url: 'proveedores/modal/' + id,
            success: function(response) {
                /*   console.log(response);
                  console.log(response.Mensaje.Nombre); */
                $('#txtId').val(id);
                $('#txtNombre').val(response.Mensaje.Nombre);
                $('#txtDireccion').val(response.Mensaje.Direccion);
                $('#txtTelefono').val(response.Mensaje.Telefono);
            }
        });
    }

    $('#btnactualizar').on('click', function(e) {
        e.preventDefault();
        let id = $('#txtId').val();
        let update = $('#formulario-proveedores-editar').serialize();

        $.ajax({
            type: 'POST',
            url: 'proveedores/actualizar/' + id,
            data: update,
            success: function(response) {
                $('#example').DataTable().ajax.reload();
                limpiar();
                cerrar_modal('#proveedores-modal')
                Swal.fire(
                    'Excelente!',
                    'Modificado correctamente.',
                    'success',
                );
            },
            error: function(response) {
                console.log(response);
                Swal.fire(
                    'Ops!',
                    'Ocurrió un error',
                    'error',
                );
            }
        });

    })

    function borrar(d) {
        let id = d;
        Swal.fire({
            title: 'Seguro?',
            text: "Borrar proveedor!",
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
                    url: 'proveedores/eliminar/' + id,
                    success: function(response) {
                        $('#example').DataTable().ajax.reload();
                        console.log(response.Mensaje);
                    },
                    error: function(response) {
                        console.log(response);
                        Swal.fire(
                            'Ops!',
                            'Ocurrió un error',
                            'error',
                        );
                    }
                });
            }
        })

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