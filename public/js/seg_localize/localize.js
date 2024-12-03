/*Para geolocalizaciòn*/
function localize(tipo) {
  if (navigator.geolocation) {
    switch (tipo) {
      case "1":
        navigator.geolocation.getCurrentPosition(mapa, error);
        break;
      case "3":
        navigator.geolocation.getCurrentPosition(coordenadas, error);
        break;
      case "4":
        navigator.geolocation.getCurrentPosition(coordenadas_trans, error);
        break;
      case "5":
        navigator.geolocation.getCurrentPosition(coordenadas_hotel, error);
        break;
      default:
        navigator.geolocation.getCurrentPosition(mapa_visita, error);
        break;
    }
  } else {
    alert("Tu navegador no soporta geolocalizacion.");
  }
}

function coordenadas(pos) {
  latitud_capturada = pos.coords.latitude;
  longitud_capturada = pos.coords.longitude;
  precision_capturada = pos.coords.accuracy;
  coordenadas_capturadas = latitud_capturada + "," + longitud_capturada;
  $("#txtcoordenadas_insert_almacen").val(coordenadas_capturadas);
}

function coordenadas_trans(pos) {
  latitud_capturada = pos.coords.latitude;
  longitud_capturada = pos.coords.longitude;
  precision_capturada = pos.coords.accuracy;
  coordenadas_capturadas = latitud_capturada + "," + longitud_capturada;
  $("#txtcoordenadas_insert_transporte").val(coordenadas_capturadas);
}

function coordenadas_hotel(pos) {
  latitud_capturada = pos.coords.latitude;
  longitud_capturada = pos.coords.longitude;
  precision_capturada = pos.coords.accuracy;
  coordenadas_capturadas = latitud_capturada + "," + longitud_capturada;
  $("#txtcoordenadas_insert_hotel").val(coordenadas_capturadas);
}


function mapa(pos) {
  latitud_capturada = pos.coords.latitude;
  longitud_capturada = pos.coords.longitude;
  precision_capturada = pos.coords.accuracy;

  //moveToLocation(latitud_capturada,longitud_capturada);

  coordenadas_capturadas = latitud_capturada + "," + longitud_capturada;

  console.log(
    "latitud capturada: " +
      latitud_capturada +
      "-  longitud capturada:" +
      longitud_capturada +
      "- Precisión Captaurada: " +
      precision_capturada
  );

  /*Realizamos el registro de todo aquel que se conecte al sistema geo*/
  $.ajax({
    type: "POST",
    url: "https://geochasqui.com/sistema_geo/Controller_localize_gestores/insert_localize",
    data: {
      latitud_capturada: latitud_capturada,
      longitud_capturada: longitud_capturada,
      precision_capturada: precision_capturada,
      coordenadas_capturadas: coordenadas_capturadas,
    },
    beforeSend: function () {},
    success: function (data) {},
    error: function () {},
  });
}

function mapa_visita(pos) {
  latitud_capturada = pos.coords.latitude;
  longitud_capturada = pos.coords.longitude;
  precision_capturada = pos.coords.accuracy;
  //moveToLocation(latitud_capturada,longitud_capturada);
  coordenadas_capturadas = latitud_capturada + "," + longitud_capturada;
  $("#txtcoordenadas").val(coordenadas_capturadas);

  console.log(
    "latitud capturada: " +
      latitud_capturada +
      "-  longitud capturada:" +
      longitud_capturada +
      "- Precisión Captaurada: " +
      precision_capturada
  );

  /*Realizamos el registro de todo aquel que se conecte al sistema geo*/
  $.ajax({
    type: "POST",
    url: "https://geochasqui.com/sistema_geo/Controller_localize_gestores/insert_localize_visita",
    data: {
      latitud_capturada: latitud_capturada,
      longitud_capturada: longitud_capturada,
      id_visita_insertada: id_visita_insertada,
      coordenadas_capturadas: coordenadas_capturadas,
    },
    beforeSend: function () {},
    success: function (data) {
      //alert(data);
      if (data == "1") {
        $("#mensaje_grabar_coordenadas")
          .text(
            "No se puede ingresar, las coordenadas superan el límit//de 30 minutos establecidos desde su ingreso."
          )
          .css("color", "red");
      } else {
        $("#mensaje_grabar_coordenadas")
          .text("Coordenadas guardadas correctamente")
          .css("color", "green");
      }

      setTimeout(() => {
        $("#mensaje_grabar_coordenadas").text("");
      }, 3000);
    },
    error: function () {},
  });
}

function error(errorCode) {
  if (errorCode.code == 1) alert("No has permitido buscar tu localizacion");
  else if (errorCode.code == 2) alert("Posicion no disponible");
  else alert("Ha ocurrido un error");
}

/**/
