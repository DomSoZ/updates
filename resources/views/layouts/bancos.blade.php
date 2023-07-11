@extends('plantilla')
@extends('layouts/menu')
@section('body')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
<div class="container-fluid">
    <div class="card rounded">
        <div class="card-body">
            <table id="bancos" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Impuesto</th>
                        <th>Clave del impuesto</th>
                        <th>Banco</th>
                        <th>Libro mayor</th>
                        <th>Convenio</th>
                        <th>Via de pago</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bancos as $banco)
                    <tr>
                        <td>{{$banco->id_convenio}}</td>
                        <td>{{$banco->impuesto}}</td>
                        <td>{{$banco->clave_impuesto}}</td>
                        <td>{{$banco->banco}}</td>
                        <td>{{$banco->cuenta_contable}}</td>
                        <td>{{$banco->convenio}}</td>
                        <td>{{$banco->via_pago}}</td>    
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#bancos').DataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ Registros por página",
            "zeroRecords": "Sin registros que mostrar",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No archivos disponibles",
            "infoFiltered": "(Encontrado total de _MAX_ Registros)",
            "search": "Buscar:",
        },
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        columnDefs: [{
            className: 'control',
            orderable: false,
            // targets:   0 // oculta la primer linea
        }],
        order: [0, 'asc']
    });
});
</script>
@endsection