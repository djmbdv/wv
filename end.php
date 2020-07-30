<?php 
	
require_once "admin_actions.php";

if(isset($_POST['action'])){
	switch ($_POST['action']){
		
		case 'add_worker':
			$password = $_POST["password"];
			$repass = $_POST["repassword"];
			$name = $_POST["name"];
			$project = $_POST["project"];
			$email = $_POST["email"];
			$username = $_POST["username"];
			if($password == $repass){
				add_worker($name,$password,$email,$project,$username);
			}

			break;
		
		case 'add_project':
			$name = $_POST["name"];
			$description = $_POST['description'];
			add_project($name,$description);
			header("location: .");
			break;
	}

}