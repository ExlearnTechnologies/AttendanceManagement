<?php
require_once 'config/config.php'; 
require_once 'config/session.php';
require_once 'class/dbclass.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php require_once 'config/commonJS.php'; ?>
        <script>
           $.fx.speeds._default = 1000;
           $(document).ready(function() {
           var oTable = $('#dataList').dataTable( {
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,
                "bRedraw" : true,
                "sAjaxSource": "process/SalaryData.php",
                "aoColumns": [
                    { "mDataProp": "EmpID" },
                    { "mDataProp": "EmpName" },
                    { "mDataProp": "EmpType" },
                    { "mDataProp": "CurrentSalary" },
                    { "mDataProp": "IncrementAmount" },
                    { "mDataProp": "IncrementDate" },
                    { "mDataProp": "yes" },
                    { "mDataProp": "edit" },
                    { "mDataProp": "delete" }
                ],
                "aoColumnDefs": [
                   { "bSortable": false, "aTargets": [ 6 ] },
                   { "bSortable": false, "aTargets": [ 7 ] },
                   { "bSortable": false, "aTargets": [ 8 ] }
                ],
                "aaSorting": [[ 5, "asc" ]]
            } ); 
            $('#delEmp').live('click', function () {
               var id = $(this).attr('val');
               var r = confirm("Are You Sure Delete Employee ?");
               if (r==true){
                  $.ajax({
                     type: "POST",
                     url: "process/processEmpRegister.php",
                     data:{EmpID:id ,type:'SalaryDelete'},
                     beforeSend : function () {
                        //$('#wait').html("Wait for checking");
                     },
                     success:function(resp){
                        oTable.fnDraw();
                        alert("Delete sucessful");
                     }
                  });
               }else{   
               }
            });
            
             $('#Recived').live('click', function () {
               var id = $(this).attr('val');
               var r = confirm("Are You Sure change status ?");
               if (r==true){
                  $.ajax({
                     type: "POST",
                     url: "process/processEmpRegister.php",
                     data:{EmpID:id ,type:'SalaryIncrement'},
                     beforeSend : function () {
                        //$('#wait').html("Wait for checking");
                     },
                     success:function(resp){
                        oTable.fnDraw();
                        alert("update sucessful" +resp);
                     }
                  });
               }else{
                  
               }
            });
            
            });
        </script>
<!--        end Data tabel-->
        <script>
            window.onload = menuSelect('menuSalaryList');
        </script>
    </head>

    <body>
        <!-- wrap starts here -->
        <div id="wrap">

            <!--header -->
            <?php @require_once 'menu/header.php'; ?>

            <!-- navigation -->	
            <?php @require_once 'menu/menu.php'; ?>

            <!-- content-wrap starts here -->
            <div id="content-wrap">
                <div id="main">				
                    <div class="clear"></div>
            <div>
            <table class="displayGrid tbl" id="dataList" cellpadding="0" cellspacing="0" border="0" style="table-layout: fixed;" width="600px">
                        <thead>
                            <tr>
                                <th rowspan="2" width="50px">ID</th>
                                <th rowspan="2" width="150px">Name</th>
                                <th rowspan="2" width="100px">Emp Type</th>
                                <th rowspan="2" width="120px">Cur Salary</th>
                                <th rowspan="2" width="120px">Inc Amount</th>
                                <th rowspan="2" width="145px">Inc Date</th>
                                <th colspan="3" width="170px">Action</th>
                            </tr>
                            <tr>
                               <th></th>
                               <th></th>
                               <th></th>
                            </tr>
                        </thead>
                        <tbody>	
                        </tbody>
                    </table>
             </div>
                    
                <div class="clear"></div>
                </div>
            <?php @require_once 'menu/sidemenu.php'; ?>	
            <!-- content-wrap ends here -->
            </div> 
            <!--footer starts here-->
            <?php @require_once 'menu/footer.php'; ?>
            <!-- wrap ends here -->
        </div>
    </body>
</html>
