
function sendDatapassword(){
  $('.alert_general').html('<div class="proceso">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new  FormData($('#add_form_password')[0]);
  $.ajax({
    data: parametros,
    url: 'java/recuperar_password.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
        console.log(response);
      if (response =='error') {
        $('.alerteditt_registrarte').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
        var info = JSON.parse(response);
        if (info.resp_password == 'positiva') {
          $('.col-sm-12').html(' <form class="add_form_password" action="" method="post"name="add_form_repera_pasword_fin" id="add_form_repera_pasword_fin" onsubmit="event.preventDefault(); sendDataverifi_pasword_fin();" >'+
                                    '  <div class="text-center">'+
                                    '      <a href="/"><img src="img/guibis.png" width="90px;" alt="logo.png" /></a>'+
                                    '  </div>'+
                                    '  <div class="auth-box card">'+
                                        '  <div class="card-block">'+
                                            '  <div class="row m-b-20">'+
                                                '  <div class="col-md-12">'+
                                                    '  <h3 class="text-center">Ingresa el Pin que esta en tu bandeja de Correo</h3>'+
                                              '    </div>'+
                                          '    </div>'+
                                              '  <div class="form-group form-primary">'+
                                                '    <input type="number" name="codigo_recuperacion" class="form-control" required placeholder="Ingresa tu Pin" />'+
                                                    '    <input type="hidden" name="iduser" value="'+info.iduser+'">'+
                                                  '    <input type="hidden" name="usuario_recupera_password" value="">'+
                                                '    <span class="form-bar"></span>'+
                                              '  </div>'+

                                              '  <div class="form-group form-primary">'+
                                                '    <input type="password" name="new_password" class="form-control" required placeholder="Ingresa tu nueva Contraseña" />'+
                                                '    <span class="form-bar"></span>'+
                                              '  </div>'+



                                              '  <div class="row m-t-30">'+
                                                '    <div class="col-md-12">'+
                                                  '      <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Enviar Pin</button>'+
                                                    '   </div>'+
                                              '  </div>'+
                                              '  <div class="alert_verrifi_codigo">'+
                                              '  </div>'+
                                            '  <hr />'+
                                            '  <div class="row">'+
                                                '  <div class="col-md-10">'+
                                                '      <p class="text-inverse text-left m-b-0">Gracias.</p>'+
                                                '      <p class="text-inverse text-left">'+
                                                '          <a href="/"><b class="f-w-600">Regresar al Inicio</b></a>'+
                                                '      </p>'+
                                                '      <p class="text-inverse text-left">'+
                                                '          <a href="regist"><b class="f-w-600">No tienes una cuenta ? Registrate</b></a>'+
                                                '        </p>'+
                                                '  </div>'+
                                                '  <div class="col-md-2">'+
                                                  '    <img src="img/guibis.png" width="70px" alt="small-logo.png" />'+
                                              '    </div>'+
                                        '      </div>'+
                                        '  </div>'+
                                      '</div>'+
                                  '</form>');
        }
        if (info.resp_password == 'error_enviar_codigo') {
          $('.alert_general').html('<p style="background: #ff481c;border-radius: 5px;">Error al enviar el codigo contactanos en nuestras lineas directas.</p>');
        }

        if (info.resp_password == 'no_existe_email') {
          $('.alert_general').html('<p style="background: #ff481c;border-radius: 5px;">El email que ingresaste no existe.</p>');

        }



      }

    }

  });

}




function sendDataverifi_pasword_fin(){
   $('.alert_verrifi_codigo').html('<div class="proceso">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#add_form_repera_pasword_fin')[0]);
  $.ajax({
    data: parametros,
    url: 'java/confirmar_codigo.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
      }else {
      var info = JSON.parse(response);
      if (info.resp_password == 'positiva') {
        $('.alert_verrifi_codigo').html('<div class="alert alert-success background-success">'+
        '</button>'+
        '<strong>Contraseña!</strong> cambiada Correctamente'+
        '</div>');
      }

      if (info.resp_password == 'ingrese_codigo_valido') {
        $('.alert_verrifi_codigo').html('<p>Codigo Incorrecto.</p>');
      }

      if (info.resp_password == 'cuenta_inexistente') {
        $('.alert_verrifi_codigo').html('<p>Cuenta Inexistente.</p>');
      }


      }

    }

  });

}
function closeModal_verificar_codigo(){
  $('.modal_password').fadeOut();
}
