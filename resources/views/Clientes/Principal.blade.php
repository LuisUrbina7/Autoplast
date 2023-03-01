@extends('Maestra')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap.min.css">
<title>Clientes</title>
@endsection
@section('contenido')
<div aria-label="breadcrumb" class="d-flex justify-content-between mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Clientes</li>
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
<table id="example" class="table table-hover" cellspacing="0" style="width:100%">
    <thead class="table-light">
        <tr>
            <th></th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Identificador</th>
            <th>Zona</th>
            <th>Direccion</th>
            <th>Teléfono</th>
            <th>opciones</th>
        </tr>
    </thead>
    <tbody id="tabla-clientes">
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="clientes-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                <form id="formulario-clientes-editar" class="form-row">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault01">Nombre</label>
                            <input type="text" class="form-control" id="txtNombre" placeholder="Nombre" name="Nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault02">Apellido</label>
                            <input type="text" class="form-control" id="txtApellido" placeholder="Apellido" name="Apellido" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="Zona">Zona o Ruta</label>
                            <select class="form-select" aria-label="Default select example" name="Zona" id="txtZona">
                                <option selected>Zona</option>
                                <option value="Panamericana">Panamericana</option>
                                <option value="Barinas">Barinas</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationDefault03">Direccion</label>
                            <input type="text" class="form-control" id="txtDireccion" placeholder="Direccion" name="Direccion" required>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationDefaultUsername">Identificador</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                </div>
                                <input type="text" class="form-control" id="txtIdentificador" placeholder="Identificador" name="Identificador" aria-describedby="inputGroupPrepend2" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault04">Telefono</label>
                            <input type="text" class="form-control" id="txtTelefono" placeholder="Telefono" name="Telefono" required>
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
<div class="modal fade" id="modal_importar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-light">
                <h5 class="modal-title" id="exampleModalLabel">Archivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>

            </div>
            <div class="modal-body">
                <form action="{{route('clientes.importar')}}" method="post" enctype="multipart/form-data">
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

        var t = $('#example').DataTable({
            responsive: true,
            /*  processing:true,
              serveSider:true,*/
            "ajax": "{{route('clientes-tabla')}}",
            "columns": [{
                    data: 'id',
                    name: 'id',
                    class: 'id'
                },
                {
                    data: 'nombre',
                    class: 'Nombre'
                },
                {
                    data: 'apellido',
                    class: 'Apellido'
                },
                {
                    data: 'identificador',
                    class: 'Identificador'
                },
                {
                    data: 'zona',
                    class: 'Zona'
                },
                {
                    data: 'direccion',
                    class: 'Direccion'
                },
                {
                    data: 'telefono',
                    class: 'Telefono'
                },
                {
                    data: 'opciones',
                    class: 'opciones'
                },
            ],
            order: [
                [1, 'asc']
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
    $('#tabla-clientes').on('click', '#btnver', function() {
        var fila = $(this).parents('tr');
        var datos = {
            Id: fila.find('.id').text(),
            Nombre: fila.find('.nombre').text(),
            Apellido: fila.find('.apellido').text(),
            identificador: fila.find('.identificador').text(),
            zona: fila.find('.zona').text(),
            direccion: fila.find('.direccion').html(),
            telefono: fila.find('.telefono').html()
        };

    });


    $('#btnactualizar').on('click', function(e) {
        e.preventDefault();
        let id = $('#txtId').val();
        let update = $('#formulario-clientes-editar').serialize();

        $.ajax({
            type: 'post',
            url: 'clientes/actualizar/' + id,
            dataType:'json',
            data: update,
            success: function(response) {
                console.log(response)
                $('#example').DataTable().ajax.reload();
                cerrar_modal('#clientes-modal');
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

    function editar(d) {
        let id = d;
        $.ajax({
            type: 'GET',
            url: 'clientes/modal/' + id,
            success: function(response) {
                $('#txtId').val(response.Mensaje.id);
                $('#txtNombre').val(response.Mensaje.nombre);
                $('#txtApellido').val(response.Mensaje.apellido);
                $('#txtZona').val(response.Mensaje.zona);
                $('#txtIdentificador').val(response.Mensaje.identificador);
                $('#txtDireccion').val(response.Mensaje.direccion);
                $('#txtTelefono').val(response.Mensaje.telefono);
                console.log(response);
            }
        });
    }

    function borrar(d) {
        let id = d;

        Swal.fire({
            title: '¿Estas Seguro de Elminar?',
            text: "Se borrará el elemento seleccionado!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, borrar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: 'GET',
                    url: 'clientes/eliminar/' + id,
                    dataType:'json',
                    success: function(response) {
                        $('#example').DataTable().ajax.reload();
                        Swal.fire(
                            'Borrado!',
                            'Articulo borrado.',
                            'success'
                        )
                        console.log(response.Mensaje);
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
        });
    }

    function limpiar() {

        $('#txtZona').val('');
        $('#txtIdentificador').val('');
        $('#txtNombre').val('');
        $('#txtApellido').val('');
        $('#txtAlias').val('');
        $('#txtDireccion').val('');
        $('#txtTelefono').val('');
    }

    function cerrar_modal(modal) {
        $(modal).hide();
        $('.modal-backdrop').remove();
        $('body').css('padding-right', '');
        $('body').removeClass('modal-open');
    }
</script>
@endsection