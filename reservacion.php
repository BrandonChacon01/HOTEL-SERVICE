<?php
require_once "php/config.php";
require_once "php/fpdf183/fpdf.php";

$client = $number = $dateIn = $dateOut = $room = $cost = $mensaggeConfirmation = "";
$client_errors = $number_errors = $dateIn_errors = $dateOut_errors = $room_errors = $cost_errors = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientName = $_POST["clientName"];
    $numberOfPeople = $_POST["numberOfPeople"];
    $checkInDate = $_POST["checkInDate"];
    $checkOutDate = $_POST["checkOutDate"];
    $roomType = $_POST["roomType"];
    $totalCost = $_POST["totalCost"];

    if (empty($clientName)) {
        $client_errors = "El nombre del cliente es requerido";
    } else {
        $client = $clientName;
    }

    if (empty($numberOfPeople)) {
        $number_errors = "El número de personas es requerido";
    }else {
        $number = $numberOfPeople;
    }

    if (empty($checkInDate)) {
        $dateIn_errors = "La fecha de entrada es requerida";
    } else {
        $dateIn = $checkInDate;
    }

    if (empty($checkOutDate)) {
        $dateOut_errors = "La fecha de salida es requerida";
    } else {
        $dateOut = $checkOutDate;
    }

    if (empty($roomType)) {
        $room_errors = "El tipo de habitación es requerido";
    } else {
        $room = $roomType;
    }

    if (empty($totalCost)) {
        $cost_errors = "El costo total es requerido";
    } else {
        $cost = $totalCost;
    }

   if (empty($client_errors) && empty($number_errors) && empty($dateIn_errors) && empty($dateOut_errors) && empty($room_errors) && empty($cost_errors)) {
        $sql = "INSERT INTO clientes (nombre, numero_personas, fecha_entrada, fecha_salida, tipo_habitacion, costo_total) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssssss", $param_clientName, $param_numberOfPeople, $param_checkInDate, $param_checkOutDate, $param_roomType, $param_totalCost);

            $param_clientName = $client;
            $param_numberOfPeople = $number;
            $param_checkInDate = $dateIn;
            $param_checkOutDate = $dateOut;
            $param_roomType = $room;
            $param_totalCost = $cost;

            if ($stmt->execute()) {
               $mensaggeConfirmation = "Reservación realizada con éxito. ".generarDocumento($client, $number, $dateIn, $dateOut, $room, $cost);
           } else {
               echo "Algo salió mal, por favor inténtelo de nuevo.";
           }
        }
        $stmt->close();
    }
}
function generarDocumento($client, $number, $dateIn, $dateOut, $room, $cost) {
   $pdf = new FPDF();
   $pdf->AddPage();
   $pdf->SetFont('Arial', 'B', 16);
   $pdf->SetTextColor(0, 0, 0);
   $pdf->Cell(0, 10, "Estimado/a $client.", 0, 1);
   $pdf->Cell(0, 10, "Muchas gracias por reservar con nosotros.", 0, 1);
   $pdf->Cell(0, 10, "Aqui estan los detalles de tu reserva el ", 0, 1);
   $pdf->Cell(0, 10, "cual deberas presentar en el loby del hotel.", 0, 1);
   $pdf->Ln();
   $pdf->Cell(0, 10, "Nombre de quien reserva: $client.", 0, 1);
   $pdf->Cell(0, 10, "Numero de personas: $number", 0, 1);
   $pdf->Cell(0, 10, "Fecha de entrada: $dateIn", 0, 1);
   $pdf->Cell(0, 10, "Fecha de salida: $dateOut", 0, 1);
   $pdf->Cell(0, 10, "Tipo de habitacion: $room", 0, 1);
   $pdf->Cell(0, 10, "Costo total: $$cost", 0, 1);
   $pdf->Cell(0, 10, "Esperamos que disfrutes de tu estancia.", 0, 1);
   $filename = "reservacion_$client.pdf";
   $pdf->Output($filename, 'F');
   return "<a href='$filename' style='color: red;'>Descargar tu comprobante de reservación aquí</a>";
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <title>keto</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/responsive.css">
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <script src="js/comprobante.js"></script>
      <style>
         .error {
             color: red;
         }
         .mensaggeConf {
             color: green;
             background-color: #d4edda;
             font-size: 20px;
         }
      </style>

   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif"/></div>
      </div>
      <!-- end loader -->
       <!-- header -->
      <header>
         <!-- header inner -->
         <div class="header">
            <div class="container">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="index.html"><img src="images/logo.png" alt="#" /></a>
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
                                 <a class="nav-link" href="index.html">Inicio</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="restaurante.html">Restaurante</a>
                              </li>
                              <li class="nav-item active">
                                 <a class="nav-link" href="reservacion.php">Reservaciones</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="php/login.php">¿Eres empleado?</a>
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
      <!-- end header -->
     <div class="back_re">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                      <h2>Date el gusto</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php if(!empty($mensaggeConfirmation)): ?>
         <div class="mensaggeConf">
          <?php echo $mensaggeConfirmation; ?>
         </div>
      <?php endif; ?>
      <!--  contact -->
      <div class="contact">
         <div class="container">
            <div class="row">
               <div class="col-md-6">
                <form id="request" class="main_form" method="post">
                    <span class="error"><?php echo $client_errors; ?></span>
                    <input class="contactus <?php echo (!empty($client_errors)) ? 'is-invalid' : ''; ?>" value="<?php echo $client; ?>" placeholder="Nombre del cliente" type="text" name="clientName">

                    <span class="error"><?php echo $number_errors; ?></span>
                    <input class="contactus <?php echo (!empty($number_errors)) ? 'is-invalid' : ''; ?>" value="<?php echo $number; ?>" placeholder="Número de personas" type="number" name="numberOfPeople">

                    <span class="error"><?php echo $dateIn_errors; ?></span>
                    <input class="contactus <?php echo (!empty($dateIn_errors)) ? 'is-invalid' : ''; ?>" value="<?php echo $dateIn; ?>" placeholder="Fecha de entrada" type="text" id="checkInDate" onfocus="(this.type='date')" onblur="(this.type='text')" name="checkInDate">

                    <span class="error"><?php echo $dateOut_errors; ?></span>
                    <input class="contactus <?php echo (!empty($dateOut_errors)) ? 'is-invalid' : ''; ?>" value="<?php echo $dateOut; ?>" placeholder="Fecha de salida" type="text" id="checkOutDate" onfocus="(this.type='date')" onblur="(this.type='text')" name="checkOutDate">

                    <span class="error"><?php echo $room_errors; ?></span>
                    <select class="contactus <?php echo (!empty($room_errors)) ? 'is-invalid' : ''; ?>" value="<?php echo $room; ?>" name="roomType">
                        <option value="">Seleccione el tipo de habitación</option>
                        <option value="tipo2">Suite Deluxe</option>
                        <option value="tipo1">Executive</option>
                    </select>

                    <span class="error"><?php echo $cost_errors; ?></span>
                    <input class="contactus <?php echo (!empty($cost_errors)) ? 'is-invalid' : ''; ?>" value="<?php echo $cost; ?>" placeholder="Costo total de la reservación" type="number" name="totalCost" readonly>

                    <button class="send_btn">Reservar</button>
                    <?php if(empty($mensaggeConfirmation)): ?>
                      <button type="reset" class="send_btn">Limpiar</button>
                    <?php endif; ?>
                    <?php if(!empty($mensaggeConfirmation)): ?>
                     <?php echo '<a href="reservacion.php" class="send_btn" style="text-align: center;">Limpiar</a>'; ?>                    <?php endif; ?>
                </form>
               </div>
               <div class="col-md-6">
                  <img src="images/reserv.jpg" alt="">
               </div>
            </div>
         </div>
      </div>
      <!-- end contact -->
<!--  footer -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class=" col-md-4">
                     <h3>Contacto</h3>
                     <ul class="conta">
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i> Torre Eiffel #2022</li>
                        <li><i class="fa fa-mobile" aria-hidden="true"></i> +52 614-253-5963</li>
                        <li> <i class="fa fa-envelope" aria-hidden="true"></i><a href="#"> dancam00223@gmail.com</a></li>
                     </ul>
                  </div>
                  <div class="col-md-4">
                     <h3>Menú </h3>
                     <ul class="link_menu">
                        <li><a href="index.html">Inicio</a></li>
                        <li><a href="restaurante.html">Restaurante</a></li>
                        <li><a href="reservacion.php">Reservación</a></li>
                        <li><a href="php/login.php">¿Eres empleado?</a></li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="copyright">
               <div class="container">
                  <div class="row">
                     <div class="col-md-10 offset-md-1">
                        
                        <p>
                        © 2023 Brandon Chacón
                        </p>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/date.js"></script>
      <script src="js/costo.js"></script>
   </body>
</html>