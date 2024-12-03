const CACHE_NAME = "gestorMapa-v1";
/* var globales */
let id_cliente_1 = 0;
let id_campania = 0;
//Variables para agregar visita
let id_cliente_seleccionado = 0;
let id_campania_seleccionado = 0;
let id_tipo_base_seleccionado = 0;
//Id visita insertada
let id_visita_insertada = 0;
//Para fotos
let arr_fotos = "";
//Para captura de coordenadas
let latitud_capturada = 0;
let longitud_capturada = 0;
let precision_capturada = 0;
let coordenadas_capturadas = 0;
var id_base_tex = "";
//MARCADORES
var markers = [];
var markers_cda = [];
var markers_trans = [];
var markers_mp = [];
/* fin variables globales */
/*
            FUNCIONES QUE SE USAN EN EL CONTROL GESTOR MAPA ACTUALIZADO
            -- 19/12/2023
        */
var sessionInterval;
$(document).ready(function () {
  setInterval(() => {
    localize("1");
  }, 900000);

  actualiza_marcadores();
});

/*
            PARA SETEAR MAPA
        */
/*  */
function moveToLocation(lat, lng) {
  var center = new google.maps.LatLng(lat, lng);
  map.panTo(center);
}

function clearMarkers(arr) {
  setMapOnAll(null, arr);
}

function setMapOnAll(map, arr) {
  for (var i = 0; i < arr.length; i++) {
    arr[i].setMap(map);
  }
}

function load_ubicacion() {
  localize("1");
  clearMarkers(markers); // Limpia los marcadores existentes

  setTimeout(() => {
    var laf = latitud_capturada;
    var lof = longitud_capturada;

    var marker = "ubicacion4";
    var url_data =
      "https://geochasqui.com/sistema_geo/public/img/marker/" + marker + ".png";

    var image = {
      url: url_data,
      size: new google.maps.Size(40, 60),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(12, 35),
    };

    var myLatLng = { lat: laf, lng: lof };
    var i = 12345;

    var newMarker = new google.maps.Marker({
      id: i,
      position: new google.maps.LatLng(laf, lof),
      map: map,
      title: "Mi ubicación",
      icon: image,
    });

    markers.push(newMarker); // Agrega el nuevo marcador al array
    moveToLocation(laf, lof); // Centra el mapa en la nueva ubicación
  }, 500);
}

/*
            PARA CARGA DE FOTOS
        */

function agregar_imagen_(nimg) {
  /*Cargamos*/
  //$('#_img_icon').css('display','none');
  //$('#_img_load').css('display','block');
  //$('#_img_name').text(' Cargando imagen');
  /**/
  //var id_visita = $('#img_id_visita').val();
  var id_visita = id_visita_insertada;
  var inputfile = document.getElementById(nimg);
  var file = inputfile.files[0];
  var xhr = new XMLHttpRequest();
  (xhr.upload || xhr).addEventListener("progress", function (e) {
    var done = e.position || e.loaded;
    var total = e.totalSize || e.total;
    var carg = Math.round((done / total) * 100);
    $("#progressBar_img_add").val(carg);
    $("#loaded_n_total_img_add").text(carg + " % ");
  });
  xhr.addEventListener("load", function (e) {
    var resultado = this.responseText;
    if (resultado != 0) {
      /**/
      var hht = $("#panel_imagenes").html();
      var cadena =
        "https://geochasqui.com/sistema_geo/" +
        "public/img/adicional/resize/" +
        resultado;
      $("#panel_imagenes").html(
        hht + '<img width="50px" src="' + cadena + '">'
      );
      $("#new_file_img1").val("");
      alerta_error("success", "Imagen Subida correctamente", "Mensaje");
      setTimeout(function () {
        $("#progressBar_img_add").val("");
        $("#loaded_n_total_img_add").text("");
      }, 1500);
    } else {
      alerta("warning", "Error al subir", "");
    }
  });

  xhr.addEventListener("error", function (e) {
    alertify.error("Ocurrio un error, vuelva a intentarlo.");
  });

  xhr.addEventListener("abort", function (e) {
    alertify.error("Ocurrio un error, vuelva a intentarlo.");
  });

  xhr.open(
    "post",
    "https://geochasqui.com/sistema_geo//Controller_gestor_mapa_new/agregar_nueva_imagen",
    true
  );

  var data = new FormData();
  data.append("new_file", file);
  data.append("id_visita", id_visita);
  xhr.send(data);
}

/*
            PARA NOTIFICACIONES
        */
function generar_preaviso_gestor_mapa() {
  generar_preaviso_1(id_cliente_seleccionado);
}

function generar_notarial_gestor_mapa() {
  generar_notarial_1(id_cliente_seleccionado);
}

/*
            PARA COORDENADAS
        */

function get_data_coordenadas_gestor_mapa() {
  get_data_coordenadas(id_cliente_seleccionado);
  $("#mdl_menu").modal("hide");
}

function open_modal_menu_gestor_mapa() {
  $("#mdl_menu").modal("show");
  $("#mdl_consulta_add_add_visita").modal("hide");
}

/*
            Consultar antes de agregar una visita
        */
function open_modal_consultar_add_visita() {
  $("#mdl_consulta_add_add_visita").modal("show");
  //abrir_modal_visita();
}

/*
            ACTIVACIÓN DE PANEL DE RECOJO
        */
function activa_panel_recojo(id_pnl) {
  var res = $("#select_paleta_equipo_" + id_pnl).val();

  if (res == 1 || res == 38) {
    $(".pnl_recojo_" + id_pnl).css("display", "block");
    console.log("acepto recojo");
  } else {
    $(".pnl_recojo_" + id_pnl).css("display", "none");
  }
  if (res == 162 || res == 163 || res == 168) {
    //$('.pnl_censo_otro_' + id_pnl).css('display', 'block');
    $(".pnl_censo_" + id_pnl).css("display", "block");
  } else {
    $(".pnl_censo_otro_" + id_pnl).css("display", "none");
    $(".pnl_censo_" + id_pnl).css("display", "none");

    $("#select_censo_correcto_" + id_pnl).val("");
    $("#txt_censo_" + id_pnl).val("");
    console.log("se borra");
  }
}

function activa_otro_censo(id_pnl) {
  var res = $("#select_censo_correcto_" + id_pnl).val();
  if (res == "NO") {
    $(".pnl_censo_otro_" + id_pnl).css("display", "block");
    console.log("acepto recojo");
  } else {
    $(".pnl_censo_otro_" + id_pnl).css("display", "none");
  }
}

/*  --FIN DE FUNCIONES QUE SE USAN EN EL CONTROL GESTOR MAPA ACTUALIZADI  -- 19/12/2023 */

function valida_seleccion(id_gxeq) {
  var paleta_eq = $("#select_paleta_equipo_" + id_gxeq).val();
  var comentario_eq = $("#txt_comentario_equipo_" + id_gxeq).val();

  //var mensaje='';
  if (paleta_eq == "") {
    //mensaje+=' No se ha seleccionado la gestión del equipo.';
    $("#img_gxeq_" + id_gxeq).attr(
      "src",
      "https://geochasqui.com/sistema_geo/public/img/iconos/error_button.png"
    );
    $("#mensaje_validacion").text(
      "La respuesta seleccionada no puede ser vacía, seleccione la opción más adecuada al caso."
    );
    $("#mdl_agregar_visita").modal("hide");
    $("#mdl_mensaje_validacion").modal("show");
    return 0;
  } else {
    if (comentario_eq == "") {
      //mensaje+=' No se tiene un comentario agregado a la gestión del equipo.';
      $("#img_gxeq_" + id_gxeq).attr(
        "src",
        "https://geochasqui.com/sistema_geo/public/img/iconos/error_button.png"
      );
      return 0;
    } else {
      $("#img_gxeq_" + id_gxeq).attr(
        "src",
        "https://geochasqui.com/sistema_geo/public/img/iconos/check_button.png"
      );
      return 1;
    }
  }
}

function regresar_modal(modal_open, modal_close) {
  if (view_m != 1) {
    $("#" + modal_open).modal("show");
  }

  $("#" + modal_close).modal("hide");
}

function regresar_modal_2(modal_open, modal_close) {
  $("#" + modal_open).modal("show");
  $("#" + modal_close).modal("hide");
  obtener_detalle_visita(id_visita_insertada, id_base_tex, 2);
}

//Función actualizar comercial
function get_select(tipo) {
  $.ajax({
    type: "POST",
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_select",
    data: {
      tipo: tipo,
    },
    beforeSend: function () {},
    success: function (data) {
      switch (tipo) {
        case "paleta_visita":
          $("#select_paleta_visita").html(data);
          break;
        case "paleta_equipo":
          $(".select_equipo").html(data);
          break;

        default:
          break;
      }
    },
  });
}

function view_mdl_center_dep() {
  $("#mdl_selec_dep_center_map").modal("show");
}

function upd_coor_center() {
  var coor = $("#select_dep_center").val();
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/actualiza_center_mapa",
    data: { coor: coor },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (data) {
      $("#loader-container").css("opacity", "0");
      var json = JSON.parse(data);
      $("#mdl_selec_dep_center_map").modal("hide");
      var coor = json.coor;
      if (coor) {
        var coords = coor.split(",");
        if (coords.length === 2) {
          var lat = parseFloat(coords[0].trim());
          var lng = parseFloat(coords[1].trim());
          moveToLocation(lat, lng);
        } else {
          console.error("Coordenadas inválidas:", coor);
        }
      } else {
        console.error("No se encontraron coordenadas en el JSON");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $("#loader-container").css("opacity", "0");
      val_errores(jqXHR, textStatus, errorThrown);
    },
  });
}

function restablecer_marcadores() {
  actualiza_marcadores("1");
  $("#mdl_selec_dep_center_map").modal("hide");
}

/**************************************************************************************/
/***************************** FUNCIONES GET MARCADORES *******************************/
/**************************************************************************************/
/*VARIABLES PARA EL MANEJO DE LA INFORMACIÓN*/
//MARCADORES ASIGNADOS
var dataMarcadores = []; //INFORMACION GENERAL
var dataMarcadoresSeleccionado = []; //INFORMACION DEL MARCADOR SELECCIONADO
//MARCADORES RECOJOS
var dataRecojos = [];

/*FIN VARIABLES*/

  

/* FUNCIONES PARA LA OBTENCION DE LA DATA */

//MARCADORES ASIGNADOS

//MARCADORES RECOJOS
function searchRecojosMdl() {
  //mod
  if (tipo_user == 60) {
    $("#mdl_mensaje_fecha_transporte").modal("show");
  } else {
    actualiza_marcadores_recojos("1");
  }
}

function searchRecojoFecha() {
  actualiza_marcadores_recojos("2");
  $("#mdl_mensaje_fecha_transporte").modal("hide");
}
function actualiza_marcadores_recojos(tipo) {
  var date_programacion = $("#date_programacion").val();

  $.ajax({
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/obtener_marcadores_recojos",
    dataType: "json",
    type: "POST",
    data: { tipo: tipo, date_programacion: date_programacion },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (e) {
      clearMarkers(markers_trans);
      dataMarcadores = e;
      view_recojos(dataMarcadores);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}

/* FIN */

/* FUNCIONES PARA LA SELECCION DE LOS MARCADORES*/

// MARCADORES ASIGNADOS


//MARCADORES RECOJOS
function view_recojos(e) {
  for (var i = 0; i < e.length; i++) {
    var laf = parseFloat(e[i]["latitud"]);
    var lof = parseFloat(e[i]["longitud"]);
    var orden = parseFloat(e[i]["orden_retiro"]);
    var id_cliente = parseInt(e[i]["id_cliente"]);
    var id_eqxcampania = parseInt(e[i]["id_eqxcampania"]);
    var base = parseInt(e[i]["id_tipobase"]);

    const baseUrl = "https://geochasqui.com/sistema_geo/";
    const markerPath = "public/images/marker/";
    const markerRecojoPath = "public/img/marker_recojo/";

    let url_data;
    if (e[i]["orden_retiro"] !== null && e[i]["orden_retiro"] != 0) {
      url_data = baseUrl + markerRecojoPath + e[i]["orden_retiro"];
      if (e[i]["id_confirmacion_retiro"] == 2) {
        url_data += "_confirmado";
      }
      url_data += ".png";
    } else {
      url_data = baseUrl + markerPath + e[i]["marker"];
    }

    var image = {
      url: url_data, // ruta de la imagen
      size: new google.maps.Size(40, 60), // tamaño de la imagen
      origin: new google.maps.Point(0, 0), // origen de la imagen
      // el ancla de la imagen, el punto donde está marcando, en nuestro caso el centro inferior
      anchor: new google.maps.Point(12, 35),
    };

    var myLatLng = { lat: laf, lng: lof };
    var marker = new google.maps.Marker({
      id: "marker_" + i,
      position: new google.maps.LatLng(laf, lof),
      map: map,
      title: e[i]["id_eqxcampania"],
      icon: image,
    });

    // Almacenar los datos del marcador directamente en el manejador del evento de clic
    (function (markerData) {
      google.maps.event.addListener(marker, "click", function () {
        menu_cliente(markerData);
        console.log(markerData);
      });
    })(e[i]);

    /*
                google.maps.event.addListener(marker, 'mouseover', (function(markerData) {
                    return function() {
                        var bodyContent = `
                            <div style="font-size: 12px;">
                                <span class="text-center">Id Cliente: ${markerData['id_cliente']}</span><br>
                                <span>${markerData['distrito']} : ${markerData['hora_rango']} - ${markerData['hora_fin']}</span>
                            </div>
                        `;

                        var infowindow = new google.maps.InfoWindow({
                            content: bodyContent
                        });
                        infowindow.open(map, marker);
                    };
                })(e[i]));

                // Add mouseout event listener to hide the InfoWindow
                google.maps.event.addListener(marker, 'mouseout', (function(markerData) {
                    return function() {
                        infowindow.close();
                    };
                })(e[i]));

                */
    markers_trans.push(marker);
  }
}

/*FUNCIONE DE ACCION DEL MARCADOR*/
//MARCADORES RECOJO
function menu_cliente(markerData) {
  $("#inf_visitas").html("");
  id_cliente_seleccionado = markerData["id_cliente"];
  id_campania_seleccionado = markerData["id_campania"];
  id_tipo_base_seleccionado = markerData["id_tipobase"];
  // Limpiar contenido previo si es necesario
  $("#inf_comentario_comercial").text(markerData["inf_comercial"]);
  $("#inf_comentario_comercial_in").text(markerData["inf_comercial"]);
  $("#panel_comentario_comercial").css("display", "block");
  $("#panel_comentario_comercial_in").css("display", "block");

  $("#inf_link_comercial").text("");
  $("#inf_link_comercial").attr("href", "javascript::void(0)");
  $("#panel_foto_comercial").css("display", "none");
  $("#panel_foto_comercial_in").css("display", "block");

  if (markerData["link_jelou"] != "") {
    $("#inf_link_comercial").text("VER FOTO");
    $("#inf_link_comercial").attr("href", markerData["link_jelou"]);
    $("#panel_foto_comercial").css("display", "block");

    $("#inf_link_comercial_in").text("VER FOTO");
    $("#inf_link_comercial_in").attr("href", markerData["link_jelou"]);
    $("#panel_foto_comercial_in").css("display", "block");
  }

  inf_equipos = "";
  inf_equipos +=
    '   <table class="table table-responsive mt-2 p-1" style="font-size:10px;">';
  inf_equipos += "    <thead>";
  inf_equipos += '        <tr  class="p-1">';

  inf_equipos += '            <th  class="p-1">SERIE</th>';
  inf_equipos += '            <th class="p-1">MODELO</th>';
  inf_equipos += '            <th class="p-1">CENSO</th>';
  inf_equipos += '            <th class="p-1">CIERRE</th>';
  inf_equipos += "        </tr>";
  inf_equipos += "    </thead>";
  inf_equipos += "    <tbody>";

  var data_eq = get_dataMarcadoresxid(markerData["id_cliente"]);
  if (data_eq) {
    var count = 1;
    data_eq.forEach((element) => {
      inf_equipos += '<tr class="p-1">';

      inf_equipos += '    <td class="p-1">' + element.serie + " </td>";
      inf_equipos += '    <td class="p-1">' + element.modelo + "  </td>";
      inf_equipos += '    <td class="p-1">' + element.censo + "  </td>";
      inf_equipos += '    <td class="p-1">' + element.des_cierre + "</td>";
      inf_equipos += "</tr>";
    });
  } else {
    console.log("No se encontraron registros para el id proporcionado.");
  }

  // Para depuración, puedes usar
  console.log("equipo: " + JSON.stringify(data_eq, null, 2));

  inf_equipos += "</tr>";
  inf_equipos += "    </tbody>";
  inf_equipos += "      </table>";

  // Información del cliente
  var p = markerData["nombres"];
  var porcion = p.split(" ");
  var p1 = porcion[0];
  var p2 = porcion[1];

  $("#nombre_cliente").text(
    "" +
      markerData["id_cliente"] +
      " - " +
      p1 +
      " " +
      p2 +
      " - R:" +
      markerData["ruta"]
  );
  $("#nombre_cliente_visita").text(
    "" +
      markerData["id_cliente"] +
      " - " +
      p1 +
      " " +
      p2 +
      " - R:" +
      markerData["ruta"]
  );
  $("#direccion_cliente_visita").text(
    "" +
      markerData["direccion"] +
      " - " +
      markerData["provincia"] +
      " - " +
      markerData["departamento"] +
      " - CDA: " +
      markerData["referencia"]
  );

  var inf_cliente = "";
  inf_cliente +=
    "<span><strong>Campaña: </strong>" + markerData["des_campania"] + "</span>";
  inf_cliente +=
    "<span><strong>Tipo de Base: </strong>" +
    markerData["des_tipobase"] +
    "</span>";

  inf_cliente +=
    "<span><strong>Código: </strong>" + markerData["id_cliente"] + "</span>";
  inf_cliente +=
    "<span><strong>Nombres: </strong>" + markerData["nombres"] + "</span>";
  inf_cliente += "<span><strong>DNI: </strong>" + markerData["dni"] + "</span>";
  inf_cliente += "<span><strong>RUC: </strong>" + markerData["ruc"] + "</span>";
  inf_cliente +=
    "<span><strong>Dirección: </strong>" +
    markerData["direccion"] +
    "- " +
    markerData["departamento"] +
    " - " +
    markerData["distrito"] +
    " </span>";
  /*  inf_cliente += '<span><strong>Región: </strong>' + markerData['region'] + '</span>'; */
  inf_cliente +=
    "<span><strong>Zona: </strong>" + markerData["zona"] + "</span>";
  inf_cliente +=
    "<span><strong>CDA: </strong>" + markerData["base_cda"] + "</span>";
  inf_cliente +=
    '<a target="_blank" href="https://www.google.com/maps/place/' +
    markerData["coordenadas"] +
    '"><button class="btn btn-success btn-sm"><i class="fa fa-map-marker"></i> Ubicación PDV</button></a>';

  // Información de contacto comercial
  var inf_contacto_comercial = "";

  if (markerData["inf_sup_nombres"] != null) {
    inf_contacto_comercial += '<div class="card">';
    inf_contacto_comercial += '    <div class="card-body">';
    inf_contacto_comercial += '        <div class="row">';
    inf_contacto_comercial +=
      "            <h6><strong>SUPERVISOR</strong></h6>";
    inf_contacto_comercial += '            <div class="col-lg-6 mt-2">';
    inf_contacto_comercial +=
      '                <div>Nombres: <input class="form-control form-control-sm" id="txt_nom_sup" value="' +
      markerData["inf_sup_nombres"] +
      '"></div>';
    inf_contacto_comercial +=
      '                <div>Celular: <input class="form-control form-control-sm" id="txt_cel_sup" value="' +
      markerData["inf_sup_celular"] +
      '"></div>';
    inf_contacto_comercial += "            </div>";
    inf_contacto_comercial += '            <div class="col-lg-6 mt-2">';
    inf_contacto_comercial +=
      '                <button onclick="actualizar_contacto_comercial(1,' +
      markerData["id_cliente_key"] +
      ')" class="btn btn-sm btn-secondary"> Actualizar </button>';
    inf_contacto_comercial += "            </div>";
    inf_contacto_comercial += "        </div>";
    inf_contacto_comercial += "    </div>";
    inf_contacto_comercial += "</div>";
  }

  if (markerData["inf_vend_nombres"] != null) {
    inf_contacto_comercial += '<div class="card">';
    inf_contacto_comercial += '    <div class="card-body">';
    inf_contacto_comercial += '        <div class="row">';
    inf_contacto_comercial +=
      "            <div><strong>VENDEDOR</strong></div>";
    inf_contacto_comercial += '            <div class="col-lg-6 mt-2">';
    inf_contacto_comercial +=
      '                <div>Nombres: <input class="form-control form-control-sm" id="txt_nom_vend" value="' +
      markerData["inf_vend_nombres"] +
      '"></div>';
    inf_contacto_comercial +=
      '                <div>Celular: <input class="form-control form-control-sm" id="txt_cel_vend" value="' +
      markerData["inf_vend_celular"] +
      '"></div>';
    inf_contacto_comercial += "            </div>";
    inf_contacto_comercial += '            <div class="col-lg-6 mt-2">';
    inf_contacto_comercial +=
      '                <button onclick="actualizar_contacto_comercial(2,' +
      markerData["id_cliente_key"] +
      ')" class="btn btn-sm btn-secondary"> Actualizar </button>';
    inf_contacto_comercial += "            </div>";
    inf_contacto_comercial += "        </div>";
    inf_contacto_comercial += "    </div>";
    inf_contacto_comercial += "</div>";
  }

  $("#inf_cliente").html(inf_cliente);
  $("#inf_contacto_comercial").html(inf_contacto_comercial);
  $("#inf_contacto_comercial_gestion").html(inf_contacto_comercial);
  $("#inf_equipos").html(inf_equipos);
  $("#mdl_menu").modal("show");
}

function complete_data_visita(markerData) {
  var marcadorData = get_dataMarcadoresxid(markerData);
  var inf_contacto_comercial = "";
  if (marcadorData) {
    marcadorData.forEach((element) => {
      $("#nombre_cliente_visita").text(
        "" +
          element.id_cliente +
          " - " +
          element.nombres +
          " - R:" +
          element.ruta
      );
      $("#direccion_cliente_visita").text(
        "" +
          element.direccion +
          " - " +
          element.distrito +
          " - " +
          element.departamento +
          " - CDA: " +
          element.referencia
      );

      $("#inf_comentario_comercial_in").text(element.inf_comercial);
      $("#panel_comentario_comercial_in").css("display", "block");
      $("#panel_foto_comercial_in").css("display", "block");

      if (element.link_jelou != "") {
        $("#inf_link_comercial_in").text("VER FOTO");
        $("#inf_link_comercial_in").attr("href", element.link_jelou);
        $("#panel_foto_comercial_in").css("display", "block");
      }
      if (element.inf_sup_nombres != null) {
        inf_contacto_comercial += `<div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h6><strong>SUPERVISOR</strong></h6>
                                    <div class="col-lg-6 mt-2">
                                        <div>Nombres: <input class="form-control form-control-sm" id="txt_nom_sup" value="${element.inf_sup_nombres}"></div>
                                        <div>Celular: <input class="form-control form-control-sm" id="txt_cel_sup" value="${element.inf_sup_celular}"></div>
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <button onclick="actualizar_contacto_comercial(1, ${element.id_cliente_key})" class="btn btn-sm btn-secondary"> Actualizar </button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
      }

      if (element.inf_vend_nombres != null) {
        inf_contacto_comercial += `<div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h6><strong>VENDEDOR</strong></h6>
                                    <div class="col-lg-6 mt-2">
                                        <div>Nombres: <input class="form-control form-control-sm" id="txt_nom_vend" value="${element.inf_vend_nombres}"></div>
                                        <div>Celular: <input class="form-control form-control-sm" id="txt_cel_vend" value="${element.inf_vend_celular}"></div>
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <button onclick="actualizar_contacto_comercial(2, ${element.id_cliente_key})" class="btn btn-sm btn-secondary"> Actualizar </button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
      }
    });
    console.log("Busqueda Rapida Array:" + markerData);
  } else {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_datos",
      data: {
        id_cliente: markerData,
      },
      beforeSend: function () {},
      success: function (response) {
        if (response != "error") {
          for (let index = 0; index < response.content.length; index++) {
            const element = response.content[index];

            $("#nombre_cliente_visita").text(
              `${element.id} - ${element.nombres} - R:${element.ruta}`
            );
            $("#direccion_cliente_visita").text(
              `${element.direccion} - ${element.distrito} - CDA: ${element.referencia}`
            );

            $("#inf_comentario_comercial_in").text(element.dato5);
            $("#panel_comentario_comercial_in").css("display", "block");
            $("#panel_foto_comercial_in").css("display", "block");

            if (element.link_jelou != "") {
              $("#inf_link_comercial_in").text("VER FOTO");
              $("#inf_link_comercial_in").attr("href", element.link_jelou);
              $("#panel_foto_comercial_in").css("display", "block");
            }

            if (element.dato1 != null) {
              inf_contacto_comercial += `<div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <h6><strong>SUPERVISOR</strong></h6>
                                                <div class="col-lg-6 mt-2">
                                                    <div>Nombres: <input class="form-control form-control-sm" id="txt_nom_sup" value="${element.dato1}"></div>
                                                    <div>Celular: <input class="form-control form-control-sm" id="txt_cel_sup" value="${element.dato2}"></div>
                                                </div>
                                                <div class="col-lg-6 mt-2">
                                                    <button onclick="actualizar_contacto_comercial(1, ${element.id})" class="btn btn-sm btn-secondary"> Actualizar </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
            }

            if (element.dato3 != null) {
              inf_contacto_comercial += `<div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <h6><strong>VENDEDOR</strong></h6>
                                                <div class="col-lg-6 mt-2">
                                                    <div>Nombres: <input class="form-control form-control-sm" id="txt_nom_vend" value="${element.dato3}"></div>
                                                    <div>Celular: <input class="form-control form-control-sm" id="txt_cel_vend" value="${element.dato4}"></div>
                                                </div>
                                                <div class="col-lg-6 mt-2">
                                                    <button onclick="actualizar_contacto_comercial(2, ${element.id})" class="btn btn-sm btn-secondary"> Actualizar </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
            }
          }
          $("#inf_contacto_comercial_gestion").html(inf_contacto_comercial);
          console.log("Busqueda Lenta Array:");
        } else {
          $("#nombre_cliente_visita").text("");
          $("#direccion_cliente_visita").text("");
          $("#inf_comentario_comercial_in").text("");
          $("#panel_comentario_comercial_in").css("display", "none");
          $("#panel_foto_comercial_in").css("display", "none");
          $("#inf_link_comercial_in").text("");
          $("#inf_link_comercial_in").attr("href", "#");
          $("#panel_foto_comercial_in").css("display", "none");
        }
      },
    });
  }

  $("#inf_contacto_comercial").html(inf_contacto_comercial);
  $("#inf_contacto_comercial_gestion").html(inf_contacto_comercial);
}

//MARCADORES RECOJOS
function menu_cliente_recojos(
  tipo,
  id_cliente,
  id_campania,
  id_tipobase,
  id_programacion
) {
  id_cliente_seleccionado = id_cliente;
  id_campania_seleccionado = id_campania;
  id_tipo_base_seleccionado = id_tipobase;
  //Pasamos los datos para obtener las visitas

  $("#inf_visitas").html("");
  //get_visitas(id_cliente,id_campania)
}

/*FIN*/
/*FUNCIONES PARA LA MANIPULACION DE LA INFORMACION*/

function upd_markers(id, campo, valor) {
  for (var i = 0; i < dataMarcadores.length; i++) {
    if (dataMarcadores[i].id_cliente === id) {
      if (dataMarcadores[i].hasOwnProperty(campo)) {
        dataMarcadores[i][campo] = valor;
      } else {
        console.log(`Campo ${campo} no encontrado en el objeto con id ${id}`);
      }
      break;
    }
  }
  view_markers(dataMarcadores);
}

function get_dataMarcadoresxid(id) {
  var resultados = [];

  for (var i = 0; i < dataMarcadores.length; i++) {
    if (dataMarcadores[i].id_cliente === id) {
      resultados.push(dataMarcadores[i]);
    }
  }
  return resultados.length > 0 ? resultados : null;
}

/*FIN*/

//Actualiza marcadores cdas
function load_cdas() {
  var data = new FormData();
  data.append("tipo", "recojos");
  $.ajax({
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/load_cdas",
    dataType: "json",
    type: "POST",
    contentType: false, //ojo -sin esto nos da un ilegal invocation
    processData: false, //ojo  sin esto nos da un ilegal invocation
    data: data,
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (e) {
      clearMarkers(markers_cda);
      var infowindow;
      for (var i = 0; i < e.length; i++) {
        var laf = parseFloat(e[i]["latitud"]);
        var lof = parseFloat(e[i]["longitud"]);
        //alert();
        var marker = "flag2";
        var url_data =
          "https://geochasqui.com/sistema_geo/public/img/marker/" +
          marker +
          ".png"; //ruta de la imagen

        var image = {
          url: url_data, //ruta de la imagen
          size: new google.maps.Size(40, 60), //tamaño de la imagen
          origin: new google.maps.Point(0, 0), //origen de la iamgen
          //el ancla de la imagen, el punto donde esta marcando, en nuestro caso el centro inferior.
          anchor: new google.maps.Point(12, 35),
        };
        var myLatLng = { lat: laf, lng: lof };
        var id_marker = parseFloat(e[i]["id"]);

        var marker = new google.maps.Marker({
          id: id_marker,
          position: new google.maps.LatLng(laf, lof),
          map: map,
          title: "CDA / ALMACEN",
          icon: image,
        });

        const contentString =
          '<div id="content">' +
          '<div id="bodyContent">' +
          "<p><b>Tipo: </b>" +
          e[i]["tipo"] +
          "<p><b>Provincia: </b>" +
          e[i]["provincia"] +
          "<p><b>Direccion: </b>" +
          e[i]["direccion"] +
          '<br><p style="color:blue;">- - - - - -Información Comercial- -  - - - - </p>' +
          "<p><b>Cargo: </b>" +
          e[i]["cargo"] +
          "<br><p><b>Contacto: </b>" +
          e[i]["contacto"] +
          "<p><b>Telefono: </b>" +
          e[i]["telefono"] +
          `<p><a href="https://www.google.com/maps/place/${laf},${lof}" target="_blank" style="font-size:17px;" class="btn btn-sm btn-soft-danger waves-effect waves-light">` +
          '<i class="bx bx-map"></i>' +
          "</a> " +
          "</div>" +
          "</div>";

        (function (id_marker, marker) {
          google.maps.event.addListener(marker, "click", function () {
            const infowindow = new google.maps.InfoWindow({
              content: contentString,
            });
            infowindow.open(map, marker);
          });
        })(id_marker, marker);

        markers_cda.push(marker);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}

/**************************************************************************************/
/************************* FUNCIONES PARA EL MODAL VISITA *****************************/
/**************************************************************************************/
function ver_mdl_foto_c(event, element) {
  // Prevenir el comportamiento predeterminado del enlace
  event.preventDefault();
  var imageUrl = element.getAttribute("href");

  // Actualizar el contenido del modal con la imagen
  document.getElementById(
    "content_fotos"
  ).innerHTML = `<img class="" src="${imageUrl}" alt="Foto Comercial" style="width: 100%; height: auto;">`;

  $("#mdl_menu_fotos").modal("show");
}

//Funcion visita
function abrir_modal_visita() {
  $.ajax({
    type: "POST",
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/agregar_visita",
    data: {
      id_cliente_seleccionado: id_cliente_seleccionado,
      id_campania_seleccionado: id_campania_seleccionado,
      id_tipo_base_seleccionado: id_tipo_base_seleccionado,
    },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (e) {
      var json = eval("(" + e + ")");
      if (json.resultado == "1") {
        id_visita_insertada = json.id_visita;
        console.log(id_visita_insertada);
        //Agregar visita ingresada
        obtener_detalle_visita(id_visita_insertada, id_base_tex, 2);
        $("#mdl_agregar_visita").modal("show");
        $("#mdl_menu").modal("hide");
        $("#mdl_consulta_add_add_visita").modal("hide");
      } else {
        $("#mensaje").text(
          json.mensaje + " Código: " + id_cliente_seleccionado
        );
        $("#mdl_mensaje").modal("show");
        $("#mdl_consulta_add_add_visita").modal("hide");
        console.log(id_visita_insertada);
      }

      //actualiza_marcadores('1');
      upd_markers(id_cliente_seleccionado, "orden", "99");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}

var view_m = 0;
function obtener_detalle_visita(id_visita, id_base_tex, view) {
  view_m = view;
  id_visita_insertada = id_visita;
  $.ajax({
    type: "POST",
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/obtener_detalle_visita",
    data: {
      id_visita: id_visita,
      base: id_base_tex,
    },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (e) {
      var json = eval("(" + e + ")");
      if (json.resultado == "1") {
        $("#detalle_gestion_visita").html(json.cadena_visita);
        if (json.id_gestion == 15) {
          $("#detalle_gestion_x_equipo").html(json.cadena_acoordion);
          $("#gestion_equipo").css("display", "block");
        } else {
          $("#gestion_equipo").css("display", "none");
        }

        $("#detail_pasaje_visita").html(json.cadena_pasaje);
        //Para pruebas
        $("#mdl_menu").modal("hide");
        $("#mdl_agregar_visita").modal("show");
        $("#txtcoordenadas").val(json.coordenadas);
      } else {
        $("#mensaje").text(json.mensaje + " ID Visita: " + id_visita);
        $("#mdl_mensaje").modal("show");
      }
      $("#new_file_img1").val("");
      $("#progressBar_img_add").val("");
      $("#loaded_n_total_img_add").text("");
      $("#panel_imagenes").html("");
      complete_data_visita(json.id_cliente);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
      $("#loader-container").css("opacity", "0");
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}

// CORREGIR
function obtener_detalle_gestion(id_visita) {
  //id_visita_insertada = id_visita;
  $.ajax({
    type: "POST",
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/obtener_detalle_visita",
    data: {
      id_visita: id_visita,
      base: id_base_tex,
    },
    beforeSend: function () {},
    success: function (e) {
      var json = eval("(" + e + ")");
      if (json.resultado == "1") {
        // $('#detalle_gestion_visita').html(json.cadena_visita);
        if (json.id_gestion == 15) {
          $("#detalle_gestion_x_equipo").html(json.cadena_acoordion);
          $("#gestion_equipo").css("display", "block");
        } else {
          $("#gestion_equipo").css("display", "none");
        }
      } else {
      }
    },
  });
}

//function actualizar
function actualizar(tipo, id) {
  switch (tipo) {
    case "visita_pasaje":
      //Obtenemos los datos
      var monto_pasaje = $("#nmb_pasaje").val();
      var detalle_pasaje = $("#detalle_pasaje").val();

      if (monto_pasaje != "") {
        $("#img_pasaje_visita_modal").attr(
          "src",
          "https://geochasqui.com/sistema_geo/public/img/iconos/check_button.png"
        );
      } else {
        $("#img_pasaje_visita_modal").attr(
          "src",
          "https://geochasqui.com/sistema_geo/public/img/iconos/error_button.png"
        );
        //$('#mensaje_validacion').text('La respuesta  de gestión de la visita no puede ser vacía, seleccione la opción más adecuada al caso.');
        //$('#mdl_agregar_visita').modal('hide');
        //$('#mdl_mensaje_validacion').modal('show');
        $("#mensaje_grabar_pasaje").css("color", "red");
        $("#mensaje_grabar_pasaje").text("Complete los campos necesarios.");
        setTimeout(() => {
          $("#mensaje_grabar_pasaje").text("");
        }, 3000);
        return;
      }

      $.ajax({
        type: "POST",
        url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/actualizar",
        data: {
          tipo: tipo,
          id_visita: id,
          monto_pasaje: monto_pasaje,
          detalle_pasaje: detalle_pasaje,
        },
        beforeSend: function () {
          $("#loader-container").css("opacity", "1");
        },
        success: function (e) {
          var json = eval("(" + e + ")");
          if (json.resultado == "1") {
            $("#mensaje_grabar_pasaje").css("color", "green");
            $("#mensaje_grabar_pasaje").text("Pasaje guardado correctamente");
            id_visita_insertada = json.id_visita;
            setTimeout(() => {
              $("#mensaje_grabar_pasaje").text("");
            }, 3000);
          } else {
            console.log(id_visita_insertada);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          val_errores(jqXHR, textStatus, errorThrown);
        },
        complete: function () {
          $("#loader-container").css("opacity", "0");
        },
      });
      break;
    case "visita":
      //Obtenemos los datos
      var select_paleta_tipo_visita = $("#select_paleta_tipo_visita").val();
      var id_gestion = $("#select_paleta_visita").val();
      var comentario = $("#comentario_visita").val();

      if (id_gestion != "") {
        $("#img_visita_modal").attr(
          "src",
          "https://geochasqui.com/sistema_geo/public/img/iconos/check_button.png"
        );
      } else {
        $("#img_visita_modal").attr(
          "src",
          "https://geochasqui.com/sistema_geo/public/img/iconos/error_button.png"
        );
        //$('#mensaje_validacion').text('La respuesta  de gestión de la visita no puede ser vacía, seleccione la opción más adecuada al caso.');
        //$('#mdl_agregar_visita').modal('hide');
        //$('#mdl_mensaje_validacion').modal('show');

        $("#mensaje_grabar_visita").css("color", "red");
        $("#mensaje_grabar_visita").text("Complete los campos necesarios.");
        setTimeout(() => {
          $("#mensaje_grabar_visita").text("");
        }, 3000);
        return;
      }

      $.ajax({
        type: "POST",
        url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/actualizar",
        data: {
          tipo: tipo,
          id_visita: id,
          id_gestion: id_gestion,
          comentario: comentario,
          id_base_tex: id_base_tex,
          select_paleta_tipo_visita: select_paleta_tipo_visita,
        },
        beforeSend: function () {
          $("#loader-container").css("opacity", "1");
        },
        success: function (e) {
          var json = eval("(" + e + ")");
          if (json.mensaje_p == "1") {
            $("#mensaje_grabar_visita").css("color", "red");
            $("#mensaje_grabar_visita").text(
              "No se puede cambiar a una gestión no contacto porque cuenta con un recojo exitoso."
            );
            setTimeout(() => {
              $("#mensaje_grabar_visita").text("");
            }, 3000);
            $("#select_paleta_visita").val("15");
          } else {
            if (json.resultado == "1") {
              $("#mensaje_grabar_visita").css("color", "green");
              $("#mensaje_grabar_visita").text("Visita grabada correctamente");
              id_visita_insertada = json.id_visita;
              setTimeout(() => {
                $("#mensaje_grabar_visita").text("");
              }, 3000);
            } else {
              console.log(id_visita_insertada);
            }
            obtener_detalle_gestion(id);
          }
          //actualiza_marcadores('1');
        },
        error: function (jqXHR, textStatus, errorThrown) {
          val_errores(jqXHR, textStatus, errorThrown);
        },
        complete: function () {
          $("#loader-container").css("opacity", "0");
        },
      });
      break;
    case "equipo":
      //Obtenemos los datos
      var id_gestion = $("#select_paleta_equipo_" + id).val();
      var comentario = $("#txt_comentario_equipo_" + id).val();

      //Obtenemos los datos de los recojos
      var fecha_recojo = $("#fecha_recojo_equipo_" + id).val();
      var hora_inicio = $("#hora_inicio_recojo_equipo_" + id).val();
      var hora_fin = $("#hora_fin_recojo_equipo_" + id).val();
      var referencia = $("#referencia_recojo_equipo_" + id).val();

      var persona_contacto = $("#persona_contacto_" + id).val();
      var telefono = $("#telefono_" + id).val();

      var select_censo_correcto = $("#select_censo_correcto_" + id).val();
      var txt_censo = $("#txt_censo_" + id).val();

      //var valida = valida_seleccion(id);
      //if(valida>0){
      $.ajax({
        type: "POST",
        url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/actualizar",
        data: {
          tipo: tipo,
          id_gxeq: id,
          id_gestion: id_gestion,
          comentario: comentario,
          fecha_recojo: fecha_recojo,
          hora_inicio: hora_inicio,
          hora_fin: hora_fin,
          referencia: referencia,
          persona_contacto: persona_contacto,
          telefono: telefono,
          select_censo_correcto: select_censo_correcto,
          txt_censo: txt_censo,
          id_cliente_seleccionado: id_cliente_seleccionado,
        },
        beforeSend: function () {
          $("#loader-container").css("opacity", "1");
        },
        success: function (e) {
          var json = eval("(" + e + ")");
          if (json.resultado == "1") {
            $("#mensaje_grabar_gxeq_" + id).css("color", "green");
            $("#mensaje_grabar_gxeq_" + id).text(
              "Datos guardados correctamente"
            );
            $("#img_gxeq_" + id).attr(
              "src",
              "https://geochasqui.com/sistema_geo/public/img/iconos/" + json.img
            );

            setTimeout(() => {
              $("#mensaje_grabar_gxeq_" + id).css("color", "black");
              $("#mensaje_grabar_gxeq_" + id).text("");
            }, 3000);
            //id_visita_insertada = json.id_visita;
            //console.log(id_visita_insertada);
            //$('#mdl_agregar_visita').modal('show');
            //$('#mdl_menu').modal('hide');
          } else {
            switch (json.resultado) {
              case 10:
                $("#mensaje_validacion").text(
                  json.mensaje + " Código: " + id_cliente_seleccionado
                );
                $("#mdl_agregar_visita").modal("hide");
                $("#mdl_mensaje_validacion").modal("show");

                $("#select_paleta_equipo_" + id).val(1);
                $("#img_gxeq_" + id).attr(
                  "src",
                  "https://geochasqui.com/sistema_geo/public/img/iconos/" +
                    json.img
                );

                activa_panel_recojo(id);

                break;
              case 3:
                $("#mensaje_grabar_gxeq_" + id).css("color", "red");
                $("#mensaje_grabar_gxeq_" + id).text(
                  "El equipo tiene una programación de recojo con éxito. No se puede cambiar la gestión."
                );

                $("#select_paleta_equipo_" + id).val(1);
                $("#img_gxeq_" + id).attr(
                  "src",
                  "https://geochasqui.com/sistema_geo/public/img/iconos/" +
                    json.img
                );

                setTimeout(() => {
                  $("#mensaje_grabar_gxeq_" + id).css("color", "black");
                  $("#mensaje_grabar_gxeq_" + id).text("");
                }, 3000);
                break;
              case 2: //Status de recojo exitoso
                $("#mensaje_grabar_gxeq_" + id).css("color", "black");
                $("#mensaje_grabar_gxeq_" + id).text("Campos reestablecidos");

                $("#select_paleta_equipo_" + id).val(20);
                $("#txt_comentario_equipo_" + id).val("");
                $("#img_gxeq_" + id).attr(
                  "src",
                  "https://geochasqui.com/sistema_geo/public/img/iconos/" +
                    json.img
                );

                setTimeout(() => {
                  $("#mensaje_grabar_gxeq_" + id).css("color", "black");
                  $("#mensaje_grabar_gxeq_" + id).text("");
                }, 3000);

                break;
              default:
                $("#mensaje_grabar_gxeq_" + id).css("color", "red");
                $("#mensaje_grabar_gxeq_" + id).text(
                  "Ocurrió un error al grabar."
                );

                setTimeout(() => {
                  $("#mensaje_grabar_gxeq_" + id).css("color", "black");
                  $("#mensaje_grabar_gxeq_" + id).text("");
                }, 3000);
                break;
            }
            //$('#mensaje_validacion').text(json.mensaje);
            //$('#mdl_agregar_visita').modal('hide');
            //$('#mdl_mensaje_validacion').modal('show');
            //console.log(id_visita_insertada);
          }
          if (json.resultado_recojo == 1) {
            upd_markers(id_cliente_seleccionado, "orden", "600");
          }
          //actualiza_marcadores('1');
        },
        error: function (jqXHR, textStatus, errorThrown) {
          val_errores(jqXHR, textStatus, errorThrown);
        },
        complete: function () {
          $("#loader-container").css("opacity", "0");
        },
      });
      //}else{
      //}
      break;
    default:
      break;
  }
}

//Actualizar el historial de visitas
function actualizar_historial_visitas() {
  get_visitas(id_cliente_seleccionado, id_campania_seleccionado);
  alertify.success("Historial de visitas actualizado correctamente...");
}

//Load Data en ModalsF

//Get detalle de visitas.
function get_visitas(id_cliente_key, id_campania) {
  var data = new FormData();
  data.append("id_cliente", id_cliente_key);
  data.append("id_campania", id_campania);

  $.ajax({
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_visitas",
    //dataType: 'json',
    type: "POST",
    contentType: false,
    processData: false,
    data: data,
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (e) {
      var json = eval("(" + e + ")");

      var arr_cod_visitas = json.array_cod_visitas;
      var arr_datos = json.array_datos;

      arr_fotos = json.array_fotos;

      let inf_visita = "";
      let inf_equipo = "";
      let cuenta = "";

      let cadena_total = "";
      let inf_cabecera_visita = "";
      let inf_body_visita = "";
      let inf_pie_visita = "";

      let inf_fotos = "";

      console.log(arr_cod_visitas.length);
      //alert(arr_cod_visitas.length);
      let tt_visita = 0;

      for (let index = 0; index < arr_cod_visitas.length; index++) {
        console.log(arr_cod_visitas[index]);
        cuenta = 0;
        for (let index_j = 0; index_j < arr_datos.length; index_j++) {
          if (arr_cod_visitas[index] === arr_datos[index_j]["id"]) {
            if (cuenta === 0) {
              tt_visita++;
              inf_cabecera_visita += "";
              inf_cabecera_visita += '    <div class="card mt-3">';
              inf_cabecera_visita +=
                '        <div style="display:flex;flex-direction:column;">';
              inf_cabecera_visita +=
                '            <div class="bg-soft-info" style="padding:10px;">';
              inf_cabecera_visita +=
                "                <div><strong>Visita #" +
                tt_visita +
                "</strong></div>";
              inf_cabecera_visita +=
                "                <div><strong>Gestor: </strong>" +
                arr_datos[index]["nombres"] +
                "</div>";
              inf_cabecera_visita +=
                "                <div><strong>Fecha: </strong> " +
                arr_datos[index]["fecha_visita"] +
                "</div>";
              inf_cabecera_visita +=
                "                <div><strong>Gestión: </strong> " +
                arr_datos[index]["paleta_visita"] +
                "</div>";
              inf_cabecera_visita +=
                "                <div><strong>Comentario Visita: </strong> " +
                arr_datos[index]["comentario"] +
                "</div>";
              inf_cabecera_visita += "            </div>";

              inf_pie_visita +=
                '            <div class="d-flex justify-content-start gap-2" style="padding:10px; ">';
              inf_pie_visita +=
                '                <a class="btn btn-sm btn-success" target="_blank" href="https://www.google.com/maps/place/' +
                arr_datos[index]["latitud"] +
                "," +
                arr_datos[index]["longitud"] +
                '"><i class="mdi mdi-map-marker"></i> Ubicación </a>';
              inf_pie_visita +=
                '                <button class="btn btn-sm btn-warning"  onclick="get_imagenes(' +
                arr_datos[index]["id_visita"] +
                ')"><i class="mdi mdi-image"></i> Fotos </button>';

              //EDITAR VISITA
              if (arr_datos[index]["id_usuario"] == json.id_usuario) {
                // Obtener detalle visita
                // id_visita
                inf_pie_visita +=
                  '<button class="btn btn-sm btn-danger" onclick="obtener_detalle_visita(' +
                  arr_datos[index]["id_visita"] +
                  ", '" +
                  arr_datos[index]["base"] +
                  '\',2);"><i class="bx bx-edit-alt"></i> Editar</button>';
              }
              id_base_tex = arr_datos[index]["base"];

              //FIN EDITAR VISITA

              //inf_pie_visita+='                <button class="btn btn-sm btn-warning" onclick="abrir_modal_fotos();"><i class="mdi mdi-image"></i> Fotos de la visita</button>';
              inf_pie_visita += "            </div>";
              inf_pie_visita += "        </div>";
              inf_pie_visita += "    </div>";
              inf_pie_visita += "";

              cuenta++;
            }

            /* for (let index_k = 0; index_k < arr_datos.length; index_k++) {
                                    if(arr_datos[index_j]['id_equipo'] === arr_datos[index_k]['id_equipo']){ */
            inf_body_visita +=
              '                    <div style="padding:10px;">';
            inf_body_visita +=
              "                        <div><strong>Serie:</strong> " +
              arr_datos[index]["serie"] +
              " | <strong>Mod: </strong>" +
              arr_datos[index]["modelo"] +
              " | <strong>Censo:</strong> " +
              arr_datos[index]["censo"] +
              "</div>";
            if (arr_datos[index]["id_paletaequipo"] == 20) {
              inf_body_visita +=
                "                        <div><strong>Gestión: </strong> " +
                " Sin Contacto " +
                "</div>";
            } else {
              inf_body_visita +=
                "                        <div><strong>Gestión: </strong> " +
                arr_datos[index]["paleta_equipo"] +
                "</div>";
            }

            if (arr_datos[index]["id_paletaequipo"] == 1) {
              inf_body_visita +=
                "                        <div><strong>F. Programación: </strong> " +
                arr_datos[index]["fecha_recojo"] +
                "</div>";
              inf_body_visita +=
                "                        <div><strong>Horario: </strong> " +
                arr_datos[index]["hora_rango"] +
                " - " +
                arr_datos[index]["hora_fin"] +
                "</div>";
              inf_body_visita +=
                "                        <div><strong>Persona contacto: </strong> " +
                arr_datos[index]["persona_contacto"] +
                "</div>";
              inf_body_visita +=
                "                        <div><strong>Telefono: </strong> " +
                arr_datos[index]["telefono"] +
                "</div>";
            }

            inf_body_visita +=
              "                        <div><strong>Comentario:</strong> " +
              arr_datos[index]["comentario_equipo"] +
              ".</div>";
            inf_body_visita += "                    </div>";
            break;
            /*  }
                                } */
          }
        }
        cadena_total += inf_cabecera_visita + inf_body_visita + inf_pie_visita;
        inf_cabecera_visita = "";
        inf_body_visita = "";
        inf_pie_visita = "";
      }

      console.log(cadena_total);
      console.log(inf_fotos);
      $("#inf_visitas").html(cadena_total);

      //$('#panel_fotos').html(inf_fotos);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}

//Function model fotos
function abrir_modal_fotos() {
  $("#mdl_menu").modal("hide");
  $("#mdl_fotos").modal("show");
  console.log(arr_fotos);
}

//Función actualizar comercial
function actualizar_contacto_comercial(tipo, id) {
  //get_datos
  var nombres = "";
  var celular = "";
  switch (tipo) {
    case 1:
      nombres = $("#txt_nom_sup").val();
      celular = $("#txt_cel_sup").val();
      break;
    default:
      nombres = $("#txt_nom_vend").val();
      celular = $("#txt_cel_vend").val();
      break;
  }

  $.ajax({
    type: "POST",
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/actualizar_comercial",
    data: {
      nombres: nombres,
      celular: celular,
      tipo: tipo,
      id: id,
    },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (data) {
      alertify.success("Detalle comercial ha sido actualizado.");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}

/****************** FUNCIONES EVENTOS *********************/

/**************************************************************************************/
/***************** FUNCIONES PARA EL DETALLE DEL MENU DE OPCIONES *********************/
/**************************************************************************************/

function menu_opciones(tipo) {
  switch (tipo) {
    case "1":
      $("#inlineRadio3").prop("checked", true);
      $("#mdl_programacion_recojo").modal("show");
      get_filtro_fecha_recojo();

      break;
    case "2":
      $("#mdl_cda_talleres").modal("show");
      break;
    case "3":
      $("#mdl_transportes").modal("show");
      break;
    case "4":
      $("#mdl_hospedajes").modal("show");
      break;
    case "5":
      $("#inlineRadioOptions_micontrol_1").prop("checked", true);
      $("#mdl_micontrol").modal("show");
      break;
    case "6":
      $("#mdl_busqueda_cli").modal("show");
      break;
    case "7":
      $("#mdl_contactos_comercial").modal("show");
      get_select_cda();
      get_select_tipo_contacto();
      break;
    case "8":
      $("#mdl_dashboard").modal("show");
      break;
    case "100":
      $("#mdl_menu_opciones").modal("show");
      get_filtro_departamento_recojo();
      break;
    case "200":
      $("#mdl_menu_gastos").modal("show");
      get_filtro_departamento_recojo();
      break;
    default:
      break;
  }
}

function mdl_agregar(tipo) {
  switch (tipo) {
    case "transporte":
      $("#mdl_insert_trans").modal("show");
      $("#inlineRadio3_transporte").prop("checked", true);
      break;
    case "hotel":
      $("#mdl_insert_hotel").modal("show");
      $("#inlineRadio3_hotel").prop("checked", true);
      break;
    default:
      break;
  }
}

/************** FUNCIONES PROGRAMACION DE RECOJOS *************/

//Listo
function get_detalle_recojos_mdl() {
  var valorSeleccionado = $('input[name="inlineRadioOptions_1"]:checked').val();
  var fecha_recojo = $("#select_fecha").val();

  $.ajax({
    type: "POST",
    dataType: "json",
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_detalle_recojos_mdl",
    data: { fecha_recojo: fecha_recojo, valorSeleccionado: valorSeleccionado },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (response) {
      var contenido = "";
      var total_con = 0;
      contenido += `<h7 class="d-flex justify-content-end" >Total: ${response.content.length}</h7>`;
      for (let i = 0; i < response.content.length; i++) {
        var content = response.content[i];
        total_con += 1;
        var status = "";
        var bg = "";
        switch (content.status_recojo) {
          case "1":
            status = "PENDIENTE DE RECOJO";
            bg = "warning";
            break;
          case "2":
            status = "PENDIENTE DE RECOJO";
            bg = "warning";
            break;
          case "3":
            status = "REPROGRAMADO";
            bg = "info";
            break;
          case "4":
            status = "RECOJO EXITOSO";
            bg = "success";
            break;
          case "5":
            status = "RECOJO NO EXITOSO";
            bg = "danger";
            break;

          default:
            break;
        }

        contenido +=
          '<div class="faq-container">' +
          "<details>" +
          "<summary>" +
          '<span class="faq-title"  style="font-size:11px">' +
          "<div>" +
          '<div class="d-flex justify-content-between align-items-center">' +
          `<span class="badge bg-${bg} mb-2">${content.des_status_recojo} </span>` +
          `<span>Cod: ${content.id_cliente} </span>` +
          "</div>" +
          `<span style="display:inline-block;width:20%;">Fecha</span><span style="display:inline-block;width:80%;">: ${content.fecha_recojo} - de -  ${content.hora_rango} - a - ${content.hora_fin} </span>` +
          '<span style="display:inline-block;width:20%;">Nombres</span><span style="display:inline-block;width:80%;">: ' +
          content.nombres +
          "</span>" +
          '<span style="display:inline-block;width:20%;color:red; font-weight:bold;">Distrito</span><span style="display:inline-block;width:80%; color:red; font-weight:bold;">: ' +
          content.distrito +
          "</span>" +
          "</div>" +
          "</span>" +
          '<img src="https://geochasqui.com/sistema_geo/public/img/iconos/svg/plus.svg" class="expand-icon" alt="Plus">';
        contenido += "</summary>";
        contenido += '<div class="faq-content" style="font-size:11px">';
        contenido +=
          "<div>" +
          '<div class="sub_title">Cliente</div>' +
          '<span style="display:inline-block;width:40%;">Dirección</span><span style="display:inline-block;width:60%;">: ' +
          content.direccion +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Referencia</span><span style="display:inline-block;width:60%;">: ' +
          content.referencia +
          "</span>" +
          '<div class="sub_title">Equipo</div>' +
          '<span style="display:inline-block;width:40%;">Serie</span><span style="display:inline-block;width:60%;">: ' +
          content.serie +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Censo</span><span style="display:inline-block;width:60%;">: ' +
          content.censo +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Modelo</span><span style="display:inline-block;width:60%;">: ' +
          content.modelo +
          "</span>" +
          '<span style="display:inline-block;width:40%;">CDA</span><span style="display:inline-block;width:60%;">: ' +
          content.base_cda +
          "</span>" +
          '<div class="sub_title">Contacto</div>' +
          '<span style="display:inline-block;width:40%;">Persona</span><span style="display:inline-block;width:60%;">: ' +
          content.persona_contacto +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Celular</span><span style="display:inline-block;width:60%;">: ' +
          content.telefono +
          "</span>" +
          '<div class="sub_title">Gestor</div>' +
          '<span style="display:inline-block;width:40%;">Gestor</span><span style="display:inline-block;width:60%;">: ' +
          content.nom_gestor +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Celular</span><span style="display:inline-block;width:60%;">: ' +
          content.tel_gestor +
          "</span>" +
          '<span style="display:inline-block;width:40%; margin-top:5px">Referencia/OBS</span><span style="display:inline-block;width:60%;">: ' +
          (content.comentario_recojo == null ? "" : content.comentario_recojo) +
          " - " +
          (content.direccion_recojo == null ? "" : content.direccion_recojo) +
          "</span>" +
          '<div class="d-flex justify-content-end mt-1 gap-1 items-center">';

        contenido +=
          `<button style="font-size:17px;" class="btn btn-sm btn-soft-warning waves-effect waves-light" onclick="get_imagenes(${content.id_visita});">` +
          '<i class="bx bx-photo-album"></i><span style="font-size:11px;">Fotos</span></i>' +
          "</button>";

        contenido +=
          `<a href="https://www.google.com/maps/place/${content.coor_visitas}" target="_blank" style="font-size:17px;" class="btn btn-sm btn-soft-danger waves-effect waves-light">` +
          '<i class="bx bx-map"><span style="font-size:11px;">visita</span></i>' +
          "</a> ";

        contenido +=
          `<a href="https://www.google.com/maps/place/${content.coordenadas}" target="_blank" style="font-size:17px;" class="btn btn-sm btn-soft-danger waves-effect waves-light">` +
          '<i class="bx bx-map"><span style="font-size:11px;">PDV</span></i>' +
          "</a> ";

        "</div>" + "</div>";

        contenido += "</div>";
        contenido += "</details>";
        contenido += "</div>";
      }
      $("#content_recojos").html(contenido);
      getAccordion(".expand-icon");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}
//Listo
function get_imagenes(id_visita) {
  $.ajax({
    type: "POST",
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/ver_galeria_lindley_id",
    data: {
      id_visita: id_visita,
    },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (data) {
      var json = JSON.parse(data);
      if (json.mensaje == "ok") {
        $("#content_fotos").html($.trim(json.list_galeria));
        $("#mdl_menu_fotos").modal("show");
      } else {
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}
//Listo
function get_filtro_departamento_recojo() {
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_filtro_departamento_recojo",
    data: {},
    beforeSend: function () {},
    success: function (e) {
      $("#select_departamento").html(e);
      $("#select_departamento_cda").html(e);
      $("#select_departamento_trans").html(e);
      $("#select_departamento_hoteles").html(e);
    },
  });
}
//listo
function get_filtro_fecha_recojo() {
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_filtro_fecha_recojo",
    data: {},
    beforeSend: function () {},
    success: function (e) {
      $("#select_fecha").html(e);
    },
  });
}
//listo
function aplicar_filter_dep() {
  var dato = $("#select_departamento").val();
  var tipo = "dep";
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/aplicar_filtro",
    data: { dato: dato, tipo: tipo },
    beforeSend: function () {},
    success: function (data) {
      var json = JSON.parse(data);
      get_filtro_fecha_recojo();
    },
  });
}

/***************** FUNCIONES CDA TALLERES *********************/

//Listo
function get_detalle_almacenes() {
  var dato = $("#select_departamento_cda").val();
  if (dato == "") {
    alertify.error("Seleccione el Departamento");
  }
  $.ajax({
    type: "POST",
    dataType: "json",
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_detalle_almacenes",
    data: { dato: dato },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (response) {
      var contenido = "";
      var contador = 0;
      contenido += `<h7 class="d-flex justify-content-end mt-3" >Total: ${response.content.length}</h7>`;
      for (let i = 0; i < response.content.length; i++) {
        contador++;
        var content = response.content[i];
        var link = "";
        switch (content.tipo_coordenadas) {
          case "1":
            link = content.link_coordenadas;
            break;
          case "2":
            link =
              "https://www.google.com/maps/place/" +
              content.latitud +
              "," +
              content.longitud +
              "";
            break;
          case "3":
            link =
              "https://www.google.com/maps/place/" + content.coordenadas + "";
            break;
          default:
            break;
        }
        var status = "";
        contenido += '<div class="faq-container">';
        contenido += "<details>";
        contenido += "<summary>";
        contenido +=
          '<div class="faq-title" style="font-size:11px">' +
          "<div>" +
          '<div class="sub_title">#' +
          contador +
          " " +
          content.tipo +
          "</div>" +
          '<span style="display:inline-block;width:40%; color:red;">Dirección</span><span style="display:inline-block;width:60%;color:red;">: ' +
          content.direccion +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Provincia</span><span style="display:inline-block;width:60%;">: ' +
          content.provincia +
          "</span>" +
          '<div class="sub_title"> Datos del contacto </div>' +
          '<span style="display:inline-block;width:40%;">Contacto</span><span style="display:inline-block;width:60%;">: ' +
          content.contacto +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Cargo</span><span style="display:inline-block;width:60%;">: ' +
          content.cargo +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Teléfono</span><span style="display:inline-block;width:60%;">: ' +
          content.telefono +
          "</span>" +
          '<span style="display:inline-block;width:40%;">' +
          (content.fecha_upd == null
            ? "Fecha de registro"
            : "Fecha de actualizacion") +
          '</span><span style="display:inline-block;width:60%;">: ' +
          (content.fecha_upd == null
            ? content.fecha_registro
            : content.fecha_upd) +
          "</span>" +
          '<div class="d-flex justify-content-end mt-1">';
        if (
          content.tipo_coordenadas != null &&
          content.tipo_coordenadas != ""
        ) {
          contenido +=
            '<a href="' +
            link +
            '" target="_blank" style="font-size:17px;" class="btn btn-sm btn-soft-danger waves-effect waves-light">' +
            '<i class="bx bx-map"></i>' +
            "</a> ";
        }
        contenido +=
          '<button style="font-size:17px;" type="button" class="btn btn-sm btn-soft-warning waves-effect waves-light" onclick="editar_cda(' +
          content.id +
          ');">' +
          '<i class="bx bx-edit-alt"></i>' +
          "</button>" +
          "</div>" +
          "</div>" +
          "</div>";
        contenido += "</summary>";
        contenido += "</details>";
        contenido += "</div>";
      }
      $("#content_almacenes").html(contenido);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}
//Listo
function editar_cda(id) {
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/editar_cda",
    data: { id: id },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (data) {
      var json = JSON.parse(data);
      $("#body_upd").html(json.content);
      $("#foot_upd").html(json.foot);
      $("#title_upd").html(json.title);
      $("#mdl_editar_menu").modal("show");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}
//Listo
function logSelection(radio, tipo) {
  var val = radio.value;
  switch (tipo) {
    case "alm":
      switch (val) {
        case "1":
          $("#panel_google_insert").css("display", "block");
          $("#panel_lat_log_insert").css("display", "none");
          $("#panel_cap_coordenadas_insert").css("display", "none");
          break;
        case "2":
          $("#panel_google_insert").css("display", "none");
          $("#panel_lat_log_insert").css("display", "block");
          $("#panel_cap_coordenadas_insert").css("display", "none");
          break;
        case "3":
          $("#panel_google_insert").css("display", "none");
          $("#panel_lat_log_insert").css("display", "none");
          $("#panel_cap_coordenadas_insert").css("display", "block");
          break;

        default:
          $("#panel_google_insert").css("display", "none");
          $("#panel_lat_log_insert").css("display", "none");
          $("#panel_cap_coordenadas_insert").css("display", "none");
          break;
      }
      break;
    case "trans":
      switch (val) {
        case "1":
          $("#panel_google_transporte").css("display", "block");
          $("#panel_lat_log_transporte").css("display", "none");
          $("#panel_cap_coordenadas_transporte").css("display", "none");
          break;
        case "2":
          $("#panel_google_transporte").css("display", "none");
          $("#panel_lat_log_transporte").css("display", "block");
          $("#panel_cap_coordenadas_transporte").css("display", "none");
          break;
        case "3":
          $("#panel_google_transporte").css("display", "none");
          $("#panel_lat_log_transporte").css("display", "none");
          $("#panel_cap_coordenadas_transporte").css("display", "block");
          break;

        default:
          $("#panel_google_transporte").css("display", "none");
          $("#panel_lat_log_transporte").css("display", "none");
          $("#panel_cap_coordenadas_transporte").css("display", "none");
          break;
      }

      break;
    case "hotel":
      switch (val) {
        case "1":
          $("#panel_google_hotel").css("display", "block");
          $("#panel_lat_log_hotel").css("display", "none");
          $("#panel_cap_coordenadas_hotel").css("display", "none");
          break;
        case "2":
          $("#panel_google_hotel").css("display", "none");
          $("#panel_lat_log_hotel").css("display", "block");
          $("#panel_cap_coordenadas_hotel").css("display", "none");
          break;
        case "3":
          $("#panel_google_hotel").css("display", "none");
          $("#panel_lat_log_hotel").css("display", "none");
          $("#panel_cap_coordenadas_hotel").css("display", "block");
          break;

        default:
          $("#panel_google_hotel").css("display", "none");
          $("#panel_lat_log_hotel").css("display", "none");
          $("#panel_cap_coordenadas_hotel").css("display", "none");
          break;
      }

      break;
    default:
      break;
  }
}
//Listo
function save_almacenes(id) {
  var contacto_upd = $("#contacto_upd").val();
  var select_carga_almacenes_upd = $("#select_carga_almacenes_upd").val();
  var telefono_upd = $("#telefono_upd").val();

  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/save_almacenes",
    data: {
      contacto_upd: contacto_upd,
      select_carga_almacenes_upd: select_carga_almacenes_upd,
      id: id,
      telefono_upd: telefono_upd,
    },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (data) {
      get_detalle_almacenes();
      $("#mdl_editar_menu").modal("hide");
      alertify.success("Registro Actualizado correctamente");
    },
  });
}
//listo
function insert_almacen() {
  $("#inlineRadio3_insert").prop("checked", true);
  $("#mdl_insert_menu").modal("show");
}
//Listo
function insert_almacen_new() {
  var selectedValue = $('input[name="inlineRadioOptions_alm"]:checked').val();
  var select_tipo_almacen = $("#select_tipo_almacen").val();
  if (select_tipo_almacen == "") {
    alertify.error("Seleccione el tipo");
    return;
  }

  var select_dep_almacen = $("#select_dep_almacen").val();
  if (select_dep_almacen == "") {
    alertify.error("Seleccione el departamento");
    return;
  }

  var txt_provincia_almacen = $("#txt_provincia_almacen").val();
  if (txt_provincia_almacen == "") {
    alertify.error("Ingrese la provincia");
    return;
  }

  var txt_alm_direccion_almacen = $("#txt_alm_direccion_almacen").val();
  if (txt_alm_direccion_almacen == "") {
    alertify.error("Ingrese la dirección");
    return;
  }

  var txt_link_google_almacen = $("#txt_link_google_almacen").val();

  var txtcoordenadas_insert_almacen = $("#txtcoordenadas_insert_almacen").val();

  var txt_latitud_almacen = $("#txt_latitud_almacen").val();

  var txt_longitud_almacen = $("#txt_longitud_almacen").val();

  var txt_contacto_almacen = $("#txt_contacto_almacen").val();
  if (txt_contacto_almacen == "") {
    alertify.error("Ingrese el contacto");
    return;
  }

  var txt_cargo_almacen = $("#txt_cargo_almacen").val();
  if (txt_cargo_almacen == "") {
    alertify.error("Ingrese el cargo");
    return;
  }

  var txt_celular_almacen = $("#txt_celular_almacen").val();
  if (txt_celular_almacen == "") {
    alertify.error("Ingrese el celular");
    return;
  }

  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/insert_almacen_new",
    data: {
      selectedValue: selectedValue,
      select_tipo_almacen: select_tipo_almacen,
      select_dep_almacen: select_dep_almacen,
      txt_provincia_almacen: txt_provincia_almacen,
      txt_alm_direccion_almacen: txt_alm_direccion_almacen,
      txt_link_google_almacen: txt_link_google_almacen,
      txtcoordenadas_insert_almacen: txtcoordenadas_insert_almacen,
      txt_latitud_almacen: txt_latitud_almacen,
      txt_longitud_almacen: txt_longitud_almacen,
      txt_contacto_almacen: txt_contacto_almacen,
      txt_cargo_almacen: txt_cargo_almacen,
      txt_celular_almacen: txt_celular_almacen,
    },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (data) {
      get_detalle_almacenes();
      $("#mdl_insert_menu").modal("hide");
      alertify.success("Almacen Insertado");
    },
  });
}
//Listo
function aplicar_filter_almacenes() {
  var dato = $("#select_departamento_cda").val();
  var tipo = "almacenes";

  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/aplicar_filtro",
    data: { dato: dato, tipo: tipo },
    beforeSend: function () {},
    success: function (data) {},
  });
}

/***************** FUNCIONES  TRANSPORTES *********************/

//Listo
function get_detalle_trans_mdl() {
  $.ajax({
    type: "POST",
    dataType: "json",
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_detalle_trans_mdl",
    data: {},
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (response) {
      var contenido = "";
      var contador = 0;
      contenido += `<h7 class="d-flex justify-content-end mt-3" >Total: ${response.content.length}</h7>`;
      for (let i = 0; i < response.content.length; i++) {
        contador++;
        var content = response.content[i];
        var status = "";
        var link = "";
        switch (content.tipo_coordenadas) {
          case "1":
            link = content.link_coordenadas;
            break;
          case "2":
            link =
              "https://www.google.com/maps/place/" +
              content.latitud +
              "," +
              content.longitud +
              "";
            break;
          case "3":
            link =
              "https://www.google.com/maps/place/" + content.coordenadas + "";
            break;
          default:
            break;
        }

        contenido += '<div class="faq-container">';
        contenido += "<details>";
        contenido += "<summary>";
        contenido +=
          '<div style="font-size:11px"  class="d-flex justify-content-between items-center faq-title">' +
          '<img src="https://geochasqui.com/sistema_geo/public/img/iconos/svg/plus.svg"  alt="Plus" class="expand-icon2">' +
          "<div>" +
          content.provincia +
          "</div>" +
          "<div> " +
          content.tipo +
          "</div>" +
          "</div>";
        contenido += "</summary>";
        contenido += '<div class="faq-content" style="font-size:11px">';
        contenido +=
          "<div>" +
          '<div class="sub_title"></div>' +
          '<div class="sub_title">Contacto</div>' +
          '<span style="display:inline-block;width:40%;">Nombres</span><span style="display:inline-block;width:60%;">: ' +
          content.nombre +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Dirección</span><span style="display:inline-block;width:60%;">: ' +
          content.direccion +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Teléfono 1</span><span style="display:inline-block;width:60%;">: ' +
          content.telefono1 +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Teléfono 2</span><span style="display:inline-block;width:60%;">: ' +
          content.telefono2 +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Provincia</span><span style="display:inline-block;width:60%;">: ' +
          content.provincia +
          "</span>" +
          '<span style="display:inline-block;width:40%;">' +
          (content.f_upd == null
            ? "Fecha de registro"
            : "Fecha de actualizacion") +
          '</span><span style="display:inline-block;width:60%;">: ' +
          (content.f_upd == null ? content.f_registro : content.f_upd) +
          "</span>" +
          '<div class="d-flex justify-content-end mt-1">';
        if (
          content.tipo_coordenadas != null &&
          content.tipo_coordenadas != ""
        ) {
          contenido +=
            '<a href="' +
            link +
            '" target="_blank" style="font-size:17px;" class="btn btn-sm btn-soft-danger waves-effect waves-light">' +
            '<i class="bx bx-map"></i>' +
            "</a> ";
        }
        contenido +=
          '<button style="font-size:17px;" type="button" class="btn btn-sm btn-soft-warning waves-effect waves-light" onclick="editar_trans(' +
          content.id +
          ');">' +
          '<i class="bx bx-edit-alt" ></i>' +
          "</button> " +
          "</div>" +
          "</div>";
        contenido += "</div>";
        contenido += "</details>";
        contenido += "</div>";
      }
      $("#content_transportes").html(contenido);
      getAccordion(".expand-icon2");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}
//Listo
function editar_trans(id) {
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/editar_trans",
    data: { id: id },
    beforeSend: function () {},
    success: function (data) {
      var json = JSON.parse(data);
      $("#body_upd").html(json.content);
      $("#foot_upd").html(json.foot);
      $("#title_upd").html(json.title);
      $("#mdl_editar_menu").modal("show");
    },
  });
}
//Listo
function save_trans(id) {
  var name_trans_upd = $("#name_trans_upd").val();
  var tel_trans_upd = $("#tel_trans_upd").val();
  var tel2_trans_upd = $("#tel2_trans_upd").val();
  var select_tipo_trans_upd = $("#select_tipo_trans_upd").val();
  var direccion_trans_upd = $("#direccion_trans_upd").val();

  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/save_trans",
    data: {
      name_trans_upd: name_trans_upd,
      tel_trans_upd: tel_trans_upd,
      id: id,
      select_tipo_trans_upd: select_tipo_trans_upd,
      direccion_trans_upd: direccion_trans_upd,
      tel2_trans_upd: tel2_trans_upd,
    },
    beforeSend: function () {},
    success: function (data) {
      get_detalle_trans_mdl();
      $("#mdl_editar_menu").modal("hide");
      alertify.success("Registro Actualizado correctamente");
    },
  });
}
//Listo
function insert_transporte() {
  var selectedValue = $('input[name="inlineRadioOptions_trans"]:checked').val();
  var select_tipo_transporte = $("#select_tipo_transporte").val();
  if (select_tipo_transporte == "") {
    alertify.error("Seleccione el tipo");
    return;
  }

  var select_dep_transporte = $("#select_dep_transporte").val();
  if (select_dep_transporte == "") {
    alertify.error("Seleccione el departamento");
    return;
  }

  var txt_provincia_transporte = $("#txt_provincia_transporte").val();
  if (txt_provincia_transporte == "") {
    alertify.error("Ingrese la provincia");
    return;
  }

  var txt_direccion_transporte = $("#txt_direccion_transporte").val();
  if (txt_direccion_transporte == "") {
    alertify.error("Ingrese la dirección");
    return;
  }

  var txt_link_google_transporte = $("#txt_link_google_transporte").val();
  var txtcoordenadas_insert_transporte = $(
    "#txtcoordenadas_insert_transporte"
  ).val();
  var txt_latitud_transporte = $("#txt_latitud_transporte").val();
  var txt_longitud_transporte = $("#txt_longitud_transporte").val();

  var txt_contacto_transporte = $("#txt_contacto_transporte").val();
  if (txt_contacto_transporte == "") {
    alertify.error("Ingrese el contacto");
    return;
  }

  var txt_dni_transporte = $("#txt_dni_transporte").val();

  var txt_celular1_transporte = $("#txt_celular1_transporte").val();
  if (txt_celular1_transporte == "") {
    alertify.error("Ingrese el celular");
    return;
  }

  var txt_celular2_transporte = $("#txt_celular2_transporte").val();
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/insert_transporte",
    data: {
      selectedValue: selectedValue,
      select_tipo_transporte: select_tipo_transporte,
      select_dep_transporte: select_dep_transporte,
      txt_provincia_transporte: txt_provincia_transporte,
      txt_direccion_transporte: txt_direccion_transporte,
      txt_link_google_transporte: txt_link_google_transporte,
      txtcoordenadas_insert_transporte: txtcoordenadas_insert_transporte,
      txt_latitud_transporte: txt_latitud_transporte,
      txt_longitud_transporte: txt_longitud_transporte,
      txt_contacto_transporte: txt_contacto_transporte,
      txt_dni_transporte: txt_dni_transporte,
      txt_celular1_transporte: txt_celular1_transporte,
      txt_celular2_transporte: txt_celular2_transporte,
    },
    beforeSend: function () {},
    success: function (data) {
      get_detalle_trans_mdl();
      $("#mdl_insert_trans").modal("hide");
      alertify.success("Transporte Insertado");
    },
  });
}
//Listo
function aplicar_filtro_transporte() {
  var dato = $("#select_departamento_trans").val();
  var tipo = "transporte";
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/aplicar_filtro",
    data: { dato: dato, tipo: tipo },
    beforeSend: function () {},
    success: function (data) {},
  });
}

/******************** FUNCIONES  HOTELES **********************/

function get_detalle_hoteles() {
  $.ajax({
    type: "POST",
    dataType: "json",
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_detalle_hoteles",
    data: {},
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (response) {
      var contenido = "";
      var contador = 0;
      contenido += `<h7 class="d-flex justify-content-end mt-3" >Total: ${response.content.length}</h7>`;
      for (let i = 0; i < response.content.length; i++) {
        contador++;
        var content = response.content[i];
        var link = "";
        switch (content.tipo_coordenadas) {
          case "1":
            link = content.link_coordenadas;
            break;
          case "2":
            link =
              "https://www.google.com/maps/place/" +
              content.latitud +
              "," +
              content.longitud +
              "";
            break;
          case "3":
            link =
              "https://www.google.com/maps/place/" + content.coordenadas + "";
            break;
          default:
            break;
        }

        contenido += '<div class="faq-container">';
        contenido += "<details>";
        contenido +=
          "<summary>" +
          '<div style="font-size:11px"  class="d-flex justify-content-between items-center faq-title">' +
          `<div style="font-size:12px;font-weight:bold;">#${contador} - ${content.razon_social}</div>` +
          '<img src="https://geochasqui.com/sistema_geo/public/img/iconos/svg/plus.svg" alt="Plus" class="expand-icon2">' +
          "</div>";
        contenido += "</summary>";
        contenido += '<div class="faq-content" style="font-size:11px">';
        contenido +=
          "<div>" +
          '<div class="sub_title"></div>' +
          '<span style="display:inline-block;width:40%;">Dirección </span><span style="display:inline-block;width:60%;">: ' +
          content.direccion +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Provincia</span><span style="display:inline-block;width:60%;">: ' +
          content.provincia +
          "</span>" +
          '<span style="display:inline-block;width:40%;">RUC</span><span style="display:inline-block;width:60%;">: ' +
          content.ruc +
          "</span>" +
          '<div class="sub_title">Contacto</div>' +
          '<span style="display:inline-block;width:40%;">Nombre</span><span style="display:inline-block;width:60%;">: ' +
          content.nombres +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Teléfono 1</span><span style="display:inline-block;width:60%;">: ' +
          content.telefono_1 +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Teléfono 2</span><span style="display:inline-block;width:60%;">: ' +
          content.telefono_2 +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Aporte 1</span><span style="display:inline-block;width:60%;">: ' +
          content.nom_user +
          "</span>" +
          '<span style="display:inline-block;width:40%;margin-top:8px;">' +
          (content.fecha_upd == null
            ? "Fecha de registro"
            : "Fecha de actualización") +
          '</span><span style="display:inline-block;width:60%;">: ' +
          (content.fecha_upd == null
            ? content.fecha_registro
            : content.fecha_upd) +
          "</span>" +
          '<div class="d-flex justify-content-end mt-1">';
        if (
          content.tipo_coordenadas != null &&
          content.tipo_coordenadas != ""
        ) {
          contenido +=
            '<a href="' +
            link +
            '" target="_blank" style="font-size:17px;" class="btn btn-sm btn-soft-danger waves-effect waves-light">' +
            '<i class="bx bx-map"></i>' +
            "</a> ";
        }
        contenido +=
          '<button style="font-size:17px;" type="button" class="btn btn-sm btn-soft-warning waves-effect waves-light" onclick="editar_hotel(' +
          content.id +
          ');">' +
          '<i class="bx bx-edit-alt" ></i>' +
          "</button> " +
          "</div>" +
          "</div>";
        contenido += "</div>";
        contenido += "</details>";
        contenido += "</div>";
      }
      $("#content_hoteles").html(contenido);
      getAccordion(".expand-icon2");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}

function editar_hotel(id) {
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/editar_hotel",
    data: { id: id },
    beforeSend: function () {},
    success: function (data) {
      var json = JSON.parse(data);
      $("#body_upd").html(json.content);
      $("#foot_upd").html(json.foot);
      $("#title_upd").html(json.title);
      $("#mdl_editar_menu").modal("show");
    },
  });
}

function save_hotel(id) {
  var name_hotel_upd = $("#name_hotel_upd").val();
  var tel_hotel_upd = $("#tel_hotel_upd").val();
  var tel2_hotel_upd = $("#tel2_hotel_upd").val();
  var direccion_hotel_upd = $("#direccion_hotel_upd").val();

  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/save_hotel",
    data: {
      tel_hotel_upd: tel_hotel_upd,
      id: id,
      name_hotel_upd: name_hotel_upd,
      direccion_hotel_upd: direccion_hotel_upd,
      tel2_hotel_upd: tel2_hotel_upd,
    },
    beforeSend: function () {},
    success: function (data) {
      get_detalle_hoteles();
      $("#mdl_editar_menu").modal("hide");
      alertify.success("Registro Actualizado correctamente");
    },
  });
}

function insert_hotel() {
  var selectedValue = $('input[name="inlineRadioOptions_hotel"]:checked').val();

  var txt_ruc_hotel = $("#txt_ruc_hotel").val();
  if (txt_ruc_hotel == "") {
    alertify.error("Ingrese el RUC");
    return;
  }

  var txt_razon_social_hotel = $("#txt_razon_social_hotel").val();
  if (txt_razon_social_hotel == "") {
    alertify.error("Ingrese la Razón Social");
    return;
  }

  var select_dep_hotel = $("#select_dep_hotel").val();
  if (select_dep_hotel == "") {
    alertify.error("Seleccione el departamento");
    return;
  }

  var txt_provincia_hotel = $("#txt_provincia_hotel").val();
  if (txt_provincia_hotel == "") {
    alertify.error("Ingrese la provincia");
    return;
  }

  var txt_link_google_hotel = $("#txt_link_google_hotel").val();
  var txtcoordenadas_insert_hotel = $("#txtcoordenadas_insert_hotel").val();
  var txt_latitud_hotel = $("#txt_latitud_hotel").val();
  var txt_longitud_hotel = $("#txt_longitud_hotel").val();

  var txt_direccion_hotel = $("#txt_direccion_hotel").val();
  if (txt_contacto_transporte == "") {
    alertify.error("Ingrese la dirección");
    return;
  }

  var txt_contacto_hotel = $("#txt_contacto_hotel").val();
  if (txt_contacto_hotel == "") {
    alertify.error("Ingrese el ");
    return;
  }

  var txt_celular1_hotel = $("#txt_celular1_hotel").val();
  if (txt_celular1_hotel == "") {
    alertify.error("Ingrese el celular");
    return;
  }

  var txt_celular2_hotel = $("#txt_celular2_hotel").val();
  if (txt_celular2_hotel == "") {
    alertify.error("Ingrese el celular");
    return;
  }

  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/insert_hotel",
    data: {
      selectedValue: selectedValue,
      txt_ruc_hotel: txt_ruc_hotel,
      txt_razon_social_hotel: txt_razon_social_hotel,
      select_dep_hotel: select_dep_hotel,
      txt_provincia_hotel: txt_provincia_hotel,
      txt_direccion_hotel: txt_direccion_hotel,
      txt_contacto_hotel: txt_contacto_hotel,
      txt_celular1_hotel: txt_celular1_hotel,
      txt_celular2_hotel: txt_celular2_hotel,
      txt_link_google_hotel: txt_link_google_hotel,
      txtcoordenadas_insert_hotel: txtcoordenadas_insert_hotel,
      txt_latitud_hotel: txt_latitud_hotel,
      txt_longitud_hotel: txt_longitud_hotel,
    },
    beforeSend: function () {},
    success: function (data) {
      get_detalle_hoteles();
      $("#mdl_insert_hotel").modal("hide");
      alertify.success("Hospedaje Insertado");
    },
  });
}
//Listo
function aplicar_filter_hotel() {
  var dato = $("#select_departamento_hoteles").val();
  var tipo = "hotel";
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/aplicar_filtro",
    data: { dato: dato, tipo: tipo },
    beforeSend: function () {},
    success: function (data) {
      var json = JSON.parse(data);
    },
  });
}

/******************** FUNCIONES  MI CONTROL *******************/
function get_modal_filter() {
  $("#mdl_add_filtro").modal("show");
  $("#txt_censo_filter").val("");
  $("#txt_serie_filter").val("");
  $("#txt_codigo_filter").val("");
  $("#txt_nombre_filter").val("");
}
var tipo_detail_micontrol = 1;
function tipo_detalle_micontrol() {
  tipo_detail_micontrol = 1;
  get_detalle_micontrol();
}

function get_detalle_micontrol() {
  var date = $("#date_micontrol").val();
  if (tipo_detail_micontrol == 1) {
    if (date == "") {
      alertify.error("Seleccione la fecha a consultar");
      return;
    }
  }

  $.ajax({
    type: "POST",
    dataType: "json",
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_detalle_micontrol",
    data: { date: date },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (response) {
      /* CONTENT DETALLE MI CONTROL*/
      var total_pasaje = 0;
      var contenido = "";
      contenido += `<h7 class="d-flex justify-content-end mt-3" >Total: ${response.content.length}</h7>`;
      /* CONTENT DETALLE PASAJE*/
      var detalle = "";
      var contenido_total = `<h7 class="d-flex justify-content-end my-3">Total: ${response.content.length}</h7>`;
      var contador = 0;
      var contenido_ini = `
                        <div class="table-responsive">
                            <table class="table " style="font-size: 11px;">
                                <thead style="background:#F8F9FA;">
                                    <tr>
                                        <th scope="col">ID Cliente</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Distrito</th>
                                        <th scope="col">Pasaje</th>
                                    </tr>
                                </thead>
                                <tbody>`;

      /* FIN */
      for (let i = 0; i < response.content.length; i++) {
        /* CONTENT VISTA DETALLE */
        var content = response.content[i];
        var n = 2;
        var nombresArray = content.name_cli.split(" ").slice(0, n);
        var nombres = nombresArray.join(" ");
        var status = "";
        var bg = "";
        if (content.pasaje != null) {
          total_pasaje += parseFloat(content.pasaje);
        }

        switch (content.codigo) {
          case "0":
            status = "Sin Control";
            bg = "danger";
            break;
          case "1":
            status = "Aprobado";
            bg = "success";
            break;
          case "2":
            status = "Pendiente";
            bg = "warning";
            break;
          case "3":
            status = "Modificado";
            bg = "info";
            break;
          case "4":
            status = "Corregir Control";
            bg = "dark";
            break;
          default:
            break;
        }
        var foto = "";
        var foto_c = "";
        var w = "";
        if (content.foto != null) {
          foto = "camara.png";
        } else {
          foto = "sin-fotos.png";
        }
        if (content.coordenadas != null) {
          foto_c = "controlar.png";
        } else {
          foto_c = "quitar-ubicacion.png";
        }
        var bg_b = "#F6FAFF";
        if (content.del == 1) {
          bg_b = "#FFE0DF";
        }
        contenido += `
                            <div class="faq-container">                              
                                <details style="background:${bg_b}">
                                    <summary class="justify-content-between align-items-center">                                                
                                        <div class="d-flex justify-content-between align-items-center gap-2" style="font-size:11px">
                                            <img src="https://geochasqui.com/sistema_geo/public/img/iconos/svg/plus.svg" alt="Plus" class="expand-icon2">
                                            <div>${
                                              content.id_cliente +
                                              " - " +
                                              nombres
                                            }</div>                                                                            
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center gap-1" style="font-size:11px" >                                                       
                                            <div class="badge bg-${bg}"> ${
          content.control
        }</div>   
                                            <img style="width:18px;" src="https://geochasqui.com/sistema_geo/public/img/iconos/${foto}" alt="Plus">   
                                            <img style="width:18px;" src="https://geochasqui.com/sistema_geo/public/img/iconos/${foto_c}" alt="Plus">                    
                                        </div>
                                    </summary>
                                    <div class="faq-content" style="font-size:11px">
                                        <div>                                                                            
                                            <span style="display:inline-block;width:40%;">Fecha Visita</span><span style="display:inline-block;width:60%;">: ${
                                              content.fecha_visita
                                            }</span>
                                            <span style="display:inline-block;width:40%;">Dirección</span><span style="display:inline-block;width:60%;">: ${
                                              content.direccion
                                            }</span>                                                 
                                            
                                            <span style="display:inline-block;width:40%;margin-top:8px;">Distrito</span><span style="display:inline-block;width:60%;">: ${
                                              content.distrito
                                            }</span>
                                            <span style="display:inline-block;width:40%;">Referencia</span><span style="display:inline-block;width:60%;">: ${
                                              content.referencia
                                            }</span>
                                            <span style="display:inline-block;width:40%;margin-top:8px;">Monto Pasaje</span><span style="display:inline-block;width:60%;">: ${
                                              content.pasaje
                                            }</span>
                                            <span style="display:inline-block;width:40%;">Detalle de Pasaje</span><span style="display:inline-block;width:60%;">: ${
                                              content.detalle_pasaje
                                            }</span>
                                            <div class="d-flex justify-content-end mt-1 gap-1">`;
        if (content.coordenadas != null && content.coordenadas != "") {
          contenido += `
                                                        <a href="https://www.google.com/maps/place/${content.coordenadas}" target="_blank" style="font-size:17px;" class="btn btn-sm btn-soft-danger waves-effect waves-light">
                                                            <i class="bx bx-map"></i>
                                                        </a>
                                                    `;
        }
        contenido += ` 
                                                <button style="font-size:17px;" type="button" class="btn btn-sm btn-soft-warning waves-effect waves-light" onclick="obtener_detalle_visita(${content.id_visita},\'${content.base}\',1);">
                                                    <i class="bx bx-edit-alt"></i>
                                                </button>
                                                <button style="font-size:17px;" class="btn btn-sm btn-soft-warning waves-effect waves-light" onclick="get_imagenes(${content.id_visita});">
                                                    <i class="bx bx-photo-album"></i><span style="font-size:11px;">Fotos</span></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </details>
                            </div>`;
        /* CONTENT DETALLE PASAJE */
        var bg_new = content.del == 1 ? "FFE0DF" : "F1F5FD";
        var nombres = content.name_cli.split(" ")[0]; // Obtener primer nombre

        detalle +=
          '<tr style="background:#' +
          bg_new +
          ';">' +
          "<td>" +
          content.id_cliente +
          "</td>" +
          "<td>" +
          nombres +
          "</td>" +
          "<td>" +
          content.distrito +
          "</td>" +
          "<td>S/." +
          (content.pasaje != null ? content.pasaje : "0.00") +
          "</td>" +
          "</tr>";
        /* FIN */
      }
      /* CONTENIDO VISTA DETALLE */
      var content_foot =
        '<button  style="width: 100%; background: linear-gradient(#74788D, #A2A5B3);" type="button" class="btn btn-secondary">TOTAL PASAJE S/.<span id="t_pasaje">' +
        total_pasaje +
        "</span></button>";
      $("#content_micontrol_detalle").html(contenido);
      $("#foot_micontrol").html(content_foot);
      $("#mdl_add_filtro").modal("hide");
      getAccordion(".expand-icon2");

      /* CONTENIDO VISTA DETALLE PASAJE */
      var contenido_fin = "</tbody></table></div>";
      $("#content_micontrol_pasaje").html(
        contenido_total + contenido_ini + detalle + contenido_fin
      );

      /* FIN */
      $("#loader-container").css("opacity", "0");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}
//Listo
function get_view_micontrol(tipo) {
  switch (tipo) {
    case "pasaje":
      $("#content_micontrol_pasaje").css("display", "block");
      $("#content_micontrol_detalle").css("display", "none");

      break;
    case "detalle":
      $("#content_micontrol_pasaje").css("display", "none");
      $("#content_micontrol_detalle").css("display", "block");

      break;
    default:
      break;
  }
}

function aplicar_filter_ctrl() {
  tipo_detail_micontrol = 2;
  $("#date_micontrol").val("");
  var censo = $("#txt_censo_filter").val();
  var serie = $("#txt_serie_filter").val();
  var codigo = $("#txt_codigo_filter").val();
  var nombre = $("#txt_nombre_filter").val();

  if (censo == "" && serie == "" && codigo == "" && nombre == "") {
    alertify.error("Ingrese un dato");
    return;
  }

  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/activarFiltrosMdl",
    data: { censo: censo, serie: serie, codigo: codigo, nombre: nombre },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (data) {
      get_detalle_micontrol();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
  });
}

/******************** FUNCIONES  CONTACTOS ********************/

/* config user preaviso */
let timer = 0;
const delayValue = 100;

//tb_table_registros.ajax.reload();
var sessionInterval;

function filter_name_contacto(value) {
  var dato = value;
  var tipo = "contact";
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/aplicar_filtro",
    data: { dato: dato, tipo: tipo },
    beforeSend: function () {},
    success: function (data) {
      var json = JSON.parse(data);
      get_detalle_contactos();
    },
  });
}

$("#name_contacto_fil").on("keyup", function () {
  clearTimeout(timer);
  timer = setTimeout(() => {
    var value = $(this).val().toLowerCase();
    filter_name_contacto(value);
  }, delayValue);
});

function get_detalle_contactos() {
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_detalle_contactos",
    data: {},
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (data) {
      var json = JSON.parse(data);
      $("#content_contactos").html(json.content);
      getAccordion(".expand-icon");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}

function editar_contactos(id) {
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/editar_contactos",
    data: { id: id },
    beforeSend: function () {},
    success: function (data) {
      var json = JSON.parse(data);
      $("#body_upd").html(json.content);
      $("#foot_upd").html(json.foot);
      $("#title_upd").html(json.title);
      $("#mdl_editar_menu").modal("show");
    },
  });
}

function save_contactos(id) {
  var name_contac_upd = $("#name_contac_upd").val();
  var telefono_contact_upd = $("#telefono_contact_upd").val();
  var select_tipo_contac_upd = $("#select_tipo_contac_upd").val();
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/save_contactos",
    data: {
      name_contac_upd: name_contac_upd,
      id: id,
      telefono_contact_upd: telefono_contact_upd,
      select_tipo_contac_upd: select_tipo_contac_upd,
    },
    beforeSend: function () {},
    success: function (data) {
      get_detalle_contactos();
      $("#mdl_editar_menu").modal("hide");
      alertify.success("Registro Actualizado correctamente");
    },
  });
}

function get_select_cda() {
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_select_cda",
    data: {},
    beforeSend: function () {},
    success: function (e) {
      $("#select_cda_contac").html(e);
    },
  });
}

function get_select_tipo_contacto() {
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_select_tipo_contacto",
    data: {},
    beforeSend: function () {},
    success: function (e) {
      $("#select_tipo_contacto").html(e);
    },
  });
}

function filter_cda_contacto() {
  var dato = $("#select_cda_contac").val();
  var tipo = "cda_contact";
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/aplicar_filtro",
    data: { dato: dato, tipo: tipo },
    beforeSend: function () {},
    success: function (data) {
      var json = JSON.parse(data);
      get_detalle_contactos();
    },
  });
}

function filter_tipo_contacto() {
  var dato = $("#select_tipo_contacto").val();
  var tipo = "cda_tipo_contact";
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/aplicar_filtro",
    data: { dato: dato, tipo: tipo },
    beforeSend: function () {},
    success: function (data) {
      var json = JSON.parse(data);
      get_detalle_contactos();
    },
  });
}

function retirar_filtros() {
  $("#select_cda_contac").val("");
  $("#select_tipo_contacto").val("");
  $("#name_contacto_fil").val("");
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/unset_contac",
    data: {},
    beforeSend: function () {},
    success: function (data) {
      alertify.error("Filtros Restablecidos");
      get_detalle_contactos();
    },
  });
}

/******************** FUNCIONES  BUSQUEDA *********************/
//Listo
function get_detalle_busqueda() {
  var date = $("#date_micontrol").val();
  $.ajax({
    type: "POST",
    dataType: "json",
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_detalle_busqueda",
    data: { date: date },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (response) {
      var contenido = "";
      for (let i = 0; i < response.content.length; i++) {
        var content = response.content[i];
        var nombres = content.nombres.split(" ")[0]; // Obtener solo el primer nombre
        var status = "";
        contenido += '<div class="faq-container">';
        contenido += "<details>";
        contenido += "<summary>";
        contenido +=
          '<div style="font-size:11px"  class="d-flex justify-content-between items-center faq-title">' +
          '<img src="https://geochasqui.com/sistema_geo/public/img/iconos/svg/plus.svg"  alt="Plus" class="expand-icon2">' +
          "<div> " +
          content.serie +
          " - " +
          content.campania +
          "</div>" + // Mostrar solo el primer nombre
          "<div> " +
          content.id_cliente +
          "</div>" +
          "</div>";
        contenido += "</summary>";
        contenido += '<div class="faq-content" style="font-size:11px">';
        contenido +=
          "<div>" +
          '<div class="sub_title">Equipo</div>' +
          '<span style="display:inline-block;width:40%;">Serie</span><span style="display:inline-block;width:60%;">: ' +
          content.serie +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Censo</span><span style="display:inline-block;width:60%;">: ' +
          content.censo +
          "</span>" +
          '<div class="sub_title">Gestion</div>' +
          '<span style="display:inline-block;width:40%;">Campaña</span><span style="display:inline-block;width:60%;">: ' +
          content.campania +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Tipo Incidencia</span><span style="display:inline-block;width:60%;">: ' +
          content.tipo_incidencia +
          "</span>" +
          '<span style="display:inline-block;width:40%;">Mes Incidencia</span><span style="display:inline-block;width:60%;">: ' +
          content.mes_incidencia +
          "</span>" +
          '<div class="d-flex justify-content-end mt-1">' +
          '<button style="font-size:17px;" type="button" class="btn btn-sm btn-soft-warning waves-effect waves-light" onclick="get_detalle_equipo(' +
          content.id +
          "," +
          content.id_cliente +
          ');">' +
          '<i class="bx bx-edit-alt"></i>' +
          "</button> " +
          "</div>" +
          "</div>";
        contenido += "</div>";
        contenido += "</details>";
        contenido += "</div>";
      }

      $("#id_result_busqueda").html(contenido);
      getAccordion(".expand-icon2");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}
//Listo
function search_equipo() {
  var dato = $("#txt_codigo_cliente").val();
  var nombre = $("#txt_nombre_cliente").val();
  var serie = $("#txt_serie").val();
  var censo = $("#txt_censo").val();
  var anio_incidencia = $("input[name=formRadiosAno]:checked").val();
  var tipo_incidencia = $("input[name=formRadiosTipo]:checked").val();

  $.ajax({
    type: "POST",
    url: "https://geochasqui.com/sistema_geo/Controller_consulta/search_equipo",
    data: {
      dato: dato,
      nombre: nombre,
      censo: censo,
      serie: serie,
      anio_incidencia: anio_incidencia,
      tipo_incidencia: tipo_incidencia,
    },
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (data) {
      if (data == 1) {
        //alertify.success('Filtro activado.');
      } else {
        //alertify.error('Filtro desactivado.');
      }
      get_detalle_busqueda();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}

/******************** FUNCIONES  DASHBOARD ********************/
//Listo
function get_detalle_dashboard() {
  $.ajax({
    type: "POST",
    dataType: "json",
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/get_detalle_dashboard",
    data: {},
    beforeSend: function () {
      $("#loader-container").css("opacity", "1");
    },
    success: function (response) {
      $("#id_content_horario").html(response.content_horario);
      $("#id_content_coord").html(response.content_coor);
      $("#id_content_apoyo").html(response.content_apoyo);

      var contenido = "";
      if (response.content_recojo != "error") {
        for (let i = 0; i < response.content_recojo.length; i++) {
          var content = response.content_recojo[i];
          var n = 2;
          var nombresArray = content.nombres.split(" ").slice(0, n);
          var nombres = nombresArray.join(" ");
          var status = "";
          var bg = "";
          switch (content.status_recojo) {
            case "1":
              status = "PENDIENTE DE RECOJO";
              bg = "warning";
              break;
            case "2":
              status = "PENDIENTE DE RECOJO";
              bg = "warning";
              break;
            case "3":
              status = "REPROGRAMADO";
              bg = "info";
              break;
            case "4":
              status = "RECOJO EXITOSO";
              bg = "success";
              break;
            case "5":
              status = "RECOJO NO EXITOSO";
              bg = "danger";
              break;

            default:
              break;
          }

          contenido += '<div class="faq-container">';
          contenido += "<details >";
          contenido +=
            '<summary class="justify-content-between align-items-center">';
          contenido +=
            '<div class="d-flex justify-content-between align-items-center gap-3" style="font-size:11px">' +
            '<img src="https://geochasqui.com/sistema_geo/public/img/iconos/svg/plus.svg"  alt="Plus" class="expand-icon2">' +
            "<div> " +
            nombres +
            "</div>" + // Mostrar solo el primer nombre
            "</div>" +
            '<div style="font-size:11px"  class="d-flex justify-content-between align-items-center gap-3">' +
            "<div> " +
            content.codcliente +
            "</div>" +
            `<span class="badge bg-${bg}">${status} </span>` +
            "</div>";
          contenido += "</summary>";
          contenido += '<div class="faq-content" style="font-size:11px">';
          contenido +=
            "<div>" +
            '<div class="sub_title">Gestión</div>' +
            '<span style="display:inline-block;width:40%;">Fecha Recojo</span><span style="display:inline-block;width:60%;">: ' +
            content.fecha_recojo +
            "</span>" +
            '<span style="display:inline-block;width:40%;">Hora</span><span style="display:inline-block;width:60%;">: ' +
            content.hora_rango +
            " " +
            content.hora_fin +
            "</span>" +
            '<div class="sub_title">Equipo</div>' +
            '<span style="display:inline-block;width:40%;">Serie</span><span style="display:inline-block;width:60%;">: ' +
            content.serie +
            "</span>" +
            '<span style="display:inline-block;width:40%;">Censo</span><span style="display:inline-block;width:60%;">: ' +
            content.censo +
            "</span>" +
            '<span style="display:inline-block;width:40%;">Modelo</span><span style="display:inline-block;width:60%;">: ' +
            content.modelo +
            "</span>" +
            '<div class="sub_title">Cliente</div>' +
            '<span style="display:inline-block;width:40%;">Nombre</span><span style="display:inline-block;width:60%;">: ' +
            content.nombres +
            "</span>" +
            '<span style="display:inline-block;width:40%;">Celular</span><span style="display:inline-block;width:60%;">: ' +
            content.telefono +
            "</span>" +
            '<span style="display:inline-block;width:40%;">Dirección</span><span style="display:inline-block;width:60%;">: ' +
            content.dir +
            "</span>" +
            '<span style="display:inline-block;width:40%;">Referencia</span><span style="display:inline-block;width:60%;">: ' +
            content.referencia +
            "</span>" +
            '<div class="sub_title">Contacto</div>' +
            '<span style="display:inline-block;width:40%;">Persona Contacto</span><span style="display:inline-block;width:60%;">: ' +
            content.persona_contacto +
            "</span>" +
            '<div class="d-flex justify-content-end mt-1">';
          if (content.coordenadas != null && content.coordenadas != "") {
            contenido +=
              '<a href="https://www.google.com/maps/place/' +
              content.coordenadas +
              '" target="_blank" style="font-size:17px;" class="btn btn-sm btn-soft-danger waves-effect waves-light">' +
              '<i class="bx bx-map"></i>' +
              "</a> ";
          }
          contenido +=
            '<button style="font-size:17px;" type="button" class="btn btn-sm btn-soft-warning waves-effect waves-light" onclick="obtener_detalle_visita(' +
            content.id_visita +
            ",'" +
            content.base +
            "',1);\">" +
            '<i class="bx bx-edit-alt"></i>' +
            "</button>" +
            "</div>" +
            "</div>";
          contenido += "</div>";
          contenido += "</details>";
          contenido += "</div>";
        }
        $("#id_content_recojo").html(contenido);
      } else {
        $("#id_content_recojo").html("Sin Resultados");
      }
      getAccordion(".expand-icon2");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
      $("#loader-container").css("opacity", "0");
    },
  });
}
//Listo
function activar_filtro_fecha() {
  var fini = $("#txt_fecha_inicio").val();
  var ffin = $("#txt_fecha_fin").val();

  $("#rango_inicio").text(fini);
  $("#rango_fin").text(ffin);

  if (fini == "") {
    alertify.success("Seleccione una fecha de inicio");
    return;
  }
  if (ffin == "") {
    alertify.success("Seleccione una fecha fin");
    return;
  }

  var f1 = new Date(fini); //31 de diciembre de 2015
  var f2 = new Date(ffin); //30 de noviembre de 2014

  if (f1 > f2) {
    alerta_success(
      "error",
      "La fecha inicial es menor que la fecha final",
      "Error"
    );

    return;
  }

  var data = new FormData();
  data.append("fini", fini);
  data.append("ffin", ffin);

  $.ajax({
    type: "post",
    contentType: false,
    url: "<?php echo base_url()?>Controller_gestor_mapa_new/activar_filtro_fecha",
    data: data,
    processData: false,
    beforeSend: function () {},
    success: function (response) {
      //tb_table_consulta.ajax.reload(null,false);
      get_detalle_dashboard();
    },
  });
}

/******************** LIMPIAR FORMULARIO **********************/
function limpiar_set_form() {
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_gestor_mapa_new/retirar_filtros",
    data: {},
    beforeSend: function () {},
    success: function (data) {
      //CONTENT RECOJO
      $("#select_departamento").val("");
      $("#select_fecha").val("");
      $("#content_recojos").html("");

      //CONTENT TALLERES
      $("#select_departamento_cda").val("");
      $("#content_almacenes").html("");

      //CONTENT TRANSPORTES
      $("#select_departamento_trans").val("");
      $("#content_transportes").html("");

      //CONTENT HOSPEDAJE
      $("#select_departamento_hoteles").val("");
      $("#content_hoteles").html("");

      //CONTENT MI CONTROL
      $("#date_micontrol").val("");
      $("#txt_nombre_filter").val("");
      $("#txt_codigo_filter").val("");
      $("#txt_serie_filter").val("");
      $("#txt_censo_filter").val("");
      $("#t_pasaje").html("");
      $("#content_micontrol_detalle").html("");
      $("#content_micontrol_pasaje").html("");

      //CONTENT CONSULTA
      $("#txt_codigo_cliente").val("");
      $("#txt_serie").val("");
      $("#txt_nombre_cliente").val("");
      $("#txt_censo").val("");
      $("#id_result_busqueda").html("");

      //CONTENT CONTACTOS COMERCIAL
      $("#select_cda_contac").val("");
      $("#select_tipo_contacto").val("");
      $("#name_contacto_fil").val("");
      $("#content_contactos").html("");

      //CONTENT DASBOARD
      $("#txt_fecha_inicio").val("");
      $("#txt_fecha_fin").val("");
      $("#id_content_horario").html("00");
      $("#id_content_coord").html("00");
      $("#id_content_apoyo").html("00");
      $("#id_content_recojo").html("");
    },
  });
}

function update_view() {
  location.reload();
}

function logout() {
  window.location.href = "https://geochasqui.com/sistema_geo/logout";
}
