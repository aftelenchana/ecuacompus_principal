function buscarContactos() {

  //TRAIGO POR EL ID LA VARIABLE QUE FILTRA

  var filtro = document.getElementById('filtro').value;

    $.ajax({
        url: 'embudo_ventas/contactos.php',
        type: 'POST',
        async: true,
        data: {
            action: 'buscar_contactos_primer_contacto',
            filtro:filtro
        },
        success: function(response) {
            console.log(response);
            var info = JSON.parse(response); // Descomentar esto para analizar la respuesta

            // Seleccionamos el contenedor donde se agregarán las notificaciones
            var resultado_primer_contacto = $('.resultado_primer_contacto');
            var resultado_no_contesta = $('.resultado_no_contesta');
            var resultado_conocimiento = $('.resultado_conocimiento');
            var resultado_potenciales = $('.resultado_potenciales');
            var resultado_consideracion = $('.resultado_consideracion');

            // Limpiar el contenedor antes de agregar nuevas notificaciones
            resultado_primer_contacto.empty();
            resultado_no_contesta.empty();
            resultado_conocimiento.empty();
            resultado_potenciales.empty();
            resultado_consideracion.empty();

            // Recorremos el array de notificaciones
            info.data.forEach(function(item, index) {
                var tipo = item.tipo;

                switch (tipo) {
                    case 'Primer Contacto':
                        var notificationHtml_primer_contacto = `
                            <div class="crm-guibis-wsp-card position-relative">
                                <img src="${item.url}/home/img/uploads/${item.img}" class="crm-guibis-wsp-img-cover" alt="Contacto">
                                <div class="crm-guibis-wsp-content">
                                    <h5 class="card-title">${item.nombres}</h5>
                                    <p class="card-text"><i class="fas fa-phone"></i> ${item.celular}</p>
                                </div>
                                <!-- Menú de tres puntos -->
                                <div class="dropdown position-absolute" style="top: 3px; right: 3px;">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right resultado_opciones_contactos_embudo " aria-labelledby="dropdownMenuButton">
                                        <button class="dropdown-item ver_contacto" type="button" contacto="${item.id}">Ver</button>
                                        <button class="dropdown-item editar_contacto" type="button" contacto="${item.id}">Editar</button>
                                        <button class="dropdown-item mensaje_rapido" type="button" contacto="${item.id}">Mensaje Rápido</button>
                                        <button class="dropdown-item eliminar_contacto" type="button" contacto="${item.id}">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        `;
                        resultado_primer_contacto.append(notificationHtml_primer_contacto);
                        break;

                    case 'NO CONTESTA':
                        var notificationHtml_no_contesta = `
                        <div class="crm-guibis-wsp-card position-relative">
                            <img src="${item.url}/home/img/uploads/${item.img}" class="crm-guibis-wsp-img-cover" alt="Contacto">
                            <div class="crm-guibis-wsp-content">
                                <h5 class="card-title">${item.nombres}</h5>
                                <p class="card-text"><i class="fas fa-phone"></i> ${item.celular}</p>
                            </div>
                            <!-- Menú de tres puntos -->
                            <div class="dropdown position-absolute" style="top: 3px; right: 3px;">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right resultado_opciones_contactos_embudo " aria-labelledby="dropdownMenuButton">
                                    <button class="dropdown-item ver_contacto" type="button" contacto="${item.id}">Ver</button>
                                    <button class="dropdown-item editar_contacto" type="button" contacto="${item.id}">Editar</button>
                                    <button class="dropdown-item mensaje_rapido" type="button" contacto="${item.id}">Mensaje Rápido</button>
                                    <button class="dropdown-item eliminar_contacto" type="button" contacto="${item.id}">Eliminar</button>
                                </div>
                            </div>
                        </div>
                        `;
                        resultado_no_contesta.append(notificationHtml_no_contesta);
                        break;

                    case 'CONOCIMIENTO':
                        var notificationHtml_conocimiento = `
                        <div class="crm-guibis-wsp-card position-relative">
                            <img src="${item.url}/home/img/uploads/${item.img}" class="crm-guibis-wsp-img-cover" alt="Contacto">
                            <div class="crm-guibis-wsp-content">
                                <h5 class="card-title">${item.nombres}</h5>
                                <p class="card-text"><i class="fas fa-phone"></i> ${item.celular}</p>
                            </div>
                            <!-- Menú de tres puntos -->
                            <div class="dropdown position-absolute" style="top: 3px; right: 3px;">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right resultado_opciones_contactos_embudo " aria-labelledby="dropdownMenuButton">
                                    <button class="dropdown-item ver_contacto" type="button" contacto="${item.id}">Ver</button>
                                    <button class="dropdown-item editar_contacto" type="button" contacto="${item.id}">Editar</button>
                                    <button class="dropdown-item mensaje_rapido" type="button" contacto="${item.id}">Mensaje Rápido</button>
                                    <button class="dropdown-item eliminar_contacto" type="button" contacto="${item.id}">Eliminar</button>
                                </div>
                            </div>
                        </div>
                        `;
                        resultado_conocimiento.append(notificationHtml_conocimiento);
                        break;

                    case 'POTENCIALES':
                        var notificationHtml_potenciales = `
                        <div class="crm-guibis-wsp-card position-relative">
                            <img src="${item.url}/home/img/uploads/${item.img}" class="crm-guibis-wsp-img-cover" alt="Contacto">
                            <div class="crm-guibis-wsp-content">
                                <h5 class="card-title">${item.nombres}</h5>
                                <p class="card-text"><i class="fas fa-phone"></i> ${item.celular}</p>
                            </div>
                            <!-- Menú de tres puntos -->
                            <div class="dropdown position-absolute" style="top: 3px; right: 3px;">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right resultado_opciones_contactos_embudo " aria-labelledby="dropdownMenuButton">
                                    <button class="dropdown-item ver_contacto" type="button" contacto="${item.id}">Ver</button>
                                    <button class="dropdown-item editar_contacto" type="button" contacto="${item.id}">Editar</button>
                                    <button class="dropdown-item mensaje_rapido" type="button" contacto="${item.id}">Mensaje Rápido</button>
                                    <button class="dropdown-item eliminar_contacto" type="button" contacto="${item.id}">Eliminar</button>
                                </div>
                            </div>
                        </div>
                        `;
                        resultado_potenciales.append(notificationHtml_potenciales);
                        break;

                    case 'CONSIDERACIÓN':
                        var notificationHtml_consideracion = `
                        <div class="crm-guibis-wsp-card position-relative">
                            <img src="${item.url}/home/img/uploads/${item.img}" class="crm-guibis-wsp-img-cover" alt="Contacto">
                            <div class="crm-guibis-wsp-content">
                                <h5 class="card-title">${item.nombres}</h5>
                                <p class="card-text"><i class="fas fa-phone"></i> ${item.celular}</p>
                            </div>
                            <!-- Menú de tres puntos -->
                            <div class="dropdown position-absolute" style="top: 3px; right: 3px;">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right resultado_opciones_contactos_embudo " aria-labelledby="dropdownMenuButton">
                                    <button class="dropdown-item ver_contacto" type="button" contacto="${item.id}">Ver</button>
                                    <button class="dropdown-item editar_contacto" type="button" contacto="${item.id}">Editar</button>
                                    <button class="dropdown-item mensaje_rapido" type="button" contacto="${item.id}">Mensaje Rápido</button>
                                    <button class="dropdown-item eliminar_contacto" type="button" contacto="${item.id}">Eliminar</button>
                                </div>
                            </div>
                        </div>
                        `;
                        resultado_consideracion.append(notificationHtml_consideracion);
                        break;

                    default:
                        console.log('NO CORRESPONDE');
                        break;
                }
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
}

buscarContactos();

$(document).on('click', '.editar_contacto', function() {
    var contacto = $(this).attr('contacto');
    console.log(contacto);
    // Aquí puedes abrir el modal o realizar cualquier acción adicional
     $('#modal_editar_contacto').modal('show');
     $(".noticia_editar_contactos").html('');


     var action = 'info_contactos';
     $.ajax({
         url: 'embudo_ventas/contactos.php',
         type: 'POST',
         async: true,
         data: {action: action, contacto: contacto},
         success: function(response){
             console.log(response);
             if (response != 'error') {
                 var info = JSON.parse(response);
                 $("#nombres_update").val(info.nombres);
                 $("#email_update").val(info.email);
                 $("#identificacion_update").val(info.identificacion);
                 $("#tipo_identificacion_update").val(info.tipo_identificacion);
                 $("#tipo_update").val(info.tipo);
                 $("#celular_update").val(info.celular);
                 $("#telefono_update").val(info.telefono);
                 $("#direccion_update").val(info.direccion);
                 $("#descripcion_update").val(info.descripcion);
                  $(".img_editar_contacto").html(' <img width="100px" src="'+info.url+'/home/img/uploads/'+info.img+'" alt="'+info.img+'">');
                 $("#id_contacto").val(info.id);
             }
         },
         error: function(error){
             console.log(error);
         }
     });


});





function sendData_editar_contacto(){
  $('.noticia_editar_contactos').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#editar_contacto')[0]);
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
        $('.noticia_editar_contactos').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.noticia_editar_contactos').html('<div class="alert alert-success background-success" role="alert">Contacto Editado correctamente !</div>');
        buscarContactos();

      }
      if (info.noticia == 'error') {
      $('.noticia_editar_contactos').html('<div class="alert alert-danger background-danger" role="alert">Error en el servidor '+info.contenido_error+' !</div>');

      }


      }

    }

  });

}






$(document).on('click', '.mensaje_rapido', function() {
    var contacto = $(this).attr('contacto');
    console.log(contacto);
    // Aquí puedes abrir el modal o realizar cualquier acción adicional
     $('#modal_envirar_mensaje_rapido').modal('show');
     $(".noticia_enviar_mensaje_rapido").html('');

     var action = 'info_contactos';
     $.ajax({
         url: 'embudo_ventas/contactos.php',
         type: 'POST',
         async: true,
         data: {action: action, contacto: contacto},
         success: function(response){
             console.log(response);
             if (response != 'error') {
                 var info = JSON.parse(response);
                 $("#nombres_delete").val(info.nombres);
                 $("#email_delete").val(info.email);
                 $("#identificacion_delete").val(info.identificacion);
                 $("#tipo_identificacion_delete").val(info.tipo_identificacion);
                 $("#tipo_delete").val(info.tipo);
                 $("#celular_delete").val(info.celular);
                 $("#telefono_delete").val(info.telefono);
                 $("#direccion_delete").val(info.direccion);
                 $("#descripcion_delete").val(info.descripcion);
                 $(".img_enviar_mensaje_rapido").html(' <img width="100px" src="'+info.url+'/home/img/uploads/'+info.img+'" alt="'+info.img+'">');
                 $("#contacto_mensaje_envio").val(info.id);


             }
         },
         error: function(error){
             console.log(error);
         }
     });

});


$(document).ready(function(){
    // Obtener datos de la API al cargar la página
    var archivos = [];
    $.ajax({
        url: 'mensajeria/nube.php',
        type: 'POST',
        async: true,
        data: { action: 'consultar_datos' },
        success: function(response){
            const data = JSON.parse(response).data;
            archivos = data; // Almacenar datos en una variable global
        },
        error: function(error){
            console.log(error);
        }
    });

    // Evento de entrada en el input
    $('#buscador_archivos_nube').on('input', function(){
        var valor = $(this).val();
        if (valor.includes('@')) {
            var buscar = valor.split('@')[1]; // Obtener el texto después de '@'
            mostrarSugerencias(buscar);
        } else {
            $('#sugerencias').hide(); // Ocultar sugerencias si no contiene '@'
        }
    });

    function mostrarSugerencias(buscar) {
        $('#sugerencias').empty(); // Limpiar sugerencias anteriores
        var coincidencias = archivos.filter(function(archivo) {
            return archivo.id.includes(buscar) || archivo.descripcion.toLowerCase().includes(buscar.toLowerCase());
        });

        if (coincidencias.length > 0) {
            $.each(coincidencias, function(index, archivo) {
                $('#sugerencias').append('<div class="sugerencia-item" data-id="' + archivo.id + '">' + archivo.descripcion + ' (ID: ' + archivo.id + ')</div>');
            });
            $('#sugerencias').show(); // Mostrar sugerencias
        } else {
            $('#sugerencias').hide(); // Ocultar si no hay coincidencias
        }
    }

    // Manejar clic en una sugerencia
    $(document).on('click', '.sugerencia-item', function() {
        var id = $(this).data('id');
        var descripcion = $(this).text();
        var seleccionado = id + '-' + descripcion;

        // Agregar el seleccionado al input oculto
        var archivosSeleccionados = $('#archivos_seleccionados').val();
        if (archivosSeleccionados) {
            archivosSeleccionados += ','; // Separar con coma
        }
        archivosSeleccionados += seleccionado;
        $('#archivos_seleccionados').val(archivosSeleccionados);

        // Mostrar el archivo en el contenedor de archivos agregados
        mostrarArchivosAgregados(seleccionado);

        // Limpiar el input y ocultar sugerencias
        $('#buscador_archivos_nube').val('');
        $('#sugerencias').hide();
    });

    function mostrarArchivosAgregados(seleccionado) {
        var idDescripcion = seleccionado.split('-');
        var id = idDescripcion[0];
        var descripcion = idDescripcion[1];

        $('#archivos-agregados').append('<div class="archivo-item" data-id="' + id + '">' + descripcion + '<span class="remove">x</span></div>');
    }

    // Manejar clic en el botón de eliminación
    $(document).on('click', '.remove', function() {
        var archivoItem = $(this).parent();
        var id = archivoItem.data('id');

        // Remover el archivo del contenedor visual
        archivoItem.remove();

        // Actualizar el input oculto eliminando el elemento
        actualizarArchivosSeleccionados();
    });

    function actualizarArchivosSeleccionados() {
        var archivosSeleccionados = [];
        $('#archivos-agregados .archivo-item').each(function() {
            var id = $(this).data('id');
            var descripcion = $(this).text().replace('x', '').trim(); // Quitar la 'x'
            archivosSeleccionados.push(id + '-' + descripcion);
        });
        $('#archivos_seleccionados').val(archivosSeleccionados.join(',')); // Actualizar el input oculto
    }
});



function sendData_enviar_mensaje_rapido(){
  $('.noticia_enviar_mensaje_rapido').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#enviar_mensaje_rapido')[0]);
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
        $('.noticia_enviar_mensaje_rapido').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'enviado') {
        $('.noticia_enviar_mensaje_rapido').html('<div class="alert alert-success background-success" role="alert">Mensaje enviado Correctamente !</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.noticia_enviar_mensaje_rapido').html('<div class="alert alert-danger background-danger" role="alert">Error en el servidor '+info.mensaje+' !</div>');

      }


      }

    }

  });

}







$(document).on('click', '.eliminar_contacto', function() {
    var contacto = $(this).attr('contacto');
    console.log(contacto);
    // Aquí puedes abrir el modal o realizar cualquier acción adicional
     $('#modal_eliminar_contacto').modal('show');
     $(".noticia_eliminar_contactos").html('');

     var action = 'info_contactos';
     $.ajax({
         url: 'embudo_ventas/contactos.php',
         type: 'POST',
         async: true,
         data: {action: action, contacto: contacto},
         success: function(response){
             console.log(response);
             if (response != 'error') {
                 var info = JSON.parse(response);
                 $("#nombres_delete").val(info.nombres);
                 $("#email_delete").val(info.email);
                 $("#identificacion_delete").val(info.identificacion);
                 $("#tipo_identificacion_delete").val(info.tipo_identificacion);
                 $("#tipo_delete").val(info.tipo);
                 $("#celular_delete").val(info.celular);
                 $("#telefono_delete").val(info.telefono);
                 $("#direccion_delete").val(info.direccion);
                 $("#descripcion_delete").val(info.descripcion);
                  $(".img_eliminar_contacto").html(' <img width="100px" src="'+info.url+'/home/img/uploads/'+info.img+'" alt="'+info.img+'">');
                 $("#id_contacto_delete").val(info.id);


             }
         },
         error: function(error){
             console.log(error);
         }
     });

});




function sendData_eliminar_contacto(){
  $('.noticia_eliminar_contactos').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#eliminar_contacto')[0]);
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
        $('.noticia_eliminar_contactos').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.noticia_eliminar_contactos').html('<div class="alert alert-success background-success" role="alert">Contacto Eliminado correctamente !</div>');
        buscarContactos();

      }
      if (info.noticia == 'error') {
      $('.noticia_eliminar_contactos').html('<div class="alert alert-danger background-danger" role="alert">Error en el servidor '+info.contenido_error+' !</div>');

      }


      }

    }

  });

}



$(function() {
  $('#boton_agregar_contacto').on('click', function() {
    $('#modal_agregar_cliente').modal('show');
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
        buscarContactos();

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
    $('#modal_agregar_contactos_wsp').modal('show');
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
        buscarContactos();
        $('.noticia_agregar_contactos_masivamente_wsp').html('<div class="alert alert-success background-success" role="alert">Se ha procesado correctamente '+info.datos_wsp_insertados+' agregados,'+info.datos_wsp_duplicados+' no insertados por duplicación,'+info.datos_wsp_no_error_insertados+' errores !</div>');

      }
      if (info.noticia == 'no_es_json') {
      $('.noticia_agregar_contactos_masivamente_wsp').html('<div class="alert alert-danger background-danger" role="alert">Error , datos vacios o procesamiento incorrecto !</div>');

      }


      }

    }

  });

}












$(document).on('click', '.ver_contacto', function() {
    var contacto = $(this).attr('contacto');
    console.log(contacto);


});


//ELEGIR LA PLANTILLA PARA EL ENVIO DE MENSAJES
