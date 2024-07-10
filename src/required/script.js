$(document).ready(function () {
  //FABORITOTAN GEHITZEKO
  $(".starButtonBtn").click(function () {
    var jokuaId = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "../../required/post.php",
      data: {
        action: "fabSartu",
        jokuaId: jokuaId,
      },
    }).done(function (data) {});
    $(this).removeClass("starButtonBtn").addClass("starButtonBtnFab");
  });

  ////////////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////////////

  //GORDETAKO LISTA GEHITZEKO
  $(".listButtonBtn").click(function () {
    var jokuaId = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "../../required/post.php",
      data: {
        action: "lstGorde",
        jokuaId: jokuaId,
      },
    }).done(function (data) {});

    $(this).removeClass("listButtonBtn").addClass("listButtonBtnList");
  });

  //LISTATIK KENTZEKO
  $(".delete-button").click(function () {
    var jokuaId = $(this).attr("id");
    var mota = $("#gordetaMotaInput").val();
    $.ajax({
      type: "POST",
      url: "../../required/post.php",
      data: {
        action: "listatikKendu",
        jokuaId: jokuaId,
        mota: mota,
      },
    }).done(function (data) {
      location.reload();
    });
  });

  //JOKUAK GEHITZEKO

  $(".btnSubmitInsert").click(function () {
    var juegosName = $("#juegosName").val();
    var descripcion = $("#descripcion").val();
    var categoria = $("#categoria").val();
    var subcategoria = $("#subcategoria").val();
    var pasos = $("#pasos").val();
    var notas = $("#notas").val();
    var explicacion = $("#explicacion").val();
    var demostracion = $("#demostracion").val();
    var asierUsu = $("#opcion1Usuario").is(":checked") ? 1 : 0;
    var benatUsu = $("#opcion2Usuario").is(":checked") ? 1 : 0;

    if (asierUsu == 0 && benatUsu == 0) {
      alert("Pon un nombre");
    } else if (asierUsu == 0 && benatUsu == 0) {
      alert("Elige un usuario");
    } else {
      $.ajax({
        type: "POST",
        url: "../../required/post.php",
        data: {
          action: "añadirJuego",
          juegosName: juegosName,
          descripcion: descripcion,
          categoria: categoria,
          subcategoria: subcategoria,
          pasos: pasos,
          notas: notas,
          explicacion: explicacion,
          demostracion: demostracion,
          asierUsu: asierUsu,
          benatUsu: benatUsu,
        },
      }).done(function (data) {
        alert(data);
        history.back();
      });
    }
  });

  //JOKUAK Editatzeko

  $(".btnSubmitEdit").click(function () {
    var jokuaId = $("#idJuego").val();
    var juegosName = $("#juegosName").val();
    var descripcion = $("#descripcion").val();
    var categoria = $("#categoria").val();
    var subcategoria = $("#subcategoria").val();
    var pasos = $("#pasos").val();
    var notas = $("#notas").val();
    var explicacion = $("#explicacion").val();
    var demostracion = $("#demostracion").val();
    var asierUsu = $("#opcion1Usuario").is(":checked") ? 1 : 0;
    var benatUsu = $("#opcion2Usuario").is(":checked") ? 1 : 0;

    if (juegosName == "") {
      alert("Pon un nombre");
    } else if (asierUsu == 0 && benatUsu == 0) {
      alert("Elige un usuario");
    } else {
      $.ajax({
        type: "POST",
        url: "../../required/post.php",
        data: {
          action: "editarJuego",
          jokuaId: jokuaId,
          juegosName: juegosName,
          descripcion: descripcion,
          categoria: categoria,
          subcategoria: subcategoria,
          pasos: pasos,
          notas: notas,
          explicacion: explicacion,
          demostracion: demostracion,
          asierUsu: asierUsu,
          benatUsu: benatUsu,
        },
      }).done(function (data) {
        alert(data);
        history.back();
      });
    }
  });

  //JOKUAK BORRATZEKO

  $(".btnSubmitDelete").click(function () {
    var jokuaId = $("#idJuego").val();

    $.ajax({
      type: "POST",
      url: "../../required/post.php",
      data: {
        action: "borrarJuego",
        jokuaId: jokuaId,
      },
    }).done(function (data) {
      alert(data);
      history.back();
    });
  });
  //JOKUAK RESTAURATZEKO

  $(".restore-button").click(function () {
    var jokuaId = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "../../required/post.php",
      data: {
        action: "restaurarJuego",
        jokuaId: jokuaId,
      },
    }).done(function (data) {
      alert(data);
      location.reload();
    });
  });
  // HISTORIALETIK JOKUK BORRATZEKO
  $(".deleteHis-button").click(function () {
    var jokuaId = $(this).attr("id");
    let userResponse = confirm("Seguro que quieres borrar este juego para siempre?");
    if (userResponse) {
      $.ajax({
        type: "POST",
        url: "../../required/post.php",
        data: {
          action: "BorrarJuegoHistorial",
          jokuaId: jokuaId,
        },
      }).done(function (data) {
        alert(data);
        location.reload();
      });
    }
    
  });
});
