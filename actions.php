<?php 
require_once "con.php";
require_once "worker_actions.php";


if(isset($_POST["event_type"])){
	$type = $_POST["event_type"];
	if($type == 0 && is_jornada_started()){
		echo 0;
		die();
	}else{
		$event = start_event($_POST["event_type"]);
		$o = new stdClass();
		$o->ok = 1;
		$o->data = $event;
		header("Content-type:application/json");
		echo json_encode($o);
	}
	die();
}
if(isset($_POST["event"])){
	stop_event($_POST["event"]);
	echo 1;
}

if(isset($_POST["list_events"])){
	list_actions_today();
}