<?php
/**
 * Control de Operaciones (Tiendas y Pedidos) - Versión Mejorada
 * - Implementa Sentencias Preparadas (Prepared Statements) para prevenir Inyección SQL.
 * - Optimiza consultas de verificación y mejora el manejo de errores.
 */

// Configuración de errores (ajustar según entorno de producción o desarrollo)
error_reporting(0);

// Incluir el archivo de conexión a la base de datos
include("../conexion/conexion.php");


/* ==========================================================================
   1. AGREGAR TIENDA NUEVA
   ========================================================================== */
if (isset($_POST['agregar_tienda_nueva'])) {
    
    $nombre_tienda  = $_POST['nom_tienda'] ?? '';
    $municipio      = $_POST['municipio'] ?? '';
    $colonia        = $_POST['colonia'] ?? '';
    $calle          = $_POST['calle'] ?? '';
    $nom_encargado  = $_POST['nom_encargado'] ?? '';
    $numero_ti      = $_POST['numero_ti'] ?? '';
    $contacto_ti    = $_POST['contacto_ti'] ?? '';

    // Validar si la tienda ya existe usando una sentencia preparada optimizada
    $stmtCheck = $conexion->prepare("SELECT COUNT(*) FROM t_tienda_venta WHERE nombre_tienda = ?");
    $stmtCheck->bind_param("s", $nombre_tienda);
    $stmtCheck->execute();
    $stmtCheck->bind_result($totalTiendas);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if ($totalTiendas == 0) {
        // Inserción segura con sentencia preparada
        $stmtInsert = $conexion->prepare("
            INSERT INTO t_tienda_venta 
            (nombre_tienda, direccion_tienda_municipio, direccion_tienda_colonia, direccion_tienda_calle, encargado_tienda, direccion_tienda_numero, contacto_tienda, fecha_alta) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmtInsert->bind_param("sssssss", $nombre_tienda, $municipio, $colonia, $calle, $nom_encargado, $numero_ti, $contacto_ti);
        
        $resultado = $stmtInsert->execute();
        $stmtInsert->close();

        if ($resultado) {
            $mensajeParams = "men=1&mensaje=La tienda ha sido registrada correctamente&tipo=success&icon=fa fa-bell&titu=Registro exitoso";
        } else {
            $mensajeParams = "men=1&mensaje=No se ha realizado el registro&tipo=danger&icon=fa fa-times&titu=Error en el registro";
        }
    } else {
        $mensajeParams = "men=1&mensaje=Ya se encuentra registrada esta tienda&tipo=warning&icon=fa fa-times&titu=Registro duplicado";
    }

    header("Location: ../forms/form_alta_tienda.php?" . $mensajeParams);
    exit();
}


/* ==========================================================================
   2. AGREGAR PEDIDO NUEVO (TRANSACCIÓN)
   ========================================================================== */
if (isset($_POST['agregar_pedido'])) {
   
    $cliente = $_POST['id_cliente'] ?? '';

    $query= "SELECT * FROM t_pedido_temporal INNER JOIN c_sabores ON t_pedido_temporal.id_producto = c_sabores.id_sabores";
                        
    $resultado = $conexion->query($query);
    while($row=$resultado->fetch_assoc()){
     $t_unitario = $row['cantidad'] * $row['precio_mayoreo'];
     $t_final = $t_final + $t_unitario;
    }

    // Validar si la tabla temporal tiene registros
    $checkTemp = $conexion->query("SELECT COUNT(*) as total FROM t_pedido_temporal");
    $rowTemp   = $checkTemp->fetch_assoc();

    if ($rowTemp['total'] == 0) {
        $mensajeParams = "men=1&mensaje=No hay productos en el pedido para registrar&tipo=warning&icon=fa fa-exclamation-triangle&titu=Atencion";
        header("Location: ../forms/form_alta_solicitud.php?" . $mensajeParams);
        exit();
    }

    // Iniciar transacción de base de datos
    $conexion->begin_transaction();

    try {
        // 1. Insertar la venta principal de forma segura
        $stmtVenta = $conexion->prepare("INSERT INTO t_venta (tienda_venta, total_venta, estatus_venta, fecha_alta_tventa) VALUES (?,$t_final, 1, NOW())");
        $stmtVenta->bind_param("s", $cliente);
        $stmtVenta->execute();
        
        // 2. Obtener el ID generado automáticamente
        $idpedido = $conexion->insert_id;
        $stmtVenta->close();

        // 3. Insertar el detalle usando el ID obtenido (asegurando el parámetro)
        $stmtDetalle = $conexion->prepare("
            INSERT INTO t_venta_detalle (id_venta, id_producto, cantidad_prod, fecha_alta_venta)
            SELECT ?, id_producto, cantidad, NOW()
            FROM t_pedido_temporal
        ");
        $stmtDetalle->bind_param("i", $idpedido);
        $stmtDetalle->execute();
        $stmtDetalle->close();

        // 4. Vaciar la tabla temporal
        $conexion->query("TRUNCATE TABLE t_pedido_temporal");

        // Confirmar transacción
        $conexion->commit();
        $mensajeParams = "men=1&mensaje=Se registro correctamente el pedido&tipo=success&icon=fa fa-bell&titu=Registro exitoso";

    } catch (Exception $e) {
        // Revertir cambios en caso de error
        $conexion->rollback();
        $mensajeParams = "men=1&mensaje=No se ha realizado el registro del pedido&tipo=danger&icon=fa fa-times&titu=Error en el registro";
    }

    header("Location: ../forms/form_alta_solicitud.php?" . $mensajeParams);
    exit();
}


/* ==========================================================================
   3. AGREGAR PRODUCTO AL PEDIDO (TEMPORAL)
   ========================================================================== */
if (isset($_POST['agregar_nuevo_producto'])) {
   
    $idprod   = $_POST['nom_prod'] ?? '';
    $cantidad = $_POST['cantidad_prod'] ?? '';

    // Validar si el producto ya fue agregado al temporal usando sentencia preparada
    $stmtCheck = $conexion->prepare("SELECT COUNT(*) FROM t_pedido_temporal WHERE id_producto = ?");
    $stmtCheck->bind_param("s", $idprod);
    $stmtCheck->execute();
    $stmtCheck->bind_result($totalProd);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if ($totalProd == 0) {
        // Insertar en la tabla temporal de forma segura
        $stmtInsert = $conexion->prepare("INSERT INTO t_pedido_temporal (id_producto, cantidad, fecha_alta_temp) VALUES (?, ?, NOW())");
        $stmtInsert->bind_param("ss", $idprod, $cantidad);
        $resultado = $stmtInsert->execute();
        $stmtInsert->close();

        if ($resultado) {
            $mensajeParams = "men=1&mensaje=Se registro correctamente el producto&tipo=success&icon=fa fa-bell&titu=Registro exitoso";  
        } else {
            $mensajeParams = "men=1&mensaje=No se a realizado el registro&tipo=danger&icon=fa fa-times&titu=Error en el registro";
        }
    } else {
        $mensajeParams = "men=1&mensaje=Ya se encuentra registrado este producto&tipo=warning&icon=fa fa-times&titu=Registro duplicado";   
    }

    header("Location: ../forms/form_alta_solicitud.php?" . $mensajeParams);
    exit();
}
?>