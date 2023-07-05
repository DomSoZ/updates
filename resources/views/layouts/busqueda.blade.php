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
<div class="card mx-auto rounded mt-3 pl-1" style="width:95%;">
    <table class="table table-striped-columns">
        <thead>
            <tr>
                <th>Sistema</th>
                <th>Orden</th>
                <th>Monto</th>
                <th>Forma de pago</th>
            </tr>
        </thead>
        <tbody>
            @if($resultados)
            <tr>
                <td>SAP</td>
                <td>{{$resultados['TB_ConsultaRecibo']['Folio']}}</td>
                <td>{{$resultados['TB_ConsultaRecibo']['Total']}}</td>
                <td>{{$resultados['TB_ConsultaRecibo']['FormaPago']}}</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@if($consultarLc)
    @if($consultarLc[0]->estado)
        <form action="" method="get">
            <button type="submit">Update</button>
        </form>
    @endif
@else
    @if($resultados)
        <form action="" method="post">
            <button type="submit">Insertar</button>
        </form>
    @endif
@endif

@endsection