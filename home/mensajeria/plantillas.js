$(document).ready(function() {
    // Inicialización de DataTable
    var tabla_clientes = $('#tabla_clientes').DataTable({
        "ajax": {
            "url": "mensajeria/plantillas.php",
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
          { "data": "id" },
          { "data": "nombre" },
          { "data": "texto" },


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
        $('.noticia_agregar_variables_entorno').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#add_cliente')[0]);
        $.ajax({
            data: parametros,
            url: 'mensajeria/plantillas.php',
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
                                    $('.noticia_agregar_variables_entorno').html('<div class="alert alert-success background-success">'+
                                        '<strong>Plantilla  !</strong> agregada correctamente'+
                                    '</div>');
                                    tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
                                }


                  if (info.noticia == 'error_insertar') {
                      $('.noticia_agregar_variables_entorno').html('<div class="alert alert-danger background-danger">'+
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
            url: 'mensajeria/plantillas.php',
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
        $('#modal_editar_cliente').modal('show');
        $(".alerta_editar_categoria").html('');
        var cliente = $(this).attr('cliente');
        var action = 'info_cliente';
        $.ajax({
            url: 'mensajeria/plantillas.php',
            type: 'POST',
            async: true,
            data: {action: action, cliente: cliente},
            success: function(response){
                console.log(response);
                if (response != 'error') {
                    var info = JSON.parse(response);
                    $("#nombre_update").val(info.nombre);
                    $("#texto_update").val(info.texto);
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
        $('.alerta_editar_categoria').html(' <div class="notificacion_negativa">'+
            '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
        '</div>');
        var parametros = new FormData($('#update_cliente')[0]);
        $.ajax({
            data: parametros,
            url: 'mensajeria/plantillas.php',
            type: 'POST',
            contentType: false,
            processData: false,
            beforesend: function(){
            },
            success: function(response){
                console.log(response);
                if (response =='error') {
                    $('.notificacion_agregar_sucursal').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
                } else {
                    var info = JSON.parse(response);
                    if (info.noticia == 'insert_correct') {
                                    $('.alerta_editar_categoria').html('<div class="alert alert-success background-success">'+
                                        '<strong>Variables !</strong> Editado Correctamente'+
                                    '</div>');
                                    tabla_clientes.ajax.reload(); // Recargar los datos en la tabla
                                }
                  if (info.noticia == 'error_insertar') {
                      $('.alerta_editar_categoria').html('<div class="alert alert-danger background-danger">'+
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
      $('#modal_agregar_cliente').modal('show');
      $("#texto").val('');
      $(".noticia_agregar_plantilla").html('');

    });
  });



  document.addEventListener('DOMContentLoaded', function() {
      const textarea = document.getElementById('texto');
      const vistaPrevia = document.getElementById('vistaPrevia');

      // Escuchar el evento 'input' en el textarea
      textarea.addEventListener('input', function() {
          // Reemplazar saltos de línea con <br>, conservar espacios y convertir asteriscos en negrita
          const textoConFormatos = textarea.value
              .replace(/\n/g, '<br>') // Reemplazar saltos de línea con <br>
              .replace(/ /g, '&nbsp;') // Reemplazar espacios con &nbsp;


          // Actualizar el contenido del div de vista previa
          vistaPrevia.innerHTML = textoConFormatos;
      });
  });



  function handleFileSelect(evt) {
      var files = evt.target.files;
      for (var i = 0, f; f = files[i]; i++) {
        if (!f.type.match('image.*')) {
          continue;
        }

        var reader = new FileReader();
        reader.onload = (function(theFile) {
          return function(e) {
            var span = document.createElement('span');
            span.innerHTML = ['<img class="img_galeria" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
            document.getElementById('miniaturas_productos').insertBefore(span, null);
            document.getElementById('miniaturas_vista_previa_salida_imagenes').insertBefore(span, null);
          };
        })(f);
        reader.readAsDataURL(f);
      }
    }
      document.getElementById('lista').addEventListener('change', handleFileSelect, false);
