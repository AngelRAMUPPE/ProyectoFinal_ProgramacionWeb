<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/styles.css">
    <link rel="stylesheet" href="public/css/stylesMedidor.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <link rel="shortcut icon" href="public/images/Logo.png" type="image/x-icon">
    <title>AppGrow</title>
</head>
<body>
<?php
        session_start();

        if(!isset($_SESSION['user_id'])) {
            header('Location: login.html');
            exit;
          }

        $db = new mysqli('localhost', 'root', 'SQL100_', 'pagina_web');
        $userId = $_SESSION['user_id']; 
        $sql = "SELECT codigo_medidor 
                FROM usuarios
                WHERE id_usuario = $userId";

        $result = $db->query($sql);  
        $row = $result->fetch_assoc();
        $meterCode = $row['codigo_medidor'];
        $sql = "SELECT * 
                FROM registros_humedad
                WHERE codigo_medidor = '$meterCode'
                ORDER BY fecha_hora DESC";

        $result = $db->query($sql); 
        $humidityData = $result;
        $sql = "SELECT correo 
        FROM usuarios
        WHERE id_usuario = $userId";

        $result2 = $db->query($sql);
        $userData = $result2->fetch_assoc();

        $userEmail = $userData['correo'];
        
        ?>
  <header>
    <nav>
      <div class="nav-contenedor">
        <div class="logo">
        <a href="index.html" style="text-decoration: none; color: black !important;"><img src="public/images/Logo.png" alt="" srcset="" height="150px"><b style="color: #2ACC32;">APP</b><b>GROW</b></a>    
        </div>
        <div class="contenido">
          <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="#" class="nav-link px-2" style="color: #2ACC32;border-bottom: 2px solid #2ACC32;">Home</a></li>

            <li><a href="#medidor" class="nav-link px-2">Mediciones</a></li>
          </ul>
        </div>
        <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?php echo $userEmail ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="includes/cerrarsession.php">Cerrar session</a></li>
        </ul>
</div>
      </div>
    </nav>
  </header>
  <br>
  <div class="acercaDe" id="sobre">
    <div class="float-left">
        <img src="public/images/Logo.png" alt="">
    </div>
    <div class="float-right">
      <h3 style="text-align: left; color: #2ACC32;">Sobre tu planta &#8213;</h3>
      <p> Tu planta parece llevar un nivel adecuado y mantenido bueno de humedad, recordar evitar el sobreriego.</p>
    </div>
  </div> 
  <div class="medidor" id="medidor">
    <div class="info-tabla">
    <div class="ser-titulo2">
      <h2>Tu medidor en accion &#8213; </h2>
    </div>
        <table class="tabla">
        <thead>
        <tr>
            <th>ID</th>
            <th>Código</th> 
            <th>Fecha</th>
            <th>Humedad</th>
            <th>Editar</th>
        </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id_registro']; ?></td>
            <td><?php echo $row['codigo_medidor']; ?></td>
            <td><?php echo $row['fecha_hora']; ?></td>
            <td><?php echo $row['valor_leido']. "%" ; ?></td>
            <td>                                            
                                            <div class="modal fade" id="editarModal_<?php echo $row['id_registro']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color:black;">Editar</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="includes/editarvalor.php">
                                                            <div class="row form-group">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position: relative; top: 7px; color:black;">
                                                                        Humedad
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <input type="hidden" id="id2" name="id2" value="<?php echo $row['id_registro']; ?>">
                                                                    <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $row['valor_leido']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-primary" name="editar">Guardar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="deleteModal_<?php echo $row['id_registro']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel" style="color:black;">Confirmacion de eliminacion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="Color:black;">
                                                    Estas seguro que quieres Borrar el id <?php echo $row['id_registro']; ?>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="POST" action="includes/eliminarvalor.php">
                                                    <input type="hidden" name="id" value="<?php echo $row['id_registro']; ?>">  
                                                    <button type="submit" class="btn btn-danger" name="eliminar">Borrar</button>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                            <form method="POST" action="includes/eliminarvalor.php">
                                                <input type="hidden" id="id" name="id" value="<?php echo $row['id_registro']; ?>">
                                                <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editarModal_<?php echo $row['id_registro']; ?>" href="">Editar</a>
                                                <a href="" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal_<?php echo $row['id_registro']; ?>">Eliminar</a>
                                            </form></td>
        </tr>
        <?php endwhile; ?>
        </tbody>
        </table>
    </div>
    <div class="grafica">
      <div class="ser-titulo2">
      <h2>Grafica del avance de tu planta &#8213; </h2>
      </div>
      <canvas id="chart">

      </canvas>
    </div>
  </div>
  <?php
  $sql = "SELECT codigo_medidor 
  FROM usuarios
  WHERE id_usuario = $userId";

  $result = $db->query($sql);  
  $row = $result->fetch_assoc();
  $meterCode = $row['codigo_medidor'];
  $sql = "SELECT * FROM registros_humedad 
  WHERE codigo_medidor = '$meterCode'
  ORDER BY fecha_hora";
  $result = $db->query($sql);  
  $fechas = [];
  $humedad = [];
  while($row = $result->fetch_assoc()) {
  $fecha = date('M d, Y', strtotime($row['fecha_hora'])); 
  $fechas[] = "'$fecha'";
  $humedad[] = $row['valor_leido'];
  }
  $fechasJSON = json_encode($fechas);
  $humedadJSON = json_encode($humedad);
  ?>
<div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
      <p class="col-md-4 mb-0 text-muted">© 2023 AppGrow</p>
      <ul class="nav col-md-4 justify-content-end" style="--bs-nav-link-color: black; --bs-nav-link-hover-color: #2ACC32 !important;">
        <li><a href="#" class="nav-link px-2">Home</a></li>
        <li><a href="#medidor" class="nav-link px-2">Mediciones</a></li>
      </ul>
    </footer>
  </div>
  <script>
    var fecha = <?php echo $fechasJSON; ?>;
    var humedad = <?php echo $humedadJSON; ?>;
    const ctx = document.getElementById('chart').getContext('2d'); 
    console.log(humedad);
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: fecha,
          datasets: [{ 
            data: humedad
          }]
        }
      });
  </script>
</body>
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/bootstrap.bundle.min.js"></script>
</html>