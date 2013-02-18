var dataRow, nRow,oTable,columnSearch,anOpenCategories = [],anOpenSubCategories = [],requiredUsername=true,requiredPassword=true,requiredPincode=true,resetForm,requiredSelect=true;
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
    $('a.delete').live('click', function (e) {
        e.preventDefault(); 
        if (! confirm("Are you sure you want to delete?")){
            return;
        }
        name=$(this).attr("id");
        if(name=='')return;
        array=name.split("-");
        if(array.length>1){
            a=array[1];
            b=array[2];
            if(a==''||b=='')
            {
                return;
            }
        }
        else{
            a=b='';
            return;
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
                errorBefore(k.message);
            }else if(k.status=='success')
            {
                if ( nRow!=null ) {
                    $(".messages").remove();
                    oTable.fnDeleteRow( nRow );
                    $(".widget").before(k.message);
                }
            }else
            {
                replaceTable(k,a); 
            }
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a);
        })
    } );
    $('.add').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        if(name=='')return;
        array=name.split("-");
        if(array.length>1){
            a=array[1];
            if(a=='')
            {
                return;
            }
        }
        else{
            a='';
            return;
        }
        if($('#id').length==0)return;
        oTable =  $('#'+a+'-table').dataTable();
        if(existRow(oTable,$('#id').val()))
        {
            return;
        }
        if($('#number').val()==''||$('#id option:selected').val()=='')return;
        oTable.fnAddData([$('#id option:selected').val(),$('#id option:selected').text(),$('#number').val(),'<span class="content-link"><a class="delete-table " id="delete-'+a+'" href="" title="Delete"></a></span>']);
        $('#'+a+'-table tr td:nth-child(2)').addClass('tdedit');
        $('#'+a+'-table tr td:nth-child(3)').addClass('controls');
        oTable.fnDraw();
        $('#category').val('');
        $('.add').disabled=true;
        $('.control-category-children').remove();
        $('.control-item').remove();
        $('#id').val('');
        $('#number').val('');  
    } );
    $('#categories-table tbody tr td.control-category').live( 'click', function (e) {
        e.preventDefault();
        nRow = $(this).parents('tr')[0];
        var nTr = this.parentNode;
        var table=  $(this).parents('table')[0];
        oTable =  $('#'+table['id']).dataTable();
        dataRow=oTable.fnGetData(nTr);
        var i = $.inArray( nTr, anOpenCategories );
   
        if ( i === -1 ) {
            if($('.details').parents('tr').length==0)
            {
                fnNestedTable(dataRow[1],oTable,nTr,anOpenCategories,'sub-categories');
                $('img', this).attr( 'src', sImageUrl+"details_close.png" );
            }
            else
            {
                anOpenCategories.push( nTr );
                $('.sub-categories #widget-table', $(nTr).next()[0]).css('display', 'block');
            }
        }
        else {
            $('img', this).attr( 'src', sImageUrl+"details_open.png" );
            $('#widget-table', $(nTr).next()[0]).slideUp( function () {
                oTable.fnClose( nTr );
                oTable.fnClose($('.sub-categories'));
                anOpenCategories.splice( i, 1 );
            } );
            $('.sub-categories #widget-table', $(nTr).next()[0]).css('display', 'none');
        }
    } );
    
    $('.category-Children-table tbody tr td.control-sub-category').live( 'click', function (e) {
        e.preventDefault();
        nRow = $(this).parents('tr')[0];
        var nTr = this.parentNode;
        var table=  $(this).parents('table')[0];
        oTable =  $('#'+table['id']).dataTable();
        dataRow=oTable.fnGetData(nTr);
        var i = $.inArray( nTr, anOpenSubCategories );
        if ( i === -1 ) {
            if($('.details').parents('tr').length==0)
            {
                fnNestedTable(dataRow[1],oTable,nTr,anOpenSubCategories,'items');
                $('img', this).attr( 'src', sImageUrl+"details_close.png" );
            }
            else
            {
                /*var data=$('.details').html();
                $('.details').parents('tr').show();
                oTable.fnOpen( nTr, data, 'details' );
                anOpen.push( nTr );
                $('.details #widget-table', $(nTr).next()[0]).css('display', 'block');
            }*/
                /* if($('.details').parents('tr').length>0)
            {
                $('.details').parents('tr').remove();     
            }*/
                anOpenSubCategories.push( nTr );
                $('.items #widget-table', $(nTr).next()[0]).css('display', 'block');
            }
        }
        else {
            $('img', this).attr( 'src', sImageUrl+"details_open.png" );
            $('#widget-table', $(nTr).next()[0]).slideUp( function () {
                oTable.fnClose( nTr );
                oTable.fnClose($('.items'));
                anOpenSubCategories.splice( i, 1 );
            } );
        }
    } );
 
    $('.delete-table').live('click', function (e) {
        e.preventDefault();
        if (! confirm("Are you sure you want to delete?")){
            return;
        }
        name=$(this).attr("id");
        if(name=='')return;
        array=name.split("-");
        if(array.length>1){
            a=array[1];
            if(a=='')
            {
                return;
            }
        }
        else{
            a='';
            return;
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
        if(name=='')return;
        array=name.split("-");
        if(array.length>1){
            a=array[1];
            if(a=='')
            {
                return;
            }
        }
        else{
            a='';
            return;
        }
        a=array[1];
        $("#widget-content-"+a+"-table").html('<div align="center" style="width:'+width+';height:'+height+'"><img src="'+sImageUrl+'loader.gif" alt="Loading...."/></div>');
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
        $('.add').disabled=true;
        $('.control-category-children').remove();
        $('.control-item').remove();
        getDropDown('category');
    } );
    $('#category-children').live('change', function (e) {
        e.preventDefault();
        $('.control-item').remove();
        getDropDown('category-children');
    } );
    $('#roles').live('change', function (e) {
        resetValidateForm();
        var value=$('#roles').val();
        if (value==1 ||value==4){
            $('#pincode').attr('disabled','disabled').toggleClass('disabled');
            $('#pincode').val('');
            $('#username').removeAttr('disabled');
            $('#password').removeAttr('disabled');
            requiredUsername=true;
            requiredPassword=true;
            requiredPincode=false;
        }
        else if(value==3)
        {
            $('#username').attr('disabled','disabled').toggleClass('disabled');
            $('#username').val('');
            $('#password').attr('disabled','disabled').toggleClass('disabled');
            $('#password').val('');
            $('#pincode').removeAttr('disabled');
            requiredUsername=false;
            requiredPassword=false;
            requiredPincode=true;
        }else{
            $('#pincode').removeAttr('disabled');
            $('#username').removeAttr('disabled');
            $('#password').removeAttr('disabled');
            requiredUsername=true;
            requiredPassword=true;
            requiredPincode=true;
        }
    } );
    $('.permissions').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        if(name=='')return;
        array=name.split("-");
        if(array.length==3){
            a=array[0];
            c=array[1];
            b=array[2];
            if(a==''||b==''||c=='')
            {
                return;
            }
        }
        else{
            a=b=c='';
            return;
        }
        var width=$('.widget-table').height();
        var height=$('.widget-table').width();
        $("#widget-content-"+c+"-table").append('<div align="center" style="width:'+width+';height:'+height+'"><img src="'+sImageUrl+'loader.gif" alt="Loading...."/></div>');
        $.seprof(baseurl,{
            name:a,
            action:'add',
            query:b
        },function(k){
            if(k.status=='error')
            {
                errorBefore(k.message,"#widget-content-"+c+"-table");
            }else{
                showform(k,c);
            }
        },function(httpReq, status, exception,c){
            error(httpReq, status, exception,c)
        })
    } );
    $('.show-reports').live('click', function (e) {
        name=$(this).attr("id");
        var width=$('.widget-content').height();
        var height=$('.widget-content').width();
        $("#widget-content").html('<div align="center" style="width:'+width+';height:'+height+'"><img src="'+sImageUrl+'"loader.gif" alt="Loading...."/></div>');
        if(!validateReport(name,'show',e)){
            return;
        }
    } );
    $('.back').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        var width=$('.widget-content').height();
        var height=$('.widget-content').width();
        $("#widget-content").html('<div align="center" style="width:'+width+';height:'+height+'"><img src="'+sImageUrl+'loader.gif" alt="Loading...."/></div>');
        $.seprof(baseurl,{
            name:'reports',
            action:name,
            query:'back'
        },function(k){
            showFormPrepareReports(k);
        },function(httpReq, status, exception,c){
            error(httpReq, status, exception,c)
        })
    } );
    $('.back-preview').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        if(name=='')return;
        array=name.split("-");
        if(array.length==4){
            a=array[1];
            c=array[2];
            b=array[3];
            if(a==''||b==''||c=='')
            {
                return;
            }
        }
        else{
            a=b=c='';
            return;
        }
        $.seprof(baseurl,{
            name:c,
            action:a,
            query:b
        },function(k){
            $('#header').show();
            $('#nav').show();
            $('#page-title').show();
            $('#footer').show();
            $('.content-preview').replaceWith(k);
        },function(httpReq, status, exception,c){
            error(httpReq, status, exception,c)
        })
    } );
    $('.print').live('click', function (e) {
        e.preventDefault();
        $('.form-actions').hide();
        $('#header-container').css('background-color','#263849');
        window.print();
        $('.form-actions').show();
    } );
    $('.pos').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        if(name=='')return;
        array=name.split("-");
        if(array.length==3){
            a=array[0];
            c=array[1];
            b=array[2];
            if(a==''||b==''||c=='')
            {
                return;
            }
        }
        else{
            a=b=c='';
            return;
        }
        $("#widget-content-"+c+"-table").append('<img src="'+sImageUrl+'loader.gif" alt="Uploading...."/>');
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
        if(name=='')return;
        array=name.split("-");
        if(array.length>1){
            a=array[1];
            b=array.length==4?array[3]:array[2];
            if(a==''||b=='')
            {
                return;
            }
        }
        else{
            a= b='';
            return;
        }
        $("#widget-content-"+a+"-table").append('<img src="'+sImageUrl+'loader.gif" alt="Uploading...."/>');
        $.seprof(baseurl,{
            name:a,
            action:'edit',
            query:b
        },function(k){
            if(k.status=='error')
            {
                errorBefore(k.message,"#widget-content-"+a+"-table");
            }else{
                showform(k,a);
            }
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a)
        })
    } );
    $('.approved').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        if(name=='')return;
        array=name.split("-");
        if(array.length>1){
            a=array[1];
            b=array[2];
            if(a==''||b=='')
            {
                return;
            }
        }
        else{
            a=b='';
            return;
        }
        $.seprof(baseurl,{
            name:a,
            action:'approved',
            query:b
        },function(k){
            if(k.status=='error')
            {
                error('','',k.message,a)  
            }
            else 
            {
                $('.messages').remove();
                replaceTable(k,a);
            }
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a)
        })
    } );
    $('.rejected').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        if(name=='')return;
        array=name.split("-");
        if(array.length>1){
            a=array[1];
            b=array[2];
            if(a==''||b=='')
            {
                return;
            }
        }
        else{
            a=b='';
            return;
        }
        $.seprof(baseurl,{
            name:a,
            action:'rejected',
            query:b
        },function(k){
            if(k.status=='error')
            {
                error('','',k.message,a)  
            }
            else 
            {
                $('.messages').remove();
                replaceTable(k,a);
            }
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a)
        })
    } );
    $('.save').live('click', function (e) {
        name=$(this).attr("id");
        if(name=='')return;
        array=name.split("-");
        if(array.length>1){
            a=array[1];
            b=array[2];
            if(a=='')
            {
                return;
            }
        }
        else{
            a=b='';
            return;
        }
        if(!validate(a,b,e)){
            return;
        }
    } ); 
    $('#checkall').live('change', function (e) {
        if($('#checkall').is(':checked')){
            $("#checkall").val(1);
        }
        else
        {
            $("#checkall").val(0);
        }

    });
    $('.cancel').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        if(name=='')return;
        array=name.split("-");
        if(array.length>1){
            a=array[1];
            if(a=='')
            {
                return;
            }
        }
        else{
            a='';
            return;
        }
        $("#widget-"+a+"-form").append('<img src="'+sImageUrl+'loader.gif" alt="Uploading...."/>');
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
    jQuery.validator.addMethod("customdate", function(value, element) { 
        return this.optional(element) || /^\d{1,2}[\/-]\d{1,2}[\/-]\d{4}$/.test(value); 
    }, "Please specify the date in DD/MM/YYYY  format");
    jQuery.validator.addMethod("validateUsername", function(value, element) { 
        return this.optional(element)|| /^[a-zA-Z0-9\-\_\+\.]+$/.test(value); 
    }, "Username may contain only letters,numbers and ./+/-/_ characters.");
     jQuery.validator.addMethod("validateStartUsername", function(value, element) { 
        return this.optional(element)||value.substr(0, 1).match(/[A-Za-z]/) != null;
    }, "Username start only  by letters.");
        $('.dataTables_filter input').live('keyup change',function (e) {
            e.preventDefault();
            var val = $(this).val();
            oTable.fnFilter("^"+val,columnSearch,true,false,false,false);
            oTable.fnDraw();
        });
        
        $("#checkallpermission").live('change', function (e) {
              e.preventDefault();
                if($(this).prop('checked')){
                    $(".checkbox").addClass('checked');
                     $(".check").attr("checked", true);
                }else{
                    $(".checkbox").removeClass('checked');
                    $(".check").attr("checked", false);
                }});
});
function getDropDown(a)
{
    $.seprof(baseurl,{
        name:'categories',
        action:'get',
        query:$('#'+a).val()
    },function(k){
        showSelect(k,a)
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
        $('.widget-form').replaceWith(b);
        $("#widget-"+a+"-form img:last-child").remove();
    }
}
function replaceTable(b,a)
{
    $(".messages").remove();
    if(b !=null){
        $('#widget-table').replaceWith(b);
    }
}
function showReports(k)
{
    $('.widget-content').replaceWith(k);
}
function showFormPrepareReports(k)
{
    $('.span12').replaceWith(k);
}
function showSelect(b,a)
{
    if(b!=null)
    {
        $(".control-"+a).append(b); 
    }
}
function error(httpReq, status, exception,a){

    resetValidateForm();
    b="<div id='block' class='alert alert-block'>"+
    "<a class='close' data-dismiss='alert' href='#'>&times;</a>"+
    exception+"</div>";
    $("#widget-content-"+a+"-table img:last-child").remove();
    $("#block").replaceWith(b);
    $(".alert").show();
    $('.control-group.show-error').addClass('error');
}
function success(message,a){
    $("#block").replaceWith(message);
}
function table(name,sdom,column_hide,editable,columnsearch)
{
    var table=sdom!='rt'?tableRLFTIP(name,sdom,column_hide,editable):tableRT(name,sdom,column_hide,editable); 
    if(column_hide!=-1){
        table.fnSetColumnVis(column_hide,false);
    }
    $('#'+editable+'-table tbody td.tdedit input').live('keypress', function (e) {
        var value=$('#'+editable+'-table tbody td.tdedit input').val();
        var arr= value.split('.');
        /* var success=true;
        if(value!='')
        {
            success =isNumberKey(e)&&$.isNumeric(value);
        }
        return success;*/
        var dot=editable=='allowances'?1:0;
        return isNumberKey(e,dot)&&arr.length<3;
    })
    columnSearch=columnsearch;
    //table.fnUpdate(oSettings);
    return table;
}
function tableRLFTIP(name,sdom,column_hide,editable)
{
    var tableRLFTIP =  $('#'+name+'-table').dataTable( {
        sDom:sdom,//;"<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",//"rlfrtip"//
        sPaginationType: "bootstrap",
        bLengthChange:true,
        bPaginate:true,
        bStateSave: false, 
        bRetrieve: true,
        bProcessing: true,
        fnDrawCallback: function () {
            $('#'+editable+'-table tbody td.tdedit').editable(baseurl+'?name='+editable+'&action=save',{
                "callback": function( sValue, y ) {
                    oTable.fnUpdate([ dataRow[0], dataRow[1],sValue] );
                },
                "submitdata": function ( value, settings ) {
                    nRow = $(this).parents('tr')[0];
                    dataRow=oTable.fnGetData(nRow);
                    $("#id").val(dataRow[0]);
                },
                "formid":"formeditable",
                "height": "14px"
            } );
        }
    });
    return tableRLFTIP;
}
function tableRT(name,sdom,column_hide,editable)
{
    var tableRT =  $('#'+name+'-table').dataTable( {
        sDom:sdom,//;"<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",//"rlfrtip"//
        sPaginationType: "bootstrap",
        bLengthChange:true,
        bPaginate:true,
        iDisplayLength :200,
        bStateSave: false, 
        bRetrieve: true,
        bProcessing: true,
        fnDrawCallback: function () {
            $('#'+editable+'-table tbody td.tdedit').editable(baseurl+'?name='+editable+'&action=save',{
                "callback": function( sValue, y ) {
                    oTable.fnUpdate([ dataRow[0], dataRow[1],sValue] );
                },
                "submitdata": function ( value, settings ) {
                    nRow = $(this).parents('tr')[0];
                    dataRow=oTable.fnGetData(nRow);
                    $("#id").val(dataRow[0]);
                },
                "formid":"formeditable",
                "height": "14px"
            } );
        }
    });
    return tableRT;
}
function checkMaxLength(textareaID, maxLength){

    currentLengthInTextarea = $("#"+textareaID).val().length;
    $(remainingLengthTempId).text(parseInt(maxLength) - parseInt(currentLengthInTextarea));

    if (currentLengthInTextarea > (maxLength)) {

        // Trim the field current length over the maxlength.
        $("textarea#comment").val($("textarea#comment").val().slice(0, maxLength));
        $(remainingLengthTempId).text(0);

    }
}
function validateRoles(a,b)
{
    resetForm= $('#roles-form').validate({
        rules: {
            role_name: {
                required: true,
                maxlength:100
            },
            status:{
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
        },
        submitHandler: function (form) {
            ajaxSubhmit(a,b);
        }
    });
}
function validatePermissions(a,b)
{
    $('#permissions-form').validate({
        focusCleanup: false,
        submitHandler: function (form) {
            ajaxSubhmit(a,b);
        }
    });
}
function validatePos(a,b)
{
    resetForm= $('#pos-form').validate({
        rules: {
            pos_key: {
                required: true,
                maxlength:150
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
        },
        submitHandler: function (form) {
            ajaxSubhmit(a,b);
        }
    });
}
function vaidateCafeterias(a,b)
{
    resetForm= $('#cafeterias-form').validate({
        rules: {
            cafeteria_name: {
                required: true,
                maxlength:50
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
        },
        submitHandler: function (form) {
            ajaxSubhmit(a,b);
        }
    });
}
function vaidateCategories(a,b)
{
    resetForm=  $('#categories-form').validate({
        rules: {
            category_name: {
                required: true,
                maxlength:100
            },
            status: {
                required: true
            },
            color_code: {
                required: true,
                maxlength:7
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
        },
        submitHandler: function (form) {
            ajaxSubhmit(a,b);
        }
    });
}
function validateItems(a,b)
{
    resetForm=$('#items-form').validate({
        rules: {
            item_name: {
                required: true,
                maxlength:100
            },
            category: {
                required: true
            },
            item_price: {
                required: true,
                maxlength:18,
                number:true
            },
            status: {
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
        },
        submitHandler: function (form) {
            ajaxSubhmit(a,b);
        }
    }); 
}
function validateEvents(a,b,e)
{
    resetForm= $('#events-form').validate({
        rules: {
            event_name: {
                required: true,
                maxlength:50
            },
            event_date: {
                required: true
            },
            event_invitees_nb: {
                required: true,
                maxlength:9,
                number:true
            },
            department: {
                required: true
            },
            employee: {
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
        },
        submitHandler: function (form) {
            var date=new Date();
            var dateevent=processDateTime($('#event_date').val());
            if(dateevent <date )
            {
                $('.control-date').removeClass('success');
                $('.control-date').addClass('error');
                $('.date .error').remove();
                $('#datetimepicker').after('<label for="datepicker" generated="true" class="error" style="">Must be greater than Date</label>');
                e.preventDefault();
                return false;           
            }else{
                $('.date .error').remove();
            }
            ajaxSubhmit(a,b);
        }
    });
}
function validateAllowance(a,b)
{
    resetForm=   $('#allowances-form').validate({
        rules: {
            max_debit: {
                required: true,
                maxlength:18,
                number:true
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
        },
        submitHandler: function (form) {
            ajaxSubhmit(a,b);
        }
    });
}
function validateUsers(a,b)
{
    resetForm=$('#users-form').validate({
        rules: {
            user_name: {
                required: requiredUsername,
                maxlength:50,
                validateUsername:true,
                validateStartUsername:true
            },
            user_password: {
                required: requiredPassword,
                maxlength:50,
                minlength:6
            },
            user_pin: {
                required: requiredPincode,
                maxlength:4
            },
            roles: {
                required: true
            },
            employees: {
                required: true
            },
            status: {
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
        },
        submitHandler: function (form) {
            if(a!='' || b!=''){
                ajaxSubhmit(a,b);
            }
        }
    });
}
function validate(a,b,e)
{
    switch(a)
    {
        case 'users':
            validateUsers(a,b);
            break;
        case 'roles':
            validateRoles(a,b);
            break;
        case 'permissions':
            validatePermissions(a,b);
            break;
        case 'categories':
            vaidateCategories(a,b);
            break;
        case 'items':
            validateItems(a,b);
            break;
        case 'pos':
            validatePos(a,b);
            break;
        case 'allowance':
            validateAllowance(a,b);
            break;
        case 'events':
            validateEvents(a,b,e);
            break;
        case 'cafeterias':
            vaidateCafeterias(a,b);
            break;
        default:
            break;
    }
}
function processDateTime(date){
    var parts = date.split(" ");
    var time=parts[1].split(":");
    parts = parts[0].split("/");
    return new Date(parts[2], parts[1] - 1, parts[0],time[0],time[1],time[2]);
}
function processDate(date){
    var parts = date.split("/");
    if(parts.length>2)
    {
        return new Date(parts[2], parts[1] - 1, parts[0]);
    }else return '';
}
function isNumberKey(evt,dot)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if(dot==1&&charCode==46)return true;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
function denySpace(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    return charCode!=32;
}
function existRow(oTable,value)
{
    var nodes=oTable.fnGetNodes();
    for(var i=0;i<nodes.length;i++)
    {
        var data=oTable.fnGetData(nodes[i]);
        if(data[0]==value){
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
        var idSelect=data[0];
        obj[i]= {
            items_event:{
                id:idSelect,
                number:data[2]
            }
        };
    }
    return obj;
}
function ajaxSubhmit(a,b)
{
    var sequence="";
    $('input[name=check]:checked').each(function(){
        sequence+=$(this).val()+",";
    });
    datatable=getData(oTable,a,'id');
    var data='';// =decodeURIComponent($('.'+a+'-form').serialize());
    var element;
    $("form :input[type='text'],[type='password'],[type='checkbox'],select,textarea,datetime").each(function(index, elm){
        element=elm.name+'='+$(elm).val()+'&';
        data+=element;
    });
    $("#widget-content-"+a+"-table").append('<img src="'+sImageUrl+'loader.gif" alt="Loading...."/>');
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
    });
}
function validateCafeteriaReport(a,c)
{
    resetForm=$('#cafeteria-balance-form').validate({
        rules: {
            filter_select: {
                required: requiredSelect
            },
            mindate:{
                required: true,
                customdate: true
            },
            maxdate:{
                required: true,
                customdate: true
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
        },
        submitHandler: function (form) {
            ajaxReport(a,c);
        }
    });  
}
function validateUserReport(a,c)
{
    resetForm=$('#user-purchases-form').validate({
        rules: {
            mindate:{
                required: true,
                customdate: true
            },
            maxdate:{
                required: true,
                customdate: true
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
        },
        submitHandler: function (form) {
            ajaxReport(a,c);
        }
    });
}
function validatePurchasesReport(a,c)
{
    resetForm=$('#purchases-inventory-form').validate({
        rules: {
            mindate:{
                required: true,
                customdate: true
            },
            maxdate:{
                required: true,
                customdate: true
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
        },
        submitHandler: function (form) {
            ajaxReport(a,c);
        }
    }); 
}
function validateDetailedUserReport(a,c)
{
    resetForm= $('#detailed-user-purchases-form').validate({
        rules: {
            filter_select:{
                required: true
            },
            mindate:{
                required: true,
                customdate: true
            },
            maxdate:{
                required: true,
                customdate: true
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
        },
        submitHandler: function (form) {
            ajaxReport(a,c);
        }
    });
}
function validateEventReport(a,c)
{
    resetForm= $('#events-listing-form').validate({
        rules: {
            mindate:{
                required: true,
                customdate: true
            },
            maxdate:{
                required: true,
                customdate: true
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
        },
        submitHandler: function (form) {
            ajaxReport(a,c);
        }
    }); 
}
function validateDetailedEventReport(a,c)
{
    resetForm= $('#detailed-event-form').validate({
        rules: {
            filter_select: {
                required: requiredSelect
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
        },
        submitHandler: function (form) {
            ajaxReport(a,c);
        }
    });
}
function validateMenuReport(a,c)
{
    resetForm= $('#menu-report-form').validate({
        submitHandler: function (form) {
            ajaxReport(a,c);
        }
    });
}
function validateReport(a,c,e)
{
    resetValidateForm();
    if($('#mindate').length>0 ||$('#maxdate').length){
        var from=processDate($('#mindate').val())
        var to=processDate($('#maxdate').val());
        if( from >to )
        {
            $('#datetimepickermax .error').remove();
            $('.date .error').remove();
            $('#datetimepickermax').after('<label for="maxdate" generated="true" class="error" style="">Must be greater than From Date</label>');
            e.preventDefault();
            return ;           
        }else{
            $('#datetimepickermax .error').remove();
        }  
    }
    switch(a)
    {
        case 'menu-report':
            validateMenuReport(a,c);
            break;
        case 'detailed-event':
            validateDetailedEventReport(a,c);
            break;
        case 'events-listing':
            validateEventReport(a,c);
            break;
        case 'detailed-user-purchases':
            validateDetailedUserReport(a,c);
            break;
        case 'purchases-inventory':
            validatePurchasesReport(a,c);
            break;
        case 'user-purchases':
            validateUserReport(a,c);
            break;
        case 'cafeteria-balance':
            validateCafeteriaReport(a,c);
            break;
        default:
            break;
    }
}
function ajaxReport(name,query)
{
    var data='';// =decodeURIComponent($('#'+name+'-form').serialize());
    var element;
    $("form :input[type='text'],[type='checkbox'],select").each(function(index, elm){
        element=elm.name+'='+$(elm).val()+'&';
        data+=element;
    });
    if($('#filter_select').length!=0){
        data+="select="+$('#filter_select option:selected').text();
    }
    $.seprof(baseurl,{
        name:'reports',
        action:name,
        query:query,
        datainput:data
    },function(k){
        showReports(k);
    },function(httpReq, status, exception,c){
        error(httpReq, status, exception,c)
    })
}
function enable_text(status,links)
{
    requiredSelect=links.disabled=!status;
}
function enable_allowance(status)
{
    if(status){
        $('.form-actions').show();
    }
    else{
        $('.form-actions').hide();
    }
    $('#save-allowances').attr('disabled',!status);
    if(status){
        $('#widget-table').hide();
    }else{
        $('#widget-table').show(); 
    }
}
function fnNestedTable(id,oTable,nTr,anOpen,name )
{
    $.seprof(baseurl,{
        name:'categories',
        action:'nested',
        query:id
    },function(data){
        var nDetailsRow=oTable.fnOpen( nTr, data, name );
        $('#widget-table', nDetailsRow).show('slow');
        anOpen.push( nTr );
    });
}
function errorBefore(message,name)
{
    $(name+" img:last-child").remove();
    $('.messages').remove();
    $( '.widget').before(message)  ;
}
function getDateTime(d){
    // padding function
    var s = function(a,b){
        return(1e15+a+"").slice(-b)
    };

    // default date parameter
    if (typeof d === 'undefined'){
        d = new Date();
    };
    return s(d. getDate(),2)+ '/' +
    s(d.getMonth()+1,2) + '/' +
    d.getFullYear()+ ' ' +
    s(d.getHours(),2) + ':' +
    s(d.getMinutes(),2) + ':' +
    s(d.getSeconds(),2);
}
function resetValidateForm()
{
    if(resetForm!=null)
    {
        resetForm.resetForm();
        resetForm.hideErrors();
        resetForm.clean();
    }
    $('.control-group').removeClass('error');
    $('.control-group').removeClass('success');
}