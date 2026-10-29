<?PHP
include("../conexion/conexion.php");

// --------------   Modificar Producto
    if (isset($_POST['modificar_ms'])) {
    
        $id_prod = $_POST['id_prod'];
        $nom_prod = $_POST['nom_prod'];
        $pre_entrada = $_POST['pre_entrada'];
        $pre_salida = $_POST['pre_salida'];
        $des_producto = $_POST['descripcion_prod'];

        $query= "SELECT * FROM t_producto WHERE nom_producto = '$nom_prod'";
          $softcomdup = $conexion->query($query);
          $dup = mysqli_num_rows($softcomdup);
          
        if ($dup == 0 || $dup == 1) {
          $query1= "UPDATE t_producto set nom_producto = '$nom_prod', precio_entrada = '$pre_entrada', precio_salida = '$pre_salida', descripcion = '$des_producto', fecha_actualizacion = now() where id_producto = '$id_prod'";
          $resultado = mysqli_query ($conexion, $query1);

          if($resultado){
            header("Location: ../forms/form_alta_prod.php?men=1&mensaje=El producto a sido modificado correctamente&tipo=success&icon=fa fa-bell&titu=Modificación exitosa");
          }
          else{
              return "error";
          }
           }
        else
        {
          header("Location: ../forms/form_alta_prod.php?men=1&mensaje=Ya existe un producto con este nombre&tipo=warning&icon=fa fa-times&titu=Registro duplicado");    
        }
    }

    // --------------   Modificar productio cargado al pedido
    if (isset($_POST['modificar_prod'])) {
    
        $id_prod = $_POST['id_prod'];
        $cant_pedido = $_POST['cant_pedido'];

        $query1= "UPDATE t_pedido_temporal set cantidad = '$cant_pedido', fecha_act_temp = now() where id_pedido_temporal = '$id_prod'";
        $resultado = mysqli_query ($conexion, $query1);

        if($resultado){
          header("Location: ../forms/form_alta_solicitud.php?men=1&mensaje=La solicitud a sido modificado correctamente&tipo=success&icon=fa fa-bell&titu=Modificación exitosa");
        }
        else{
            return "error";
        }
           
    }

    // --------------   Modificar Estatus venta
    if (isset($_POST['avanzar_estado'])) {
    
        $id_venta = $_POST['id_venta'];
        $id_estatus = $_POST['id_estatus'];

        $est = $id_estatus + 1;

        $query1= "UPDATE t_venta set estatus_venta = '$est', fecha_actualizacion_tventa = now() where id_venta = '$id_venta'";
        $resultado = mysqli_query ($conexion, $query1);

        if($resultado){
          header("Location: ../forms/tablero_solicitudes.php?men=1&mensaje=La solicitud a sido modificado correctamente&tipo=success&icon=fa fa-bell&titu=Modificación exitosa");
        }
        else{
            return "error";
        }
           
    }

?>