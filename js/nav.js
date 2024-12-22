
// Aquí se asegura que el documento esté totalmente cargado, por eso se utiliza "DOMContentLoaded"
document.addEventListener("DOMContentLoaded", () => {
    //Aquí se solicita los datos del nav.html con el fetch, es decir, su código html
    fetch("nav.html")
    .then((res) => res.text())
    //Aquí se ejecuta con el html ya cargado
    .then((html) => {
      const navContenedor = document.createElement("div");
      navContenedor.innerHTML = html;
      // Añade el div al principio del html
      document.body.prepend(navContenedor);

      const titulo = document.title.toLowerCase();
      const navTitulos = {
        formulario: "nav-formulario",
        tabla: "nav-tabla",
        titulos: "nav-titulos",
        imagenes: "nav-imagenes",
      };

      const id = navTitulos[titulo];
      const link = document.getElementById(id);

      if (link) {
        link.style.color = "green";
        link.style.fontWeight = "bold";
      }
    })
    .catch((err) => console.error("Error al cargar el nav: ", err));
});
