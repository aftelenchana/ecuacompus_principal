function buscarContactos() {
    $.ajax({
        url: 'embudo_ventas/contactos.php',
        type: 'POST',
        async: true,
        data: {
            action: 'buscar_contactos_primer_contacto'
        },
        success: function(response) {
            //console.log(response);
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



$(document).on('click', '.eliminar_contacto', function() {
    var contacto = $(this).attr('contacto');
    console.log(contacto);
    // Aquí puedes abrir el modal o realizar cualquier acción adicional
     $('#modal_eliminar_contacto').modal('show');;
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


$(document).on('click', '.ver_contacto', function() {
    var contacto = $(this).attr('contacto');
    console.log(contacto);


});
