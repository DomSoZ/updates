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
                <th>Numero de orden</th>
                <th>Forma de pago</th>
                <th>RFC</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @if($datos_update)
            <tr>
                <td>SAP</td>
                <td>{{$datos_update['NUMERO_ORDEN']}}</td>
                <td>{{$datos_update['FORMA_PAGO']}}</td>
                <td>{{$datos_update['RFC']}}</td>
                <td>{{$datos_update['ESTADO']}}</td>
            </tr>
            @endif
            @if($consultarLc)
            <tr>
                <td>Bancos 2.0</td>
                <td>{{$consultarLc[0]->numero_orden}}</td>
                <td>{{$consultarLc[0]->id_forma_pago}}</td>
                <td>{{$consultarLc[0]->rfc}}</td>
                <td>{{$consultarLc[0]->estado}}</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@if($consultarLc)
    @if($consultarLc[0]->estado)
        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Update</button>
    @endif
@else
    @if($datos_update)
        <form action="" method="post">
            <button type="submit">Insertar</button>
        </form>
    @endif
@endif

@if($datos_update)
<!-- modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Información para update</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('update') }}" id="update" name="update" method="post">
            @csrf
            <div class="row">
                <div class="form-group col mb-3">
                    <label>Forma de pago: </label>
                    <input type="text" name="FORMA_PAGO" class="form-control" id="FORMA_PAGO" value="{{$datos_update['FORMA_PAGO']}}"/>
                </div>
                <div class="form-group col mb-3">
                    <label>RFC: </label>
                    <input type="text" name="RFC" class="form-control" id="RFC" value="{{$datos_update['RFC']}}"/>
                </div>
                <div class="form-group col mb-3">
                    <label>Metodo de pago: </label>
                    <input type="text" name="METODO_PAGO" class="form-control" id="METODO_PAGO" value="{{$datos_update['METODO_PAGO']}}"/>
                </div>
                <div class="form-group col mb-3">
                    <label>N° de operación: </label>
                    <input type="text" name="NUMERO_OPERACION" class="form-control" id="NUMERO_OPERACION" value="{{$datos_update['NUMERO_OPERACION']}}"/>
                </div>
            </div>
            <div class="row">
                <div class="form-group col mb-3">
                    <label>Banco: </label>
                    <select class="form-select" name="BANCO" id="BANCO" aria-label="Default select example">
                        @foreach ($bancos as $banco)
                            <option value="{{$banco->banco}}">{{$banco->banco}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col mb-3">
                    <label>Banco: </label>
                    <select class="form-select" name="CONVENIO" id="CONVENIO" aria-label="Default select example">
                        @foreach ($convenios as $convenio)
                            <option value="{{$convenio->id_convenio}}">{{$convenio->cuenta_contable}}-{{$convenio->via_pago}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col mb-3">
                    <label>Monto pagado: </label>
                    <input type="text" name="MONTO_PAGADO" class="form-control" id="MONTO_PAGADO" value="{{$datos_update['MONTO_PAGADO']}}"/>
                </div>
            </div>
            <div class="row">
                <div class="form-group col mb-3">
                    <label>Fecha de pago: </label>
                    <input type="datetime-local" name="FECHA_PAGO" class="form-control" id="FECHA_PAGO" value="{{$datos_update['FECHA_PAGO']}}"/>
                </div>
                <div class="form-group col mb-3">
                    <label>Número de orden: </label>
                    <input type="text" name="NUMERO_ORDEN" class="form-control" id="NUMERO_ORDEN" value="{{$datos_update['NUMERO_ORDEN']}}"/>
                </div>
                <div class="form-group col mb-3">
                    <label>Monto pagado: </label>
                    <input type="text" name="ESTADO" class="form-control" id="ESTADO" value="{{$datos_update['ESTADO']}}"/>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" form="update" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endif

@endsection