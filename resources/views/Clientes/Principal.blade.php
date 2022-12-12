@extends('Maestra')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Clientes</title>
@endsection
@section('contenido')
<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Clientes</li>
    </ol>
</div>
<table id="example" class="table table-striped display nowrap" cellspacing="0" style="width:100%">
    <thead class="bg-primary bg-gradient text-light">
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Identificador</th>
            <th>Zona</th>
            <th>Direccion</th>
            <th>Teléfono</th>
            <th>Op</th>
        </tr>
    </thead>
    <tbody id="tabla-clientes">
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="clientes-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

        $('#example').DataTable({
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
                    data: 'Nombre',
                    class: 'Nombre'
                },
                {
                    data: 'Apellido',
                    class: 'Apellido'
                },
                {
                    data: 'Identificador',
                    class: 'Identificador'
                },
                {
                    data: 'Zona',
                    class: 'Zona'
                },
                {
                    data: 'Direccion',
                    class: 'Direccion'
                },
                {
                    data: 'Telefono',
                    class: 'Telefono'
                },
                {
                    data: 'Prueba',
                    class: 'Prueba'
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
    $('#tabla-clientes').on('click', '#btnver', function() {
        var fila = $(this).parents('tr');
        var datos = {
            Id: fila.find('.id').html(),
            Nombre: fila.find('.Nombre').html(),
            Apellido: fila.find('.Apellido').html(),
            identificador: fila.find('.Identificador').html(),
            zona: fila.find('.Zona').html(),
            direccion: fila.find('.Direccion').html(),
            telefono: fila.find('.Telefono').html()
        };
        $('#txtId').val(datos.Id);
        $('#txtNombre').val(datos.Nombre);
        $('#txtApellido').val(datos.Apellido);
        $('#txtZona').val(datos.zona);
        $('#txtIdentificador').val(datos.identificador);
        $('#txtDireccion').val(datos.direccion);
        $('#txtTelefono').val(datos.telefono);
        console.log(datos);
    });


    $('#btnactualizar').on('click', function(e) {
        e.preventDefault();
        let id = $('#txtId').val();
        let update = $('#formulario-clientes-editar').serialize();

        $.ajax({
            type: 'post',
            url: 'clientes/actualizar/' + id,
            data: update,
            success: function(response) {
                $('#clientes-modal').modal('hide');
                $('#example').DataTable().ajax.reload();
                limpiar();
            }, error: function(response) {
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
            title: '¿Estas Seguro de Elminar?',
            text: "Se borrará el elemento seleccionado!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, borrar!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: 'GET',
                    url: 'clientes/eliminar/' + id,
                    success: function(response) {
                        $('#example').DataTable().ajax.reload();
                        Swal.fire(
                            'Borrado!',
                            'Articulo borrado.',
                            'success'
                        )
                        console.log(response.Mensaje);
                    }, error: function(response) {
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
</script>
@endsection
