<?php
require_once 'config/config.php';
require_once 'config/session.php';
require_once 'class/dbclass.php';
require_once 'class/EmpRegister.php';
$emp = new EmpRegister();
$AllList = $emp->AllList();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>

        <?php require_once 'config/commonJS.php'; ?>
        <script>
            $(document).ready(function(){
                $( "#date" ).datepicker({
                    currentText: "Now",
                    dateFormat: 'yy-mm-dd',
                    inline: true,
                    altField: '#datepicker_value',
                    onSelect: function(){
                        getData();
                    }
                    
                });
                var myDate = new Date();
                var prettyDate =myDate.getFullYear() +'-' + (myDate.getMonth()+1) + '-' + myDate.getDate();
                $("#datepicker_value").val(prettyDate);
            });
            
        </script>
        <script type="text/javascript">
        	function getData(){
                var dt = $("#datepicker_value").val();
            	$.ajax({
                    type: "POST",
                    url: "process/processEmpAttendance.php",
                    data: {type:'get',date:dt},
                    beforeSend : function () {
                        $('#wait').html("Loading");
                    },
                    success: function(resp){
                    	var obj = jQuery.parseJSON(resp);
                    	if(obj.sucess == 'new'){
                    		$('.present').attr('checked',true);	
                    	}else{
                    		$('.present').attr('checked',false);
                    		$(obj.data).attr('checked',true);
                    	}
                    },
                    error: function(e){
                        alet('Please Try again form not submit sucessful');
                    }
                });
        	}	
            function setData(){
                if(!$('#formSubmit').validationEngine('validate')){

                }else{
                    var absent = unCheckedEmployee();
                    var formVal = $('#formSubmit').serialize();
                    if(absent != null){
                        formVal+="&absent="+absent;
                    }
                    $.ajax({
                        type: "POST",
                        url: "process/processEmpAttendance.php",
                        data: formVal,
                        beforeSend : function () {
                            $('#wait').html("Loading");
                        },
                        success: function(resp){
                            alert('Sucessful'+resp);
                        },
                        error: function(e){
                            alet('Please Try again form not submit sucessful');
                        }
                    });
                }
            }
            function unCheckedEmployee(){
                    var ellength = document.formSubmit.elements.length;
                    var absent = new Array();
                    for(i=0;i<ellength;i++){
                          var type = document.formSubmit.elements[i].type;
                          var name = document.formSubmit.elements[i].name;
                          if (type=="checkbox" && name=="present[]" && document.formSubmit.elements[i].checked){
                          }
                          else if(type=="checkbox" && name=="present[]"){
                              absent.push(document.formSubmit.elements[i].value);
                          }
                    }
                    return absent;
            }
            
        </script>
        <script>
        $(document).ready(function(){
        	window.onload = menuSelect('menuAttandance');
            window.onload = getData();
        });
            
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
                    
                   <form name="formSubmit" class='form' id="formSubmit" method="post" >
                        <input type="hidden" name="type" value="<?php echo $EmpID == '' ? 'Add' : 'Update'; ?>">
<!--                        <input type="text" onchange="getData(this.value)" class="validate[required]" readonly style="margin-left: 20px;" name="date" id="date" >-->
                        <input type="hidden" onchange="getData(this.value)" class="validate[required]" readonly style="margin-left: 20px;" name="date" id="datepicker_value" >
                            <div id="date" style="float: right;margin: 20px;"></div>    
                        <br/>
                        <br/>
                        <div style="float: left;margin: 20px;">
                        <table width="500px" class="tbl">
                            <tr><th><b>Present</b></th><th><b>Name</b></th><th><b>Department</b></th></tr>
                            <?php
                            for ($i = 0; $i < count($AllList); $i++) {
                                echo "<tr>";
                                echo "<td><input id='{$AllList[$i]['EmpID']}' type='checkbox' name='present[]' class='present' value='{$AllList[$i]['EmpID']}' checked></td>";
                                echo "<td>{$AllList[$i]['EmpName']}</td>";
                                echo "<td>{$AllList[$i]['EmpTechnology']}</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                        <input style="margin: 20px;cursor: pointer;" type="button" class="button" onclick="setData()" value="Save">
                        </div>    
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
