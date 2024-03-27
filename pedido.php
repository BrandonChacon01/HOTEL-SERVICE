<?php
require_once "php/config.php";
require_once "php/fpdf183/fpdf.php";

$client = $numberId = $date = $platillo = $cost = $mensaggeConfirmation = "";
$client_err = $numberId_err = $date_err = $platillo_err = $cost_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientName = $_POST["clientName"];
    $numberId = $_POST["numberId"];
    $date = $_POST["date"];
    $totalCost = $_POST["totalCost"];

    if (empty($_POST["platilloType"])) {
      $platillo_err = "Es necesario seleccionar un platillo";
    } else {
       $platilloType = $_POST["platilloType"];
       $platillo = implode(", ", $_POST["platilloType"]);
    }

    if (empty($clientName)) {
        $client_err = "El nombre del cliente es requerido";
    } else {
        $client = $clientName;
    }

    if (empty($numberId)) {
        $numberId_err = "El número de identificacion es requerido";
    }else {
        $numberId = $numberId;
    }

    if (empty($date)) {
        $date_err = "La fecha es requerida";
    } else {
        $date = $date;
    }

    if (empty($totalCost)) {
        $cost_err = "El costo total es requerido";
    } else {
        $cost = $totalCost;
    }

   if (empty($client_err) && empty($numberId_err) && empty($date_err) && empty($platillo_err) && empty($cost_err)) {
        $sql = "INSERT INTO restaurante (nombre_cliente, numeroId, fecha, platillos, costo_total) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sssss", $param_clientName, $param_numberId, $param_date, $param_platilloType, $param_totalCost);

            $param_clientName = $client;
            $param_numberId = $numberId;
            $param_date = $date;
            $param_platilloType = $platillo;
            $param_totalCost = $cost;

            if ($stmt->execute()) {
               $mensaggeConfirmation = "Pedido realizado con éxito. ".generarDocumento($client, $numberId, $date, $platillo, $cost);
           } else {
               echo "Algo salió mal, por favor inténtelo de nuevo.";
           }
        }
        $stmt->close();
    }
}
function generarDocumento($client, $numberId, $date, $platillo, $cost) {
   $pdf = new FPDF();
   $pdf->AddPage();
   $pdf->SetFont('Arial', 'B', 16);
   $pdf->SetTextColor(0, 0, 0);
   $pdf->Cell(0, 10, "Estimado/a $client.", 0, 1);
   $pdf->Cell(0, 10, "Muchas gracias por realizar el pedido.", 0, 1);
   $pdf->Cell(0, 10, "Aqui estan los detalles de tu pedido el ", 0, 1);
   $pdf->Cell(0, 10, "cual deberas presentar al camarero.", 0, 1);
   $pdf->Ln();
   $pdf->Cell(0, 10, "Nombre de quien reserva: $client.", 0, 1);
   $pdf->Cell(0, 10, "Numero de identificacion: $numberId", 0, 1);
   $pdf->Cell(0, 10, "Fecha de pedido: $date", 0, 1);
   $pdf->MultiCell(0, 10, "Platillos: $platillo", 0);
   $pdf->Cell(0, 10, "Costo total: $$cost", 0, 1);
   $pdf->Cell(0, 10, "Esperamos que disfrutes de tu comida.", 0, 1);
   $filename = "pedido_$client.pdf";
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
      <style>
         .error {
             color: red;
         }
         .mensaggeConf {
             color: green;
             background-color: #d4edda;
             font-size: 20px;
         }
         .select-pedidos {
             color: black;
             font-size: 18px;
             font-weight: bold;
             margin-top: 6px;
             margin-left: 16px;
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
                                 <a class="nav-link" href="pedido.php">Pedido</a>
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
                      <h2>No le temas a engordar y pide ahora</h2>
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
                    <span class="error"><?php echo $client_err; ?></span>
                    <input class="contactus <?php echo (!empty($client_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $client; ?>" placeholder="Nombre del cliente" type="text" name="clientName">

                    <span class="error"><?php echo $numberId_err; ?></span>
                    <input class="contactus <?php echo (!empty($numberId_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $numberId; ?>" placeholder="Número de identificación" type="numberId" name="numberId">

                    <span class="error"><?php echo $date_err; ?></span>
                    <input class="contactus <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>" placeholder="Fecha de orden" type="text" id="checkInDate" onfocus="(this.type='date')" onblur="(this.type='text')" name="date">

                    <span class="error"><?php echo $platillo_err; ?></span>
                    <p class="select-pedidos">Seleccione los platillos que desea</p>
                    <div class="form-check">
                        <input class="form-check-input <?php echo (!empty($platillo_err)) ? 'is-invalid' : ''; ?>" type="checkbox" value="Filete de salmon a la parrila con salsa de miel y mostaza" id="tipo1" name="platilloType[]">
                        <label class="form-check-label" for="tipo1">Filete de salmón a la parrila con salsa de miel y mostaza</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input <?php echo (!empty($platillo_err)) ? 'is-invalid' : ''; ?>" type="checkbox" value="Risotto de champinones salvajes y trufa negra" id="tipo2" name="platilloType[]">
                        <label class="form-check-label" for="tipo2">Risotto de champiñones salvajes y trufa negra</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input <?php echo (!empty($platillo_err)) ? 'is-invalid' : ''; ?>" type="checkbox" value="Filete migon con pure de papas trufado" id="tipo3" name="platilloType[]">
                        <label class="form-check-label" for="tipo3">Filete migon con puré de papas trufado</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input <?php echo (!empty($platillo_err)) ? 'is-invalid' : ''; ?>" type="checkbox" value="Ensalada de quinoa con aguacate y aderezo de lima" id="tipo4" name="platilloType[]">
                        <label class="form-check-label" for="tipo4">Ensalada de quinoa con aguacate y aderezo de lima</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input <?php echo (!empty($platillo_err)) ? 'is-invalid' : ''; ?>" type="checkbox" value="Pasta gourmet con salsa de trufa blanca" id="tipo5" name="platilloType[]">
                        <label class="form-check-label" for="tipo5">Pasta gourmet con salsa de trufa blanca</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input <?php echo (!empty($platillo_err)) ? 'is-invalid' : ''; ?>" type="checkbox" value="Tarta de chocolate negro con couils de frutos rojos" id="tipo6" name="platilloType[]">
                        <label class="form-check-label" for="tipo6">Tarta de chocolate negro con couils de frutos rojos</label>
                    </div>

                    <span class="error"><?php echo $cost_err; ?></span>
                    <input class="contactus <?php echo (!empty($cost_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cost; ?>" placeholder="Costo total del pedido" type="numberId" name="totalCost" readonly>

                    <button class="send_btn">Ordenar</button>
                    <?php if(empty($mensaggeConfirmation)): ?>
                      <button type="reset" class="send_btn">Limpiar</button>
                    <?php endif; ?>
                    <?php if(!empty($mensaggeConfirmation)): ?>
                     <?php echo '<a href="pedido.php" class="send_btn" style="text-align: center;">Limpiar</a>'; ?>
                    <?php endif; ?>
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
      <script src="js/orden.js"></script>
   </body>
</html>