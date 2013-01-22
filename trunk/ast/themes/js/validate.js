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

}
function enable_text(status,links)
{
    status=!status;
    //for (i = 0; i < links.length; i++)
    links.disabled=status;
}

/*
$(document).ready(function(){
    var str="";
    $('.virgule').click(function() {
        $('input[name=links]:checked').each(function(){
            str+=$(this).val()+",";
        });
        alert(str);
        str="";
    });
});
*/
$(function() {
    $( ".datepicker" ).datepicker();
});
/*
var $checktree;
$(function(){
    $checktree = $("ul.tree").checkTree();
});
*/
