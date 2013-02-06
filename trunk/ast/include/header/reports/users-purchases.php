<link href="<?php echo $root; ?>themes/js/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="<?php echo $root; ?>themes/js/plugins/datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript">
    $(function () {	
        $("#datetimepickermin").datetimepicker({language: 'en',pickTime: false});
       $("#datetimepickermax").datetimepicker({language: 'en',pickTime: false});
    });
</script>

