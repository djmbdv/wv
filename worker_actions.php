<?php 
require_once "con.php";

function start_event($type){
	session_start();
	if(!isset($_SESSION['id']))return;
	$id = $_SESSION['id'];
	session_commit();
	global $conn;
	$stmt= $conn->prepare("INSERT INTO `events` (  `type`, `worker`) VALUES (:type, :id);");
	$stmt->bindParam(":type",$type);
	$stmt->bindParam(":id", $id);
	$stmt->execute();
	$id = $conn->lastInsertId();
	return $id;
}

function stop_event($event){
	global $conn;
	$stmt= $conn->prepare("UPDATE events set end_at = current_timestamp() where id = :id;");
	$stmt->bindParam(":id", $event);
	$stmt->execute();
	return $stmt->rowCount();
}

function is_jornada_started(){
	session_start();
	if(!isset($_SESSION['id']))return;
	$id = $_SESSION['id'];
	session_commit();
	global $conn;
	$stmt=$conn->prepare("SELECT * FROM `events` WHERE DATE(`start_at`) = CURDATE() and type='0' and worker = :id");
	$stmt->bindParam(":id",$id);
	$stmt->execute();
	return $stmt->rowCount() == 1;
}

function get_current_jornada(){
	session_start();
	if(!isset($_SESSION['id']))return;
	$id = $_SESSION['id'];
	session_commit();
	global $conn;
	$stmt=$conn->prepare("SELECT * FROM `events` WHERE DATE(`start_at`) = CURDATE() and type='0' and worker = :id");
	$stmt->bindParam(":id",$id);
	$stmt->execute();
	return ($stmt->rowCount() == 1)?$stmt->fetchObject()->id:0;
}


function is_in_pausa(){
	session_start();
	if(!isset($_SESSION['id']))return;
	$id = $_SESSION['id'];
	session_commit();
	global $conn;
	$stmt=$conn->prepare("SELECT * FROM `events` WHERE DATE(`start_at`) = CURDATE() and type <> '0' and worker = :id and end_at is null");
	$stmt->bindParam(":id",$id);
	$stmt->execute();
	return $stmt->rowCount() > 0;
}

function get_latest_pausa(){
	session_start();
	if(!isset($_SESSION['id']))return;
	$id = $_SESSION['id'];
	session_commit();
	global $conn;
	$stmt=$conn->prepare("SELECT * FROM `events` WHERE DATE(`start_at`) = CURDATE() and type <> '0' and worker = :id and end_at is null");
	$stmt->bindParam(":id",$id);
	$stmt->execute();
	return ($stmt->rowCount() > 0)?$stmt->fetchObject():0;
}

function jornada_has_finnished(){
	session_start();
	if(!isset($_SESSION['id']))return;
	$id = $_SESSION['id'];
	session_commit();
	global $conn;
	$stmt=$conn->prepare("SELECT * FROM `events` WHERE DATE(`start_at`) = CURDATE() and type='0' and worker = :id ");
	$stmt->bindParam(":id",$id);
	$stmt->execute();

	if( $stmt->rowCount() != 1)return false;
	$o = $stmt->fetchObject();
	return $o->end_at != null;
}


function my_project(){
	session_start();
	if(!isset($_SESSION['project']))return;
	$id = $_SESSION['project'];
	session_commit();
	global $conn;
	$stmt = $conn->prepare("SELECT * from projects where id = :id");
	$stmt->bindParam(":id", $id);
	$stmt->execute();
	return $stmt->fetchObject();
}

function compare_interval($a, $b){
    $t1 = strtotime($a[0]);
    $t2 = strtotime($b[0]);
    return $t1 - $t2;
}    




function list_actions_today(){
	session_start();
	if(!isset($_SESSION['id']))return;
	$id = $_SESSION['id'];
	session_commit();
	global $conn;
	$stmt=$conn->prepare("SELECT * FROM `events` left join event_types on event_types.id = events.type WHERE DATE(`start_at`) = CURDATE()  and worker = :id");
	$stmt->bindParam(":id",$id);
	$stmt->execute();
	$res = $stmt->fetchAll();
	$list = [];
	foreach ($res as $row) {
		array_push($list, array($row['start_at'],$row['type'],$row['description'],$row['id'],false));
		if(isset($row['end_at']) &&  $row['end_at'] != null){
			array_push($list, array($row['end_at'],$row['type'],$row['description'],$row['id'], true));
		}
	}
	usort($list, 'compare_interval');
	foreach ($list as $event): ?>
<li> <a href="#" class="list-group-item list-group-item-action <?= ($event[1])?"":"active" ?>"><?= $event[0] ?> - <?= ($event[4])?"Fin":"Inicio" ?> <?= ($event[1] == 0)?"Jornada" :$event[2] ?></a></li>
<?php
	endforeach;
}