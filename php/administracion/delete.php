<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}
    require_once "../config.php";

    $sql_delete = "DELETE FROM empleados WHERE id = ?";
    if ($stmt_delete = $mysqli->prepare($sql_delete)) {
        $stmt_delete->bind_param("i", $param_id_delete);

        // SETEO DE PARAMETROS
        $param_id_delete = trim($_GET["id"]);

        if ($stmt_delete->execute()) {
            header("location: empleados.php");
            exit();
        } else {
            echo "Ha ocurrido un error. Intente de nuevo más tarde.";
        }
    }
    $mysqli->close();
?>