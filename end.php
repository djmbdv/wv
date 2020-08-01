<?php 
	
require_once "admin_actions.php";

if(isset($_POST['action'])){
	switch ($_POST['action']){
		
		case 'add_worker':
			$password = $_POST["password"];
			$repass = $_POST["repassword"];
			$name = $_POST["name"];
			$email = $_POST["email"];
			$username = $_POST["username"];
			if($password == $repass){
				add_worker($name,$password,$email,$username);
			}

			break;
		
		case 'add_project':
			$name = $_POST["name"];
			$description = $_POST['description'];
			add_project($name,$description);
			header("location: .");
			break;

		case 'leave_project':
			$id = $_POST["worker"];
			leave_project($id);
			break;
		case 'asign-worker':
			$worker = $_POST["worker"];
			$project = $_POST["project"];
			asign_worker($worker,$project);
			header("location: .");
			break;
		case 'data_worker':
			$worker = $_POST["worker"];
			header('Content-Type: application/json');
			echo data_worker($worker);
			die();
			break;
		case 'edit_worker':
			$worker = $_POST["worker"];
			$name = $_POST["name"];
			$password = $_POST['password'];
			$repassword = $_POST['repassword'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			if($repassword != $password){
				echo 0;
				die();
			}
			edit_worker($worker, $name, $username, $email ,$password);
			header("location: .");
	}

}