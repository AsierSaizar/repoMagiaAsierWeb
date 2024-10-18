// Obtener elementos
var modal = document.getElementById("myModal");
var btn = document.querySelector(".crearNuevaLista");
var span = document.getElementsByClassName("close")[0];

// Cuando el usuario hace clic en el botón, abrir el modal
btn.onclick = function() {
  modal.style.display = "block";
}

// Cuando el usuario hace clic en la "x", cerrar el modal
span.onclick = function() {
  modal.style.display = "none";
}

// Cuando el usuario hace clic fuera del modal, cerrarlo
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

$(document).ready(function () {
    //FABORITOTAN GEHITZEKO
    $("#crearListaBtn").click(function () {
        var listaIzena = $("#listName").val();
        var asierUsu = $("#opcion1Usuario").is(":checked") ? 1 : 0;
        var benatUsu = $("#opcion2Usuario").is(":checked") ? 1 : 0;
  
      
        if (asierUsu == 0 && benatUsu == 0) {
            alert("Elije un nombre minimo");
        } else if (listaIzena == null | listaIzena == "") {
            alert("Nombra la lista");
        }else {
            $.ajax({
                type: "POST",
                url: "../../required/post.php",
                data: {
                action: "añadirLista",
                listaIzena: listaIzena,
                asierUsu: asierUsu,
                benatUsu: benatUsu,
                },
            }).done(function (data) {
                modal.style.display = "none";
            });
        }
       
  
      
    });
})