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
    $('#cafeterias-table a.edit').live('click', function (e) {
        e.preventDefault();
        /* Get the row as a parent of the link that was clicked on */
        var nRow = $(this).parents('tr')[0];
         
        /* A different row is being edited - the edit should be cancelled and this row edited */
        var aData = oTable.fnGetData(nRow);
    /*oTable.fnServerData("/ast/controller/cafeteriasController.php",
        {action:"edit",},editRow(oTable,nRow));
    })*/
    } );
    
    $('a.delete').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        array=name.split("-");
        a=array[1];
        if(array.length>1){
            a=array[1];
            b=array[2];
        }
        else{
            a='';
            b='';
        }
        $.seprof(baseurl,{
            name:a,
            action:'delete',
            query:b
        },function(k){
            if(k.status=='error')
            {
                error('','', k.message,a)  
            }else{
                oTable.fnDeleteRow();
            }
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a);
        },"json")
    } );
    
    $('.new').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        array=name.split("-");
        a=array[1];
        $("#widget-content-"+a+"-table").append('<img src="/ast/themes/img/loader.gif" alt="Uploading...."/>');
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
    
    $('.edit').live('click', function (e) {
        e.preventDefault();
        name=$(this).attr("id");
        array=name.split("-");
        a=array[1];
        alert(baseurl);
        $("#widget-content-"+a+"-table").append('<img src="/ast/themes/img/loader.gif" alt="Uploading...."/>');
        $.seprof(baseurl,{
            name:a,
            action:'edit',
            query:''
        },function(k){
            showform(k,a)
        },function(httpReq, status, exception,a){
            error(httpReq, status, exception,a)
        },"json")
    } );
    
    $('.save').live('click', function () {
        if(!validate())return;
        name=$(this).attr("id");
        array=name.split("-");
        a=array[1];
        if(array.length>1){
            a=array[1];
            b=array[2];
        }
        else{
            a='';
            b='';
        }
        var data =$('.'+a+'-form').serialize();
        $("#widget-content-"+a+"-table").append('<img src="/ast/themes/img/loader.gif" alt="Uploading...."/>');
        $.seprof(baseurl,{
            name:a,
            action:'save',
            query:b,
            datainput:data
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
    $(".widget-header").hide();
    $("#widget-content-"+a+"-table").replaceWith(b); 
    $("#widget-content-"+a+"-table img:last-child").remove();
}

function showTable(b,a)
{
    // alert(b);
    if(b !=null){
        $(".widget-form").replaceWith(b); 
        $(".widget-header").show();
        $("#widget-"+a+"-form img:last-child").remove();
    }
}

function error(httpReq, status, exception,a){
// alert(exception);
// b="<div class=error-callback>Please try again,reload the page</div>";
//$("#widget-content-"+a+"-table").replaceWith(b);
}

function table(name)
{
    var table =  $('#'+name+'-table').dataTable( {
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
}