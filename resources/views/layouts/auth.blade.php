<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title',env('APP_NAME'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css" />
    
  </head>
  <div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <div class="col-md-3 mb-2 mb-md-0">
        <a class="d-inline-flex link-body-emphasis text-decoration-none">
          <svg class="bi" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
        </a>
      </div>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/inventario/miinventario" class="nav-link px-2">Mi inventario</a></li>
        <li><a href="/inventario/total" class="nav-link px-2">Todo el inventario</a></li>
      </ul>

      <div class="col-md-3 text-end">
        
        <button type="button" class="btn btn-primary" id="btn-header-logout"><span class="pe-1"><i class="fas fa-sign-out-alt"></i></span>Salir</button>
      </div>
    </header>
  </div>
  <body>
    <div class="container">
      @yield('content')
    </div>
  </body>
  <div class="container">
  <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      
    </ul>
    <p class="text-center text-body-secondary">&copy; <span id="curretYear"></span> JuanMX</p>
  </footer>
</div>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.jqueryui.min.js" type="text/javacsript"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    document.getElementById("curretYear").innerHTML = new Date().getFullYear();
  </script>
  <script>
    $(document).ready(function () {
        $('#btn-header-logout').click(function(event) {

            event.preventDefault();

            $.ajax({
              url: '/logout',
              type: 'GET',
              dataType: 'json',
              data: {
                  _token:  "{{ csrf_token() }}",
              }
            }).done(function(data) {
                alert("Cerrando sesión");
                window.location.href = "/inventario";
            }).fail(function() {
                window.location.href = "/inventario";
            });
        });
    });
    
  </script>
@yield('script')
</html>