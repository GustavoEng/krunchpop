<?php
// Llamamos a la lógica del backend
include("../back/consultas.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>CRUNCHPOP - Tablero pedidos</title>
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
                                        <h4 class="card-title">Tablero de pedidos</h4>
                                        <!-- Formulario de Filtro por Estatus -->
                                        <form method="GET" class="d-flex align-items-center mt-2 mt-md-0">
                                            <select name="estatus" class="form-control form-select form-select-sm" style="width: 220px;" onchange="this.form.submit()">
                                                <option value="">Todos los activos</option>
                                                <option value="1" <?php echo (isset($_GET['estatus']) && $_GET['estatus'] == '1') ? 'selected' : ''; ?>>Solicitado</option>
                                                <option value="2" <?php echo (isset($_GET['estatus']) && $_GET['estatus'] == '2') ? 'selected' : ''; ?>>Empacado</option>
                                                <option value="3" <?php echo (isset($_GET['estatus']) && $_GET['estatus'] == '3') ? 'selected' : ''; ?>>Entregado</option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="tabla-pedidos" class="display table table-striped table-hover">
                                            <thead>
                                                <tr align="center">
                                                    <th>Cliente</th>
                                                    <th>Fecha solicitud</th>
                                                    <th>Estatus</th>
                                                    <th>total venta</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while($row = $resultado->fetch_assoc()){ 
                                                    $estatus = obtenerTextoEstatus($row['estatus_venta']);
                                                    $estatus_btn = obtenerTextoEstatus($row['estatus_venta'] + 1);
                                                ?>
                                                <tr align="center">
                                                    <td hidden><?php echo $row['id_venta']; ?></td>
                                                    <td hidden><?php echo $row['estatus_venta']; ?></td>
                                                    <td><?php echo $row['nombre_tienda']; ?></td>
                                                    <td><?php echo $row['fecha_alta_tventa']; ?></td>
                                                    <td><?php echo $estatus; ?></td>
                                                    <td><?php echo $row['total_venta']; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm btn-consultar" data-id="<?php echo $row['id_venta']; ?>">
                                                            Ver Detalle
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-sm mod_estatus" data-bs-toggle="modal" data-bs-target="#modificar_estatus"> 
                                                            <?php echo $estatus_btn; ?> 
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
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