@extends('layouts.auth')
 
@section('title','Inventario Total')

@section('content')
<div class="table-responsive small">
    <table class="table table-striped table-sm" id="myTable">
        <thead>
        <tr>
            
            <th scope="col">Nombre </th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Creado por</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $.fn.dataTable.ext.errMode = 'none';
        dataTable = $('#myTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            },  
            "searching": true,       
            "ajax": {
                type: "POST",
                url: "total",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : { '_token' : "{{csrf_token()}}" },
                dataType: 'json',
            },
            fail: function (data) {
                console.log(data);
            },
            done: function (data)
            {
                console.log(data);
            },
            "columns": [
                {
                    "data": "nombre",
                },
                {
                    "data": "cantidad",
                },
                {
                    "data": "precio",
                },
                {
                    "data": "descripcion",
                },
                {
                    "data": "creador",
                }
            ],
        }).on('error.dt', function(e, settings, techNote, message) {
            
            if (typeof techNote === 'undefined') {

            } else {
                console.error(message);
            }
            return true;
        });
    });
</script>
@endsection