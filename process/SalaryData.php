<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
$db = new MySQLCN();

$aColumns = array('e.EmpID','e.EmpName','s.EmpType','s.CurrentSalary','s.IncrementAmount','s.IncrementDate');
$aResultColumns = array('e.EmpID','e.EmpName','s.*');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "e.EmpID";

/* DB table to use */
$sTable = "employee_detail e,salary_detail s";

/* Paging */
$sLimit = "";
if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
   $sLimit = "LIMIT " . mysql_real_escape_string($_GET['iDisplayStart']) . ", " .
           mysql_real_escape_string($_GET['iDisplayLength']);
}

/* Ordering */

if (isset($_GET['iSortCol_0'])) {
   $sOrder = "ORDER BY  ";
   for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
      if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
         $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
				 	" . mysql_real_escape_string($_GET['sSortDir_' . $i]) . ", ";
      }
   }

   $sOrder = substr_replace($sOrder, "", -2);
   if ($sOrder == "ORDER BY") {
      $sOrder = "";
   }
}

/*
 * Filtering
 * NOTE this does not match the built-in DataTables filtering which does it
 * word by word on any field. It's possible to do here, but concerned about efficiency
 * on very large tables, and MySQL's regex functionality is very limited
 */

$sWhere = 'WHERE e.EmpID = s.EmpID ';
if ($_GET['sSearch'] != "") {
   $sWhere = $sWhere." AND (";
   for ($i = 0; $i < count($aColumns); $i++) {
      $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch']) . "%' OR ";
   }
   $sWhere = substr_replace($sWhere, "", -3);
   $sWhere .= ')';
}

$sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aResultColumns)) . "
	   FROM   $sTable
	   $sWhere
	   $sOrder
	   $sLimit
	";

$rResult = $db->selectForJason($sQuery);
/* Data set length after filtering */

$sQuery = "SELECT FOUND_ROWS()";

$aResultFilterTotal = $db->select($sQuery);
$iFilteredTotal = $aResultFilterTotal[0][0];


/* Total data set length */
$sQuery = "SELECT COUNT(" . $sIndexColumn . ")
           FROM   $sTable
           WHERE  e.EmpID = s.EmpID
          ";
$aResultTotal = $db->select($sQuery);
$iTotal = $aResultTotal[0][0];

/* Output */

$output = array(
    "sEcho" => intval($_GET['sEcho']),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => array()
);

for ($i = 0; $i < count($rResult); $i++) {
   $row = array();
   $row = $rResult[$i];
   
   $start = strtotime(date('Y-m-d'));
   $end = strtotime($row['IncrementDate']);
   $days_between = ($end - $start) / 86400;
   if($days_between<32){
       $row['yes'] = "<a href='EmployeeSalaryUpdate.php?EmpID={$row['EmpID']}' ><img src='".ROOT."images/yes.gif' class='editIcon'></a>";
   }else{
       $row['yes'] = "";
   }
   $row['edit'] = "<a href='EmployeeSalary.php?EmpID={$row['EmpID']}' ><img src='".ROOT."images/edit.gif' ></a>";
   $row['delete'] = "<a val='{$row['EmpID']}' id='delEmp' ><img src='".ROOT."images/delete.gif' ></a>";
   
   $output['aaData'][] = $row;
}

echo json_encode($output);
?>