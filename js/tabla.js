// Estos son los datos de la lista de usuarios

const datosCampos = [
  {
    nombre: "pablo",
    apellidos: "garcía",
    telefono: "123456789",
    email: "pablo@gmail.com",
    sexo: "masculino",
  },
  {
    nombre: "amanda",
    apellidos: "rodríguez",
    telefono: "298347566",
    email: "pablo@gmail.com",
    sexo: "femenino",
  },
  {
    nombre: "matías",
    apellidos: "fernández",
    telefono: "102938475",
    email: "carlos@gmail.com",
    sexo: "masculino",
  },
  {
    nombre: "pabolo",
    apellidos: "fernández",
    telefono: "102938456",
    email: "pabolo@gmail.com",
    sexo: "masculino",
  },
  {
    nombre: "andrés",
    apellidos: "martínez",
    telefono: "102938456",
    email: "pabolo@gmail.com",
    sexo: "femenino",
  },
];

// Rellenamos los datos de de datosCampo en lista de usuarios
function cargarDatos() {
  //con esto hacemos que los usuarios ser rellenen en la tabla
  const tabla = document
    .getElementById("tabla")
    .getElementsByTagName("tbody")[0];

  datosCampos.forEach((datos) => {
    // Aquí creamos las filas para cada usuario con sus campos
    const fila = document.createElement("tr");

    // Crear nombre en la lista de usuraios
    // Creamos y añadimos creando un td las celdas para cada propiedad del usuario
    const elNombre = document.createElement("td");
    // Aquí te rellena los datos que tu escribes en el array
    elNombre.textContent = datos.nombre;
    // Aquí lo crea la celda en la fila correspondiente en la tabla
    fila.appendChild(elNombre);

    const losApellidos = document.createElement("td");
    losApellidos.textContent = datos.apellidos;
    fila.appendChild(losApellidos);

    const elTelefono = document.createElement("td");
    elTelefono.textContent = datos.telefono;
    fila.appendChild(elTelefono);

    const elEmail = document.createElement("td");
    elEmail.textContent = datos.email;
    fila.appendChild(elEmail);

    const elSexo = document.createElement("td");
    elSexo.textContent = datos.sexo;
    fila.appendChild(elSexo);

    // Creamos y añadimos el botón de eliminar

    const celdaAccion = document.createElement("td");

    const botonEliminar = document.createElement("button");

    botonEliminar.textContent = "X";
    botonEliminar.classList.add("eliminar");
    // Aquí crea el botón con la "X" para que al pulsarle se elimine
    celdaAccion.appendChild(botonEliminar);
    // Aquí crea la celda para la "X" de eliminar el ususario
    // celdaAccion.appendChild(celdaEliminar);

    //------------------
    const botonModificar = document.createElement("button");

    botonModificar.textContent = "Modificar";
    botonModificar.classList.add("modificar"); // Añade el botón de modificar al lado del botón de eliminar

    celdaAccion.appendChild(document.createTextNode(" "));
    celdaAccion.appendChild(botonModificar);

    fila.appendChild(celdaAccion);

    // Añadimos la fila de dicho usuario a la tabla
    tabla.appendChild(fila);
  });
}

// Aquí hacemos que todos los datos de "Lista de usuarios"
cargarDatos();

// Esto va a ser para que cuando nosotros le demos a la X se elimine toda la fila del usuario
document.querySelector("#tabla").onclick = function (event) {
  // Si tu le das al botón de eliminar, verifica con el contains que contiene la clase 'eliminar' y con el classList lo borras
  if (event.target.classList.contains("eliminar")) {
    //Con el closest('tr') selecciona toda la fila que quieres borrar
    event.target.closest("tr").remove();
  }
};

// Creamos la manera de filtrar

document.getElementById("filtrar").addEventListener("input", (input) => {
  // El texto hace que sea en minúsculas
  const texto = input.target.value.toLowerCase();
  // Esto selecciona todas las filas del array que hemos creado en la tabla de lista de usuarios, y sirve para poder filtrar con el filter
  const filas = Array.from(document.querySelectorAll("#tabla tbody tr"));

  const filasFiltro = filas.filter((fila) => {
    // Aquí al filtrar te pone todo en minúsculas el nombre
    const nombre = fila.cells[0].textContent.toLowerCase();
    // Aquí al filtrar te pone todo en minúsculas el apellido
    const apellidos = fila.cells[1].textContent.toLowerCase();
    // Aquí filtramos con las 3 primeras letras y que sea solo por el nombre o el apellido
    return (
      texto.length < 3 || nombre.includes(texto) || apellidos.includes(texto)
    );
  });

  filas.forEach((fila) => {
    fila.style.display = filasFiltro.includes(fila) ? "" : "none";
  });
});

//-----------------------

document.querySelector("#tabla").onclick = function (event) {
  if (event.target.classList.contains("modificar")) {
    const fila = event.target.closest("tr");
    const celdas = fila.querySelectorAll("td");

    document.querySelector('input[name="nombre"]').value =
      celdas[0].textContent;
    document.querySelector('input[name="apellidos"]').value =
      celdas[1].textContent;
    document.querySelector('input[name="telefono"]').value =
      celdas[2].textContent;
    document.querySelector('input[name="email"]').value = celdas[3].textContent;

    const sexo = celdas[4].textContent;
    document.querySelector(
      `input[name="sexo"][value="${sexo}"]`
    ).checked = true;

    fila.dataset.index = Array.from(fila.parentNode.children).indexOf(fila);
  }
};

document.getElementById("guardar").onclick = function () {
  Swal.fire({
    title: "¿Guardar cambios?",
    text: "Se actualizarán los datos del usuario seleccionado.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, guardar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const fila = document.querySelector("[data-index]");

      if (fila) {
        const id = fila.dataset.id;

        const formData = new FormData();
        formData.append("id", id);
        formData.append(
          "nombre",
          document.querySelector('input[name="nombre"]').value
        );
        formData.append(
          "apellidos",
          document.querySelector('input[name="apellidos"]').value
        );
        formData.append(
          "telefono",
          document.querySelector('input[name="telefono"]').value
        );
        formData.append(
          "email",
          document.querySelector('input[name="email"]').value
        );
        formData.append(
          "sexo",
          document.querySelector('input[name="sexo"]:checked').value
        );
        formData.append(
          "fecha_nacimiento",
          document.querySelector('input[name="fecha_nacimiento"]').value
        );

        fetch("modificarUsuario.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              Swal.fire("Guardado", data.message, "success");

              const celdas = fila.querySelectorAll("td");
              celdas[0].textContent = formData.get("nombre");
              celdas[1].textContent = formData.get("apellidos");
              celdas[2].textContent = formData.get("telefono");
              celdas[3].textContent = formData.get("email");
              celdas[4].textContent = formData.get("sexo");
              if (celdas.length > 5) {
                celdas[5].textContent = formData.get("fecha_nacimiento");
              }

              document.querySelector("form").reset();
              fila.removeAttribute("data-index");
              fila.removeAttribute("data-id");
            } else {
              Swal.fire("Error", data.message, "error");
            }
          })
          .catch(() =>
            Swal.fire("Error", "No se pudo guardar el usuario.", "error")
          );
      } else {
        Swal.fire("Error", "Selecciona un usuario para editar.", "error");
      }
    }
  });
};

document.getElementById("borrar").onclick = function () {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "El usuario será eliminado de forma permanente.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, borrar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const fila = document.querySelector("[data-index]");

      if (fila) {
        const id = fila.dataset.id;

        const formData = new FormData();
        formData.append("id", id);

        fetch("deleteUser.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              Swal.fire("Eliminado", data.message, "success");

              fila.remove();

              document.querySelector("form").reset();
            } else {
              Swal.fire("Error", data.message, "error");
            }
          })
          .catch(() =>
            Swal.fire("Error", "No se pudo borrar el usuario.", "error")
          );
      } else {
        Swal.fire("Error", "Selecciona un usuario para borrar.", "error");
      }
    }
  });
};
