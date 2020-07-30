<?php 
	
print_r($_POST);

if(isset($_POST['action'])){
	switch ($_POST['action']){
		
		case 'add_user':
			$pasword = $_POST["password"];
			$name = $_POST["name"];
			# code...
			break;
		
		case 'value':
			# code...
			break;
		
		case 'value':
			# code...
			break;
		
		default:
			# code...
			break;
	}

}