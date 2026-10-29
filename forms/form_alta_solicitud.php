<?php
  include("../back/cargas.php");
  
  $men = $_GET['men'];
  $mensaje = $_GET['mensaje'];
  $tipo = $_GET['tipo'];
  $icon = $_GET['icon'];
  $titulo = $_GET['titu'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SCIRS - Alta Solicitudes</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="../assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["../assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="../assets/css/demo.css" />
  </head>
  <body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php
      include("../menu_forms.html");
    ?>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        
        <!--  Barra de navegación -->
        <?php
          include("barra_notificaciones.php");
        ?>
        <!-- Fin barra de navegación -->


      </div>

      <div class="container">
        <div class="page-inner">
          
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <h4 class="card-title">Nuevo pedido</h4>
                    <button
                      class="btn btn-success btn-round ms-auto"
                      data-bs-toggle="modal"
                      data-bs-target="#altaprod">
                      <i class="fa fa-plus"></i>
                      Agregar producto
                    </button>
                    <button
                      class="btn btn-success btn-round ms-auto"
                      data-bs-toggle="modal"
                      data-bs-target="#alta_pedido">
                      <i class="fa fa-plus"></i>
                      Guardar pedido
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table
                      id="add-row"
                      class="display table table-striped table-hover"
                    >
                      <thead>
                        <tr align="center">
                          <th>Producto</th>
                          <th>Cantidad</th>
                          <th>total</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                       <?php 
                          $query= "SELECT * FROM t_pedido_temporal
                          INNER JOIN c_sabores ON t_pedido_temporal.id_producto = c_sabores.id_sabores
                          ORDER BY fecha_alta_temp DESC";
                        
                          $resultado = $conexion->query($query);
                          
                          // Inicializar variables acumuladoras
                          $total_cantidad = 0;
                          $total_general = 0;

                          while($row = $resultado->fetch_assoc()){
                              // Acumular valores
                              $total_cantidad += $row['cantidad'];
                              $subtotal = $row['cantidad'] * $row['precio_mayoreo'];
                              $total_general += $subtotal;
                       ?>
                        <tr align="center">
                          <td hidden><?php echo $row['id_pedido_temporal'];?></td>
                          <td><?php echo $row['nombre_sabor'];?></td>
                          <td><?php echo $row['cantidad'];?></td>
                          <td><?php echo $subtotal;?></td>
                          <td>
                            <div class="form-button-action">
                              <button
                                type="button"
                                title=""
                                class="btn btn-link btn-primary btn-lg modmicro"
                                data-original-title="Edit Task"
                                data-bs-toggle="modal"
                                data-bs-target="#modprod"
                              >
                                <i class="fa fa-edit"></i>
                              </button>
                              <button type="button" title="" class="btn btn-link btn-danger delms" data-original-title="Remove"
                                data-bs-toggle="modal"
                                data-bs-target="#eliminarms"
                              >
                                <i class="fa fa-times"></i>
                              </button>
                            </div>
                          </td>
                        </tr>
                      <?php
                          }
                      ?>
                      </tbody>
                      <tfoot>
                        <tr align="center" style="font-weight: bold; background-color: #f8f9fa;">
                          <td>Total:</td>
                          <td><?php echo $total_cantidad; ?></td>
                          <td><?php echo $total_general; ?></td>
                          <td></td>
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

  </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="../assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="../assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="../assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Google Maps Plugin -->
    <script src="../assets/js/plugin/gmaps/gmaps.js"></script>

    <!-- Sweet Alert -->
    <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>

  </body>
</html>

<!-- Modal Agregar-->
  <div class="modal fade" id="altaprod" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="../back/cargas.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" >Nuevo producto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row g-2 mb-3">
              <div class="col mb-0">
                <label>Seleccione producto *</label>
                <select required name="nom_prod" class="form-control">
                  <?php
                    $consulta = "SELECT * FROM c_sabores";
                    $ejecutar=mysqli_query($conexion,$consulta) or die(mysql_error($conexion));
                  ?> 
                  <option value="" selected>Seleccione un producto</option>
                  <?php foreach ($ejecutar as $opciones): ?>
                  <option value="<?php echo $opciones['id_sabores']?>"><?php echo $opciones['nombre_sabor']?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="col mb-0">
                <label>Cantidad *</label>
                <input type="number" class="form-control input-full" name="cantidad_prod" placeholder="Cantidad de productos"/>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" name="agregar_nuevo_producto" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--------   Modal Alta pedido   --------->
  <div class="modal fade" id="alta_pedido" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form action="../back/cargas.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Desea confirmar el pedido?</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            data-bs-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="row g-2 mb-3">
            <div class="col mb-0">
              <label>Seleccione cliente *</label>
                <select required name="id_cliente" class="form-control">
                  <?php
                    $consulta = "SELECT * FROM t_tienda_venta";
                    $ejecutar=mysqli_query($conexion,$consulta) or die(mysql_error($conexion));
                  ?> 
                  <option value="" selected>Seleccione un cliente</option>
                  <?php foreach ($ejecutar as $opciones): ?>
                  <option value="<?php echo $opciones['idt_tienda']?>"><?php echo $opciones['nombre_tienda']?></option>
                  <?php endforeach ?>
                </select>
            </div>
          </div>
        </div>
          
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" name="agregar_pedido" class="btn btn-primary">Aceptar</button>
        </div>
        </form>
      </div>
    </div>
  </div>

<!--------   Modal Eliminar   --------->
  <div class="modal fade" id="eliminarms" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form action="../back/eliminar_reg.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Desea eliminar la solicitud?</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
              <input type="hidden" name="id_prod" id="del_id">
          
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" name="eliminar_prod" class="btn btn-primary">Eliminar</button>
        </div>
        </form>
      </div>
    </div>
  </div>

   <!---------   Modal Modificar    -------->

  <div class="modal fade" id="modprod" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="../back/modificar_reg.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Modificar producto</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          
          <div class="row g-2">
            <div class="col mb-0">
              <input type="hidden" name="id_prod" id="mod_idsol">
              <label for="emailBasic" class="form-label">Nombre producto</label>
              <input disabled type="text" id="mod_prod" name="nom_prod" class="form-control" required />
            </div>
          </div>

          <div class="row g-2">
            <div class="col mb-3">
              <label for="dobBasic" class="form-label">Cantidad</label>
              <input type="text" id="mod_cantidadsol" name="cant_pedido" class="form-control" required />
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" name="modificar_prod" class="btn btn-primary">Modificar</button>
        </div>
        </form>
      </div>
    </div>
  </div>


<script>
  $('.delms').on('click',function(){
    $tr=$(this).closest('tr');
    var datos = $tr.children("td").map(function(){
      return $(this).text();
    });
    $('#del_id').val(datos[0]);
  });

  
  $('.modmicro').on('click',function(){
      $tr=$(this).closest('tr');
      var datos = $tr.children("td").map(function(){
         return $(this).text();
      });
      
      $('#mod_idsol').val(datos[0]);
      $('#mod_prod').val(datos[1]);
      $('#mod_cantidadsol').val(datos[2]);
  });
  </script>

<?php 
if($men == 1)
{
?>
  <script>
    $(document).ready(function () {
      var placementFrom = 'top';
      var placementAlign = 'right';
      var state = "<?php echo $tipo;?>";
      var content = {};

      content.message = "<?php echo $mensaje;?>";
      content.title = "<?php echo $titulo ;?>";
      content.icon = "<?php echo $icon;?>";

      $.notify(content, {
        type: state,
        placement: {
          from: placementFrom,
          align: placementAlign,
        },
        time: 800,
        delay: 3000,
      });
    });
  </script>
<?php 
}
?>