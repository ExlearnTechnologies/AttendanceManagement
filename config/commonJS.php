
<link rel="stylesheet" href="css/CoolWater.css" type="text/css" />

<script type="text/javascript" src="js/jquery.js"></script>
<!-- validation start -->
<link rel="stylesheet" href="css/validation/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<script src="js/validation/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="js/validation/jquery.validationEngine.js" type="text/javascript"></script>
<!-- validation end -->
<script>
    $(document).ready(function(){
    $("#formSubmit").validationEngine();
    });
</script>
<link rel="stylesheet" href="css/themes/base/jquery.ui.all.css" />
<!-- start dataTable-->
<link rel="stylesheet" href="css/dataTable/demo_page.css" type="text/css" />
<link rel="stylesheet" href="css/dataTable/demo_table_jui.css" type="text/css" />
<link rel="stylesheet" href="css/dataTable/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />        
<script type="text/javascript" language="javascript" src="js/dataTable/jquery.dataTables.js"></script>
<!-- end dataTable-->

<script src="js/ui/jquery.ui.core.js"></script>
<script src="js/ui/jquery.ui.widget.js"></script>
<script src="js/ui/jquery.ui.datepicker.js"></script>

<script type="text/javascript">
    function menuSelect(mainMenu){
        $(function() {
            $('#'+mainMenu).addClass('current');
        });
    }
</script>