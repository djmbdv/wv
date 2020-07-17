<?php
include "con.php";
require_once  "auth.php";
  if(!is_login()){
    header('location: login.php');
    die();
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Work Counter</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="css/custom.css?43">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <h5 class="my-0 mr-md-auto font-weight-normal">WC</h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="nav-link" href="">Workers</a>
      </nav>
      <a class="btn btn-outline-primary" href="logout.php">Logout</a>
</div>

<?php

if(!ami_admin()):
  include_once "view_worker.php";
else:
 ?>
<div class="container py-5">
  <div class="row">

    <!-- For demo purpose -->
    <div class="col-lg-12 mx-auto mb-5  text-center">
      <h1 class="display-4">Work Counter</h1>
      </p>
    </div>
    <!-- END -->

    <div class="col-xl-3 col-lg-6 mb-4">
      <div class="bg-white  p-5 shadow">
        <h2 class="h6 font-weight-bold text-center mb-4">Fabian Espejo</h2>

        <!-- Progress bar 1 -->
        <div class="text-center">
       <img class="img img-responsive " src="img/logo.png">
       </div>
        <!-- END -->

        <!-- Demo info -->
        <div class="row text-center mt-4">
          <div class="col-6 border-right">
            <div class="h4 font-weight-bold mb-0">28%</div><span class="small text-gray">Last week</span>
          </div>
          <div class="col-6">
            <div class="h4 font-weight-bold mb-0">60%</div><span class="small text-gray">Last month</span>
          </div>

          <hr>

          <div class="col-md-6 col-xs-12  p-3">
          <button class="btn btn-block btn-success" id="btn-jornada-start">Iniciar</button>
      		</div>
      		 <div class="col-md-6 col-xs-12  p-3">
          <button class="btn btn-block btn-danger">Finalizar</button>
          </div>
        </div>
        <!-- END -->
      </div>
    </div>
    <div class="col-xl-9 col-md-12">
      <div class="row">


    <div class="col-xl-3 col-lg-6 mb-4">
      <div class="bg-white p-3 ">
        <h2 class="h6 font-weight-bold text-center mb-4">Jornada</h2>

        <!-- Progress bar 3 -->
        <div class="progress mx-auto" data-value='25' id ="counter1">
          <span class="progress-left">
                        <span class="progress-bar border-success"></span>
          </span>
          <span class="progress-right">
                        <span class="progress-bar border-success"></span>
          </span>
          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
            <div class="h2 font-weight-bold" > <spam id = "counter1-label"> </spam><small>S</small></div>
          </div>
        </div>
        <!-- END -->

        <!-- Demo info -->
        <div class="row text-center mt-4">
          <div class="col-6 border-right">
            <div class="h4 font-weight-bold mb-0">07:11</div><span class="small text-gray">Inicio de Jornada</span>
          </div>
          <div class="col-6">
            <div class="h4 font-weight-bold mb-0">60%</div><span class="small text-gray">Last month</span>
          </div>
        </div>
        <!-- END -->
      </div>
    </div>

    <div class="col-xl-3 col-lg-6 mb-4">
      <div class="bg-white rounded-lg p-3 ">
        <h2 class="h6 font-weight-bold text-center mb-4">Horas Trabajadas</h2>

        <!-- Progress bar 4 -->
        <div class="progress mx-auto" data-value='12'>
          <span class="progress-left">
                        <span class="progress-bar border-warning"></span>
          </span>
          <span class="progress-right">
                        <span class="progress-bar border-warning"></span>
          </span>
          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
            <div class="h2 font-weight-bold">12<sup class="small">%</sup></div>
          </div>
        </div>
        <!-- END -->

        <!-- Demo info -->
        <div class="row text-center mt-4">
          <div class="col-6 border-right">
            <div class="h4 font-weight-bold mb-0">28%</div><span class="small text-gray">Last week</span>
          </div>
          <div class="col-6">
            <div class="h4 font-weight-bold mb-0">60%</div><span class="small text-gray">Last month</span>
          </div>
        </div>
        <!-- END -->
      </div>
    </div>
        <div class="col-xl-3 col-lg-6 mb-4">
      <div class="bg-white  p-3 ">

        <h2 class="h6 font-weight-bold text-center mb-4">Hora en Pausa</h2>

        <!-- Progress bar 2 -->
        <div class="progress mx-auto" data-value='25'>
          <span class="progress-left">
                        <span class="progress-bar border-danger"></span>
          </span>
          <span class="progress-right">
                        <span class="progress-bar border-danger"></span>
          </span>
          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
            <div class="h2 font-weight-bold">25<sup class="small">%</sup></div>
          </div>
        </div>
        <!-- END -->

        <!-- Demo info-->
        <div class="row text-center mt-4">
          <div class="col-6 border-right">
            <div class="h4 font-weight-bold mb-0">33</div><span class="small text-gray">Pausas Hoy</span>
          </div>
          <div class="col-6">
            <div class="h4 font-weight-bold mb-0">60%</div><span class="small text-gray">Mayor Pausa</span>
          </div>
        </div>
        <!-- END -->
      </div>
    </div>
  </div>
  <div class="row">
     <div class="col-xs-12 col-md-12">
    <h3>Pausas </h3>
  </div>
    <div class="col-md-12">
<?php
  $stmt = $conn->prepare("select * from event_types");
  $stmt->execute();
  foreach ($stmt->fetchAll() as $key => $value):
?>
  <button class="btn btn-warning btn-pausa <?= $value['class']?>" ><?=  $value['description'] ?> </button>
<?php
  endforeach;
?>
</div>
  </div>
</div>
</div>
</div>
<?php 
endif;
?>
<script type="text/javascript" src="js/custom.js?8"></script>
</body>
</html>