
$(function () {
    jQuery.extend({
        seprof: function(url,data,callback,errorCallback,type) {
            if(jQuery.isFunction(data)) {
                callback=data;
                data={};
            }
            return jQuery.ajax({
                beforeSend: function(xhr){
                    xhr.setRequestHeader("Accept","text/x-json");
                },
                type: "POST",
                url: url,
                data: data,
                success: callback,
                error: errorCallback,
                dataType: type,
                async:true
            });
        }
    });
    var baseurl="/ast/process.php";
    /* $('#cafeterias-table a.edit').live('click', function (e) {
        e.preventDefault();
        /* Get the row as a parent of the link that was clicked on */
    // var nRow = $(this).parents('tr')[0];
         
    /* A different row is being edited - the edit should be cancelled and this row edited */
    // var aData = oTable.fnGetData(nRow);
    /*oTable.fnServerData("/ast/controller/cafeteriasController.php",
        {action:"edit",},editRow(oTable,nRow));
    })
    } );*/
    
    $('a.delete').live('click', function (e) {
        e.preventDefault();     
        name=$(this).attr("id");
        array=name.split("-");
        if(array.length>1){
            a=array[1];
            b=array[2];
        }
        else{
            a='';
            b='';
        }
        var oTable =  $('#'+a+'-table').dataTable();
        var nRow = $(this).parents('tr')[0];
        $.seprof(baseurl,{
            name:a,
            action:'delete',
            query:b
        },function(k){
            if(k.status=='error')
            {
                error('','', k.message,a)  
            }else{
                if ( nRow!=null ) {
                    $(".messages").remove();
                    oTable.fnDeleteRow( nRow );
                    $(".widget").before(k);
                }
                
            }
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a);
        },"json")
    } );
    
    $('.new').live('click', function (e) {
        e.preventDefault();
        var width=$('.widget-table').height();
        var height=$('.widget-table').width();
        name=$(this).attr("id");
        array=name.split("-");
        a=array[1];
        $("#widget-content-"+a+"-table").html('<div style="width:'+width+';height:'+height+'"><img src="/ast/themes/img/loader.gif"  style="vertical-align: middle; alt="Loading...."/></div>');
        $.seprof(baseurl,{
            name:a,
            action:'add',
            query:''
        },function(k){
            showform(k,a)
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a)
        },"json")
    } );
    
    
    $('.permissions').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        array=name.split("-");
        if(array.length>1){
            a=array[0];
            b=array[1];
        }
        else{
            a='';
            b='';
        }
        c='roles';
        $("#widget-content-"+c+"-table").append('<img src="/ast/themes/img/loader.gif" alt="Uploading...."/>');
        $.seprof(baseurl,{
            name:a,
            action:'add',
            query:b
        },function(k){
            showform(k,c)
        },function(httpReq, status, exception,c){
            error(httpReq, status, exception,c)
        },"json")
    } );
    
    $('.items').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        array=name.split("-");
        if(array.length>1){
            a=array[0];
            b=array[1];
        }
        else{
            a='';
            b='';
        }
        c='events';
        $("#widget-content-"+c+"-table").append('<img src="/ast/themes/img/loader.gif" alt="Uploading...."/>');
        $.seprof(baseurl,{
            name:'eventItems',
            action:'index',
            query:b
        },function(k){
            showform(k,c)
        },function(httpReq, status, exception,c){
            error(httpReq, status, exception,c)
        },"json")
    } );
    
    $('.pos').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        array=name.split("-");
        if(array.length>1){
            a=array[0];
            b=array[1];
        }
        else{
            a='';
            b='';
        }
        c="cafeterias";
        $("#widget-content-"+c+"-table").append('<img src="/ast/themes/img/loader.gif" alt="Uploading...."/>');
        $.seprof(baseurl,{
            name:a,
            action:'index',
            query:b
        },function(k){
            showform(k,a)
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a)
        },"json")
    } );
    
    $('.edit').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        array=name.split("-");
        if(array.length>1){
            a=array[1];
            b=array[2];
        }
        else{
            a='';
            b='';
        }
        $("#widget-content-"+a+"-table").append('<img src="/ast/themes/img/loader.gif" alt="Uploading...."/>');
        $.seprof(baseurl,{
            name:a,
            action:'edit',
            query:b
        },function(k){
            showform(k,a)
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a)
        },"json")
    } );
    

    $('.save').live('click', function (e) {
        //if(!validate())return;
        e.preventDefault();
        name=$(this).attr("id");
        array=name.split("-");
        if(array.length>1){
            a=array[1];
            b=array[2];
        }
        else{
            a='';
            b='';
        }
        var sequence="";
        $('input[name=check]:checked').each(function(){
            sequence+=$(this).val()+",";
        });
        var data =$('.'+a+'-form').serialize();
        $("#widget-content-"+a+"-table").append('<img src="/ast/themes/img/loader.gif" alt="Loading...."/>');
        $.seprof(baseurl,{
            name:a,
            action:'save',
            query:b,
            datainput:data,
            sequence:sequence
        },function(k){
            if(k.status=='error')
            {
                error('','', k.message,a)  
            }else{
                showTable(k,a);
            }
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a);
        },"json")
    } );
    
    $('.cancel').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        array=name.split("-");
        a=array[1];
        $("#widget-"+a+"-form").append('<img src="/ast/themes/img/loader.gif" alt="Uploading...."/>');
        $.seprof(baseurl,{
            name:a,
            action:'index',
            query:''
        },function(k){
            showTable(k,a)
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a)
        },"json")
    } );
    
});

function deleteRow(nRow)
{
    oTable.fnDeleteRow( nRow );
}

function showform(b,a)
{
    $(".messages").remove();
     if(b !=null){
    $("#widget-table").replaceWith(b); 
    $("#widget-content-"+a+"-table img:last-child").remove();
     }
}


function showTable(b,a)
{
    $(".messages").remove();
    if(b !=null){
        $(".widget-form").replaceWith(b); 
        $("#widget-"+a+"-form img:last-child").remove();
    }
}

function error(httpReq, status, exception,a){

    b="<div id='block' class='alert alert-block'>"+
    "<a class='close' data-dismiss='alert' href='#'>&times;</a>"+
    exception+"</div>";
    $("#block").replaceWith(b);
    $(".alert").show();
}

function table(name)
{
    var oTable =  $('#'+name+'-table').dataTable( {
        sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
        sPaginationType: "bootstrap",
        oLanguage: {
            "sLengthMenu": "_MENU_ records per page"
        }
    /*  fnServerData: function ( sSource, aoData,fnCallback,fnError ) {
            $.ajax( {
                "dataType": 'json', 
                "type": "POST", 
                "url": sSource, 
                "data": aoData, 
                "success": fnCallback,
                "error":fnError
            } );
    }*/
    });
    return table;
}

function validate()
{
    $('#users-form').validate({
        rules: {
            user_name: {
                required: true
            },
            user_password: {
                required: true
            },
            user_pin: {
                required: true
            },
            roles: {
                required: true
            },
            employees: {
                required: true
            }
        },
        focusCleanup: false,

        highlight: function(label) {
            $(label).closest('.control-group').removeClass ('success').addClass('error');
        },
        success: function(label) {
            label
            .text('OK!').addClass('valid')
            .closest('.control-group').addClass('success');
        },
        errorPlacement: function(error, element) {
            error.appendTo( element.parents ('.controls') );
        }
    });

    $('#roles-form').validate({
        rules: {
            role_name: {
                required: true
            }
        },
        focusCleanup: false,

        highlight: function(label) {
            $(label).closest('.control-group').removeClass ('success').addClass('error');
        },
        success: function(label) {
            label
            .text('OK!').addClass('valid')
            .closest('.control-group').addClass('success');
        },
        errorPlacement: function(error, element) {
            error.appendTo( element.parents ('.controls') );
        }
    });

    $('#permissions-form').validate({
        rules: {
            links : {
                required: true
            }
        },
        focusCleanup: false,

        highlight: function(label) {
            $(label).closest('.control-group').removeClass ('success').addClass('error');
        },
        success: function(label) {
            label
            .text('OK!').addClass('valid')
            .closest('.control-group').addClass('success');
        },
        errorPlacement: function(error, element) {
            error.appendTo( element.parents ('.controls') );
        }
    });

    $('#pos-form').validate({
        rules: {
            pos_key: {
                required: true
            },
            cafeteria : {
                required: true
            },
            status : {
                required: true
            }
        },
        focusCleanup: false,

        highlight: function(label) {
            $(label).closest('.control-group').removeClass ('success').addClass('error');
        },

        success: function(label) {
            label
            .text('OK!').addClass('valid')
            .closest('.control-group').addClass('success');
        },
        errorPlacement: function(error, element) {
            error.appendTo( element.parents ('.controls') );
        }
    });

    $('#cafeterias-form').validate({
        rules: {
            cafeteria_name: {
                required: true
            }
        },
        focusCleanup: false,

        highlight: function(label) {
            $(label).closest('.control-group').removeClass ('success').addClass('error');
        },

        success: function(label) {
            label
            .text('OK!').addClass('valid')
            .closest('.control-group').addClass('success');
        },
        errorPlacement: function(error, element) {
            error.appendTo( element.parents ('.controls') );
        }
    });

    $('#categories-form').validate({
        rules: {
            category_name: {
                required: true
            },
            category: {
                required: true
            },
            category_description: {
                required: true
            },
            color_code: {
                required: true
            }
        },
        focusCleanup: false,

        highlight: function(label) {
            $(label).closest('.control-group').removeClass ('success').addClass('error');
        },
        success: function(label) {
            label
            .text('OK!').addClass('valid')
            .closest('.control-group').addClass('success');
        },
        errorPlacement: function(error, element) {
            error.appendTo( element.parents ('.controls') );
        }
    });

    $('#items-form').validate({
        rules: {
            item_name: {
                required: true
            },
            categories: {
                required: true
            },
            item_price: {
                required: true
            },
            item_photo: {
                required: true
            },
            item_description: {
                required: true
            }
        },
        focusCleanup: false,

        highlight: function(label) {
            $(label).closest('.control-group').removeClass ('success').addClass('error');
        },
        success: function(label) {
            label
            .text('OK!').addClass('valid')
            .closest('.control-group').addClass('success');
        },
        errorPlacement: function(error, element) {
            error.appendTo( element.parents ('.controls') );
        }
    });

    $('.form').eq (0).find ('input').eq (0).focus ();

    $('#event-form').validate({
        rules: {
            event_name: {
                required: true
            },
            datepicker: {
                required: true
            },
            invitees_nb: {
                required: true
            },
            department: {
                required: true
            },
            users: {
                required: true
            }
        },
        focusCleanup: false,

        highlight: function(label) {
            $(label).closest('.control-group').removeClass ('success').addClass('error');
        },
        success: function(label) {
            label
            .text('OK!').addClass('valid')
            .closest('.control-group').addClass('success');
        },
        errorPlacement: function(error, element) {
            error.appendTo( element.parents ('.controls') );
        }
    });

}


function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

