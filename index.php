<?php 
@require_once 'config/config.php';
@require_once 'config/session.php';
@require_once 'class/dbclass.php';
@require_once 'class/Attandanse.php';

if($_POST['chart'] == 'Chart' && $_POST['startDate'] != NULL && $_POST['endDate'] != NULL){
    $chart = 1;
    $att = new Attandanse();

    $data['startDate'] = $_POST['startDate'];
    $data['endDate'] = $_POST['endDate'];

    $result = $att->Report($data);
    $start = strtotime($data['startDate']);
    $end = strtotime($data['endDate']);
    $days_between = (ceil(abs($end - $start) / 86400) + 1) - $att->number_of_days(0, $start, $end);
    $dataJson = "[['Name','Attandanse']";
    for($i=0;$i<count($result);$i++){
        $dataJson .= ",['{$result[$i]['EmpName']}',{$result[$i]['Att']}]";
    }
    $dataJson .= "]";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php require_once 'config/commonJS.php'; ?>
        
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            <?php if($chart) { echo "google.setOnLoadCallback(drawChart);"; }?>
            function drawChart() {
                var data = google.visualization.arrayToDataTable(
                    <?php echo $dataJson; ?>
                );

                var options = {
                        title: '<?php echo $days_between; ?> Day Report',
                        vAxis: {   title: 'Name',  
                                    titleTextStyle: {color: 'red'}
                                },
                        colors: ['#c7cfc7', '#b2c8b2']       
                    };
                var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        //var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
      //  var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      //  var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
               chart.draw(data, options);
            }
            
       </script>
        
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
                $('#chart_div').hide();
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
                            
                            var obj = jQuery.parseJSON(resp);
                            $('#AttendanceList').html(obj.AttendanceList);
                            
                            
                           // var dat = jQuery.parseJSON(obj.Chart);
                            
                            drawChart(obj.Chart);
                        },
                        error: function(e){
                        }
                    });
                }
            }
        </script>
        <script>
            window.onload = menuSelect('menuHome');
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
                        <input type="hidden" name="type" value="view" />
                        <input type="text" class="validate[required]" readonly value='<?php echo $data['startDate']; ?>' name="startDate" id="startDate" />
                        <input type="text" class="validate[required]" readonly value='<?php echo $data['endDate']; ?>' name="endDate" id="endDate" />
                        <input class="button" type="button" onclick="setData()" value="View" />
                        <input class="button" type="submit" name="chart" onclick="setData()" value="Chart" />
                    </form>
                    <table id="AttendanceList" class='tbl' width="700px">

                    </table>   
                    <div class="clear"></div>
                    <div id="chart_div" style="width: 100%; height: 1000px;"></div>
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
