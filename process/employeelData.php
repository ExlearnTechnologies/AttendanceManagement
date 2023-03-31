<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
$db = new MySQLCN();

$aColumns = array('EmpID','EmpName','EmpEmail','EmpMobile','EmpTechnology');
$aResultColumns = array('EmpID','EmpName','EmpAddress','EmpMobile','EmpEmail','EmpBirthdate','EmpBloodGroup','EmpTechnology');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "EmpID";

/* DB table to use */
$sTable = "employee_detail";

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

$sWhere = '';
if ($_GET['sSearch'] != "") {
   $sWhere = $sWhere."WHERE (";
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
 //  $row['edit'] = "<a href='EmployeeRegister.php?EmpID={$row['EmpID']}' >Edit</a>";
   $row['salary'] = "<a href='EmployeeSalary.php?EmpID={$row['EmpID']}' >Salary Detail</a>";
//   $row['delete'] = "<a val='{$row['EmpID']}' id='delEmp' >Delete</a>";
   $row['edit'] = "<a href='EmployeeRegister.php?EmpID={$row['EmpID']}' ><img src='".ROOT."images/edit.gif' ></a>";
   $row['delete'] = "<a val='{$row['EmpID']}' id='delEmp' ><img src='".ROOT."images/delete.gif' ></a>";
   $output['aaData'][] = $row;
}

echo json_encode($output);
?>