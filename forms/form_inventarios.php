<?php
  include("../back/cargas.php");

  if (isset($_POST['b_sucursal'])) {
  $bus_sucursal = $_POST['sucursal_rs'];
}
  
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
    <title>SCIRS - Inventario de Productos</title>
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
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                      <div class="d-flex align-items-center">
                        <div class="col-md-8">
                        <h4 class="card-title">Inventario de productos</h4>
                        </div>
                        <div class="col-md-2">
                          <select required class="form-select input-fixed" name="sucursal_rs">
                            <?php
                              $consulta = "SELECT * FROM c_sucursales";
                              $ejecutar=mysqli_query($conexion,$consulta) or die(mysql_error($conexion));
                            ?> <option value="" selected>Seleccione una opción</option><?php
                             foreach ($ejecutar as $opciones): ?>
                            <option value="<?php echo $opciones['id_sucursales']?>"><?php echo $opciones['nom_sucursal']?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-1">
                          <button class="btn btn-primary btn-round" name="b_sucursal">Buscar</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="add-row"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr align="center">
                            <th>Nombre producto</th>
                            <th>Cantidad</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                         <?php 

                         if($bus_sucursal != null)
                          {    
                            $query= "SELECT * FROM t_inventario 
                                    INNER JOIN t_producto ON t_inventario.id_producto = t_producto.id_producto
                                    INNER JOIN c_sucursales ON  t_inventario.id_sucursal = c_sucursales.id_sucursales 
                                    WHERE t_inventario.id_sucursal = '$bus_sucursal'";
                          }
                          else
                          {
                            $query= "SELECT * FROM t_inventario 
                                    INNER JOIN t_producto ON t_inventario.id_producto = t_producto.id_producto
                                    INNER JOIN c_sucursales ON  t_inventario.id_sucursal = c_sucursales.id_sucursales 
                                    WHERE t_inventario.id_sucursal = 1";

                          }
                          $resultado = $conexion->query($query);
                          while($row=$resultado->fetch_assoc()){

                          
                        ?>
                        <tbody>
                          <tr align="center">
                            <td><?php echo $row['nom_producto'];?></td>
                            <td><?php echo $row['existencias'];?></td>
                            <td><?php echo $row['descripcion'];?></td>
                            <td>
                                                           
                              </div>
                            </td>
                            <td><b><?php echo $row['nom_estado'];?></b></td>
                          </tr>
                        </tbody>
                        <?php
                          }
                        ?>
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




  <!--------   Modal iniciar solicitud    --------->
  <div class="modal fade" id="modini" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form action="../back/administracion_sol.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Desea iniciar con la solicitud?</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
              <input type="hidden" name="id_soli" id="id_sol1">
          
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" name="iniciar_sol" class="btn btn-primary">Aceptar</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!--------   Modal enviar a revisión solicitud    --------->
  <div class="modal fade" id="modrev" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form action="../back/administracion_sol.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Desea iniciar la revisión del producto?</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
              <input type="hidden" name="id_soli" id="id_sol2">
          
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" name="revisar_sol" class="btn btn-primary">Aceptar</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!--------   Modal Finalizar solicitud    --------->
  <div class="modal fade" id="modfin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form action="../back/administracion_sol.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">La solicitud a sido atendida?</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
              <input type="hidden" name="id_soli" id="id_sol3">
          
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" name="finalizar_sol" class="btn btn-primary">Aceptar</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!--------   Modal observación    --------->
  <div class="modal fade" id="modalobserva" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form action="" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Observaciones e indicaciones</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
          <div class="modal-body">
              <h6><?php echo $obser;?></h6>
          </div>
          
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
        </form>
      </div>
    </div>
  </div>




<script>
  $('.aceptsol').on('click',function(){
    $tr=$(this).closest('tr');
    var datos = $tr.children("td").map(function(){
      return $(this).text();
    });
    $('#id_sol').val(datos[0]);
    $('#id_sol1').val(datos[0]);
    $('#id_sol2').val(datos[0]);
    $('#id_sol3').val(datos[0]);
  });

  
  $('.modmicro').on('click',function(){
      $tr=$(this).closest('tr');
      var datos = $tr.children("td").map(function(){
         return $(this).text();
      });
      $('#mod_idsol').val(datos[0]);
      $('#mod_prod').val(datos[1]);
      $('#mod_cantidadsol').val(datos[2]);
      $('#mod_observsol').val(datos[4]);
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
