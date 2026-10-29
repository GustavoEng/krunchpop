<?php
header('Content-Type: application/json');
$connect = mysqli_connect("localhost", "root", "root", "bd_pop");

if(isset($_POST["id"])){
    $id = mysqli_real_escape_string($connect, $_POST["id"]);
    
    // Consulta para obtener todos los productos vinculados a esa venta
    $query = "SELECT * FROM t_venta_detalle 
                INNER JOIN c_sabores ON t_venta_detalle.id_producto = c_sabores.id_sabores
                WHERE t_venta_detalle.id_venta = '$id'";
    $result = mysqli_query($connect, $query);
    
    $detalles = array();

    if(mysqli_num_rows($result) > 0) {
        while($fila = mysqli_fetch_assoc($result)) {
            $detalles[] = $fila; // Agregamos cada fila al array
        }
        echo json_encode($detalles); // Enviamos la lista completa
    } else {
        echo json_encode(["error" => "No se encontraron productos para este pedido."]);
    }
} else {
    echo json_encode(["error" => "ID no recibido."]);
}
mysqli_close($connect);
?>