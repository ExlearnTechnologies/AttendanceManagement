<?php

require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Attandanse.php';

$att = new Attandanse();

if ($_POST['type'] == 'Add' && $_POST['date']) {
    echo $att->Add();
    
} else if ($_POST['type'] == 'view' && $_POST['startDate'] != NULL && $_POST['endDate'] != NULL) {
    $start = strtotime($_POST['startDate']);
    $end = strtotime($_POST['endDate']);
    $days_between = (ceil(abs($end - $start) / 86400) + 1 ) - $att->number_of_days(0, $start, $end);
    $result = $att->Report($_POST);
    
    $AttendanceList .= "<tr>";
    $AttendanceList .= "<th><b>Emp Name</b></th>";
    $AttendanceList .= "<th><b>Dept</b></th>";
    $AttendanceList .= "<th><b>Total</b></th>";
    $AttendanceList .= "</tr>";
    
    for ($i = 0; $i < count($result); $i++) {
        $AttendanceList .= "<tr>";
        $AttendanceList .= "<td>{$result[$i]['EmpName']}</td>";
        $AttendanceList .= "<td>{$result[$i]['EmpTechnology']}</td>";
        $AttendanceList .= "<td>{$result[$i]['Att']} Out of {$days_between}</td>";
        $AttendanceList .= "</tr>";
    }
    
    $res['AttendanceList'] = $AttendanceList;
    echo json_encode($res);
    
} else if ($_POST['type'] == 'EmpView' && $_POST['reportType'] == 'Attendance' && $_POST['EmpID'] != NULL && $_POST['startDate'] != NULL && $_POST['endDate'] != NULL) {
    $start = strtotime($_POST['startDate']);
    $end = strtotime($_POST['endDate']);
    $pre = array('0'=>'<b>Absent</b>','1'=>'Present');
    $result = $att->EmpReport($_POST['EmpID']);
    
    echo "<tr>";
    echo "<th><b>Emp Name</b></th>";
    echo "<th><b>Dept</b></th>";
    echo "<th><b>Date</b></th>";
    echo "<th><b>Present</b></th>";
    echo "</tr>";
    for ($i = 0; $i < count($result); $i++) {
        echo "<tr>";
        echo "<td>{$result[$i]['EmpName']}</td>";
        echo "<td>{$result[$i]['EmpTechnology']}</td>";
        echo "<td>{$result[$i]['AttDate']}</td>";
        echo "<td>{$pre[$result[$i]['Prensent']]}</td>";
        echo "</tr>";
    }
} else if ($_POST['type'] == 'EmpView' && $_POST['reportType'] == 'Salary' && $_POST['EmpID'] != NULL ) {
    $result = $att->SalaryReport($_POST['EmpID']);
    echo "<tr>";
    echo "<th><b>Emp Name</b></th>";
    echo "<th><b>Dept</b></th>";
    echo "<th><b>Salary</b></th>";
    echo "<th><b>Date</b></th>";
    echo "</tr>";
    for ($i = 0; $i < count($result); $i++) {
        echo "<tr>";
        echo "<td>{$result[$i]['EmpName']}</td>";
        echo "<td>{$result[$i]['EmpTechnology']}</td>";
        echo "<td>{$result[$i]['Salary']}</td>";
        echo "<td>{$result[$i]['IncrementDate']}</td>";
        echo "</tr>";
    }
} else if ($_POST['type'] == 'get' && $_POST['date'] != NULL) {

    $result = $att->getDate($_POST['date']);
    $eID = '';
    for ($i = 0; $i < count($result); $i++) {
        $eID = $eID . '#' . $result[$i]['EmpID'];
        if ($i != ( count($result) - 1)) {
            $eID = $eID . ', ';
        }
    }
    $ret = array();
    if ($result == NULL) {
        $ret['sucess'] = 'new';
        $ret['data'] = '';
    } else {
        $ret['sucess'] = 'old';
        $ret['data'] = $eID;
    }

    echo json_encode($ret);
} else {
    
}
?>
