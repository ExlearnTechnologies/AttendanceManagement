<?php
class User extends MySQLCN{
 	function login() {
 		if($_POST['UserName'] == NULL || $_POST['Password'] == NULL){
 			return false;
 		}
 		$qry = "SELECT * 
 				FROM user 
 				WHERE UserName = '{$_POST['UserName']}' AND Password = '{$_POST['Password']}'";
		$result = $this->select($qry);
		if($result != NULL){
			$_SESSION['UserID'] = $result[0]['UserID'];
			$_SESSION['UserName'] = $result[0]['UserName'];
			return true;
		}else{
			return false;
		}
 	}
}
?>