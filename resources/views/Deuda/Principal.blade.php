@extends('Maestra')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Deudas</title>
@endsection

@section('contenido')

    <table id="example" class="table table-striped display nowrap" cellspacing="0" style="width:100%">
        <thead class="bg-primary text-white">
            <tr>
                <th>id</th>
                <th>Proveedor</th>
                <th>COL</th>
                <th>USD</th>
                <th>Deuda</th>
                <th>Opciones</th>
            </tr>
            </tr>
        </thead>
        <tbody id="tabla-deuda">
        @foreach ($Proveedores as $Proveedor)
        <tr> 
            <td> {{$Proveedor->id}}</td>
            <td> {{$Proveedor->Nombre}}</td>  
            <td> {{number_format($Proveedor->COL,2) }}</td> 
            <td> {{number_format($Proveedor->USD,2)}}</td>
            @if ($Proveedor->COL == 0 && $Proveedor->USD == 0 )
                <td> <span class="badge bg-primary h4">Solvente</span></td>
                @else
                <td> <span class="badge bg-success h4">Pendiente</span></td>
                @endif

         
            <td> <a href="{{route('facturas.deuda',[$Proveedor->id])}}" class="btn btn-primary" id="btneditar">Ver</a>
        </td>
        @endforeach
        </tbody>
    </table>

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script>
$(document).ready(function() {

        $('#example').DataTable({
            responsive: true,
            "decimal": ".",//separador decimales
            "thousands": ",",//Separador miles
            /*  processing:true,
              serveSider:true,*/
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

</script>
@endsection