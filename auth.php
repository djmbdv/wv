<?php

require_once "con.php";
global $conn;

function is_login(){
	session_start();
	$r = isset($_SESSION["online"]);
	session_commit();
	return $r;
}
function auth($username,$password){
	global $conn;
	$stmt = $conn->prepare("select  workers.name as name, workers.id as id, projects.id as project, password from workers left join projects on projects.id = current_project where username = :username");
	$stmt->bindParam(":username",$username);
	$stmt->execute();
	$o =  $stmt->fetchObject();
	if($stmt->rowCount()  == 0)return false;
	$pass = $o->password;
	$res = password_verify($password,$pass);
	if($res){
		session_start();
		$_SESSION['worker'] = true;
		$_SESSION['id'] = $o->id;
		$_SESSION['name'] =$o->name;
		$_SESSION['project'] = $o->project;
		session_commit();
	}
	return $res;
}
function auth2($username,$password){
	global $conn;
	$stmt = $conn->prepare("select * from admins where username = :username  ");
	$stmt->bindParam(":username",$username);
	$stmt->execute();
	$pass = $stmt->fetchColumn(2);
	$res = password_verify($password,$pass);
	if($res){
		session_start();
		$_SESSION['admin'] = true;
		session_commit();
	}
	return $res;
}

function ami_admin(){
	session_start();
	$res = isset($_SESSION['admin']) && $_SESSION['admin'];
	session_commit();
	return $res;
}

if(isset($_POST['username']) && isset($_POST['password']) ){
	echo auth($_POST['username'],$_POST['password']);
	if(auth($_POST['username'],$_POST['password']) || auth2($_POST['username'],$_POST['password'])){
		session_start();
		$_SESSION["online"] = true;
		session_commit();
		header("location: index.php");
		die();
	}
}
//echo $_SESSION['name'];