<?php

include(__DIR__ ."/../conexion/conexion.php");


// Capturamos el filtro enviado por GET de forma segura
$estatus_filtro = isset($_GET['estatus']) ? $_GET['estatus'] : '';

$query = "SELECT * FROM t_venta 
          INNER JOIN t_tienda_venta ON t_venta.tienda_venta = t_tienda_venta.idt_tienda 
          WHERE fecha_baja_tventa IS NULL";

// Si se seleccionó un estatus específico, lo filtramos; de lo contrario, mostramos los activos por defecto (< 4)
if ($estatus_filtro !== '' && is_numeric($estatus_filtro)) {
    $estatus_limpio = intval($estatus_filtro);
    $query .= " AND estatus_venta = $estatus_limpio";
} else {
    $query .= " AND estatus_venta < 4";
}

$query .= "  ";

$resultado = $conexion->query($query);

// Función auxiliar para traducir el estatus
function obtenerTextoEstatus($v) {
    switch ($v) {
        case 1: return 'Solicitado';
        case 2: return 'Empacado';
        case 3: return 'Entregado';
        case 4: return 'Pagado';
        default: return 'Desconocido';
    }
}

$sql = "SELECT 
            SUM(CASE WHEN estatus_venta = 1 THEN 1 ELSE 0 END) AS total_1,
            SUM(CASE WHEN estatus_venta = 2 THEN 1 ELSE 0 END) AS total_2,
            SUM(CASE WHEN estatus_venta = 3 THEN 1 ELSE 0 END) AS total_3,
            SUM(CASE WHEN estatus_venta = 4 THEN 1 ELSE 0 END) AS total_4
        FROM t_venta"; 

$resultado_est = $conexion->query($sql);

// Inicializamos las variables en 0 por seguridad
$t_estatus_1 = 0;
$t_estatus_2 = 0;
$t_estatus_3 = 0;
$t_estatus_4 = 0;

if ($resultado_est && $fila = $resultado_est->fetch_assoc()) {
    $t_estatus_1 = $fila['total_1'];
    $t_estatus_2 = $fila['total_2'];
    $t_estatus_3 = $fila['total_3'];
    $t_estatus_4 = $fila['total_4'];
}

// consulta de Historial

$query_hist = "SELECT * FROM t_venta 
          INNER JOIN t_tienda_venta ON t_venta.tienda_venta = t_tienda_venta.idt_tienda 
          WHERE fecha_baja_tventa IS NULL AND estatus_venta > 3 ORDER BY fecha_alta_tventa DESC";

$resultado_hist = $conexion->query($query_hist);

// consulta de Historial de ventas por sabor

$query_sabor = "SELECT nombre_sabor, SUM(cantidad_prod) AS total_cantidad
                  FROM t_venta_detalle
                  INNER JOIN c_sabores ON id_producto = id_sabores
                  GROUP BY id_producto, id_sabores";

$resultado_sabor = $conexion->query($query_sabor);

?>