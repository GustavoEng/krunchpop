<?PHP
include("../conexion/conexion.php");

// --------------   Aceptar solicictud
    
  if (isset($_POST['aceptar_sol'])) {
    $id_sol = $_POST['id_soli'];
    $id_esta = 2;

    $query1= "UPDATE t_solicitud set id_estatus = '$id_esta',fecha_act_sol = now() where id_solicitud = '$id_sol'";
    $resultado = mysqli_query ($conexion, $query1);

    if($resultado){
      header("Location: ../forms/form_admin_solicitudes.php?men=1&mensaje=La solicitud a sido aceptada correctamente&tipo=success&icon=fa fa-bell&titu=Solicitud aceptada");
    }
    else{
      return "error";
    }
  }

  // --------------   Iniciar solicitud
    
  if (isset($_POST['iniciar_sol'])) {
    $id_sol = $_POST['id_soli'];
    $id_esta = 3;

    $query1= "UPDATE t_solicitud set id_estatus = '$id_esta',fecha_act_sol = now() where id_solicitud = '$id_sol'";
    $resultado = mysqli_query ($conexion, $query1);

    if($resultado){
      header("Location: ../forms/form_admin_solicitudes.php?men=1&mensaje=La solicitud se comenzo a atender&tipo=success&icon=fa fa-bell&titu=Solicitud iniciada");
    }
    else{
      return "error";
    }
  }

  // --------------   Revisar solicitud
    
  if (isset($_POST['revisar_sol'])) {
    $id_sol = $_POST['id_soli'];
    $id_esta = 4;

    $query1= "UPDATE t_solicitud set id_estatus = '$id_esta',fecha_act_sol = now() where id_solicitud = '$id_sol'";
    $resultado = mysqli_query ($conexion, $query1);

    if($resultado){
      header("Location: ../forms/form_admin_solicitudes.php?men=1&mensaje=La solicitud se envio a revisión&tipo=success&icon=fa fa-bell&titu=Solicitud en Revisión");
    }
    else{
      return "error";
    }
  }

  // --------------   Finalizar solicitud
    
  if (isset($_POST['finalizar_sol'])) {
    $id_sol = $_POST['id_soli'];
    $id_producto = $_POST['id_prod_sol'];
    $cant_prod = $_POST['cant_prod_sol'];
    $id_esta = 5;

    //se cambia el estatus de 4 a 5
    $query1= "UPDATE t_solicitud set id_estatus = '$id_esta',fecha_act_sol = now(), fecha_final_sol = now() where id_solicitud = '$id_sol'";
    $resultado = mysqli_query ($conexion, $query1);

    if($resultado){

      //se resliza una consulta en la tabla inventario para saber si se encuentra un registro existente en la tabla, de no ser así el se genera un nuevo registro para llevar el inventasrio,     Aqui solo se agregan los productos termiandos a la fabrica.
      $query= "SELECT * FROM t_inventario where id_producto = '$id_producto'";
      $inventario = $conexion->query($query);
      $existeinvent = mysqli_num_rows($inventario);

      if($existeinvent == 0)
      {
        //se crea nuevo registro ya que no hay un registro existente del producto en el inventario
        $query_inv = "INSERT INTO t_inventario (id_sucursal, id_producto, existencias, fecha_alta_inv) VALUES(1, '$id_producto', '$cant_prod', now())";
        $resultado1 = mysqli_query ($conexion, $query_inv);
      }
      else
      {
        //se realiza la suma de existencias en el inventario con las terminadas y se actualiza el registro
        while($row=$inventario->fetch_assoc()){
          $exitencias_inv = $row['existencias'];
          $id_inv = $row['id_inventario'];
          $total_exist = $exitencias_inv + $cant_prod;
        }

        $query2= "UPDATE t_inventario set existencias = '$total_exist',fecha_act_inv = now() where id_inventario = '$id_inv'";
        $resultado1 = mysqli_query ($conexion, $query2);
      }
      
      if($resultado1){
        header("Location: ../forms/form_admin_solicitudes.php?men=1&mensaje=Se finalizo la solicitud de manera correcta&tipo=success&icon=fa fa-bell&titu=Solicitud atendida");
      }
      else{
        return "error";
      }
    }
    else{
      return "error";
    }
  }

?>