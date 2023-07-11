@extends('plantilla')
@extends('layouts/menu')
@section('body')
<div class="mx-auto mt-5 card rounded w-50">
    <div class="bg-white card-header">
        Busqueda de Numero de Orden
    </div>
    <div class="card-body">
        <form action="{{ route('busqueda') }}" class="d-flex" role="search">
            <input name="lineacaptura" maxlength='12' class="form-control me-2" type="search" placeholder="Numero de Orden"
                pattern="[0-9]{12}" required>
            <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
    </div>
</div>
<div class="card mx-auto rounded mt-3 pl-1" style="width:95%;">
    <table class="table">
        <thead>
            <tr>
                <th>Sistema</th>
                <th>Linea de captura</th>
                <th>Monto</th>
                <th>Fecha de pago</th>
                <th>Estado</th>
                <th>Forma de pago</th>
                <th>Banco</th>
            </tr>
        </thead>
        <tbody>
            @if($datos_update)
            <tr>
                <td>SAP</td>
                <td>{{$datos_update['LINEA_CAPTURA']}}</td>
                <td>{{$datos_update['MONTO_PAGADO']}}</td>
                <td>{{$datos_update['FECHA_PAGO']}}</td>
                <td>{{$datos_update['ESTADO']}}</td>
                <td>{{$datos_update['METODO_PAGO']}}</td>
                <td>{{$datos_update['BANCO']}}</td>
            </tr>
            @endif
            @if($consultarLc)
            <tr>
                <td>Bancos 2.0</td>
                <td>{{$consultarLc[0]->linea_captura}}</td>
                <td>{{$consultarLc[0]->monto}}</td>
                <td>{{$consultarLc[0]->fecha_pago}}</td>
                <td>{{$consultarLc[0]->estado}}</td>
                <td>{{$consultarLc[0]->id_forma_pago}}</td>
                <td>{{$consultarLc[0]->banco}}</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@if($consultarLc)
    @if($consultarLc[0]->estado != 'P')
        <button class="pill mx-auto mt-1" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Update</button>
    @endif
@else
    @if($datos_update)
        <form action="{{ route('insert') }}" method="post">
            @csrf
            <input type="text" name="linea" id="linea" value="{{$datos_update['LINEA_CAPTURA']}}" hidden/>
            <input type="text" name="rfc" id="rfc" value="{{$datos_update['RFC']}}" hidden/>
            <input type="text" name="fecha_ven" id="fecha_ven" value="{{$datos_update['FECHA_VENCE']}}" hidden/>
            <input type="text" name="monto" id="numero_ord" value="{{$datos_update['MONTO_PAGADO']}}" hidden/>
            <input type="text" name="numero_ord" id="numero_ord" value="{{$datos_update['NUMERO_ORDEN']}}" hidden/>
            <button class="pill mx-auto mt-1" type="submit">Insertar</button>
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
                    <input type="text" name="FORMA_PAGO" class="form-control" id="FORMA_PAGO" value="{{$datos_update['FORMA_PAGO']}}" readOnly/>
                </div>
                <div class="form-group col mb-3">
                    <label>RFC: </label>
                    <input type="text" name="RFC" class="form-control" id="RFC" value="{{$datos_update['RFC']}}" readOnly/>
                </div>
                <div class="form-group col mb-3">
                    <label>Metodo de pago: </label>
                    <input type="text" name="METODO_PAGO" class="form-control" id="METODO_PAGO" value="{{$datos_update['METODO_PAGO']}}" readOnly/>
                </div>
                <div class="form-group col mb-3">
                    <label>N° de operación: </label>
                    <input type="text" name="NUMERO_OPERACION" class="form-control" id="NUMERO_OPERACION" value="{{$datos_update['NUMERO_OPERACION']}}" readOnly/>
                </div>
            </div>
            <div class="row">
                <div class="form-group col mb-3">
                    <label>Monto pagado: </label>
                    <input type="text" name="MONTO_PAGADO" class="form-control" id="MONTO_PAGADO" value="{{$datos_update['MONTO_PAGADO']}}" readOnly/>
                </div>
                <div class="form-group col mb-3">
                    <label>Número de orden: </label>
                    <input type="text" name="NUMERO_ORDEN" class="form-control" id="NUMERO_ORDEN" value="{{$datos_update['NUMERO_ORDEN']}}" readOnly/>
                </div>
                <div class="form-group col mb-3">
                    <label>Estado: </label>
                    <input type="text" name="ESTADO" class="form-control" id="ESTADO" value="{{$datos_update['ESTADO']}}" readOnly/>
                </div>
            </div>
            <br>
            <p>Unicamente se deben de modificar los siguientes tres datos</p>
            <div class="row">
                <div class="form-group col-3 mb-3">
                    <label>Banco: </label>
                    <select class="form-select" name="BANCO" id="BANCO" aria-label="Default select example">
                        @foreach ($bancos as $banco)
                            <option value="{{$banco->banco}}">{{$banco->banco}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-3 mb-3">
                    <label>Fecha de pago: </label>
                    <input type="datetime-local" name="FECHA_PAGO" class="form-control" id="FECHA_PAGO" value="{{$datos_update['FECHA_PAGO']}}"/>
                </div>
                <div class="form-group col-6 mb-3">
                    <label>Convenio: </label>
                    <input class="form-control" list="CONVENIO" id="convenio" name="convenio" placeholder="Type to search...">
                    <datalist name="CONVENIO" id="CONVENIO" aria-label="Default select example">
                        @foreach ($convenios as $convenio)
                            <option value="{{$convenio->id_convenio}}">{{$convenio->cuenta_contable}} - {{$convenio->convenio}} - {{$convenio->via_pago}}</option>
                        @endforeach
                    </datalist>
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