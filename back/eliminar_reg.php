<?php
/**
 * Control de Eliminaciones (Tiendas y Productos Temporales)
 * - Implementa Sentencias Preparadas (Prepared Statements) para prevenir Inyección SQL.
 * - Gestiona de forma segura las redirecciones tras eliminar registros.
 */

// Incluir el archivo de conexión a la base de datos
include("../conexion/conexion.php");


/* ==========================================================================
   1. ELIMINAR TIENDA
   ========================================================================== */
if (isset($_POST['eliminar_tienda'])) {
    
    $id = $_POST["id_prod"] ?? '';

    // Uso de sentencia preparada para evitar Inyección SQL
    $stmt = $conexion->prepare("DELETE FROM t_tienda_venta WHERE idt_tienda = ?");
    $stmt->bind_param("i", $id); // Se asume ID numérico ("i"). Cambiar a "s" si es texto.
    $resultado = $stmt->execute();
    $stmt->close();

    if ($resultado) {
        $mensajeParams = "men=1&mensaje=La tienda ha sido eliminada correctamente&tipo=success&icon=fa fa-bell&titu=Eliminación exitosa";
    } else {
        $mensajeParams = "men=1&mensaje=No se ha podido eliminar la tienda&tipo=danger&icon=fa fa-times&titu=Error en la eliminación";
    }

    header("Location: ../forms/form_alta_tienda.php?" . $mensajeParams);
    exit();
}


/* ==========================================================================
   2. ELIMINAR PRODUCTO DE LA LISTA DE PEDIDO (TEMPORAL)
   ========================================================================== */
if (isset($_POST['eliminar_prod'])) {
    
    $id = $_POST["id_prod"] ?? '';

    // Uso de sentencia preparada para evitar Inyección SQL
    $stmt = $conexion->prepare("DELETE FROM t_pedido_temporal WHERE id_pedido_temporal = ?");
    $stmt->bind_param("i", $id); // Se asume ID numérico ("i"). Cambiar a "s" si es texto.
    $resultado = $stmt->execute();
    $stmt->close();

    if ($resultado) {
        $mensajeParams = "men=1&mensaje=El producto ha sido eliminado de la solicitud correctamente&tipo=success&icon=fa fa-bell&titu=Eliminación exitosa";
    } else {
        $mensajeParams = "men=1&mensaje=No se ha podido eliminar el producto&tipo=danger&icon=fa fa-times&titu=Error en la eliminación";
    }

    header("Location: ../forms/form_alta_solicitud.php?" . $mensajeParams);
    exit();
}
?>