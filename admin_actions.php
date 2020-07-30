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


function cron(){
	global $conn;
	$stmt = $conn->prepare("update events set end_at = current_timestamp() where events.end_at is null and time(current_timestamp()) >= time('18:00:00')");
	$stmt->execute();
}



function all_workers_by_project($project){
	global $conn;
	$smtm = $conn->prepare("select * from workers  ".
	"where workers.current_project = :id_project");
	$smtm->bindParam(":id_project",$project);
	$smtm->execute();
	$res = $smtm->fetchAll(); 
	return $res;
}
function all_workers(){
	global $conn;
	$smtm = $conn->prepare("select * from workers");
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
	$stmt = $conn->prepare("select  id, time(start_at) as start_at,time( end_at) as end_at, type,  time_to_sec(TIMEDIFF(time(start_at),time('8:00:00')))   as d_jornada, 
		TIMEDIFF(time(start_at),time('8:00:00')) as t_jornada ,
		if(
			end_at is null,
			time_to_sec(
				TIMEDIFF(
					time(current_timestamp()) ,
					time(start_at)
				)
			),
			time_to_sec(
				TIMEDIFF(
					time(end_at),
					time(start_at)
				)
			)
		) as duration from events where DATE(`start_at`) = CURDATE() and worker = :id and type = '0'");
	$stmt->bindParam(":id",$id);
	$stmt->execute();
	return $stmt->fetchObject();
}
function get_jornada_range($start, $end, $id){
	global $conn;
	$stmt  = $conn->prepare("
		select  
		time(start_at) as start_at,
		time( end_at) as end_at,  
		date(start_at) as fecha,
		time_to_sec(TIMEDIFF(time(start_at),time('8:00:00')))   as d_jornada, 
		TIMEDIFF(time(start_at),time('8:00:00')) as t_jornada ,
		if(
			end_at is null,
			time_to_sec(
				TIMEDIFF(
					time(current_timestamp()) ,
					time(start_at)
				)
			),
			time_to_sec(
				TIMEDIFF(
					time(end_at),
					time(start_at)
				)
			)
		) as duration from events where worker = :id and type = '0' and date(start_at) >= date(:f) and date(start_at) <= date(:fe) group by date(start_at), date(end_at)
			");
	$stmt->bindParam(":id", $id);
	$stmt->bindParam(":f", $start);
	$stmt->bindParam(":fe", $end);
	$stmt->execute();
	return $stmt->fetchAll();

}
function get_horas_pausa($id){
	global $conn;
	$stmt = $conn->prepare("
	select sum( if(end_at is null,time_to_sec(TIMEDIFF( time(current_timestamp()), time(start_at))),time_to_sec(TIMEDIFF( time(end_at), time(start_at))))) as horas_pausa, count(id) as num_pausas  from events where worker = :id and DATE(`start_at`) = CURDATE() and type <> '0'");
	$stmt->bindParam(":id",$id);
	$stmt->execute();
	return $stmt->fetchObject();
}

function get_horas_pause_range($date_start, $date_end, $id){
	global $conn;
	$stmt = $conn->prepare("
	select 
			if(
				end_at is null,
				time_to_sec(
					TIMEDIFF( 
						time(
							current_timestamp()
						),
						time(start_at)
					)
				),    
				time_to_sec(
					TIMEDIFF(
						time(end_at),
						time(start_at)
					)
				)
			)
		 as pausa,
	  date(start_at) as fecha  

	  from events where worker = :id and type <> '0' 
	  and date(start_at) >= date(:f) and date(start_at) <= date(:fe)");


	$stmt->bindParam(":id",$id);
	$stmt->bindParam(":f", $date_start);
	$stmt->bindParam(":fe", $date_end);
	$stmt->execute();
	return $stmt->fetchAll();
}
function big_pause_range($start_at, $end_at, $id){

}
function add_proyect($name, $description){
	global $conn;
	$stmt = $conn->prepare("insert into table projects (name,description) values (:name,:description)");
	$stmt->bindParam(":name",$name);
	$stmt->bindParam(":description",$description);
	return 0;
}


function add_worker($name, $password, $project){
	global $conn;
	$stmt =  $conn->prepare("insert into table workers values (name,password,project) values (:name, :password, :project)");
	$stmt->bindParam(":name",$name);
	$stmt->bindParam(":password", password_hash($password,password_algos()[0]));
	$stmt->bindParam(":project", $project);
	return true;
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
function projects(){
	global $conn;
	$stmt =  $conn->prepare("select * from projects");
	$stmt->execute();
	return $stmt->fetchAll();
}

