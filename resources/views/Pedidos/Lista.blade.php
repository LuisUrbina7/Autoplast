@foreach ($data as $datos)
    
@php
  echo  $datos;
@endphp
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-2 bg-">
            <img src="#" class="img-fluid rounded-start" alt="...">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">Para <span>{{$datos->Cliente}} </span></h5>
                <p class="card-text">Monto estimado =</p>
                <p class="card-text"> <small class="text-muted">Fecha ;</small>{{$datos->Fecha}}</p>\
            </div>
        </div>
        <div class="col-md-2 d-flex justify-content-center align-items-center">
            <a class="btn btn-warning " href="../public/pedidos/actualizar/{{$datos->id}}">Procesar</a>\
        </div>
    </div>
</div>
@endforeach