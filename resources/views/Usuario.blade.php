<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>Dashboard</title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
  <!-- Enlace al archivo CSS de Bootstrap -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/light-bootstrap-dashboard.css?v=2.0.0') }}">
  <!-- Enlace a tu archivo de estilos personalizado -->
  <link rel="stylesheet" href="{{ asset('css/demo.css') }}" />
  <!-- Icono del sitio -->
  <link rel="icon" href="{{ asset('img/biblioteca.ico') }}" type="image/x-icon">

  <style>
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(70% - 1rem);
        }
    </style>
</head>


<body>
  <div class="wrapper">
    <div class="sidebar" data-image="{{asset('img/sidebar-5.jpg')}}">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="sidebar-wrapper">
        <div class="logo">
          <a href="http://www.creative-tim.com" class="simple-text">
            Library
          </a>
        </div>
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
              <i class="nc-icon nc-chart-pie-35"></i>
              <p>Dashboard</p>
            </a>
          </li>

          @if (Auth::check() && Auth::user()->tipo_usuario === 'usuario')
          <li class="nav-item">
            <a class="nav-link" href="">
              <i class="nc-icon nc-circle-09"></i>
              <p>User Profile</p>
            </a>
          </li>
          @endif


          @if (Auth::check() && Auth::user()->tipo_usuario === 'admin')
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('mostrar_libros') }}">
              <i class="nc-icon nc-notes"></i>
              <p>Book List</p>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('mostrar_usuarios') }}">
              <i class="nc-icon nc-notes"></i>
              <p>Usuarios</p>
            </a>
          </li>
          @endif

          <li>
            <a class="nav-link" href="">
              <i class="nc-icon nc-bell-55"></i>
              <p>Notifications</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg " color-on-scroll="500">
        <div class="container-fluid">
          <i class="bi bi-grid"></i>
          <i class='bx bx-sun' id="darkLight"></i>
          <a class="navbar-brand" href="#pablo"> Book List </a>
          <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="nav navbar-nav mr-auto">
              <li class="nav-item">
                <a href="#" class="nav-link" data-toggle="dropdown">
                  <i class="nc-icon nc-palette"></i>
                  <span class="d-lg-none">Dashboard</span>
                </a>
              </li>
              <li class="dropdown nav-item">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <i class="nc-icon nc-planet"></i>
                  <span class="notification">5</span>
                  <span class="d-lg-none">Notification</span>
                </a>
                <ul class="dropdown-menu">
                  <a class="dropdown-item" href="#">Notification 1</a>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nc-icon nc-zoom-split"></i>
                  <span class="d-lg-block">&nbsp;Search</span>
                </a>
                <input type="text" placeholder="Busca un libro">
              </li>
            </ul>
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <span class="no-icon">Account</span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="no-icon">Dropdown</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                  <div class="divider"></div>
                  <a class="dropdown-item" href="#">Separated link</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                               
                  <a id="navbarDropdownMenuLink" class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      Cerrar Sesion
                  </a>

                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card strpied-tabled-with-hover">
                <div class="card-header ">
                  <h4 class="card-title">Usuarios</h4>
                  <p class="card-category">Gestiona los Usuarios en esta seccion</p>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#RegistrarUser">
                    Registrar Usuario
                  </button>

                </div>
                <div class="card-body table-full-width table-responsive">
                  <table class="table table-hover table-striped">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Creado el</th>
                        <th>Actualizado el</th>
                        <th>Tipo Usuario</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($users as $user)
                      <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>{{ $user->tipo_usuario }}</td>
                        </td>
                        <td>
                          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#EditarUser" onclick="editUser({{ $user->toJson() }})"><i class="fas fa-pencil-alt"></i></button>
                          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#EliminarUser" onclick="deleteUser({{ $user->toJson() }})"><i class="fas fa-solid fa-trash"></i></button>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<!-- Modal Registro-->
<div class="modal fade" id="RegistrarUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Registrar Usuario</h5>
                <button type="button" class="close" id="cerrarmodal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('guardar_user') }}" enctype="multipart/form-data" id="formregistrar">
                    @csrf
                    <div class="modal-flex">
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" class="form-control" id="name" name="name" required autocomplete="on">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" autocomplete="on">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required autocomplete="on">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="created_at">Creado el:</label>
                            <input type="date" class="form-control" id="created_at" name="created_at" required autocomplete="on">
                        </div>
                        <div class="form-group">
                            <label for="updated_at">Actualizado el:</label>
                            <input type="date" class="form-control" id="updated_at" name="updated_at" required autocomplete="on">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="tipo_usuario">Tipo de Usuario:</label>
                            <input type="text" class="form-control" id="tipo_usuario" name="tipo_usuario" autocomplete="on">
                        </div>
                        <br>
                        <!-- Botón de guardar dentro del formulario -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" id="guardar" name="guardar" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


      <!-- Modal edit -->
      <div class="modal fade" id="EditarUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Actualizar Usuario</h5>
              <button type="button" class="close" id="cerrarmodal" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('actualizar_user') }}" enctype="multipart/form-data" id="formedit">
                @csrf
                <div class="modal-flex">
                  <div class="form-group">
                    
                    <input type="hidden" name="id" id="user_id"  value="{{$user->id}}" required autocomplete="on">
                    
                    
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control" id="nameedit" name="nameedit" required autocomplete="on">
                  </div>
                  <br>
                  <br>
                  <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="emailedit" name="emailedit"   required autocomplete="on">
                  </div>
                  <br>
                  <div class="form-group">
                    <label for="tipo_usuario">Tipo de Usuario:</label>
                    <input type="text" class="form-control" id="tipo_usuarioedit" name="tipo_usuarioedit"   required autocomplete="on">
                  </div>
                  <br>
                  <!-- Botón de guardar dentro del formulario -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="actualizar" name="actualizar" class="btn btn-primary">Guardar</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <script>
          // Function to populate the modal with user data
          function editUser(user) {
            document.getElementById('user_id').value = user.id;
            document.getElementById('nameedit').value = user.name;
            document.getElementById('emailedit').value = user.email;
            document.getElementById('tipo_usuarioedit').value = user.tipo_usuario;
            $('#EditarUser').modal('show');
          }
      </script>


      <!-- Modal Eliminar-->
      <div class="modal fade" id="EliminarUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Usuario</h5>
              <button type="button" class="close" id="cerrarmodal" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('eliminar_user') }}" enctype="multipart/form-data" id="formeliminar">
                @csrf
                @method('DELETE')
                <div class="form-group">
                  
                
                  <input type="hidden" name="id_delete" id="id_delete" value="{{$user->id}}" required autocomplete="on">
                  <p>Nombre: <span  name="userdelete" id="userdelete"></span></p>

                  <input type="hidden" class="form-control" name="deletename" id="deletename" required autocomplete="on" >
                  
                </div>
                <br>
                <!-- Botón de guardar dentro del formulario -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" id="eliminar" name="eliminar" class="btn btn-primary">Eliminar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <script>
          // Function to populate the modal with user data
          function deleteUser(user) {
            document.getElementById('id_delete').value = user.id;
            document.getElementById('deletename').value = user.name;
            document.getElementById('userdelete').textContent = user.name;
            $('#EliminarUser').modal('show');
          }
      </script>
      <footer class="footer">
        <div class="container-fluid">
          <nav>
            <ul class="footer-menu">
              <li>
                <a href="#">
                  Home
                </a>
              </li>
              <li>
                <a href="#">
                  Company
                </a>
              </li>
              <li>
                <a href="#">
                  Portfolio
                </a>
              </li>
              <li>
                <a href="#">
                  Blog
                </a>
              </li>
            </ul>
            <p class="copyright text-center">
              ©
              <script>
                document.write(new Date().getFullYear())
              </script>
              <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
            </p>
          </nav>
        </div>
      </footer>
    </div>
  </div>

  
 

</body>


<!-- jQuery -->
<script src="{{ asset('js/core/jquery.3.2.1.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/core/popper.min.js') }}"></script>
<script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
<!-- SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
<!-- Tu propio script -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.js"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{asset('js/plugins/bootstrap-switch.js')}}"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Chartist Plugin  -->
<script src="{{asset('js/plugins/chartist.min.js')}}"></script>
<!--  Notifications Plugin    -->
<script src="{{asset('js/plugins/bootstrap-notify.js')}}"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="{{asset('js/light-bootstrap-dashboard.js?v=2.0.0')}} " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="{{asset('js/demo.js')}}"></script>



</html>