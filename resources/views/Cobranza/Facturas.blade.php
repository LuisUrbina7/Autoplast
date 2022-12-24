@extends('Maestra')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Facturas</title>
@endsection

@section('contenido')
<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('cobranza')}}">Cobranza</a></li>
        <li class="breadcrumb-item active" aria-current="page">Facturas</li>
    </ol>
</div>

<table id="example" class="table table-striped display nowrap" cellspacing="0" style="width:100%">
    <thead class="bg-primary text-white">
        <tr>
            <th>Factura</th>
            <th>Fecha</th>
            <th>COL</th>
            <th>USD</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
        </tr>
    </thead>
    <tbody id="tabla-cobranza">
        @foreach ($Factura as $factura )
        <tr>
            <td>{{$factura->id}}</td>
            <td> {{$factura->Fecha}}</td>
            <td> {{number_format ($factura->VendidoA,2)}}</td>
            <td> {{number_format ($factura->VendidoB,2)}}</td>
            @if (($factura->Estado) == 'Cancelada')
            <td> <span class="badge bg-secondary h4">Cancelada</span></td>
            @else
            <td> <span class="badge bg-success h4">Credito</span></td>
            @endif
            <td>
                <div class="btn-group">
                    <a href="{{route('detalles.cobranza',[$factura->idCliente,$factura->id])}}" class="btn btn-warning" value="{{$factura->id}}" id="btnver"><i class="las la-eye fs-4"></i>
                    </a>
                    <a href="{{ route('generarpdf',[$factura->idCliente,$factura->id]) }}" class="btn btn-info" value="{{$factura->id}}" target="_blank"><i class="las la-file-pdf fs-4"></i>
                    </a>
                    <a href="{{route('eliminar.cobranza',[$factura->id])}}" class="btn btn-danger" value="{{$factura->id}}" id="btnborrar"><i class="las la-trash-alt fs-4"></i>
                    </a>

                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        
    </tfoot>
</table>
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js">
</script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {

        $('#example').DataTable({
            responsive: true,
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
    $(document).on('click', '#btnborrar', function(e) {
        e.preventDefault();

        var link = $(this).attr('href');


        Swal.fire({
            title: 'Seguro?',
            text: "Borrar una factura eliminará los detalles y regresará los productos !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, quiero hacerlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: link,
                    success: function(response) {

                        Swal.fire(
                            'Borrado!',
                            'Excelente.',
                            'success'
                        );
                        location.reload();
                    },
                    error: function(response) {
                        console.log(response);
                        Swal.fire(
                            'Algo está mal!',
                            'Vuelve a intentarlo más tarde',
                            'error'
                        )
                    }
                });
            }
        })






    });
</script>
@endsection