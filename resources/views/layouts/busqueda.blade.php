@extends('plantilla')
@extends('layouts/menu')
@section('body')
<div class="mx-auto mt-5 card rounded w-50">
    <div class="bg-white card-header">
        Busqueda de Numero de Orden
    </div>
    <div class="card-body">
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Numero de Orden" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
    </div>
</div>
@endsection