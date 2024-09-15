@extends('layouts.auth')
 
@section('title','Mi inventario')

@section('content')

<h2>Mi inventario</h2>
<div class="pb-3">
    <button type="button" class="btn btn-primary" id="btn-new"><i class="fas fa-plus-circle"></i> Nuevo</button>
</div>
<div class="table-responsive small">
    <table class="table table-striped table-sm" id="myTable">
        <thead>
        <tr>
            
            <th scope="col">Nombre </th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@include('inventario.modals.creareditar')
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
                url: "miinventario",
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
                    "data": "id",
                    "orderable": false,
                    render: function ( data, type, row ) {
                        return `<button type="button" class="btn btn-sm btn-primary btn-edit" value="${data}" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="fa fa-edit" aria-hidden="true"></i></button>&nbsp;
                            
                                <button type="button" class="btn btn-sm btn-danger btn-delete" value="${data}" data-toggle="tooltip" data-placement="bottom" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i></button>`;
                        
                    }
                }
            ],
        }).on('error.dt', function(e, settings, techNote, message) {
            
            if (typeof techNote === 'undefined') {

            } else {
                console.error(message);
            }
            return true;
        });

        $('#btn-new').click(function(event) {

            event.preventDefault();

            $('#form-new')[0].reset();
            $("[name='_method']").val("POST")
            $('#exampleModal').modal('show');
        });

        $('#myTable tbody').off('click', 'button.btn-edit');
        $('#myTable tbody').on('click', 'button.btn-edit', function(event) {
            event.preventDefault();

            $('#form-new')[0].reset();
            $("[name='_method']").val("PATCH")
            $('#exampleModal').modal('show');

            var currentRow = $(this).closest("tr");
            var data = $('#myTable').DataTable().row(currentRow).data();

            $('#name').val(data['nombre']);
            $('#description').val(data['descripcion']);
            $('#quantity').val(data['cantidad']);
            $('#price').val(data['precio']);
            
            
            $('#id').val(data['id']);
        });

        $('#form-new').on('submit', function(e){

            e.preventDefault();

            postFormData = new FormData($('#form-new')[0]);

            var ajaxURL = $("[name='_method']").val() === "PATCH" ? 'miinventario-editar' : 'miinventario-crear';

            $.ajax({
                url: ajaxURL,
                type: 'POST',
                dataType: 'json',
                data: postFormData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    
                    $('#btn-save').prop('disabled',true);
                    $('#btn-save').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Please wait...');
                }
            })
            .always(function() {
                
                $('#btn-save').prop('disabled',false);
                $('#btn-save').html('<i class="far fa-save"></i> Save');
            })
            .done(function(response) {
                if(response.success){
                    $('#myTable').DataTable().ajax.reload(null, false);
                    $('#exampleModal').modal('hide');
                    $('#form-new')[0].reset();    
                }
                else{
                    alert("Algo salio mal al guardar los datos")
                }

            })
            .fail(function(response) {
                alert("Algo salio mal");
            });
        });

        $('#myTable tbody').off('click', 'button.btn-delete');
        $('#myTable tbody').on('click', 'button.btn-delete', function(event) {
          
          var me=$(this),
          id=me.attr('value');

          $.ajax({
              url: 'miinventario-eliminar',
              type: 'POST',
              dataType: 'json',
              data: {
                  _token:  "{{ csrf_token() }}",
                  _method: "DELETE",
                  id: id
              }
          }).done(function(data) {
            $('#myTable').DataTable().ajax.reload(null, false);
          }).fail(function() {
              alert("Algo salio mal");
          });
        });
    });
</script>
@endsection