var dataRow, nRow,oTable,count=0,row_id='', baseurl="/ast/process.php";
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
                async:true
            });
        }
    });
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
        if (! confirm("Are you sure you want to delete?")){
            return;
        }
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
        oTable =  $('#'+a+'-table').dataTable();
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
        })
    } );
    $('.add').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        array=name.split("-");
        if(array.length>1){
            a=array[1];
        }
        else{
            a='';
        }
        oTable =  $('#'+a+'-table').dataTable();
        row_id='';
        if(existRow(oTable,$('#id').val()))
        {
            return;
        }
        count++;
        oTable.fnAddData([count,$('#id option:selected').text(),$('#number').val(),'<span><a class="delete-table btn" id="delete-'+a+'" href="">Delete</a></span>']);
        $('#id').val('');
        $('#number').val('');  
    } );
    $('.edit-table').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        array=name.split("-");
        if(array.length>1){
            a=array[2];
        }
        else{
            a='';
        }
        oTable =  $('#'+a+'-table').dataTable();
        if(nRow!=null){
            oTable.fnUpdate([row_id,$('#id option:selected').text(),$('#number').val(),'<span><a class="delete-table btn" id="delete-'+a+'" href="">Delete</a></span>'],nRow);
        };
    } );
     
    $('.table tbody tr td').live('click', function (e) {
        e.preventDefault();
        nRow = $(this).parents('tr')[0];
        oTable=null;
        var table=  $('tr').parents('table')[0];
        oTable =  $('#'+table['id']).dataTable();
        dataRow=oTable.fnGetData(nRow);
        row_id=dataRow[0];
        $('#id :selected').text(dataRow[1]);
        $('#number').val(dataRow[2]);
    } );
    
    $('.delete-table').live('click', function (e) {
        e.preventDefault();
        if (! confirm("Are you sure you want to delete?")){
            return;
        }
        name=$(this).attr("id");
        array=name.split("-");
        if(array.length>1){
            a=array[1];
        }
        else{
            a='';
        }
        oTable =  $('#'+a+'-table').dataTable();
        var nRow = $(this).parents('tr')[0];
        oTable.fnDeleteRow( nRow );
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
        })
    } );
    $('#category').live('change', function (e) {
        e.preventDefault();
        getDropDown('category','category-children');
    } );
    $('#category-children').live('change', function (e) {
        e.preventDefault();
        getDropDown('category-children','item');
    } );
    $('.permissions').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        array=name.split("-");
        if(array.length>1){
            a=array[0];
            c=array[1];
            b=array[2];
        }
        else{
            a=b=c='';
        }
        $("#widget-content-"+c+"-table").append('<img src="/ast/themes/img/loader.gif" alt="Uploading...."/>');
        $.seprof(baseurl,{
            name:a,
            action:'add',
            query:b
        },function(k){
            showform(k,c)
        },function(httpReq, status, exception,c){
            error(httpReq, status, exception,c)
        })
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
        })
    } );
    $('.pos').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        array=name.split("-");
        if(array.length>1){
            a=array[0];
            c=array[1];
            b=array[2];
        }
        else{
            a=b=c='';
        }
        $("#widget-content-"+c+"-table").append('<img src="/ast/themes/img/loader.gif" alt="Uploading...."/>');
        $.seprof(baseurl,{
            name:a,
            action:c,
            query:b
        },function(k){
            showform(k,a)
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a)
        })
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
        })
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
        datatable=getData(oTable,a,'id');
        var data =$('.'+a+'-form').serialize();
        $("#widget-content-"+a+"-table").append('<img src="/ast/themes/img/loader.gif" alt="Loading...."/>');
        $.seprof(baseurl,{
            name:a,
            action:'save',
            query:b,
            datainput:data,
            sequence:sequence,
            datatable:datatable
        },function(k){
            if(k.status=='error')
            {
                error('','',k.message,a)  
            }
            else if(k.status=='success')
            {
                success( k.message,a)  
            }else{
                showTable(k,a);
            }
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a);
        })
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
        })
    } );
});
function getDropDown(a,b)
{
    $.seprof(baseurl,{
        name:'categories',
        action:'get',
        query:$('#'+a).val()
    },function(k){
        showSelect(k,b)
    },function(httpReq, status, exception,a){
        error(httpReq, status, exception,a)
    });
}
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
function showSelect(b,a)
{
    $(".control-"+a).append(b); 
}
function error(httpReq, status, exception,a){

    b="<div id='block' class='alert alert-block'>"+
    "<a class='close' data-dismiss='alert' href='#'>&times;</a>"+
    exception+"</div>";
    $("#block").replaceWith(b);
    $(".alert").show();
}
function success(message,a){
    $("#block").replaceWith(message);
}
function table(name,column_hide)
{
    var table =  $('#'+name+'-table').dataTable( {
        sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
        sPaginationType: "bootstrap",
        oLanguage: {
            "sLengthMenu": "_MENU_ records per page"
        },
        bProcessing: true,
        fnDrawCallback: function () {
            $('#'+name+'-table tbody td.tdedit').editable('/ast/process.php',{
                "callback": function( sValue, y ) {
                    /* Redraw the table from the new data on the server */
                    table.fnDraw();
                },
                "height": "14px"
            } );
        }
    });
    if(column_hide!=-1){
        table.fnSetColumnVis(column_hide,false);
    }
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
function existRow(oTable,name)
{
    var nodes=oTable.fnGetNodes();
    for(var i=0;i<nodes.length;i++)
    {
        var data=oTable.fnGetData(nodes[i]);
        if(data[1]==name&&data[0]!=row_id){
            alert('already exist');
            return true;
        }
    }
    return false;
}

function getData(oTable,name,select)
{
    if(oTable==null)
    {
        oTable =  $('#'+name+'-table').dataTable();     
    }
    var nodes=oTable.fnGetNodes();
    var obj=[];
    for(var i=0;i<nodes.length;i++)
    {
        var data=oTable.fnGetData(nodes[i]);
        var idSelect=$("#"+select+" option:contains('" + $.trim(data[1]) + "')").val();
        obj[i]= {
            id:idSelect,
            number:data[2]
        };
    }
    return obj;
}