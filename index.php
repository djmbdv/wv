<?php
include "con.php";
require_once  "auth.php";
require_once "admin_actions.php";
cron();

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
	<link rel="stylesheet" href="css/custom.css?45">
  <script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
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
  $start = isset($_POST['start_date'])?  $_POST['start_date']: date("Y-m-d");
  $end =   isset($_POST['end_date'])?  $_POST['end_date']: date("Y-m-d");
 ?>
<div class="container py-5">
  <div class="col-lg-12 mx-auto mb-5  text-center">
      <h1 class="display-4">Work Counter</h1>
      </p>
  </div>
  <div class="row container">
    <div class="col-md-6">
      <h6>Add Project</h6>
      <form method="post" action="end.php">
        <input type="hidden" name="action" value="add_project">
        <div class="form-group">
          <input type="text" class="form-control" name="name" placeholder="Title" required="">
        </div>
        <div class="form-group">
          <textarea class="form-control" name="description" placeholder="Description" required=""></textarea>
        </div>
        <button type="submit" class="btn-primary btn">Add Project</button>
      </form>
    </div>
    <div class="col-md-6">
    <form method="post" action="end.php">
      <input type="hidden" name="action" value="add_worker">
      <h6 class="">Add Worker</h6>
      <div class="form-group">
        <input class="form-control" type="text" name="name" placeholder="Name" required="">
      </div>
      <div class="form-group">
        <input class="form-control" type="email" name="email" placeholder="email" required="">
      </div>
      <div class="form-group">
        <input class="form-control" type="text" name="username" placeholder="username" required="">
      </div>
      <div class="form-group">
        <input class="form-control" type="password" name="password" placeholder="Password" required="">
      </div>
      <div class="form-group">
        <input class="form-control" type="password" name="repassword" placeholder="Retype Password" required="">
      </div>
      <div class="form-group">
        <select class="custom-select" name="project" placeholder="select" required="">
          <option>Seleccione Proyecto</option>
<?php
  foreach (projects() as $p):?>
  <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
<?php endforeach; ?>
        </select>
      </div>
      <button class="btn btn-primary" type="submit">Add Worker</button>
    </form>
  </div>
  </div>
  <hr>
<?php 
$pp =  isset($_POST["project"])?intval($_POST["project"]):0;
?>

  <form method="post">
  <div  class="row">
    
    <div class="col-md-3">
      <select class="custom-select" name="project" placeholder="select">
          <option value="0">All</option>
<?php

  foreach (projects() as $p):?>
  <option value="<?= $p['id'] ?>" <?= ($pp == $p['id'])?'selected':'' ?>><?= $p['name'] ?></option>
<?php endforeach; ?>
        </select></div>
    <div class="col-md-3"> <input class="form-control" type="date" name="start_date" placeholder="Fecha Inicio" value="<?= $start ?>"></div>
    <div class="col-md-3"><input class="form-control" type="date" name="end_date" placeholder="Fecha Fin" value="<?= $end ?>"></div>
    <div class="col-md-2"><button class="btn btn-block btn-primary">Search</button></div>
  
  </div>
  </form>
<hr/>
  <div class="row">
<?php
$t = get_horas_pause_range("2020-07-01","2020-07-30",1);
if(isset($_POST["project"]) &&  $_POST["project"] != '0'){
  $workers =  all_workers_by_project($_POST["project"]);
}else{
  $workers = all_workers();
}

foreach($workers as $worker):
  $w = get_worker($worker['id']);
  $w->jornada = get_jornada_range($start,$end,$w->id);
?>
    <div class="col-xl-2 col-lg-4 mb-4">
      <div class="bg-white  p-5 shadow">
        <h2 class="h6 font-weight-bold text-center mb-4"><?= $w->name ?></h2>
        <!-- Progress bar 1 -->
        <div class="text-center">
       <img class="img img-responsive " src="img/logo.png">
       </div>
        <div class="row text-center mt-4">
          <div class="col-6 border-right">
            <div class="h4 font-weight-bold mb-0">28%</div><span class="small text-gray">Last week</span>
          </div>
          <div class="col-6">
            <div class="h4 font-weight-bold mb-0">60%</div><span class="small text-gray">Last month</span>
          </div>
          <hr>
        </div>
      </div>
    </div>
    <div class="col-xl-9 col-md-10">
      <div class="row">
        <div class="col-xl-3 col-lg-6 mb-4">
        <div class="bg-white p-3 ">
          <h2 class="h6 font-weight-bold text-center mb-4">Jornada</h2>
        <!-- Progress bar 3 -->
<?php
  $duracion = 0.0;
  foreach ($w->jornada as $j) {
    $duracion += intval($j['duration']);
  }
  $porcentaje_duracion =count($w->jornada) > 0 ? $duracion / (count($w->jornada) * 8 * 36) : 0;
?>
        <div class="progress2 mx-auto" data-value='<?= $porcentaje_duracion ?>' >
          <span class="progress-left">
                        <span class="progress-bar border-success"></span>
          </span>
          <span class="progress-right">
                        <span class="progress-bar border-success"></span>
          </span>
          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
            <div class="h2 font-weight-bold" >
              <?php if(count($w->jornada ) < 1): ?>
              <small>Sin Jornada</small> 
              <?php else: ?> 
                   <?= ($duracion > 3600)?number_format($duracion / 3600.0, 1): number_format($duracion / 60.0, 0)?><small><?=($duracion > 3600)?'H': 'm'?></small>
            <?php endif ?>
              </div>
            </div>
          </div>
        <!-- END -->

        <!-- Demo info -->
        <div class="row text-center mt-4">
          <div class="col-6 border-right">
            <div class="font-weight-bold mb-0" style="font-size: 1rem;" ><?= count($w->jornada) ?></div><span class="small text-gray"># Jornadas</span>
          </div>
          <div class="col-6">

            <div class="font-weight-bold mb-0"><?= number_format($porcentaje_duracion,2) ?></div><span class="small text-gray">% de tiempo</span>
          </div>
        </div>
        <!-- END -->
      </div>
      </div>
    <div class="col-xl-3 col-lg-6 mb-4">
<?php 
  $pausas = get_horas_pause_range($start,$end, $w->id);
  $tiempo_pausa = 0.0;
  $num_pausas = 0;
  foreach ($pausas as $pausas) {
    $tiempo_pausa += intval($pausas["pausa"]);
    $num_pausas++;
  }
  $porcentaje_pausa = ($duracion > 0)? $tiempo_pausa * 100 / $duracion: 0;
  $porcentaje_trabajo =count($w->jornada) > 0? ($duracion - $tiempo_pausa) / ((8*36)*count($w->jornada)):0;

?>
      <div class="bg-white rounded-lg p-3 ">
        <h2 class="h6 font-weight-bold text-center mb-4">Horas Trabajadas</h2>

        <!-- Progress bar 4 -->
        <div class="progress2 mx-auto" end="" data-value='<?= number_format($porcentaje_trabajo,2) ?>'>
          <span class="progress-left">
                        <span class="progress-bar border-warning"></span>
          </span>
          <span class="progress-right">
                        <span class="progress-bar border-warning"></span>
          </span>
          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
            <div class="h2 font-weight-bold"><?= number_format($porcentaje_trabajo,2) ?><sup class="small">%</sup></div>
          </div>
        </div>
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
        <div class="col-xl-3  mb-4">


      <div class="bg-white  p-3 ">

        <h2 class="h6 font-weight-bold text-center mb-4">Hora en Pausa</h2>

        <!-- Progress bar 2 -->
        <div class="progress2 mx-auto" data-value='<?=  number_format($porcentaje_pausa,2)  ?>'>
          <span class="progress-left">
                        <span class="progress-bar border-danger"></span>
          </span>
          <span class="progress-right">
                        <span class="progress-bar border-danger"></span>
          </span>
          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
            <div class="h2 font-weight-bold"><?=  number_format($porcentaje_pausa,2)  ?><sup class="small">%</sup></div>
          </div>
        </div>
        <!-- END -->

        <!-- Demo info-->
        <div class="row text-center mt-4">
          <div class="col-6 border-right">
            <div class="h4 font-weight-bold mb-0"><?= $num_pausas ?></div><span class="small text-gray">Pausas</span>
          </div>
          <div class="col-6">
            <div class="h4 font-weight-bold mb-0">60%</div><span class="small text-gray">Mayor Pausa</span>
          </div>
        </div>
        <!-- END -->
      </div>
    </div>
    <div class="col-xl-3  mb-4">
       <div class="bg-white  p-3 ">
        <p>
          Nota: La Jornada es de 8 horas.
        </p>
       </div>
    </div>
  </div>
</div>
  <?php endforeach; 
  ?>
  </div>
</div>
</div>
</div>
<?php 
endif;
?>
<script type="text/javascript" src="js/custom.js?16"></script>
</body>
</html>