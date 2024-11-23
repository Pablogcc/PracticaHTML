

// Estos son los datos de la lista de usuarios
const datosCampos = [
    { nombre: 'pablo', apellidos: 'garcía', telefono: '123456789', email: 'pablo@gmail.com', sexo: 'masculino' },
    { nombre: 'amanda', apellidos: 'rodríguez', telefono: '298347566', email: 'pablo@gmail.com', sexo: 'femenino' },
    { nombre: 'matías', apellidos: 'fernández', telefono: '102938475', email: 'carlos@gmail.com', sexo: 'masculino' },
    { nombre: 'pabolo', apellidos: 'fernández', telefono: '102938456', email: 'pabolo@gmail.com', sexo: 'masculino' },
    { nombre: 'andrés', apellidos: 'martínez', telefono: '102938456', email: 'pabolo@gmail.com', sexo: 'femenino' }

];

// Rellenamos los datos de de datosCampo en lista de usuarios 
function cargarDatos() {
    //con esto hacemos que los usuarios ser rellenen en la tabla
    const tabla = document.getElementById('tabla').getElementsByTagName('tbody')[0];

    datosCampos.forEach(datos => {
        // Aquí creamos las filas para cada usuario con sus campos
        const fila = document.createElement('tr');



        // Crear nombre en la lista de usuraios
        // Creamos y añadimos creando un td las celdas para cada propiedad del usuario
        const elNombre = document.createElement('td');
        // Aquí te rellena los datos que tu escribes en el array
        elNombre.textContent = datos.nombre;
        // Aquí lo crea la celda en la fila correspondiente en la tabla
        fila.appendChild(elNombre);



        const losApellidos = document.createElement('td');
        losApellidos.textContent = datos.apellidos;
        fila.appendChild(losApellidos);

        const elTelefono = document.createElement('td');
        elTelefono.textContent = datos.telefono;
        fila.appendChild(elTelefono);

        const elEmail = document.createElement('td');
        elEmail.textContent = datos.email;
        fila.appendChild(elEmail);

        const elSexo = document.createElement('td');
        elSexo.textContent = datos.sexo;
        fila.appendChild(elSexo);

        // Creamos y añadimos el botón de eliminar
        
        const celdaAccion = document.createElement('td');

        const botonEliminar = document.createElement('button');
        
        botonEliminar.textContent = 'X';
        botonEliminar.classList.add('eliminar');
        // Aquí crea el botón con la "X" para que al pulsarle se elimine
        celdaAccion.appendChild(botonEliminar);
        // Aquí crea la celda para la "X" de eliminar el ususario
       // celdaAccion.appendChild(celdaEliminar);

        //------------------
        const botonModificar = document.createElement('button');

        botonModificar.textContent = 'Modificar';
        botonModificar.classList.add('modificar');

        celdaAccion.appendChild(document.createTextNode(' '));
        celdaAccion.appendChild(botonModificar);


        fila.appendChild(celdaAccion);

        // Añadimos la fila de dicho usuario a la tabla
        tabla.appendChild(fila);
    });
}

// Aquí hacemos que todos los datos de "Lista de usuarios"
cargarDatos();

// Esto va a ser para que cuando nosotros le demos a la X se elimine toda la fila del usuario
document.querySelector('#tabla').onclick = function (event) {
    // Si tu le das al botón de eliminar, verifica con el contains que contiene la clase 'eliminar' y con el classList lo borras
    if (event.target.classList.contains('eliminar')) {
        //Con el closest('tr') selecciona toda la fila que quieres borrar
        event.target.closest('tr').remove();
    }
};


// Creamos la manera de filtrar

document.getElementById('filtrar').addEventListener('input', (input) => {
    // El texto hace que sea en minúsculas
    const texto = input.target.value.toLowerCase();
    // Esto selecciona todas las filas del array que hemos creado en la tabla de lista de usuarios, y sirve para poder filtrar con el filter
    const filas = Array.from(document.querySelectorAll('#tabla tbody tr'));

 
    const filasFiltro = filas.filter(fila => {
        // Aquí al filtrar te pone todo en minúsculas el nombre
        const nombre = fila.cells[0].textContent.toLowerCase(); 
        // Aquí al filtrar te pone todo en minúsculas el apellido
        const apellidos = fila.cells[1].textContent.toLowerCase(); 
        // Aquí filtramos con las 3 primeras letras y que sea solo por el nombre o el apellido
        return texto.length < 3 || nombre.includes(texto) || apellidos.includes(texto); 
    });

     
    
    filas.forEach(fila => {
        fila.style.display = filasFiltro.includes(fila) ? '' : 'none';
    });
});

//-----------------------


document.querySelector('#tabla').onclick = function (event) {
    // Aquí se verifica si existe modificar
    if (event.target.classList.contains('modificar')) {
        // quí hace que se seleccione el ususario y se ponga en formulario
       const fila = event.target.closest('tr');
        const celdas = fila.querySelectorAll('td');
        
        
        document.querySelector('input[name="nombre"]').value = celdas[0].textContent;
        document.querySelector('input[name="apellidos"]').value = celdas[1].textContent;
        document.querySelector('input[name="telefono"]').value = celdas[2].textContent;
        document.querySelector('input[name="email"]').value = celdas[3].textContent;
        
        
        const sexo = celdas[4].textContent;
        document.querySelector(`input[name="sexo"][value="${sexo}"]`).checked = true;
        
        // Aquí guarda el índice de la fila en un atributo
        fila.dataset.index = Array.from(fila.parentNode.children).indexOf(fila);
    }
};





document.getElementById('guardar').onclick = function () {
    // Busca el elemento que se ha seleccionado al darle a modificar y luego se ha puesto en el formulario
    const fila = document.querySelector('[data-index]'); 
    
    if (fila) {
        // Aquí obtiene la fila de dicho usuario
        const index = fila.dataset.index; 

        // Aquí se obtiene los valores del formulario 
        const nombre = document.querySelector('input[name="nombre"]').value;
        const apellidos = document.querySelector('input[name="apellidos"]').value;
        const telefono = document.querySelector('input[name="telefono"]').value;
        const email = document.querySelector('input[name="email"]').value;
        const sexo = document.querySelector('input[name="sexo"]:checked').value;

        // Aquí se actualizan los datos cambiados
        datosCampos[index] = { nombre, apellidos, telefono, email, sexo };
        const celdas = fila.querySelectorAll('td');
        celdas[0].textContent = nombre;
        celdas[1].textContent = apellidos;
        celdas[2].textContent = telefono;
        celdas[3].textContent = email;
        celdas[4].textContent = sexo;

        
        

        alert('El usuario se ha editato');
    } else {
        alert('No se pillado ningún usuario para editar.');
    }
};
















