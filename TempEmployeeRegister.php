<?php
require_once 'config/config.php';
//require_once 'config/session.php'; 
require_once 'class/dbclass.php';
require_once 'class/EmpRegister.php';

$emp = new EmpRegister();
$EmpID = $_REQUEST['EmpID'];
if($EmpID != NULL){
    $result = $emp->get($EmpID);
    if($result == NULL){
        $EmpID = '';
    }
}
$EmpID = '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php require_once 'config/commonJS.php'; ?>
        <script>
             $(document).ready(function(){
                   $( "#EmpBirthdate" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true,
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-30"
                   });
              });
        </script>
        <script>
            window.onload = menuSelect('menuEmployee');
        </script>
    </head>

    <body>
        <!-- wrap starts here -->
        <div id="wrap">

            <!--header -->
            <div id="header">
                <h1 id="logo-text"><a href=".">Logisitic InfoTech</a></h1>
                <p id="slogan">Software Solution</p>
                <div id="header-links">
                </div>
            </div>

            <!-- navigation -->	

            <!-- content-wrap starts here -->
            <div id="content-wrap">
                <div id="main">				
                    <h1><?php echo $_SESSION['Msg']; ?></h1>
                    <form id="formSubmit" method="post" action="process/processEmpRegister.php">
            <input type="hidden" name="type" value="<?php echo $EmpID == '' ? 'Add' : 'Update'; ?>"/>
            <input type="hidden" name="temp" value="temp"/>
            <input type="hidden" name="EmpID" value="<?php echo $EmpID; ?>"/>
            <center>
            <table class="tbl">
                <tr>
                    <td><b>Name</b></td>
                    <td><input type="text" class="validate[required]" name="EmpName" id="EmpName" value="<?php echo $result[0]['EmpName'];?>"/></td>
                </tr>
                <tr>
                    <td><b>Address</b></td>
                    <td><textarea rows="5" cols="30" class="validate[required]" name="EmpAddress" id="EmpAddress" ><?php echo $result[0]['EmpAddress'];?></textarea></td>
                </tr>
                <tr>
                    <td><b>Mobile</b></td>
                    <td><input class="validate[required,minSize[10],maxSize[10],custom[integer]]" type="text" class="validate[required]" name="EmpMobile" id="EmpMobile" value="<?php echo $result[0]['EmpMobile'];?>"/></td>
                </tr>
                <tr>
                    <td><b>Email</b></td>
                    <td><input type="text" class="validate[required,custom[email]]" name="EmpEmail" id="EmpEmail" value="<?php echo $result[0]['EmpEmail'];?>"/></td>
                </tr>
                <tr>
                    <td><b>Birth Date</b></td>
                    <td><input type="text" class="validate[required]" readonly name="EmpBirthdate" id="EmpBirthdate" value="<?php echo $result[0]['EmpBirthdate'];?>"/></td>
                </tr>
                <tr>
                    <td><b>Blood Group</b></td>
                    <td><select name="EmpBloodGroup" id="EmpBloodGroup">
                            <option value="A+" <?php echo $result[0]['EmpTechnology'] == 'A+' ? 'selected' : ''; ?> >A+</option>
                            <option value="A-" <?php echo $result[0]['EmpTechnology'] == 'A-' ? 'selected' : ''; ?> >A-</option>
                            <option value="B+" <?php echo $result[0]['EmpTechnology'] == 'B+' ? 'selected' : ''; ?> >B+</option>
                            <option value="B-" <?php echo $result[0]['EmpTechnology'] == 'B-' ? 'selected' : ''; ?> >B-</option>
                            <option value="AB+" <?php echo $result[0]['EmpTechnology'] == 'AB+' ? 'selected' : ''; ?> >AB+</option>
                            <option value="AB-" <?php echo $result[0]['EmpTechnology'] == 'AB-' ? 'selected' : ''; ?> >AB-</option>
                            <option value="O+" <?php echo $result[0]['EmpTechnology'] == 'O+' ? 'selected' : ''; ?> >O+</option>
                            <option value="O-" <?php echo $result[0]['EmpTechnology'] == 'O-' ? 'selected' : ''; ?> >O-</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><b>Technology</b></td>
                    <td>
                        <select name="EmpTechnology" id="EmpTechnology">
                            <option value="php" <?php echo $result[0]['EmpTechnology'] == 'php' ? 'selected' : ''; ?> >Php</option>
                            <option value="android" <?php echo $result[0]['EmpTechnology'] == 'android' ? 'selected' : ''; ?> >Android</option>
                            <option value="iphone" <?php echo $result[0]['EmpTechnology'] == 'iphone' ? 'selected' : ''; ?> >Iphone</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" id="" value="<?php echo $EmpID == '' ? 'Register' : 'Update'; ?>"/></td>
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
