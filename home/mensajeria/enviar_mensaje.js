function sendData_iniciar() {
    $(".alerta_inicio_campana").html(
        '<div class="proceso">' +
        '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>' +
        "</div>"
    );

    var parametros = new FormData($("#iniciar")[0]);

    $.ajax({
        data: parametros,
        url: "mensajeria/reload_wsp.php",
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

                    if (info.noticia === 'procesar_datos') {
                        var codigo_envio = info.mensaje_masivo;
                        var cantidad_datos = parseInt(info.cantidad_datos);  // Cantidad de datos a iterar
                        var intervalo_tiempo = parseInt(info.intervalo_tiempo) * 1000;  // Intervalo en milisegundos

                        var contador = 0; // Contador para iterar sobre los datos

                        function enviarDatos() {
                            if (contador < cantidad_datos) {
                                var action = 'enviar_mensaje';

                                $.ajax({
                                    url: 'mensajeria/enviar_mensaje.php',
                                    type: 'POST',
                                    async: true,
                                    data: {action: action, codigo_envio: codigo_envio},
                                    success: function(response) {
                                        console.log(response);
                                        if (response !== 'error') {
                                            try {
                                                var info_envio = JSON.parse(response);

                                                if (info_envio.noticia == 'dato_procesado') {
                                                    $(".alerta_inicio_campana").html('<div class="alert alert-info background-info"  role="alert">' + info_envio.numero + ' procesado, faltan '+info_envio.cantidad_datos_faltantes+'  !</div>');
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
