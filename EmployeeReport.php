<?php 
@require_once 'config/config.php';
require_once 'config/session.php'; 
require_once 'class/dbclass.php';
require_once 'class/Attandanse.php';
$att = new Attandanse();
$empList = $att->getEmployeeList();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php require_once 'config/commonJS.php'; ?>
        <script>
            $(document).ready(function(){
                $( "#startDate , #endDate" ).datepicker({
                    dateFormat: 'yy-mm-dd',
                    showOn: "button",
                    buttonImage: "images/calendar.gif",
                    buttonImageOnly: true
                });
            });
        </script>
        <script type="text/javascript">
            function setData(){
                if(!$('#formSubmit').validationEngine('validate')){
                    
                }else{
                    $.ajax({
                        type: "POST",  
                        url: "process/processEmpAttendance.php",
                        data: $('#formSubmit').serialize(),
                        beforeSend : function () {
                            $('#wait').html("Loading");
                        },
                        success: function(resp){
                            $('#AttendanceList').html(resp);
                        },
                        error: function(e){
                        }
                    });
                }
            }
            function ReportType(){
                var res = $('input:radio[name=reportType]:checked').val();
                if(res == 'Salary'){
                    $('.DateHide').hide();
                }else{
                    $('.DateHide').show();
                }
                $('#AttendanceList').html("");
            }
        </script>
        <script>
            window.onload = menuSelect('menuEmployeeReport');
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

                    <form id="formSubmit" method="post" >
                        <input type="hidden" name="type" value="EmpView" />
                        <table class="tbl">
                        	<tr>
                        		<td>Employee Name</td>
                        		<td>
                        			<select name='EmpID'>
			                        	<?php
			                        		for($i=0;$i<count($empList);$i++){
			                        			echo "<option value='{$empList[$i]['EmpID']}'>{$empList[$i]['EmpName']}</option>";
			                        		} 
			                        	?>
			                        </select>
                        		</td>
                        	</tr>
                                <tr>
                                    <td><label><input checked type="radio" name="reportType" value="Attendance" id="reportType" onchange="ReportType();" /> Attendance Report</label></td>
                                    <td><label><input type="radio" name="reportType" value="Salary" id="reportType" onchange="ReportType();" /> Salary Report</label></td>
                                </tr>
                        	<tr class="DateHide">
                        		<td>
                        			Start Date:
                        		</td>
                        		<td>
                        			<input type="text" class="validate[required]" readonly name="startDate" id="startDate" />
                        		</td>
                        	</tr>
                        	<tr class="DateHide">
                        		<td>
                        			End Date:
                        		</td>
                        		<td>
                        			<input type="text" class="validate[required]" readonly name="endDate" id="endDate" />
                        		</td>
                        	</tr>
                        	<tr>
                        		<td colspan="2"><input class="button" type="button" onclick="setData()" value="View" /> </td>
                        	</tr>
                        </table>
                        
                    </form>
                    <table id="AttendanceList" class='tbl' width="700px">
						
                    </table>   
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
