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
    <title>SCIRS - Administrar Solicitudes</title>
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
                      <h4 class="card-title">Solicitudes finalizadas</h4>
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
                            <th>Id solicitud</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Fecha solicitud</th>
                            <th>Fecha fin</th>
                            <th>Observaciones</th>
                            <th>Estatus</th>
                          </tr>
                        </thead>
                         <?php 

                            $query= "SELECT * FROM t_solicitud 
                                    INNER JOIN t_producto ON t_solicitud.id_producto = t_producto.id_producto
                                    INNER JOIN c_estatus ON  t_solicitud.id_estatus = c_estatus.id_estatus
                                    WHERE t_solicitud.fecha_baja_sol is null and t_solicitud.id_estatus = 5 ORDER BY t_solicitud.fecha_alta_sol ASC";
                          
                          $resultado = $conexion->query($query);
                          while($row=$resultado->fetch_assoc()){

                            $validbut = $row['id_estatus'];
                            $obser = $row['observaciones'];
                          
                        ?>
                        <tbody>
                          <tr align="center">
                            <td><?php echo $row['id_solicitud'];?></td>
                            <td><?php echo $row['nom_producto'];?></td>
                            <td><?php echo $row['cant_productos'];?></td>
                            <td><?php echo $row['fecha_alta_sol'];?></td>
                            <td><?php echo $row['fecha_final_sol'];?></td>
                            <td>
                              <div class="form-button-action">
                                <button
                                  type="button"
                                  title=""
                                  class="btn btn-link btn-default btn-lg modmicro"
                                  data-original-title="Edit Task"
                                  data-bs-toggle="modal"
                                  data-bs-target="#modalobserva"
                                >
                                  <i class="fa fa-eye"></i>
                                </button>                              
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

<!-- Modal Agregar-->
    <div class="modal fade" id="altaprod" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="../back/cargas.php" method="POST">
            <div class="modal-header">
              <h5 class="modal-title" >Nueva solicitud</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              
              <div class="row g-2 mb-3">
                <div class="col mb-0">
                  <label>Seleccione producto *</label>
                  <select required name="nom_prod" class="form-control">
                    <?php
                        $consulta = "SELECT * FROM t_producto";
                        $ejecutar=mysqli_query($conexion,$consulta) or die(mysql_error($conexion));
                        ?> <option value="" selected>Seleccione una opción</option><?php
                     foreach ($ejecutar as $opciones): ?>
                    <option value="<?php echo $opciones['id_producto']?>"><?php echo $opciones['nom_producto']?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col mb-0">
                  <label>Cantidad *</label>
                  <input type="number" class="form-control input-full" name="cantidad_piezas" placeholder="Canitad de productos"/>
                </div>
              </div>
              
              <div class="row g-2 mb-3">
                <div class="col mb-0">
                  <label>Observaciones</label>
                  <input type="text" class="form-control input-full" name="observaciones_sol" placeholder="Observaciones" />
                </div>
              </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" name="agregar_nueva_solicitud" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

<!--------   Modal Aceptar solicitud    --------->
  <div class="modal fade" id="modaceptar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form action="../back/administracion_sol.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Desea aceptar la solicitud?</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
              <input type="hidden" name="id_soli" id="id_sol">
          
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" name="aceptar_sol" class="btn btn-primary">Aceptar</button>
        </div>
        </form>
      </div>
    </div>
  </div>

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
