<?php
	if($_SESSION['UserID']==NULL){
		header('Location: login.php');
	}
?>