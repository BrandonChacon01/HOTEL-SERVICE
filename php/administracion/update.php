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
    } else {
        $nombre = $input_name;
    }

    $input_puesto = trim($_POST["puesto"]);
    if (empty($input_puesto)) {
        $puesto_err = "Por favor ingrese el puesto.";
    } else {
        $puesto = $input_puesto;
    }

    $input_telefono = trim($_POST["telefono"]);
    if (empty($input_telefono)) {
        $telefono_err = "Por favor ingrese una telefono.";
    } else {
        $telefono = $input_telefono;
    }

    $input_direccion = trim($_POST["direccion"]);
    if (empty($input_direccion)) {
        $direccion_err = "Ingrese las horas clase por semana de la telefono.";
    } else {
        $direccion = $input_direccion;
    }

    if (empty($nombre_err) && empty($puesto_err) && empty($telefono_err) && empty($direccion_err)) {

        $sql = "UPDATE empleados SET nombre=?, puesto=?, telefono=?, direccion=? WHERE id=?";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sssss", $param_nombre, $param_puesto, $param_telefono, $param_direccion, $param_id);

            $param_nombre = $nombre;
            $param_puesto = $puesto;
            $param_telefono = $telefono;
            $param_direccion = $direccion;
            $param_id = $_POST["id"];

            if ($stmt->execute()) {
                header("location: empleados.php");
                exit();
            } else {
                echo "Algo falló. Por favor intente más tarde.";
            }
        }

        $stmt->close();
    }

    $mysqli->close();
} else {
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);

        $sql = "SELECT * FROM empleados WHERE id = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $param_id);

            $param_id = $id;

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $nombre = $row["nombre"];
                    $puesto = $row["puesto"];
                    $telefono = $row["telefono"];
                    $direccion = $row["direccion"];
                } else {
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Algo falló. Por favor intente más tarde.";
            }
        }

        $stmt->close();
        $mysqli->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Actualizar empleado</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Actualizar empleado</h2>
                    <p>Por favor actualice los datos del docente y envíe el formulario.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control <?php echo (!empty($nombre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombre; ?>">
                            <span class="invalid-feedback"><?php echo $nombre_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Puesto</label>
                            <input name="puesto" class="form-control <?php echo (!empty($puesto_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $puesto; ?>">
                            <span class="invalid-feedback"><?php echo $puesto_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Telefono</label>
                            <input type="text" name="telefono" class="form-control <?php echo (!empty($telefono_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $telefono; ?>">
                            <span class="invalid-feedback"><?php echo $telefono_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" name="direccion" class="form-control <?php echo (!empty($direccion_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $direccion; ?>">
                            <span class="invalid-feedback"><?php echo $direccion_err; ?></span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Actualizar">
                        <a href="empleados.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
