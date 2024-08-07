@extends('layouts.app')

@section('content')
    <div class="content" style="height: 100%">
        <div class="container-fluid" style="height: 100%">
            <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover" style="height: 100%">
                        <div class="card-header ">
                            <h4 class="card-title">LIBROS</h4>
                            <p class="card-category">Gestiona los libros en esta seccion</p>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#RegistrarUsuario">
                                Registrar Libro
                            </button>

                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Portada</th>
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
                                    @foreach ($libros as $libro)
                                        <tr>
                                            <td>{{ $libro->id }}</td>
                                            <td>
                                                @if ($libro->imagen)
                                                    <img src="{{ asset('storage/portada/' . $libro->imagen) }}"
                                                        alt="Portada" style="width: 50%; height: auto;">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $libro->titulo }}</td>
                                            <td>{{ $libro->autor_id ? $libro->autor->nombre : 'N/A' }}</td>
                                            <td>{{ $libro->categoria_id ? $libro->categoria->nombre_categoria : 'N/A' }}
                                            </td>
                                            <td>{{ $libro->editorial_id ? $libro->editorial->nombre : 'N/A' }}
                                            </td>
                                            <td>{{ $libro->isbn }}</td>
                                            <td>{{ $libro->ano_publicacion }}</td>
                                            <td>{{ $libro->cantidad }}</td>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#EditarUsuario" onclick="modalEdit(event);"><i
                                                        class="fas fa-pencil-alt"></i></button>
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#EliminarUsuario" id="eliminarLibro"><i
                                                        class="fas fa-solid fa-trash"></i></button>
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
    <div class="modal fade" id="RegistrarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Registrar Libros</h5>
                    <button type="button" class="close" id="cerrarmodal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('guardar_libro') }}" enctype="multipart/form-data"
                        id="formregistrar">
                        @csrf
                        <div class="modal-flex">
                            <div class="form-group">
                                <label for="titulo">Título:</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required
                                    autocomplete="on">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="autor">Autor:</label>
                                <select id="autor_select" class="form-control" onchange="updateTextInput(this, 'autor')">
                                    <option value="">--Seleccionar Autor--</option>
                                    @foreach ($autores as $autor)
                                        <option value="{{ $autor->id }}">{{ $autor->nombre }}</option>
                                    @endforeach
                                </select>
                                <input type="button" class="btn btn-primary mt-2" value="Agregar"
                                    onclick="toggleInput('autor')">
                                <input type="text" id="autor" name="autor" class="form-control mt-2"
                                    placeholder="Ingresar nuevo autor" style="display: none;">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="editorial">Editorial:</label>
                                <select id="editorial_select" class="form-control"
                                    onchange="updateTextInput(this, 'editorial')">
                                    <option value="">--Seleccionar Editorial--</option>
                                    @foreach ($editoriales as $editorial)
                                        <option value="{{ $editorial->id }}">{{ $editorial->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="button" class="btn btn-primary mt-2" value="Agregar"
                                    onclick="toggleInput('editorial')">
                                <input type="text" id="editorial" name="editorial" class="form-control mt-2"
                                    placeholder="Ingresar nueva editorial" style="display: none;">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="categoria">Categoría:</label>
                                <select id="categoria_select" class="form-control"
                                    onchange="updateTextInput(this, 'categoria')">
                                    <option value="">--Seleccionar Categoría--</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">
                                            {{ $categoria->nombre_categoria }}</option>
                                    @endforeach
                                </select>
                                <input type="button" class="btn btn-primary mt-2" value="Agregar"
                                    onclick="toggleInput('categoria')">
                                <input type="text" id="categoria" name="categoria" class="form-control mt-2"
                                    placeholder="Ingresar nueva categoría" style="display: none;">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="isbn">ISBN:</label>
                                <input type="text" class="form-control" id="isbn" name="isbn" required
                                    autocomplete="on">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="ano_publicacion">Año de Publicación:</label>
                                <input type="date" class="form-control" id="ano_publicacion" name="ano_publicacion"
                                    required autocomplete="on">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" required
                                    autocomplete="on">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="imagen">Imagen:</label>
                                <div class="mb-3 d-flex justify-content-center align-items-center flex-column">
                                    <input class="form-control-file" type="file" id="formFileMultiple" name="imagen"
                                        multiple required onchange="vistaPreviaRegistro()">
                                    <br>
                                    <div class="text-center mt-2">
                                        <img id="imagenPrevia" src="#" alt="Vista previa de la imagen"
                                            style="max-width: 200px; max-height: 200px; display: none;">
                                    </div>
                                </div>
                            </div>
                            <!-- Botón de guardar dentro del formulario -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" id="guardar" name="guardar"
                                    class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal edit -->
    <div class="modal fade" id="EditarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Actualizar Libro</h5>
                    <button type="button" class="close" id="cerrarmodal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('actualizar_libro') }}" enctype="multipart/form-data"
                        id="formedit">
                        @csrf
                        <div class="modal-flex">
                            <div class="form-group">
                                @foreach ($libros as $libro)
                                    <input type="hidden" name="id" value="{{ $libro->id }}">
                                @endforeach
                                <label for="titulo">Titulo:</label>
                                <input type="text" class="form-control" id="tituloedit" name="tituloedit" required
                                    autocomplete="on">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="autor">Autor:</label>
                                <select style="display: none;" id="autoredit_select" class="form-control"
                                    onchange="updateTextInput(this, 'autoredit')">
                                    <option value="">--Seleccionar Autor--</option>
                                    @foreach ($autores as $autor)
                                        <option value="{{ $autor->id }}">{{ $autor->nombre }}</option>
                                    @endforeach
                                </select>
                                <input type="button" class="btn btn-primary mt-2" value="Agregar"
                                    onclick="toggleInput('autoredit_select')">
                                <input type="text" id="autoredit" name="autoredit" class="form-control mt-2"
                                    placeholder="Ingresar nuevo autor">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="editorial">Editorial:</label>
                                <select id="editorialedit_select" class="form-control" style="display: none;"
                                    onchange="updateTextInput(this, 'editorialedit')">
                                    <option value="">--Seleccionar Editorial--</option>
                                    @foreach ($editoriales as $editorial)
                                        <option value="{{ $editorial->id }}">{{ $editorial->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="button" class="btn btn-primary mt-2" value="Agregar"
                                    onclick="toggleInput('editorialedit_select')">
                                <input type="text" id="editorialedit" name="editorialedit" class="form-control mt-2"
                                    placeholder="Ingresar nueva editorial">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="categoria">Categoría:</label>
                                <select id="categoriaedit_select" class="form-control" style="display: none;"
                                    onchange="updateTextInput(this, 'categoriaedit')">
                                    <option value="">--Seleccionar Categoría--</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">
                                            {{ $categoria->nombre_categoria }}</option>
                                    @endforeach
                                </select>
                                <input type="button" class="btn btn-primary mt-2" value="Agregar"
                                    onclick="toggleInput('categoriaedit_select')">
                                <input type="text" id="categoriaedit" name="categoriaedit" class="form-control mt-2"
                                    placeholder="Ingresar nueva categoría">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="isbn">ISBN:</label>
                                <input type="text" class="form-control" id="isbnedit" name="isbnedit" required
                                    autocomplete="on">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="ano_publicacion">Año de Publicación:</label>
                                <input type="date" class="form-control" id="ano_publicacionedit"
                                    name="ano_publicacionedit" required autocomplete="on">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" class="form-control" id="cantidadedit" name="cantidadedit"
                                    required autocomplete="on">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="imagen">Imagen:</label>
                                <div class="mb-3 d-flex justify-content-center align-items-center flex-column">
                                    <input class="form-control-file" type="file" id="formFileMultiple"
                                        name="imagenedit" multiple required onchange="vistaPreviaEdicion()">
                                    <br>
                                    <div class="text-center mt-2">
                                        <img id="vistaPreviaImagenEdit" src="#" alt="Vista previa de la imagen"
                                            style="max-width: 200px; max-height: 200px; display: none;">
                                    </div>
                                </div>
                            </div>
                            <!-- Botón de guardar dentro del formulario -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" id="actualizar" name="actualizar"
                                    class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar-->
    <div class="modal fade" id="EliminarUsuario" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Libro</h5>
                    <button type="button" class="close" id="cerrarmodal" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('eliminar_libro') }}" enctype="multipart/form-data"
                        id="formeliminar">
                        @csrf
                        <div class="form-group">
                            <label for="titulo">Titulo:</label>
                            @foreach ($libros as $libro)
                                <input type="hidden" name="id_delete" value="{{ $libro->id }}">
                                <input type="text" class="form-control" value="{{ $libro->titulo }}" required
                                    disabled>
                            @endforeach
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="imagen">Imagen:</label>
                            <div class="mb-3 d-flex justify-content-center align-items-center flex-column">
                                <input class="form-control" type="file" id="formFileMultiple" multiple
                                    onchange="vistaPreviaRegistro()">
                                <br>
                                <div class="text-center mt-2">
                                    <img id="imagenPrevia" src="#" alt="Vista previa de la imagen"
                                        style="max-width: 200px; max-height: 200px; display: none;">
                                </div>
                            </div>
                        </div>
                        <!-- Botón de guardar dentro del formulario -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" id="eliminar" name="eliminar"
                                class="btn btn-primary">Eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
