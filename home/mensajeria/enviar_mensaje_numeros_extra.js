function sendData_iniciar() {
    $(".alerta_inicio_campana").html(
        '<div class="proceso">' +
        '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>' +
        "</div>"
    );

    var parametros = new FormData($("#iniciar")[0]);

    $.ajax({
        data: parametros,
        url: "mensajeria/reload_wsp_numeros_extra.php",
        type: "POST",
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);

            if (response == "error") {
                $(".alerta_inicio_campana").html('<p class="alerta_negativa">Error al iniciar la campaña</p>');
            } else {
                try {
                    var info = JSON.parse(response); // Intentamos parsear el JSON

                    if (info.modo_tiempo == 'en_tiempo_real') {
                      if (info.noticia === 'procesar_datos') {
                          var codigo_envio = info.mensaje_masivo;
                          var cantidad_datos = parseInt(info.cantidad_datos);  // Cantidad de datos a iterar
                          var intervalo_tiempo = parseInt(info.intervalo_tiempo) * 1000;  // Intervalo en milisegundos

                          var contador = 0; // Contador para iterar sobre los datos

                          function enviarDatos() {
                              if (contador < cantidad_datos) {
                                  var action = 'enviar_mensaje';

                                  $.ajax({
                                      url: 'mensajeria/enviar_mensaje_numeros_extra.php',
                                      type: 'POST',
                                      async: true,
                                      data: {action: action, codigo_envio: codigo_envio},
                                      success: function(response) {
                                          console.log(response);
                                          if (response !== 'error') {
                                              try {
                                                  var info_envio = JSON.parse(response);

                                                  if (info_envio.noticia == 'dato_procesado') {
                                                      $(".alerta_inicio_campana").html('<div class="alert alert-info background-info"  role="alert">' + info_envio.numero + ' procesado ,' + info_envio.estatus_mensaje + ', faltan '+info_envio.cantidad_datos_faltantes+' Mensaje Enviado: '+info_envio.mensaje+'  !</div>');
                                                  }

                                              } catch (e) {
                                                  console.log("Error al parsear la respuesta AJAX:", e);
                                              }
                                          } else {
                                              console.log("Error en la respuesta del servidor.");
                                          }
                                      },
                                      error: function(error) {
                                          console.log("Error en la solicitud AJAX:", error);
                                      }
                                  });

                                  // Incrementamos el contador para la siguiente iteración
                                  contador++;

                                  // Llamar a enviarDatos de nuevo después del intervalo especificado
                                  setTimeout(enviarDatos, intervalo_tiempo);
                              } else {
                                  // Una vez terminado, mostramos mensaje final
                                  $(".alerta_inicio_campana").append('<div class="alert alert-success" role="alert"> Datos Procesados correctamente!</div>');
                              }
                          }

                          // Iniciar el envío de datos
                          enviarDatos();
                      }

                    }

                    if (info.modo_tiempo == 'diferido') {

                        $(".alerta_inicio_campana").html('<div class="alert alert-success" role="alert">Se ha guardado la campaña exitosamente para la fecha '+info.fecha_hora_envio+' !</div>');

                    }


                } catch (e) {
                    console.log("Error al procesar el JSON de respuesta:", e);
                }
            }
        },
        error: function(error) {
            console.log("Error en la solicitud principal:", error);
            $(".alerta_inicio_campana").html('<p class="alerta_negativa">Error al procesar la campaña</p>');
        }
    });
}


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

        },
        error: function(error){
            console.log(error);
        }
    });

});


const radioEnTiempoReal = document.getElementById('en_tiempo_real');
const radioDiferido = document.getElementById('diferido');
const inputDiferido = document.getElementById('input_diferido');
const alertaDiferido = document.getElementById('alerta_diferido');

// Evento para manejar el cambio en los radios
document.querySelectorAll('input[name="modo_tiempo"]').forEach((radio) => {
    radio.addEventListener('change', () => {
        if (radio.value === 'diferido') {
            inputDiferido.style.display = 'block';
            alertaDiferido.style.display = 'block';
        } else {
            inputDiferido.style.display = 'none';
            alertaDiferido.style.display = 'none';
        }
    });
});
