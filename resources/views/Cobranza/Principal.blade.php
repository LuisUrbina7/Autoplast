@extends('Maestra')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Cobranza</title>
@endsection

@section('contenido')
<div aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Cobranza</li>
  </ol>
</div>

    <table id="example" class="table table-striped display nowrap" cellspacing="0" style="width:100%">
        <thead class="bg-primary text-white">
            <tr>
                <th>id</th>
                <th>Cliente</th>
                <th>Identificador</th>
                <th>COL</th>
                <th>USD</th>
                <th>Estado</th>
                <th>Opcones</th>
            </tr>
            </tr>
        </thead>
        <tbody id="tabla-cobranza">
            @foreach ($datos as $cuentas)
            <tr>
                <td> {{$cuentas->id}}</td>
                <td> {{$cuentas->Nombre}}</td>
                <td> {{$cuentas->Identificador}}</td>
                <td> {{number_format($cuentas->COL,2)}}</td>
                <td> {{number_format($cuentas->USD,2)}}</td>
                @if ($cuentas->COL == 0 && $cuentas->USD == 0 )
                <td> <span class="badge bg-primary h4">Solvente</span></td>
                @else
                <td> <span class="badge bg-success h4">Deudor</span></td>
                @endif


                <td> <a href="{{route('facturas.cobranza',[$cuentas->id])}}" class="btn btn-outline-info btn-sm rounded-5 " id="btneditar"><i class="fa fa-eye" aria-hidden="true"></i>
                    </a>
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
            "decimal": ".", //separador decimales
            "thousands": ",", //Separador miles
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