<?php
    require_once '../config/config.php';
    require_once '../class/dbclass.php'; 
    require_once '../class/EmpRegister.php';

    $emp = new EmpRegister();
    if($_POST['type']=='Add' && $_POST['EmpAddress'] != NULL && $_POST['EmpMobile'] != NULL){
       $id = $emp->Add();
       $_SESSION['Msg'] = "Employee Add Sucessfuly";
       if($_POST['temp'] == 'temp'){
       	header('Location: ../TempEmployeeRegister.php');	
       }else{
       	header('Location: ../EmployeeRegister.php');
       }
    }
    else if($_POST['type']=='Update' && $_POST['EmpID'] != NULL && $_POST['EmpAddress'] != NULL && $_POST['EmpMobile'] != NULL){
       $emp->Update($_POST['EmpID']);
       $_SESSION['Msg'] = "Employee Update Sucessfuly";
       header('Location: ../EmployeeRegister.php?EmpID='.$_POST['EmpID']);
    }
    else if($_POST['type']=='delete' && $_POST['EmpID'] != NULL){
       $id = $emp->Delete($_POST['EmpID']);
       echo "Delete Sucessful";
    }
    else if($_POST['type']=='SalaryAdd' && $_POST['EmpID'] != NULL){
        $emp->SalaryAdd();
        header('Location: ../SalaryDetail.php');
    }
    else if($_POST['type']=='SalaryUpdate' && $_POST['EmpID'] != NULL){
        $emp->SalaryUpdate();
        header('Location: ../SalaryDetail.php');
    }
    else if($_POST['type']=='SalaryDelete' && $_POST['EmpID'] != NULL){
        $emp->SalaryDelete($_POST['EmpID']);
        //header('Location: ../SalaryDetail.php');
    }
    else if($_POST['type']=='SalaryIncrement' && $_POST['EmpID'] != NULL){
        $emp->SalaryIncrement($_POST['EmpID']);
        header('Location: ../SalaryDetail.php');
    }
    else{
       // header("Location: ../EmployeeRegister.php");
    }
?>