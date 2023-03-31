<?php 
    require_once 'config/config.php';
    require_once 'class/dbclass.php';
    require_once 'class/Attandanse.php';
    
    $att = new Attandanse();
    
    $data['startDate'] = '2012-08-01';
    $data['endDate'] = '2012-09-10';
    
    $result = $att->Report($data);
    $start = strtotime($data['startDate']);
    $end = strtotime($data['endDate']);
    $days_between = (ceil(abs($end - $start) / 86400) + 1) - $att->number_of_days(0, $start, $end);
    $dataJson = "[['Name','Attandanse']";
    for($i=0;$i<count($result);$i++){
       // $dataJson .= ",['{$result[$i]['EmpName']}',{$result[$i]['Att']},{$days_between}]";
         $dataJson .= ",['{$result[$i]['EmpName']}',{$result[$i]['Att']}]";
    }
   $dataJson .= "]";

?>

<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
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
  </head>
  <body>
    <div id="chart_div" style="width: 100%; height: 1000px;"></div>
  </body>
</html>