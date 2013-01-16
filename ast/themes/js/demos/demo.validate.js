


$(document).ready(function(){
	
		$('#contact-form').validate({
	    rules: {
	      name: {
	        minlength: 2,
	        required: true
	      },
	      email: {
	        required: true,
	        email: true
	      },
	      subject: {
	      	minlength: 2,
	        required: true
	      },
	      message: {
	        minlength: 2,
	        required: true
	      },
	      validateSelect: {
	      	required: true
      	},
	      validateCheckbox: {
	      	required: true,
	      	minlength: 2	
      	  },
	      validateRadio: {
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
	  
}); // end document.ready

function ValidateForm(formid)
{
    
}