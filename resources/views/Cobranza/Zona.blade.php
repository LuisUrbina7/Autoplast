@extends('Maestra')

@section('css')



<title>Cobranza</title>
@endsection

@section('contenido')
<div aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Cobranza</li>
    </ol>
</div>

<div class="justify-content-center px-md-3">

    <div class="row text-center">
        <div class="col-md-6 border">
            <div class="py-3">
                <span class="text-muted">Ruta A</span>
                <h2>Panamericana</h2>
              
                <a href="{{ route('cobranza.zona','Panamericana')}}" class="badge bg-primary rounded text-decoration-none">  <i class="las la-th-list fs-4 d-block"></i> Revisar</a>
            </div>
        </div>
        <div class="col-md-6 border">
            <div class="py-3">
            <span class="text-muted">Ruta B</span>
                <h3>Barinas</h3>
           
                <a href="{{ route('cobranza.zona','Barinas')}}" class="badge bg-primary rounded text-decoration-none">   <i class="las la-th-list fs-4 d-block"></i>Revisar</a>
            </div>
        </div>
        <div class="col-md-12 border">
        <div class="py-3">
        <span class="text-muted">Ruta C</span>
            <h3>Otro</h3>
           
            <a href="{{ route('cobranza.zona','Barinas')}}" class="badge bg-primary rounded text-decoration-none">  <i class="las la-th-list fs-4 d-block"></i>Revisar</a>
        </div>
        </div>
    </div>

</div>
@endsection