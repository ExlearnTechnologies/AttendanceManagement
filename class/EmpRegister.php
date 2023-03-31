<?php

class EmpRegister extends MySQLCN {

    function Add() {
        $qry = "INSERT INTO `employee_detail` 
            ( `EmpName`, `EmpAddress`, `EmpMobile`, 
              `EmpEmail`, `EmpBirthdate`, `EmpBloodGroup`, `EmpTechnology`) 
            VALUES 
            ( '{$_POST['EmpName']}', '{$_POST['EmpAddress']}', '{$_POST['EmpMobile']}', 
              '{$_POST['EmpEmail']}', '{$_POST['EmpBirthdate']}', '{$_POST['EmpBloodGroup']}', '{$_POST['EmpTechnology']}')";
        return $this->insert($qry);
    }

    function Update($EmpID) {
        $check = $this->get($EmpID);
        if ($check == NULL) {
            return false;
        }
        $qry = "UPDATE `employee_detail` SET
              `EmpName` = '{$_POST['EmpName']}', 
              `EmpAddress` = '{$_POST['EmpAddress']}', 
              `EmpMobile` = '{$_POST['EmpMobile']}',
              `EmpEmail` = '{$_POST['EmpEmail']}', 
              `EmpBirthdate` = '{$_POST['EmpBirthdate']}', 
              `EmpBloodGroup` = '{$_POST['EmpBloodGroup']}', 
              `EmpTechnology` = '{$_POST['EmpTechnology']}'
               WHERE EmpID = '{$EmpID}'";
        return $this->insert($qry);
    }

    function Delete($EmpID) {
        $qry = "DELETE FROM `employee_detail` WHERE EmpID = '{$EmpID}'";
        return $this->insert($qry);
    }

    function get($EmpID) {
        $qry = "SELECT * 
                FROM `employee_detail` ed LEFT JOIN salary_detail sd ON sd.EmpID = ed.EmpID
                WHERE ed.EmpID = '{$EmpID}'";
        return $this->select($qry);
    }

    function SalaryAdd() {
        $result = $this->get($_POST['EmpID']);
        if ($result == NULL) {
            return false;
        }

        $dateOneMonthAdded = strtotime(date("Y-m-d", strtotime($_POST['LastIncrement'])) . "+{$_POST['IncrementAfter']} month");
        $IncrementDate = date('Y-m-d', $dateOneMonthAdded);
        
        $lastt = strtotime(date("Y-m-d", strtotime($_POST['LastIncrement'])));
        $LastIncrement = date('Y-m-01', $lastt);
        
        $qry = "INSERT INTO `salary_detail` 
               (`EmpID`,`JoinDate`,`EmpType`,
                `CurrentSalary`,`IncrementAmount`,`IncrementAfter`,`IncrementDate`,
                `LastSalary`,`LastIncrement`
               )
               VALUES 
               (
                '{$_POST['EmpID']}','{$_POST['JoinDate']}','{$_POST['EmpType']}',
                '{$_POST['CurrentSalary']}','{$_POST['IncrementAmount']}','{$_POST['IncrementAfter']}','{$IncrementDate}',
                '{$_POST['CurrentSalary']}','{$LastIncrement}'
               )
               ";
        $this->insert($qry);
    }

    function SalaryUpdate() {
        $result = $this->get($_POST['EmpID']);
        if ($result == NULL) {
            return false;
        }

        $dateOneMonthAdded = strtotime(date("Y-m-d", strtotime($result[0]['LastIncrement'])) . "+{$_POST['IncrementAfter']} month");
        $IncrementDate = date('Y-m-d', $dateOneMonthAdded);

        $qry = "UPDATE salary_detail SET 
               `JoinDate` = '{$_POST['JoinDate']}',
               `EmpType`  = '{$_POST['EmpType']}',
               `CurrentSalary` = '{$_POST['CurrentSalary']}',
               `IncrementAmount` = '{$_POST['IncrementAmount']}',
               `IncrementAfter` = '{$_POST['IncrementAfter']}',
               `IncrementDate` = '{$IncrementDate}'
                WHERE EmpID = '{$_POST['EmpID']}'
                ";
        return $this->insert($qry);
    }
    
    function SalaryDelete($EmpID){
        $qry = "DELETE FROM `salary_detail` WHERE EmpID = '{$EmpID}'";
        return $this->insert($qry);
    }
    function SalaryIncrement($EmpID){
        $result = $this->get($EmpID);
        if ($result == NULL) {
            return false;
        }
        $dateOneMonthAdded = strtotime(date("Y-m-d", strtotime($result[0]['IncrementDate'])) . "+{$_POST['IncrementAfter']} month");
        $IncrementDate = date('Y-m-d', $dateOneMonthAdded);
        $newSalary = $result[0]['CurrentSalary'] + $_POST['IncrementAmount'];
        
        $qry = "UPDATE salary_detail SET 
               `JoinDate` = '{$_POST['JoinDate']}',
               `EmpType`  = '{$_POST['EmpType']}',
               `IncrementAfter` = '{$_POST['IncrementAfter']}',
               `CurrentSalary` = '{$newSalary}',
               `IncrementDate` = '{$IncrementDate}',
               `LastSalary` = '{$result[0]['CurrentSalary']}',
               `LastIncrement` = '{$result[0]['IncrementDate']}'
                WHERE EmpID = '{$EmpID}'
                ";
       $this->insert($qry);
       
       $qry = "INSERT INTO `increment_detail` 
                (`EmpID`,`Salary`,`IncrementDate`)
                VALUES
                ('{$_POST['EmpID']}','{$result[0]['CurrentSalary']}','{$result[0]['IncrementDate']}')
                ";
        $this->insert($qry);
        return true;
    }

    function AllList() {
        $qry = "SELECT * 
                FROM `employee_detail`
                ORDER BY `EmpTechnology` DESC,EmpName ASC
                ";
        return $this->select($qry);
    }
    
}

?>