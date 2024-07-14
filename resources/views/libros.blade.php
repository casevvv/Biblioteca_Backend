<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>Dashboard</title>
  <!-- Enlace al archivo CSS de Bootstrap -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <!-- Enlace a tu archivo de estilos personalizado -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <!-- Icono del sitio -->
  <link rel="icon" href="{{ asset('img/cinepolislogo.ico') }}" type="image/x-icon">
</head>


<body>
  <!-- navbar -->
  <nav class="navbar">
    <div class="logo_item">
      <i class="bx bx-menu" id="sidebarOpen"></i>
      <img src="{{ asset('img/cinepolislogo.png') }}" alt=""></i>CinePolis
    </div>
    <div class="navbar_content">
      <i class="bi bi-grid"></i>
      <i class='bx bx-sun' id="darkLight"></i>
    </div>
  </nav>

  <!-- sidebar -->
  <nav class="sidebar">
    <div class="menu_content">
      <ul class="menu_items">
        <div class="menu_title menu_dahsboard"></div>
        <!-- duplicate or remove this li tag if you want to add or remove navlink with submenu -->
        <!-- start -->
        <li class="item">
          <div href="#" class="nav_link submenu_item">
            <span class="navlink_icon">
              <i class="bx bx-home-alt"></i>
            </span>
            <span class="navlink">Libros</span>
          </div>
        </li>
        <!-- end -->

        <!-- Sidebar Open / Close -->
        <div class="bottom_content">
          <div class="bottom expand_sidebar">
            <span> Fijar</span>
            <i class='bx bx-log-in'></i>
          </div>
          <div class="bottom collapse_sidebar">
            <span> Cerrar</span>
            <i class='bx bx-log-out'></i>
          </div>
        </div>
    </div>
  </nav>




  <div class="red_div">
    <div class="arriba">
      <div class="arriba1" style="margin-left:10px;">
      </div>
      <div class="arriba1">
        <h1>LIBROS</h1>
      </div>
      <div class="arriba1">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#RegistrarUsuario">
          Registrar Libro
        </button>
      </div>
    </div>

    <div class="abajo">
      <div class="table-container">
        <table class="tabla_registro">
          <thead>
            <tr>
              <th>Id</th>
              <th>Titulo</th>
              <th>Autor</th>
              <th>Categoria</th>
              <th>Editorial</th>
              <th>Isbn</th>
              <th>Año publicado</th>
              <th>Cantidad</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            @foreach($libros as $libro)
            <tr>
              <td>{{ $libro->id }}</td>
              <td>{{ $libro->titulo }}</td>
              <td>{{ $libro->autor_id ? $libro->autor->nombre : 'N/A' }}</td>
              <td>{{ $libro->categoria_id ? $libro->categoria->nombre_categoria : 'N/A' }}</td>
              <td>{{ $libro->editorial_id ? $libro->editorial->nombre : 'N/A' }}</td>
              <td>{{ $libro->isbn }}</td>
              <td>{{ $libro->ano_publicacion }}</td>
              <td>{{ $libro->cantidad }}</td>

              </td>
              <td>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#EdtiarUsuario" onclick="modalEdit(event);"><i class="fas fa-pencil-alt"></i></button>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#EliminarUsuario" id="eliminarLibro"><i class="fas fa-solid fa-trash"></i></button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Registro-->
  <div class="modal fade" id="RegistrarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Registrar Libros</h5>
          <button type="button" class="close" id="cerrarmodal" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('guardar_libro') }}" enctype="multipart/form-data" id="formregistrar">
            @csrf
            <div class="form-group">
              <label for="titulo">Titulo:</label>
              <input type="text" class="form-control" id="titulo" name="titulo" required autocomplete="on">
            </div>
            <br>
            <div class="form-group">
              <label for="autor">Autor:</label>
              <select id="autor_select" onchange="updateTextInput(this,'autor')">
                <option value="">--Seleccionar Autor--</option>
                @foreach($autores as $autor)
                <option value="{{ $autor->id }}">{{ $autor->nombre }}</option>
                @endforeach
              </select>
              <input type="button" class="btn btn-primary" value="Agregar" onclick="toggleInput('autor')">
              <input type="text" id="autor" name="autor" placeholder="Ingresar nuevo autor" style="display: none;">

            </div>
            <br>
            <div class="form-group">
              <label for="editorial">Editorial:</label>
              <select id="editorial_select" onchange="updateTextInput(this,'editorial')">
                <option value="">--Seleccionar Editorial--</option>
                @foreach($editoriales as $editorial)
                <option value="{{ $editorial->id }}">{{ $editorial->nombre }}</option>
                @endforeach

              </select>
              <input type="button" class="btn btn-primary" value="Agregar" onclick="toggleInput('editorial')">
              <input type="text" id="editorial" name="editorial" placeholder="Ingresar nueva editorial" style="display: none;"><br>
            </div>
            <br>
            <div class="form-group">
              <label for="categoria">Categoría:</label>
              <select id="categoria_select" onchange="updateTextInput(this,'categoria')">
                <option value="">--Seleccionar Categoría--</option>
                @foreach($categorias as $categoria)
                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                @endforeach

              </select>
              <input type="button" class="btn btn-primary" value="Agregar" onclick="toggleInput('categoria')">
              <input type="text" id="categoria" name="categoria" placeholder="Ingresar nueva categoría" style="display: none;"><br>
            </div>
            <br>
            <div class="form-group">
              <label for="isbn">ISBN:</label>
              <input type="text" class="form-control" id="isbn" name="isbn" required autocomplete="on">
            </div>
            <br>
            <div class="form-group">
              <label for="ano_publicacion">Año de Publicación:</label>
              <input type="date" class="form-control" id="ano_publicacion" name="ano_publicacion" required autocomplete="on">
            </div>
            <br>
            <div class="form-group">
              <label for="cantidad">Cantidad:</label>
              <input type="number" class="form-control" id="cantidad" name="cantidad" required autocomplete="on">
            </div>
            <br>
            <div class="form-group">
              <label for="imagen">Imagen:</label>
              <div class="mb-3 d-flex justify-content-center align-items-center flex-column">
                <input class="form-control" type="file" id="formFileMultiple" name="imagen" multiple required onchange="vistaPreviaRegistro()">
                <br>
                <div class="text-center mt-2">
                  <img id="imagenPrevia" src="#" alt="Vista previa de la imagen" style="max-width: 200px; max-height: 200px; display: none;">
                </div>
              </div>
            </div>
            <!-- Botón de guardar dentro del formulario -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" id="guardar" name="guardar" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal edit -->
  <div class="modal fade" id="EdtiarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Actualizar Libro</h5>
          <button type="button" class="close" id="cerrarmodal" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('actualizar_libro') }}" enctype="multipart/form-data" id="formedit">
            @csrf
            <div class="form-group">
              @foreach($libros as $libro)
              <input type="hidden" name="id" value="{{$libro->id}}">
              @endforeach
              <label for="titulo">Titulo:</label>
              <input type="text" class="form-control" id="tituloedit" name="tituloedit" required autocomplete="on">
            </div>
            <br>
            <div class="form-group">
              <label for="autor">Autor:</label>
              <select style="display: none;" id="autoredit_select" onchange="updateTextInput(this,'autoredit')">
                <option value="">--Seleccionar Autor--</option>
                @foreach($autores as $autor)
                <option value="{{ $autor->id }}">{{ $autor->nombre }}</option>
                @endforeach
              </select>
              <input type="button" class="btn btn-primary" value="Agregar" onclick="toggleInput('autoredit_select')">
              <input type="text" id="autoredit" name="autoredit" placeholder="Ingresar nuevo autor">

            </div>
            <br>
            <div class="form-group">
              <label for="editorial">Editorial:</label>
              <select id="editorialedit_select" style="display: none;" onchange="updateTextInput(this,'editorialedit')">
                <option value="">--Seleccionar Editorial--</option>
                @foreach($editoriales as $editorial)
                <option value="{{ $editorial->id }}">{{ $editorial->nombre }}</option>
                @endforeach

              </select>
              <input type="button" class="btn btn-primary" value="Agregar" onclick="toggleInput('editorialedit_select')">
              <input type="text" id="editorialedit" name="editorialedit" placeholder="Ingresar nueva editorial"><br>
            </div>
            <br>
            <div class="form-group">
              <label for="categoria">Categoría:</label>
              <select id="categoriaedit_select" style="display: none;" onchange="updateTextInput(this,'categoriaedit')">
                <option value="">--Seleccionar Categoría--</option>
                @foreach($categorias as $categoria)
                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                @endforeach

              </select>
              <input type="button" class="btn btn-primary" value="Agregar" onclick="toggleInput('categoriaedit_select')">
              <input type="text" id="categoriaedit" name="categoriaedit" placeholder="Ingresar nueva categoría"><br>
            </div>
            <br>
            <div class="form-group">
              <label for="isbn">ISBN:</label>
              <input type="text" class="form-control" id="isbnedit" name="isbnedit" required autocomplete="on">
            </div>
            <br>
            <div class="form-group">
              <label for="ano_publicacion">Año de Publicación:</label>
              <input type="date" class="form-control" id="ano_publicacionedit" name="ano_publicacionedit" required autocomplete="on">
            </div>
            <br>
            <div class="form-group">
              <label for="cantidad">Cantidad:</label>
              <input type="number" class="form-control" id="cantidadedit" name="cantidadedit" required autocomplete="on">
            </div>
            <br>
            <div class="form-group">
              <label for="imagen">Imagen:</label>
              <div clasñs="mb-3 d-flex justify-content-center align-items-center flex-column">
                <input class="form-control" type="file" id="formFileMultiple" name="imagenedit" multiple required onchange="vistaPreviaRegistro()">
                <br>
                <div class="text-center mt-2">
                  <img id="imagenPrevia" src="#" alt="Vista previa de la imagen" style="max-width: 200px; max-height: 200px; display: none;">
                </div>
              </div>
            </div>
            <!-- Botón de guardar dentro del formulario -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" id="actualizar" name="actualizar" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Eliminar-->
  <div class="modal fade" id="EliminarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Libro</h5>
          <button type="button" class="close" id="cerrarmodal" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('eliminar_libro') }}" enctype="multipart/form-data" id="formeliminar">
            @csrf
            <div class="form-group">
              <label for="titulo">Titulo:</label>
              @foreach($libros as $libro)
              <input type="hidden" name="id_delete" value="{{$libro->id}}">
              <input type="text" class="form-control" value="{{$libro->titulo}}" required disabled>
              @endforeach
            </div>
            <br>
            <div class="form-group">
              <label for="imagen">Imagen:</label>
              <div class="mb-3 d-flex justify-content-center align-items-center flex-column">
                <input class="form-control" type="file" id="formFileMultiple" multiple onchange="vistaPreviaRegistro()">
                <br>
                <div class="text-center mt-2">
                  <img id="imagenPrevia" src="#" alt="Vista previa de la imagen" style="max-width: 200px; max-height: 200px; display: none;">
                </div>
              </div>
            </div>
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


  <!-- jQuery -->
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <!-- SweetAlert2 JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Bootstrap JavaScript -->
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <!-- Tu propio script -->
  <script src="{{ asset('js/script.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.js"></script>

</html>