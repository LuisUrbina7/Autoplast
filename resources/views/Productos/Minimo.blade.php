@extends('Maestra')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">

<title>Stock Minimo</title>
@endsection

@section('contenido')
<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('productos')}}">Productos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Stock Minimo</li>
    </ol>
</div>
<h3>Productos con menos de <span>10 de existencias</span></h3>
<table id="example" class="table table-striped display nowrap" cellspacing="0" style="width:100%">
    <thead class="bg-danger text-light">
        <tr>
            <th>#</th>
            <th>Detalles</th>
            <th>Stock</th>
            <th>Proveedor</th>
        </tr>
        </tr>
    </thead>
    <tbody id="tabla-productos">
        @foreach ($datosM as $datos )
            <tr>
                <td>{{$datos->id}}</td>
                <td>{{$datos->Detalles}}</td>
                <td>{{$datos->Stock}}</td>
                <td>{{$datos->Nombre}}</td>
            </tr>
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