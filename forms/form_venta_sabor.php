<?php
// Llamamos a la lógica del backend
include("../back/consultas.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>CRUNCHPOP - Estadisticas sabores</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="../assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ["../assets/css/fonts.min.css"],
            },
            active: function () { sessionStorage.fonts = true; },
        });
    </script>

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
</head>
<body>
    <div class="wrapper">
        <?php include("../menu_forms.html"); ?>

        <div class="main-panel">
            <div class="main-header">
                <?php include("barra_notificaciones.php"); ?>
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                        <h4 class="card-title">Historial de pedidos por sabor</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="tabla-pedidos" class="display table table-striped table-hover">
                                            <thead>
                                                <tr align="center">
                                                    <th>Sabor</th>
                                                    <th>Ventas totales</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                // Variable para acumular el gran total
                                                $gran_total = 0;

                                                while($row = $resultado_sabor->fetch_assoc()){ 
                                                    // Sumamos cada cantidad al acumulador general
                                                    $gran_total += $row['total_cantidad'];
                                                ?>
                                                <tr align="center">
                                                    <td><?php echo $row['nombre_sabor']; ?></td>
                                                    <td><?php echo $row['total_cantidad']; ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <!-- Fila para mostrar el total general al final de la tabla -->
                                            <tfoot>
                                                <tr align="center" class="fw-bold bg-light">
                                                    <td>Total General:</td>
                                                    <td><?php echo $gran_total; ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalle -->
    <div class="modal fade" id="modalDetalle" tabindex="-1" aria-labelledby="modalDetalleLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetalleLabel">
                        <span class="fw-mediumbold">Detalle del Pedido</span> 
                        <span class="fw-light" id="txt_id_pedido"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped mt-3">
                            <thead>
                                <tr align="center">
                                    <th>#</th>
                                    <th>Producto / Sabor</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="tabla_detalles_body"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Estatus -->
    <div class="modal fade" id="modificar_estatus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="../back/modificar_reg.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">¿Desea modificar el estatus del pedido?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <input type="hidden" name="id_venta" id="id_pedido_venta">
                    <input type="hidden" name="id_estatus" id="id_estatus_venta">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" name="avanzar_estado" class="btn btn-primary">Modificar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts JS Core -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="../assets/js/kaiadmin.min.js"></script>
    
    <!-- Script Personalizado -->
    <script src="../assets/js/scripts/sc-proj.js"></script>
</body>
</html>