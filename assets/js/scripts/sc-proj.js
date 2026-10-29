$(document).ready(function() {
    // 1. Solución manual para el menú móvil si el botón toggle falla
    $('.sidenav-toggler').on('click', function() {
        $('html').toggleClass('nav_open');
    });

    // 2. Lógica de consulta AJAX y Modal de Detalles
    $('.btn-consultar').on('click', function() {
        var idPedido = $(this).attr('data-id');
        $('#txt_id_pedido').text("#" + idPedido);
        $('#tabla_detalles_body').html('<tr><td colspan="3" class="text-center">Cargando...</td></tr>');

        $.ajax({
            url: 'procesar_consulta.php',
            method: 'POST',
            data: { id: idPedido },
            dataType: 'json',
            success: function(data) {
                var html = '';
                if(data.error) {
                    html = '<tr><td colspan="3" class="text-center text-danger">' + data.error + '</td></tr>';
                } else {
                    data.forEach(function(item, index) {
                        html += '<tr align="center">' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + (item.nombre_sabor || 'N/A') + '</td>' +
                                '<td>' + (item.cantidad_prod || '0') + '</td>' +
                                '</tr>';
                    });
                }
                $('#tabla_detalles_body').html(html);
                
                var myModal = new bootstrap.Modal(document.getElementById('modalDetalle'));
                myModal.show();
            },
            error: function() {
                alert("Error al conectar con el servidor.");
            }
        });
    });

    // 3. Lógica para capturar datos en el modal de Modificar Estatus
    $(document).on('click', '.mod_estatus', function() {
        var $tr = $(this).closest('tr');
        var datos = $tr.children("td").map(function() {
            return $(this).text();
        });
        $('#id_pedido_venta').val(datos[0]);
        $('#id_estatus_venta').val(datos[1]);
    });
});