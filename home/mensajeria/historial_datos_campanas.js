
$(document).ready(function() {
    var codigo = parseFloat(document.getElementById('codigo').value);

    // Inicialización de DataTable
    var tabla_clientes = $('#tabla_clientes').DataTable({
        "ajax": {
            "url": "mensajeria/historial_datos_campanas.php",
            "type": "POST",
            "data": {
                "action": 'consultar_datos',
                "codigo": codigo
            },
            "dataSrc": "data",
            "error": function(xhr, error, thrown) {
                console.error('Error al cargar los datos:', error);
                console.log('Respuesta del servidor:', xhr.responseText); // Añadido para depuración
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "numero" },
            { "data": "nombre" },
            { "data": "tipo" },
            { "data": "estado" },
            { "data": "estado_envio" }
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
        "autoWidth": false  // Agrega esta línea
    });

    // Función para actualizar los datos de la tabla
    function actualizarTabla() {
        tabla_clientes.ajax.reload(null, false); // Vuelve a cargar los datos sin reiniciar la paginación
    }

    // Configurar el intervalo para actualizar la tabla cada 10 segundos
    setInterval(actualizarTabla, 15000); // 10000 milisegundos = 10 segundos
});
