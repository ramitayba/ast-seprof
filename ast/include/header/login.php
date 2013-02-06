<link href="<?php echo $root; ?>themes/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $root; ?>themes/css/bootstrap-overrides.css" rel="stylesheet">
<link href="<?php echo $root; ?>themes/css/slate.css" rel="stylesheet">
<link href="<?php echo $root; ?>themes/css/components/signin.css" rel="stylesheet" type="text/css"> 
<script src="<?php echo $root; ?>themes/js/jquery-1.7.2.min.js"></script>
<script src="<?php echo $root; ?>themes/js/plugins/validate/jquery.validate.js"></script>
<script>
    function validate_login(){

        $('#login-form').validate({
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                }
            },
            highlight: function(label) {
                $(label).closest('.field').removeClass ('success').addClass('error');
            },
            success: function(label) {
                label
                .text('OK!').addClass('valid')
                .closest('.field').addClass('success');
            }
        });

    }</script>
