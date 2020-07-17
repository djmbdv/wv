<?php
  require_once 'worker_actions.php';
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
        <h2 class="h6 font-weight-bold text-center mb-4"><?= $_SESSION['name'] ?></h2>

        <!-- Progress bar 1 -->
        <div class="text-center">
       <img class="img img-responsive " src="img/logo.png">
       </div>
        <!-- END -->

        <!-- Demo info -->
        <div class="row text-center mt-4">
          <div class="col-12">
            <div class="h4 font-weight-bold mb-0"><?= my_project()->name ?></div>
            <p>
              <?= my_project()->description ?>
            </p>
          </div>
         

          <hr>

          <div class="col-md-6 col-xs-12  p-3">
          <button class="btn btn-block btn-success">Iniciar Jornada</button>
      		</div>
      		 <div class="col-md-6 col-xs-12  p-3">
          <button class="btn btn-block btn-danger btn-action">Finalizar Jornada</button>
          </div>
        </div>
        <!-- END -->
      </div>
    </div>
    <div class="col-xl-9 col-md-12">
      <div class="row">



    <div class="col-xl-3 col-lg-6 mb-4">
      <div class="bg-white rounded-lg p-3 ">
        <h2 class="h6 font-weight-bold text-center mb-4">Jornada</h2>

        <!-- Progress bar 4 -->
        <div class="progress mx-auto" data-value='12'>
          <span class="progress-left">
                        <span class="progress-bar border-warning"></span>
          </span>
          <span class="progress-right">
                        <span class="progress-bar border-warning"></span>
          </span>
          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
            <div class="h2 font-weight-bold">12:20am</div>
          </div>
        </div>
        <!-- END -->

        <!-- Demo info -->
        <div class="row text-center mt-4">
          <div class="col-12 border-right">
            <div class="h4 font-weight-bold mb-0 text-center"><?= date("d/m/y") ?></div>
          </div>
        </div>
        <!-- END -->
      </div>
    </div>
    <div class="col-xl-6 col-lg-6 mb-4">
      <ul class="list-group" style="overflow-y: scroll; height: 300px;">
        <?php list_actions_today(); ?>
      </ul>

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
  <button class="btn btn-warning btn-action <?= $value['class']?>" ><?=  $value['description'] ?> <span class="badge">34</span></button>
<?php
  endforeach;
?>
</div>
  </div>
</div>
</div>
</div>