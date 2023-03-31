<?php
require_once 'config/config.php';
require_once 'config/session.php'; 
require_once 'class/dbclass.php';
require_once 'class/EmpRegister.php';


$emp = new EmpRegister();
$EmpID = $_REQUEST['EmpID'];
if($EmpID != NULL){
    $result = $emp->get($EmpID);
    $SalaryID = $result[0]['SalaryID'];
    if($result == NULL){
        header('Location : EmployeeList.php');
    }
}else{
    header('Location : EmployeeList.php');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php require_once 'config/commonJS.php'; ?>
        <script>
             $(document).ready(function(){
                   $( "#JoinDate" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true,
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-30"
                   });
                   $( "#LastIncrement" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true,
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-30"
                   });
                   <?php if($SalaryID == ''){echo "$('.temphide').hide();";} ?>
              });
        </script>
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
                    <?php echo $_SESSION['Msg']; ?>
                    <form id="formSubmit" method="post" action="process/processEmpRegister.php">
                        <input type="hidden" name="type" value="<?php echo $SalaryID == '' ? 'SalaryAdd' : 'SalaryUpdate'; ?>"/>
                        <input type="hidden" name="EmpID" value="<?php echo $EmpID; ?>"/>
                <center>
            <table class="tbl">
                <tr>
                    <td><b>Name</b></td>
                    <td><b><?php echo $result[0]['EmpName'];?></b></td>
                </tr>
                <tr>
                    <td><b>Technology</b></td>
                    <td><b><?php echo $result[0]['EmpTechnology']; ?></b></td>
                </tr>
                <tr>
                    <td><b>Join Date</b></td>
                    <td><input type="text" class="validate[required]" readonly name="JoinDate" id="JoinDate" value="<?php echo $result[0]['JoinDate'];?>"/></td>
                </tr>
                <tr class="temphide">
                    <td><b>Last Salary</b></td>
                    <td><b><?php echo $result[0]['LastSalary']; ?></b></td>
                </tr>
                <tr>
                    <td><b>Last Increment Date</b></td>
                    <td><input type="text" <?php echo $SalaryID != NULL ? 'disabled = true' : 'readonly'; ?> class="validate[required]" name="LastIncrement" id="LastIncrement" value="<?php echo $result[0]['LastIncrement'];?>"/></td>
                </tr>
                <tr>
                    <td><b>Employee Type</b></td>
                    <td>
                        <select name="EmpType" id="EmpType" >
                            <option value="employee" <?php echo $result[0]['EmpType'] == 'employee' ? 'selected' : ''; ?> >Employee</option>
                            <option value="trainee" <?php echo $result[0]['EmpType'] == 'trainee' ? 'selected' : ''; ?> >Trainee</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><b>Current Salary</b></td>
                    <td><input type="text" class="validate[required]"  name="CurrentSalary" id="CurrentSalary" value="<?php echo $result[0]['CurrentSalary'];?>"/></td>
                </tr>
                
                <tr>
                    <td><b>Increment After</b></td>
                    <td>
                        <select name="IncrementAfter" id="IncrementAfter">
                            <option value="6" <?php echo $result[0]['IncrementAfter'] == '6' ? 'selected' : ''; ?> >6</option>
                            <option value="1" <?php echo $result[0]['IncrementAfter'] == '1' ? 'selected' : ''; ?> >1</option>
                            <option value="2" <?php echo $result[0]['IncrementAfter'] == '2' ? 'selected' : ''; ?> >2</option>
                            <option value="3" <?php echo $result[0]['IncrementAfter'] == '3' ? 'selected' : ''; ?> >3</option>
                            <option value="4" <?php echo $result[0]['IncrementAfter'] == '4' ? 'selected' : ''; ?> >4</option>
                            <option value="5" <?php echo $result[0]['IncrementAfter'] == '5' ? 'selected' : ''; ?> >5</option>
                            <option value="7" <?php echo $result[0]['IncrementAfter'] == '7' ? 'selected' : ''; ?> >7</option>
                            <option value="8" <?php echo $result[0]['IncrementAfter'] == '8' ? 'selected' : ''; ?> >8</option>
                            <option value="9" <?php echo $result[0]['IncrementAfter'] == '9' ? 'selected' : ''; ?> >9</option>
                            <option value="10" <?php echo $result[0]['IncrementAfter'] == '10' ? 'selected' : ''; ?> >10</option>
                            <option value="11" <?php echo $result[0]['IncrementAfter'] == '11' ? 'selected' : ''; ?> >11</option>
                            <option value="12" <?php echo $result[0]['IncrementAfter'] == '12' ? 'selected' : ''; ?> >12</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td><b>Increment</b></td>
                    <td><input type="text" name="IncrementAmount" id="IncrementAmount" value = "<?php echo $result[0]['IncrementAmount']; ?>"/></td>
                </tr>
                
               
                
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" id="" value="<?php echo $SalaryID == '' ? 'Add' : 'Update'; ?>"/></td>
                </tr>
            </table>
            </center>
        </form>
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
