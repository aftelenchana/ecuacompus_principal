(function(){
  $(function(){
    $('.boton_agregar_adminsiones').on('click',function(){
      $('#modal_agregar_admisiones').modal();
          var cliente = $(this).attr('cliente');
          var action = 'buscar_admisiones';
          $.ajax({
            url:'jquery_empresa/admisiones.php',
            type:'POST',
            async: true,
            data: {action:action,cliente:cliente},
             success: function(response){
               console.log(response);
               if (response != 'error') {
                 var info = JSON.parse(response);
                 if (info.noticia == 'tiene_adimsion') {
                  $('.resultado_suscripciones').html('<div class="alert alert-success" role="alert">Este usuario ya tiene admisiones !</div>');
                  $('#cliente').val(info.cliente);


                 }
                 if (info.noticia == 'no_tiene_admision') {
                  $('.resultado_suscripciones').html('<div class="alert alert-warning" role="alert">Este usuario no tiene admisiones !</div>');
                 $('#cliente').val(info.cliente);
                 console.log('hyola ');
                 }




               }
             },
             error:function(error){
               console.log(error);
               }
             });
          console.log(cliente);
    });

  });
}());
