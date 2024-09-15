<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo o editar</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form-new" method="POST">
            @method('PATCH')
            @csrf
            <input type="hidden" id="id" name="id">
            <div class="mb-3">
            <label for="name" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" id="name" name="nombre">
          </div>
          <div class="mb-3">
            <label for="description" class="col-form-label">Descripcion:</label>
            <textarea class="form-control" id="description" name="descripcion"></textarea>
          </div>
          <div class="mb-3">
            <label for="quantity">Cantidad:</label>
            <input type="number" class="form-control" id="quantity" name="cantidad" min="1">
          </div>
          <div class="mb-3">
            <label for="price">Precio:</label>
            <input type="number" class="form-control" id="price" name="precio" min="1" step=".01">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="btn-save" form="form-new">Guardar</button>
      </div>
    </div>
  </div>
</div>