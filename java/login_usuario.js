
function sendData_login_ecuacompus(){
  $('.notificacion_login_ecuacompus').html('<div class="proceso">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');
  var parametros = new  FormData($('#login_ecuacompus')[0]);
  $.ajax({
    data: parametros,
    url: 'java/login_usuario.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
        console.log(response);
      if (response =='error') {
        $('.notificacion_login_ecuacompus').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
        var info = JSON.parse(response);
        if (info.noticia == 'cuenta_existente') {
          $('.notificacion_login_ecuacompus').html('<div class="alert alert-danger" role="alert">Este correo ya se encuentra registrado, si olvidaste tu contraseña dale en recuperar contraseña!</div>')
        }
        if (info.noticia == 'cuenta_creaqda') {
          $('.notificacion_login_ecuacompus').html('<div class="alert alert-success" role="alert">Cuenta Creada Correctamente Revisa en tu correo(spam) un email de registro!</div>')
        }
        if (info.noticia == 'errror_servidor') {
          $('.notificacion_login_ecuacompus').html('<div class="alert alert-danger" role="alert">Error en el servidor contacta con soporte!</div>')
        }

        if (info.noticia == 'codigo_referido_no_encontrado') {
          $('.notificacion_login_ecuacompus').html('<div class="alert alert-warning" role="alert">Código Referido no Encontrado, Verifíca o dejalo vacio!</div>')
        }




      }

    }

  });

}
