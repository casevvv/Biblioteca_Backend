const body = document.querySelector("body");
const darkLight = document.querySelector("#darkLight");
const sidebar = document.querySelector(".sidebar");
const submenuItems = document.querySelectorAll(".submenu_item");



darkLight.addEventListener("click", () => {
  body.classList.toggle("dark");
  if (body.classList.contains("dark")) {
    document.setI;
    darkLight.classList.replace("bx-sun", "bx-moon");
  } else {
    darkLight.classList.replace("bx-moon", "bx-sun");
  }
});

submenuItems.forEach((item, index) => {
  item.addEventListener("click", () => {
    item.classList.toggle("show_submenu");
    submenuItems.forEach((item2, index2) => {
      if (index !== index2) {
        item2.classList.remove("show_submenu");
      }
    });
  });
});


//--------------------------------//
function modalEdit(evento) {
  console.log("funciona")
  var id_tabla = $(evento.target).parents("tr").find("td").eq(0).text().trim();
  var nombre_tabla = $(evento.target).parents("tr").find("td").eq(1).text().trim();
  // var imagen_tabla = $(evento.target).parents("tr").find("td").eq(2).find("img").attr("src").trim(); // Obtener la ruta de la imagen
  var email_tabla = $(evento.target).parents("tr").find("td").eq(2).text().trim();
  var tipousuario_tabla = $(evento.target).parents("tr").find("td").eq(5).text().trim();

  // Convertir el valor del estado de la tabla a un texto legible
  // var estadoLegible = estadotabla === 'Activo' ? '1' : '0'; // Si es 'Activo', asignar '1', de lo contrario, asignar '0'
  console.log(titulo_tabla)
  console.log(autor_tabla)
  console.log(categoria_tabla)
  // Llenar los campos del formulario de edición con los valores obtenidos
  $("#nameedit").val(nombre_tabla);
  $("#emailedit").val(email_tabla);
  $("#tipo_usuarioedit").val(tipousuario_tabla);
  

  // Establecer el estado seleccionado
  // $("#estadoedit").val(estadoLegible);

  // Mostrar la vista previa de la imagen
  // mostrarVistaPreviaEdicion(imagentabla);
}




function activarboton(event) {
  $("#idedit").prop("disabled", false);
}



document.getElementById('formFileMultiple').addEventListener('change', function() {
  vistaPreviaRegistro();
});



//--------------------------//
//sweetaler2 de registrar 
document.getElementById('formregistrar').addEventListener('submit', function(event) {
  event.preventDefault();

  // Obtener el formulario y los datos del mismo
  const form = event.target;
  const formData = new FormData(form);

  // Hacer una solicitud POST al endpoint de Laravel
  axios.post('/guardar_user', formData)
      .then(function(response) {
          // Mostrar una alerta SweetAlert2 si la película se guardó correctamente
          Swal.fire({
              title: 'Éxito',
              text: response.data.message,
              icon: 'success',
              confirmButtonText: 'Aceptar'
          }).then((result) => {
              if (result.isConfirmed) {
                  location.href = "/"; // Redireccionar a la página de películas
              }
          });
      })
      .catch(function(error) {
          // Manejar errores
          console.error('Error al guardar el  libro:', error);
          Swal.fire({
              title: 'Error',
              text: 'Error al guardar el libro.',
              icon: 'error',
              confirmButtonText: 'Aceptar'
          });
      });
});

//sweetaler2 edit 
document.getElementById('formedit').addEventListener('submit', function(event) {
  event.preventDefault();

  // Obtener el formulario y los datos del mismo
  const form = event.target;
  const formData = new FormData(form);

  // Hacer una solicitud POST al endpoint de Laravel
  axios.post(form.action, formData)
      .then(function(response) {
          // Mostrar una alerta SweetAlert2 si la película se actualizó correctamente
          Swal.fire({
              title: 'Éxito',
              text: response.data.message,
              icon: 'success',
              confirmButtonText: 'Aceptar'
          }).then((result) => {
              if (result.isConfirmed) {
                  location.href = "/"; // Redireccionar a la página de películas
              }
          });
      })
      .catch(function(error) {
          // Manejar errores
          console.error('Error al actualizar la película:', error);
          Swal.fire({
              title: 'Error',
              text: 'Error al actualizar la película.',
              icon: 'error',
              confirmButtonText: 'Aceptar'
          });
      });
});

//--------------------------//
//sweetaler2 de eliminar 
document.getElementById('formeliminar').addEventListener('submit', function(event) {
  event.preventDefault();

  // Obtener el formulario y los datos del mismo
  const formData = new FormData(this);
  const id_delete = formData.get('id_delete');

  // Hacer una solicitud DELETE al endpoint de Laravel
  axios.delete('/eliminar_user', {data:{id_delete:id_delete}})
      .then(function(response) {
          // Mostrar una alerta SweetAlert2 si la película se guardó correctamente
          Swal.fire({
              title: 'Éxito',
              text: response.data.message,
              icon: 'success',
              confirmButtonText: 'Aceptar'
          }).then((result) => {
              if (result.isConfirmed) {
                  location.href = "/"; // Redireccionar a la página de películas
              }
          });
      })
      .catch(function(error) {
          // Manejar errores
          console.error('Error al eliminar el  libro:', error);
          Swal.fire({
              title: 'Error',
              text: 'Error al eliminar el libro.',
              icon: 'error',
              confirmButtonText: 'Aceptar'
          });
      });
});