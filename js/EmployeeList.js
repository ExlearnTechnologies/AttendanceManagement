    $.fx.speeds._default = 1000;
    $(document).ready(function() {
    var oTable = $('#businessList').dataTable( {
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bServerSide": true,
        "bRedraw" : true,
        "sAjaxSource": "process/businessData.php",
        "aoColumns": [
            { "mDataProp": "username" },
            { "mDataProp": "company_name" },
            { "mDataProp": "business_name" },
            { "mDataProp": "business_category_name" },
            { "mDataProp": "banner" },
            { "mDataProp": "active" },
            { "mDataProp": "edit" },
            { "mDataProp": "delete" }
        ],
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 4 ] },
            { "bSortable": false, "aTargets": [ 5 ] },
            { "bSortable": false, "aTargets": [ 6 ] },
            { "bSortable": false, "aTargets": [ 7 ] }
        ],
        "aaSorting": [[ 0, "asc" ]]
    } );

    $('#catFilter', this).change( function () {
            oTable.fnFilter( $(this).val(), 3 );
    } );

    $('#activeUser').live('click', function () {
        var id = $(this).attr('val');
        var status = $(this).attr('status');
        var r = confirm("Are You Sure Change Status?");
        if (r==true){
            $.ajax({
                type: "POST",
                url: "process/processBusiness.php",
                data:{business_id:id ,status:status ,type:'Active'},
                beforeSend : function () {
                //$('#wait').html("Wait for checking");
                },
                success:function(){
                oTable.fnDraw();
                }
            });
        }else{

        }
    });

    $('#deleteUser').live('click', function () {
        var id = $(this).attr('val');
        var r = confirm("Are You Sure Delete Business?");
        if (r==true){
            $.ajax({
                type: "POST",
                url: "process/processBusiness.php",
                data:{business_id:id ,type:'Delete'},
                beforeSend : function () {
                //$('#wait').html("Wait for checking");
                },
                success:function(){
                oTable.fnDraw();
                }
            });
        }else{

        }
    });

    });
   