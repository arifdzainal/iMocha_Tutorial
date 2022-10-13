<link type="text/css" href="css/demo_table_jui.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        oTable = $('#mytable').dataTable({"bJQueryUI": true, "bAutoWidth": false, "sPaginationType": "full_numbers", "bSort": false});
    });
</script>