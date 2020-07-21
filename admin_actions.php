<?php 
require_once "con.php";

function all_workers_today(){
	global $conn;
	$smtm = $conn->prepare("select count(*), events.worker from events  ".
	"left join workers on workers.id = events.worker where DATE(`start_at`) = CURDATE() group by events.worker");
	$smtm->execute();
	$res = $smtm->fetchAll(); 
	return $res;
}

function get_worker($id){
	global $conn;
	$stmt = $conn->prepare("select * from workers where id = :id ");
	$stmt->bindParam(":id", $id);
	$stmt->execute();
	return $stmt->fetchObject();
}

function get_jornada($id){
	global $conn;
	$stmt = $conn->prepare("select  id, time( start_at) as start_at, end_at, type,  time_to_sec(TIMEDIFF(time(start_at),time('8:00:00')))   as d_jornada, TIMEDIFF(time(start_at),time('8:00:00')) as t_jornada ,   if(end_at is null,time_to_sec(TIMEDIFF(time(current_timestamp()),time(start_at))),time_to_sec(TIMEDIFF(time(end_at),time(start_at))) ) as duration from events where DATE(`start_at`) = CURDATE() and worker = :id and type = '0'");
	$stmt->bindParam(":id",$id);
	$stmt->execute();
	return $stmt->fetchObject();
}

function get_horas_pausa($id){
	global $conn;
	$stmt = $conn->prepare("
	select sum( if(end_at is null,time_to_sec(TIMEDIFF( time(current_timestamp()), time(start_at))),time_to_sec(TIMEDIFF( time(end_at), time(start_at))))) as horas_pausa  from events where worker = :id and DATE(`start_at`) = CURDATE() and type <> '0'");
	$stmt->bindParam(":id",$id);
	$stmt->execute();
	return $stmt->fetchObject()->horas_pausa;
}


function get_event_diff(){
  global $conn;
  $stt= $conn->query("SELECT id, time_to_sec(TIMEDIFF(time(start_at),time('8:00:00')))   as diff from events");
  $stt->execute();
  return $stt->fetchAll();
}

function acotar_jornada($j){
  return ($j >= 8 *  3600)?8*3600:$j;
}
