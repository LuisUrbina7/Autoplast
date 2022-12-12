@extends('Maestra')

@section('css')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Clientes</title>
@endsection

@section('contenido')
<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('clientes')}}">Clientes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Nuevo Cliente</li>
    </ol>
</div>
<div class="d-flex justify-content-center px-md-5">
    <form id="formulario-clientes" class="mx-md-5" method="POST" enctype="multipart/form-data" action="{{ route('agregar-cliente')}}">
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
                <input type="number" class="form-control" id="txtTelefono" placeholder="Telefono" name="Telefono" required>
            </div>
            <div class="col-12">
                <button class="btn btn-primary w-100" id="btnagregar">Guardar</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js')

<script>
    $('#btnagregar').on('click', function(e) {
        e.preventDefault();

        let formurl = $('#formulario-clientes').attr('action');
        let datos = $('#formulario-clientes').serialize();

        if ($('#txtNombre').val() != '' && $('#txtApellido').val() != '' && $('#txtDireccion').val() != '' && $('#txtIdentificador').val() != '' &&
            $('#txtTelefono').val() != '') {
            console.log(datos);
          

            $.ajax({
                type: 'POST',
                url: formurl,
                data: datos,
                dataType: 'json',
                success: function(response) {
                      console.log(response.Mensaje); 
                    Swal.fire(
                        'Guardado!',
                        'La factura ha sido cargada',
                        'success'
                    );
                    limpiar();
                },
                error: function(response) {
                    Swal.fire(
                        'Ops!',
                        'Ocurrió un error',
                        'error',
                    );
                }
            });
        } else {
            Swal.fire(
                'Error!',
                'Faltan datos',
                'error',
            );
        }
    });

    function limpiar() {
        $('#txtNombre').val('');
        $('#txtApellido').val('');
        $('#txtDireccion').val('');
        $('#txtAlias').val('');
        $('#txtTelefono').val('');
    }
</script>
@endsection