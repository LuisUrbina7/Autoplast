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

<div class="d-flex justify-content-center px-md-5">
    <ol class="list-group list-group-numbered">
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Panamericana</div>
                Cras justo odio
            </div>
            <a href="{{ route('cobranza.zona','Panamericana')}}" class="badge bg-primary rounded-pill">Revsar</a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Barinas</div>
                Cras justo odio
            </div>
            <a href="{{ route('cobranza.zona','Barinas')}}" class="badge bg-primary rounded-pill">Revsar</a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Otro</div>
                Cras justo odio
            </div>
            <a href="" class="badge bg-primary rounded-pill">Revsar</a>
        </li>
    </ol>
</div>
@endsection

@section('js')



<script>
</script>

@endsection