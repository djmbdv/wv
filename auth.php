<?php

include_once "con.php";
global $conn;

function is_login(){
	session_start();
	$r = isset($_SESSION["online"]);
	session_commit();
	return $r;
}
function auth($username,$password){
	global $conn;
	$stmt = $conn->prepare("select * from workers where username = :username");
	$stmt->bindParam(":username",$username);
	$stmt->execute();
	$pass = $stmt->fetchColumn(2);
	return password_verify($password,$pass);
}
function auth2($username,$password){
	global $conn;
	$stmt = $conn->prepare("select * from admins where username = :username  ");
	
	$stmt->bindParam(":username",$username);
	$stmt->execute();

	$pass = $stmt->fetchColumn(2);
	session_start();
	$_SESSION['admin'] = true;
	session_commit();
	return password_verify($password,$pass);
}

if(isset($_POST['username']) && isset($_POST['password']) ){
	if(auth($_POST['username'],$_POST['password']) || auth2($_POST['username'],$_POST['password'])){
		session_start();
		$_SESSION["online"] = true;
		session_commit();
		header("location: index.php");
		die();
	}
}