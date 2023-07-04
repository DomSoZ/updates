@extends('plantilla')
@extends('layouts/menu')
@section('body')
<div class="mx-auto mt-5 card rounded w-50">
    <div class="bg-white card-header">
        Busqueda de Numero de Orden
    </div>
    <div class="card-body">
        <form action="{{ route('busqueda') }}" class="d-flex" role="search">
            <input name="lineacaptura" class="form-control me-2" type="search" placeholder="Numero de Orden"
                aria-label="Search" required>
            <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
    </div>
</div>
@if($info->count())
<div class="card mx-auto rounded mt-3 pl-1" style="width:95%;">
    <table class="table">
        <thead>
            <tr>
                <th>Sistema</th>
                <th>Referencia</th>
                <th>RFC</th>
                <th>Monto</th>
                <th>Fecha de venc.</th>
                <th>metdo de pago</th>
                <th>fecha de pago</th>
                <th>Banco</th>
                <th>Convenio</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
@endif
@endsection