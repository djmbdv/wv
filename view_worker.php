<?php
  require_once 'worker_actions.php';
?>
<div class="modal fade" id="modal-finish" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Finalizar Jornada</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Est&aacute; seguro de finalizar su jornada laboral?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btn-end" jornada="<?= get_current_jornada() ?>">Confirmar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-msg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title">PAUSA</div>
      </div>
      <div class="modal-body">
        <button class="btn btn-primary btn-block" pausa="<?= get_latest_pausa()->id ?>" id="btn-reanudar">Reanudar</button>
      </div>
    </div>
  </div>
</div>
<div class="container py-5">
  <div class="row">
    <div class="col-lg-12 mx-auto mb-5  text-center">
      <h1 class="display-4">Work Counter</h1>
      </p>
    </div>
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
          <button id="start-jornada" class="btn btn-block btn-success" <?= is_jornada_started()?"disabled":"" ?>>Iniciar Jornada</button>
      		</div>
      		 <div class="col-md-6 col-xs-12  p-3">
          <button class="btn btn-block btn-danger  btn-action" id="btn-finish">Finalizar Jornada</button>
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
            <div class="h2 font-weight-bold"><?= date("h:i:sa") ?></div>
          </div>
        </div>
        <!-- END -->

        <!-- Demo info -->
        <div class="row text-center mt-4">
          <div class="col-12 border-right">
            <div class="h6 font-weight-bold mb-0 text-center"><?= date("d/m/y") ?></div>
          </div>
        </div>
        <!-- END -->
      </div>
    </div>
    <div class="col-xl-6 col-lg-6 mb-4">
      <ul class="list-group" id="list-events" style="overflow-y: scroll; height: 300px;">
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
  <button class="btn btn-warning btn-action btn-pausa <?= $value['class']?>"  type_event="<?=  $value['id'] ?>"><?=  $value['description'] ?></button>
<?php
  endforeach;
?>
</div>
  </div>
</div>
</div>
</div>
<script type="text/javascript">
function updateScroll(){
    var element = document.getElementById("list-events");
    element.scrollTop = element.scrollHeight;
}
function refreshEventList(){
  $.post("actions.php",{
    list_events: true
  }, data=>{
    $("#list-events").html(data);
    updateScroll();
  });
}
$(document).ready(function(){
<?php if(!is_jornada_started()): ?>
  $(".btn-action").attr("disabled",true);
<?php endif; ?>
<?php if(is_in_pausa()): ?>
  $(".btn-action").attr("disabled",true);
  $("#modal-msg").modal("show");
<?php endif; 
  if(jornada_has_finnished()):?>
    $("button").attr("disabled", true);
 <?php 
endif;
?>
  $("#start-jornada").click(e=>{
    $.post("actions.php",{
      event_type: 0
    },
    data =>{
      if(data.ok){
        $(".btn-action").attr("disabled",false);
        $("#btn-end").attr("jornada", data.data);
        $("#start-jornada").attr("disabled",true);
        refreshEventList();
      }
    }
    )
  });

  $("#btn-finish").click(e=>{
    $("#modal-finish").modal("show");
  });

  $("#btn-end").click(e=>{
    var jornada = $(e.currentTarget).attr("jornada");
    $.post("actions.php",{
      event: jornada
    },data=>{
      if(data){
        $("button").attr("disabled",true);
        $("#modal-finish").modal("hide");
        refreshEventList();
      }
    });
  })

  $(".btn-pausa").click(e=>{
    var type = $(e.currentTarget).attr("type_event");
    $.post("actions.php",{
      event_type: type
    },data=>{
      if(data.ok){
        $("#btn-reanudar").attr("pausa",data.data)
        $(".btn-action").attr("disabled",true);
        $("#modal-msg").modal("show");
        refreshEventList();
      }
    });
  });

  $("#btn-reanudar").click(e=>{
    var s =  $("#btn-reanudar").attr("pausa");
    $.post("actions.php",{
      event: s
    },data=>{
      if(data)$("#modal-msg").modal("hide");
      $(".btn-action").attr("disabled",false);
      refreshEventList();
    });
  });
});
updateScroll();
</script>