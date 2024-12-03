function modal_fotos_visita(id_visita) {
  $("#modal_img_visitas").modal("show");
  ver_galeria_lindley(id_visita);
}

function ver_galeria_lindley(id_visita) {
  $.ajax({
    type: "POST",
    url: "https://geochasqui.com/sistema_geo/Controller_galeria_lindley/ver_galeria_lindley_consulta",
    data: {
      id_visita: id_visita,
    },
    beforeSend: function () {},
    success: function (data) {
      var json = eval("(" + data + ")");
      if (json.mensaje == "ok") {
        $("#list_galeria").html($.trim(json.list_galeria));
      } else {
      }
    },
  });
}

//OBTENER DETALLE DE EQUIPO Y CLIENTE

function get_detalle_incidencia() {
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_consulta/get_detalle_incidencia",
    data: {
      id: id_upd,
    },
    beforeSend: function () {
      $(".loader_carga").fadeIn("slow");
    },
    success: function (e) {
      $(".loader_carga").fadeOut("slow");
      $("#mdl_detalle_incidencia").modal("show");
      $("#detalle_incidencia").html(e);
    },
  });
}

//**********************************

//OBTENER DETALLE DE EQUIPO Y CLIENTE

function get_detalle_equipo(id, id_cliente) {
  $.ajax({
    type: "POST",
    //dataType: 'json',
    url: "https://geochasqui.com/sistema_geo/Controller_consulta/get_detalle_equipo",
    data: {
      id: id,
      id_cliente: id_cliente,
    },
    beforeSend: function () {
      $('#loader-container').css('opacity', '1');
    },
    success: function (e) {
     

      id_upd = id;
      var res = jQuery.parseJSON(e);

      if (res.mensaje != "error") {
        id_cliente = res.id_cliente;
        id_cliente_pdf = res.id;

        $("#id_cliente1").val(res.id);
        $("#txt_id").val(res.id);
        $("#txt_title_codigo").text(res.id_cliente);

        $("#txt_nombres_cliente").text(res.nombres_cliente);
        $("#txt_direccion_cliente").text(res.direccion_cliente);
        $("#txt_distrito_cliente").text(res.distrito_cliente);
        $("#txt_departamento_cliente").text(res.departamento_cliente);

        $("#txt_region").text(res.region);
        $("#txt_base_sub_region").text(res.base_sub_region);
        $("#txt_base_cda").text(res.base_cda);
        $("#txt_coordenadas").text(res.coordenadas);
        $("#txt_serie_equipo").text(res.serie_equipo);
        $("#txt_censo_equipo").text(res.censo_equipo);
        $("#txt_modelo_equipo").text(res.modelo_equipo);
        $("#txt_nombre_equipo").text(res.nombre_equipo);
        $("#txt_marca_equipo").text(res.marca_equipo);
        $("#txt_instalacion_equipo").text(res.f_instalacion);
        $("#txt_cierre").text(res.cierre);
        $("#txt_mes").text(res.mes);
        $("#txt_semana").text(res.semana);

        //Detalle comercial
        $("#detalle_comercial").text(res.data_comercial);
        $("#tbl_otras_incidencias").html(res.mdl_otras_incidencias);

        $("tr").removeClass("selected-row");

        $("#row_select_" + id).addClass("selected-row_2");

        $("#mdl_detalle_bloque_cotizacion").modal("show");
        //tb_table_equipos.ajax.reload();
        get_data_visita_1(id);
      } else {
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
        val_errores(jqXHR, textStatus, errorThrown);
    },
    complete: function () {
        $('#loader-container').css('opacity', '0');
    }
  });
}
//**********************************

//OBTENER DETALLE DE VISITA

function get_data_visita_1(id) {
  $.ajax({
    type: "POST",
    url: "https://geochasqui.com/sistema_geo/Controller_consulta/get_data_visita",
    data: {
      id: id,
    },
    beforeSend: function () {},
    success: function (data) {
      var json = eval("(" + data + ")");
      if (json.mensaje == "ok") {
        $("#listar_visitas_1").html($.trim(json.listar_visitas));

        //Consultamos donde se dejó el equipo de frio
        $("#txt_tipo_incidencia").text(json.tipo_incidencia);
        $("#txt_mes_incidencia").text(json.mes_incidencia);

        if (json.id_programacion != "0") {
          $("#panel_entrega_equipo").css("display", "block");
          get_data_entrega(json.id_programacion);
        } else {
          $("#panel_entrega_equipo").css("display", "none");
        }
      } else {
      }
    },
  });
}

//OBTENER DETALLDE ENTREGA DE EQUIPO
function get_data_entrega(id) {
  $.ajax({
    type: "POST",
    url: "https://geochasqui.com/sistema_geo/Controller_consulta/get_data_entrega",
    data: {
      id: id,
    },
    beforeSend: function () {},
    success: function (data) {
      var json = eval("(" + data + ")");
      //$('#txt_entrega_departamento').text(json.departamento);
      $("#txt_entrega_direccion").text(json.direccion);
      $("#txt_entrega_provincia").text(
        json.provincia + " - " + json.departamento
      );
      $("#txt_entrega_tipo").text(json.tipo);
    },
  });
}

//***********************
