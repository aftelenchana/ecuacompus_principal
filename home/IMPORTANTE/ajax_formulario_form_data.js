function sendData_solciitar_ifnro_compras(){
  $('.notificacion_solicutar_informacion').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#solicitar_informacion_compra')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/agregar_compras.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){
    },
    success: function(response){
      console.log(response);
      var info = JSON.parse(response);
      if (info.noticia =='insert_correct') {
        $('.notificacion_guardar_compra').html('<div class="alert alert-success" role="alert">Compra Guardada Correctamente!</div>')

      }
      if (info.noticia =='error_servidor') {
        $('.notificacion_guardar_compra').html('<div class="alert alert-danger" role="alert">Error en el servidor, intenta mas tarde!</div>')

      }
      if (info.noticia =='documento_no_valido') {
        $('.notificacion_guardar_compra').html('<div class="alert alert-danger" role="alert">Las compras se las realiza mediante una factura autorizada!</div>')

      }


      //var info = JSON.parse(response);


    }

  });
}
