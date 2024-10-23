$(function() {
  $('#boton_agregar_contacto').on('click', function() {
    $('#modal_agregar_cliente').modal();
    $("#nombre_almacen").val('');
    $("#responsable").val('');
    $("#direccion_almacen").val('');
    $("#descripcion").val('');
    $(".noticia_agregar_clientes").html('');

  });
});


function sendData_agregar_contacto(){
  $('.noticia_agregar_contactos').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_contacto')[0]);
  $.ajax({
    data: parametros,
    url: 'embudo_ventas/agregar_contacto.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.noticia_agregar_contactos').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.noticia_agregar_contactos').html('<div class="alert alert-success background-success" role="alert">Contacto Agregada correctamente !</div>');

      }
      if (info.noticia == 'error') {
      $('.noticia_agregar_contactos').html('<div class="alert alert-danger background-danger" role="alert">Error en el servidor '+info.contenido_error+' !</div>');

      }


      }

    }

  });

}



$(function() {
  $('#boton_agregar_contactos_masivamente_wsp').on('click', function() {
    $('#modal_agregar_contactos_wsp').modal();
    $("#nombre_almacen").val('');
    $("#responsable").val('');
    $("#direccion_almacen").val('');
    $("#descripcion").val('');
    $(".noticia_agregar_contactos_masivamente_wsp").html('');

  });
});



$(document).ready(function(){
    $.ajax({
        url: 'embudo_ventas/contactos.php',
        type: 'POST',
        async: true,
        data: {
            action: 'buscar_numeros_disponibles'
        },
        success: function(response){
            console.log(response);
            var info = JSON.parse(response);

            $.each(info.data, function(index, item) {
                  var newOption = $('<option>').val(item.id).text(item.numero + ' (' + item.nombre + ')');
                 $('#numero_guibis').append(newOption);
             });

             $.each(info.data, function(index, item) {
                   var newOption = $('<option>').val(item.id).text(item.numero + ' (' + item.nombre + ')');
                  $('#numero_guibis_enviar_mensaje_rapido').append(newOption);
              });

        },
        error: function(error){
            console.log(error);
        }
    });

});




function sendData_agregar_contacto_msivamente_wsp(){
  $('.noticia_agregar_contactos_masivamente_wsp').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_contacto_masivamente_wsp')[0]);
  $.ajax({
    data: parametros,
    url: 'embudo_ventas/contactos.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.noticia_agregar_contactos_masivamente_wsp').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.noticia_agregar_contactos_masivamente_wsp').html('<div class="alert alert-success background-success" role="alert">Se ha procesado correctamente '+info.datos_wsp_insertados+' agregados,'+info.datos_wsp_duplicados+' no insertados por duplicación,'+info.datos_wsp_no_error_insertados+' errores !</div>');

      }
      if (info.noticia == 'no_es_json') {
      $('.noticia_agregar_contactos_masivamente_wsp').html('<div class="alert alert-danger background-danger" role="alert">Error , datos vacios o procesamiento incorrecto !</div>');

      }


      }

    }

  });

}
