$(document).ready(function() {

  $('.integrador_qr_wsp').html(' <div class="notificacion_negativa">'+
      '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');

    $.ajax({
        url: 'mensajeria/whatsapp.php',
        type: 'POST',
        async: true,
        data: {
            action: 'informacion_session'
        },
        success: function(response) {
            console.log(response);
              var info = JSON.parse(response);

              if (info.accion == 'init_session') {
                $.ajax({
                    url: 'mensajeria/whatsapp.php',
                    type: 'POST',
                    async: true,
                    data: {
                        action: 'iniciar_session'
                    },
                    success: function(response) {
                        console.log(response);
                          var info = JSON.parse(response);

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                });

              }

              if (info.accion == 'vizualisar_qr') {

                console.log('ESRAMOS MOSTRANDO EL LOGIN Y OCULTANDO LA INFORMACION DEL USUARIO');
                //$('#contendedor_antes_loguearse').css('display', 'blok');
                //  $('#contendedor_despues_loguearse').css('display', 'none');
                $('.integrador_qr_wsp').html('<img id="qrCode" src="' + info.url_vie + '" alt="QR Code">');
                  // Iniciar un intervalo para actualizar cada 3 segundos
                  setInterval(function() {
                      actualizarQR(info.url_vie);
                  }, 3000); // 3000 milisegundos = 3 segundos

              }

              if (info.accion == 'quitar_el_login_ver_contactos') {
                  console.log('ESRAMOS MOSTRANDO LA INFIRMACION DEL USUARIO Y OCULTANDO EL LOGIN');
              //  $('#contendedor_antes_loguearse').css('display', 'none');
              //    $('#contendedor_despues_loguearse').css('display', 'block');
                  //AGREGAMOS DOS NUEVAS APIS UNA PARA VER EL ESTADO Y OTRA PARA VER LOS CONTACTOS


                  //VER ESTADO DE LA SESION
                  $.ajax({
                      url: 'mensajeria/whatsapp.php',
                      type: 'POST',
                      async: true,
                      data: {
                          action: 'estado_session'
                      },
                      success: function(response) {
                          console.log(response);
                            var info = JSON.parse(response);
                            if (info.noticia == 'estado_activa') {
                              $('.estado_session').html('Activa');

                              console.log('ESRAMOS MOSTRANDO LA INFIRMACION DEL USUARIO Y OCULTANDO EL LOGIN');

                              $('#contendedor_antes_loguearse').css('display', 'none');
                                $('#contendedor_despues_loguearse').css('display', 'block');

                              //PARA SACAR LOS NUMEROS DE LOS CONTACTOS
                              $.ajax({
                                  url: 'mensajeria/whatsapp.php',
                                  type: 'POST',
                                  async: true,
                                  data: {
                                      action: 'sacar_contactos'
                                  },
                                  success: function(response) {
                                      console.log(response);
                                        var info = JSON.parse(response);
                                        // Limpiar la lista de contactos
                                         $('#contact-list').empty();

                                         // Iterar sobre los contactos y agregarlos a la lista
                                          $.each(info, function(key, contacto) {
                                              // Obtener el id y quitar el sufijo
                                              var contactoId = contacto.id ? contacto.id.replace('@s.whatsapp.net', '') : '';
                                              // Obtener el nombre o dejar vacío si es undefined
                                              var notify = contacto.notify ? contacto.notify : '';
                                              var name = contacto.name ? contacto.name : '';

                                              // Agregar el contacto a la lista
                                              $('#contact-list').append(
                                                  '<li class="list-group-item">' +
                                                  notify + ' ' + name + ' ' +
                                                  '<span class="text-muted"> ' + contactoId + '</span>' +
                                                  '</li>'
                                              );
                                          });

                                  },
                                  error: function(jqXHR, textStatus, errorThrown) {
                                      console.log('Error: ' + textStatus + ' - ' + errorThrown);
                                  }
                              });

                            }

                      },
                      error: function(jqXHR, textStatus, errorThrown) {
                          console.log('Error: ' + textStatus + ' - ' + errorThrown);
                      }
                  });







              }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error: ' + textStatus + ' - ' + errorThrown);
        }
    });
});


function actualizarQR(baseUrl) {
    // Generar un nuevo URL para el QR, añadiendo un parámetro único
    const nuevoUrl = baseUrl + '?s=' + new Date().getTime(); // Usar timestamp para evitar caché

    // Actualizar el src del img con el nuevo URL
    $('#qrCode').attr('src', nuevoUrl);

    console.log("Actualizando QR a: " + nuevoUrl);
}





    // VER ESTADO DE LA SESION
    $.ajax({
        url: 'mensajeria/whatsapp.php',
        type: 'POST',
        async: true,
        data: {
            action: 'estado_session'
        },
        success: function(response) {
            console.log(response);
            var info = JSON.parse(response);
            if (info.noticia == 'estado_activa') {
                $('.estado_session').html('Activa');

                console.log('ESRAMOS MOSTRANDO EL LOGIN ');

              //  $('#contendedor_antes_loguearse').css('display', 'none');
              //  $('#contendedor_despues_loguearse').css('display', 'block');

                // PARA SACAR LOS NUMEROS DE LOS CONTACTOS
                $.ajax({
                    url: 'mensajeria/whatsapp.php',
                    type: 'POST',
                    async: true,
                    data: {
                        action: 'sacar_contactos'
                    },
                    success: function(response) {
                        console.log(response);
                        var info = JSON.parse(response);
                        // Limpiar la lista de contactos
                        $('#contact-list').empty();

                        // Iterar sobre los contactos y agregarlos a la lista
                        $.each(info, function(key, contacto) {
                            // Obtener el id y quitar el sufijo
                            var contactoId = contacto.id ? contacto.id.replace('@s.whatsapp.net', '') : '';
                            // Obtener el nombre o dejar vacío si es undefined
                            var notify = contacto.notify ? contacto.notify : '';
                            var name = contacto.name ? contacto.name : '';

                            // Agregar el contacto a la lista
                            $('#contact-list').append(
                                '<li class="list-group-item">' +
                                notify + ' ' + name + ' ' +
                                '<span class="text-muted"> ' + contactoId + '</span>' +
                                '</li>'
                            );
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            }

            if (info.noticia == 'estado_activa') {

              console.log('ESRAMOS MOSTRANDO LA INFIRMACION DEL USUARIO Y OCULTANDO EL LOGIN');

            //  $('#contendedor_antes_loguearse').css('display', 'blok');
            //    $('#contendedor_despues_loguearse').css('display', 'none');

            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error: ' + textStatus + ' - ' + errorThrown);
        }
    });
