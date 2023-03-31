<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once "../class/User.php";

$user = new User();

if($_POST['type']=='login'){
	if($user->login()){
		header('Location: ../index.php');
	}else{
		$_SESSION['Msg'] = "Inavalid UserName Or Password";
		header('Location: ../login.php');
	}
}
else if($_POST['type']=='register'){
	
}else{
	header('Location : ../login.php');
}
?>