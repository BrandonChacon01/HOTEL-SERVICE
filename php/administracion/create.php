<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

    require_once "../config.php";

    $nombre = $puesto = $direccion = $telefono = "";
    $nombre_err = $puesto_err = $telefono_err = $direccion_err = "";


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $input_name = trim($_POST["nombre"]);
        if (empty($input_name)) {
            $nombre_err = "Por favor ingrese un nombre.";
        }else {
            $nombre = $input_name;
        }

        $input_address = trim($_POST["puesto"]);
        if (empty($input_address)) {
            $puesto_err = "Por favor ingrese su puesto.";
        } else {
            $puesto = $input_address;
        }

        $input_telefono = trim($_POST["telefono"]);
        if (empty($input_telefono)) {
            $telefono_err = "Por favor ingrese su numero de teléfono.";
        } else {
            $telefono = $input_telefono;
        }

        $input_direccion = trim($_POST["direccion"]);
        if (empty($input_direccion)) {
            $direccion_err = "Ingrese su dirección.";
        } else {
            $direccion = $input_direccion;
        }

    if (empty($nombre_err) && empty($puesto_err) && empty($telefono_err) && empty($direccion_err)) {
        $sql = "INSERT INTO empleados (nombre, puesto, telefono, direccion) VALUES (?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssss", $param_nombre, $param_puesto, $param_telefono, $param_direccion);

            $param_nombre = $nombre;
            $param_puesto = $puesto;
            $param_telefono = $telefono;
            $param_direccion = $direccion;

            if ($stmt->execute()) {
                header("location: empleados.php");
                exit();
            } else {
                echo "Oops! Algo falló. Por favor intente más tarde.";
            }
        }
        $stmt->close();
    }
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrar empleado</title>
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
            background-image: linear-gradient(to right, #C6BAD2, #BBC5DE, #BB98D0);
        }
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
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
                              <li class="nav-item">
                                 <a class="nav-link" href="empleados.php">Empleados del hotel</a>
                              </li>
                              <li class="nav-item active">
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
                    <h2 class="mt-5">Ingresar registro</h2>
                    <p>Por favor llenar este formulario y enviarlo para su almacenamiento.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control <?php echo (!empty($nombre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombre; ?>">
                            <span class="invalid-feedback"><?php echo $nombre_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Puesto</label>
                            <input name="puesto" class="form-control <?php echo (!empty($puesto_err)) ? 'is-invalid' : ''; ?>"><?php echo $puesto; ?></input>
                            <span class="invalid-feedback"><?php echo $puesto_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Telefono</label>
                            <input type="text" name="telefono" class="form-control <?php echo (!empty($telefono_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $telefono; ?>">
                            <span class="invalid-feedback"><?php echo $telefono_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Direccion</label>
                            <input type="text" name="direccion" class="form-control <?php echo (!empty($direccion_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $direccion; ?>">
                            <span class="invalid-feedback"><?php echo $direccion_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Guardar">
                        <a href="empleados.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

