<?php 
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <title>Empleados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="../../css/style.css">
      <link rel="stylesheet" href="../../css/responsive.css">
      <link rel="icon" href="../../images/fevicon.png" type="image/gif" />
      <link rel="stylesheet" href="../../css/jquery.mCustomScrollbar.min.css">
   
    <style>
        body {
            background-image: linear-gradient(to right, #6F86C2, #B174D7, #C8A7EA);
        }
    
        table tr td:last-child {
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
<header>
 <!-- header inner -->
 <div class="header">
            <div class="container">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <img src="../../images/logo.png" alt="#" />
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                     <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li class="nav-item active">
                                 <a class="nav-link" href="empleados.php">Empleados del hotel</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="create.php">Agregar empleado</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="pedidos.php">Restaurante</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="reserva.php">Reservaciones</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="../logout.php">Cerrar sesión</a>
                              </li>
                           </ul>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- end header inner -->

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                   <br>
                    <?php
                    require_once "../config.php";

                    $sql = "SELECT * FROM empleados";
                    if ($result = $mysqli->query($sql)) {
                        if ($result->num_rows > 0) {
                            echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>#id</th>";
                            echo "<th>Nombre completo</th>";
                            echo "<th>Puesto</th>";
                            echo "<th>Direccion</th>";
                            echo "<th>Telefono</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row = $result->fetch_array()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['nombre'] . "</td>";
                                echo "<td>" . $row['puesto'] . "</td>";
                                echo "<td>" . $row['direccion'] . "</td>";
                                echo "<td>" . $row['telefono'] . "</td>";
                                echo "<td>";
                                echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3" title="Editar empleado" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                echo '<a href="delete.php?id=' . $row['id'] . '" title="Eliminar empleado" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            
                            $result->free();
                        } else {
                            echo 'ERROR';
                        }
                    } else {
                        echo "A ocurrido un error. Intentelo mas tarde.";
                    }

                    // CIERRA CONEXION
                    $mysqli->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
