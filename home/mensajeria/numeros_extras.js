$(document).ready(function() {
    // Inicialización de DataTable
    var tabla_clientes = $('#tabla_clientes').DataTable({
        "ajax": {
            "url": "mensajeria/numeros_extras.php",
            "type": "POST",
            "data": {
                "action": 'consultar_datos'
            },
            "dataSrc": "data",
            "error": function(xhr, error, thrown) {
                console.error('Error al cargar los datos:', error);
                 console.log('Respuesta del servidor:', xhr.responseText); // Añadido para depuración
            }
        },
        "columns": [
          { "data": "id", "render": function(data, type, row) {
              return '<button type="button" cliente="'+data+'" class="btn btn-danger sucursal_'+data+' eliminar_cliente"><i class="fas fa-trash-alt"></i></button>' +
                     '<button type="button" cliente="'+data+'" class="btn btn-warning sucursal_'+data+' editar_cliente"><i class="fas fa-edit"></i></button>';
          }},
          { "data": "nombre", "render": function(data, type, row) {
            return '<a href="escanearqrnumero?codigo=' + row.key_wsp + '">' + data + '</a>';
        }},

          { "data": "numero", "render": function(data, type, row) {
              return '<a href="consola_envio_numeros_extra?codigo=' + row.key_wsp + '">' + data + '</a>';
          }},
          { "data": "nombre_servidor" },
          { "data": "tipo_servidor" },



          { "data": "status" },
          { "data": "message" },
          {
              "data": "url_qr",
              "render": function(data, type, row) {
                  // Verificamos el valor de status
                  if (row.message === "La sesión no ha sido completada (no se ha escaneado el QR)." || row.message === "La sesión está completa.") {
                      // Envolvemos la imagen dentro de un enlace (<a>)
                      return `<a href="escanearqrnumero?codigo=${row.key_wsp}" >
                                  <img src="${data}" alt="QR Image" width="100" height="100">
                              </a>`;
                  } else {
                      // Si no coincide, simplemente retornamos un mensaje
                      return "";
                  }
              }
          }
        ],

        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "url": "/home/guibis/data-table.json"
        },
        "order": [],
        "destroy": true,
        "destroy": true,
        "autoWidth": false  // Agrega esta línea
    });

    // Función para enviar datos del formulario
    function sendData_cliente(){
        $('.noticia_agregar_numeros').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#add_cliente')[0]);
        $.ajax({
            data: parametros,
            url: 'mensajeria/numeros_extras.php',
            type: 'POST',
            contentType: false,
            processData: false,
            beforesend: function(){
            },
            success: function(response){
                console.log(response);
                if (response =='error') {
                    $('.alerta_nuevoproducto').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
                } else {
                    var info = JSON.parse(response);

                    if (info.noticia == 'insert_correct') {
                                    $('.noticia_agregar_numeros').html('<div class="alert alert-success background-success">'+
                                        '<strong>Número Extra !</strong> Registrado correctamente'+
                                    '</div>');
                                    tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
                                }


                  if (info.noticia == 'error_insertar') {
                      $('.noticia_agregar_numeros').html('<div class="alert alert-danger background-danger">'+
                          '<strong>Error!</strong>Error en el servidor'+
                      '</div>');
                  }
                }
            }
        });
    }


    $('#tabla_clientes').on('click', '.eliminar_cliente', function(){
        var cliente = $(this).attr('cliente');
        var action = 'eliminar_cliente';
        $.ajax({
            url: 'mensajeria/numeros_extras.php',
            type: 'POST',
            async: true,
            data: {action: action,cliente:cliente},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    if (info.noticia == 'insert_correct') {
                        // Código para manejar inserción correcta
                        tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
                    }
                    if (info.noticia == 'error_insertar') {
                        // Código para manejar error al insertar
                    }
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });
    $('#tabla_clientes').on('click', '.editar_cliente', function(){
        $('#modal_editar_cliente').modal();
        $(".noticia_editar_numero_wsp").html('');
        var cliente = $(this).attr('cliente');
        var action = 'info_cliente';
        $.ajax({
            url: 'mensajeria/numeros_extras.php',
            type: 'POST',
            async: true,
            data: {action: action, cliente: cliente},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    $("#nombre_update").val(info.nombre);
                    $("#numero_update").val(info.numero);
                    $("#estado_inteligencia_ertificial_update").val(info.estado_inteligencia_ertificial);
                    $("#contecto_system_update").val(info.contecto_system);
                    $("#servidor_update").val(info.servidor);
                    $("#id_cliente").val(info.id);
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    // Función para editar
    function sendData_update_cliente(){
        $('.noticia_editar_numero_wsp').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#update_cliente')[0]);
        $.ajax({
            data: parametros,
            url: 'mensajeria/numeros_extras.php',
            type: 'POST',
            contentType: false,
            processData: false,
            beforesend: function(){
            },
            success: function(response){
                console.log(response);
                if (response =='error') {
                    $('.noticia_editar_numero_wsp').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
                } else {
                    var info = JSON.parse(response);
                    if (info.noticia == 'insert_correct') {
                                    $('.noticia_editar_numero_wsp').html('<div class="alert alert-success background-success">'+
                                        '<strong>Número !</strong> Editado Correctamente'+
                                    '</div>');
                                    tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
                                }
                  if (info.noticia == 'error_insertar') {
                      $('.noticia_editar_numero_wsp').html('<div class="alert alert-danger background-danger">'+
                          '<strong>Error!</strong>Error en el servidor'+
                      '</div>');
                  }
                }
            }
        });
    }

      // ediat_alacen
    $('#update_cliente').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario por defecto
        sendData_update_cliente();
    });



    // Evento submit del formulario
    $('#add_cliente').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario por defecto
        sendData_cliente();
    });
});


  $(function() {
    $('#boton_agregar_cliente').on('click', function() {
      $('#modal_agregar_cliente').modal();
      $("#nombre").val('');
      $("#numero").val('');
      $("#contecto_system").val('');
      $("#estado_inteligencia_artificial").val('');
      $(".noticia_agregar_numeros").html('');

    });
  });


  //CODIGO PARA QUE COLOQUEN EL NUMERO DE CELULAR
  $(document).ready(function(){
      $.ajax({
          url: 'mensajeria/numeros_extras.php',
          type: 'POST',
          async: true,
          data: {
              action: 'buscar_servidores'
          },
          success: function(response){
              console.log(response);
              var info = JSON.parse(response);

              $.each(info.data, function(index, item) {
                    var newOption = $('<option>').val(item.id).text(item.nombre + ' (' + item.tipo + ')');
                   $('#servidor').append(newOption);
               });

               $.each(info.data, function(index, item) {
                     var newOption = $('<option>').val(item.id).text(item.nombre + ' (' + item.tipo + ')');
                    $('#servidor_update').append(newOption);
                });

          },
          error: function(error){
              console.log(error);
          }
      });

  });
