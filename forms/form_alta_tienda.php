<?php
  include("../back/cargas.php");

  // Evitar errores si las variables GET no vienen definidas
  $men = $_GET['men'] ?? 0;
  $mensaje = $_GET['mensaje'] ?? '';
  $tipo = $_GET['tipo'] ?? '';
  $icon = $_GET['icon'] ?? '';
  $titulo = $_GET['titu'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Alta de tiendas</title>
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
          <div class="main-header-logo">
            <div class="logo-header" data-background-color="dark">
              <a href="../index.html" class="logo">
                <img
                  src="../assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
          </div>
          
          <!-- Barra de navegación -->
          <?php
            include("barra_notificaciones.php");
          ?>
        </div>

        <div class="container">
          <div class="page-inner">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">Nueva Tienda</h4>
                      <button
                        class="btn btn-success btn-round ms-auto"
                        data-bs-toggle="modal"
                        data-bs-target="#altaprod">
                        <i class="fa fa-plus"></i>
                        Agregar nuevo
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
                            <th>Nombre tienda</th>
                            <th>Encargado</th>
                            <th>Contacto</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                         <?php 
                            $query = "SELECT * FROM t_tienda_venta WHERE fecha_baja IS NULL";
                            $resultado = $conexion->query($query);
                            while($row = $resultado->fetch_assoc()){
                         ?>
                          <tr align="center">
                            <td hidden><?php echo $row['idt_tienda'];?></td>
                            <td><?php echo $row['nombre_tienda'];?></td>
                            <td><?php echo $row['encargado_tienda'];?></td>
                            <td><?php echo $row['contacto_tienda'];?></td>
                            <td><?php echo $row['direccion_tienda_municipio'].", ".$row['direccion_tienda_colonia'].", ".$row['direccion_tienda_calle']." ".$row['direccion_tienda_numero'];?></td>
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
                                <button
                                  type="button"
                                  title=""
                                  class="btn btn-link btn-danger delms"
                                  data-original-title="Remove"
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

    <!-- Core JS Files -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="../assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="../assets/js/plugin/chart-circle/circles.min.js"></script>
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="../assets/js/plugin/jsvectormap/world.js"></script>
    <script src="../assets/js/plugin/gmaps/gmaps.js"></script>
    <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="../assets/js/kaiadmin.min.js"></script>

    <!-- Modal Agregar (Corregido el action y el input de contacto) -->
    <div class="modal fade" id="altaprod" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!-- SE CORRIGIÓ EL ACTION AQUÍ -->
          <form action="../back/cargas.php" method="POST">
            <div class="modal-header">
              <h5 class="modal-title">Agregar nueva tienda</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              
              <div class="row g-2 mb-3">
                <div class="col mb-0">
                  <label>Nombre tienda*</label>
                  <input type="text" class="form-control input-full" name="nom_tienda" placeholder="Nombre" required />
                </div>
              </div>
              
              <div class="row g-2 mb-3">
                <div class="col mb-0">
                  <label>Municipio</label>
                  <input type="text" class="form-control input-full" name="municipio" placeholder="Municipio"/>
                </div>
                <div class="col mb-0">
                  <label>Colonia</label>
                  <input type="text" class="form-control input-full" name="colonia" placeholder="Colonia" />
                </div>
              </div>
            
              <div class="row g-2 mb-3">
                <div class="col mb-0">
                  <label>Calle</label>
                  <input type="text" class="form-control input-full" name="calle" placeholder="Calle"/>
                </div>
                <div class="col mb-0">
                  <label>Número</label>
                  <input type="text" class="form-control input-full" name="numero_ti" placeholder="Número tienda" />
                </div>
              </div>

              <div class="row g-2 mb-3">
                <div class="col mb-0">
                  <label>Encargado</label>
                  <input type="text" class="form-control input-full" name="nom_encargado" placeholder="Nombre de encargado" required />
                </div>
              </div>

              <div class="row g-2">
                <div class="col mb-0">
                  <label>Contacto</label>
                  <!-- SE CORRIGIÓ EL TIPO Y EL PLACEHOLDER -->
                  <input type="text" class="form-control input-full" name="contacto_ti" placeholder="Teléfono de contacto" required />
                </div>
              </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" name="agregar_tienda_nueva" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Eliminar -->
    <div class="modal fade" id="eliminarms" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="../back/eliminar_reg.php" method="POST">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel1">Desea eliminar la tienda?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <input type="hidden" name="id_prod" id="del_idprod">
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" name="eliminar_tienda" class="btn btn-primary">Eliminar</button>
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
        $('#del_idprod').val(datos[0]);
      });
    </script>

    <?php 
    if($men == 1) {
    ?>
      <script>
        $(document).ready(function () {
          var placementFrom = 'top';
          var placementAlign = 'right';
          var state = "<?php echo $tipo;?>";
          var content = {};

          content.message = "<?php echo $mensaje;?>";
          content.title = "<?php echo $titulo;?>";
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
  </body>
</html>