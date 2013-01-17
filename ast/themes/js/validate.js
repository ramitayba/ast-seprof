// 
//	jQuery Validate example script
//
//	Prepared by David Cochran
//	
//	Free for your use -- No warranties, no guarantees!
//

$(document).ready(function(){
	
    $('#register-form').validate({
	    rules: {
	      username: {
	        minlength: 10,
	        required: true
	      },
	      password: {
	        required: true
	      },
	      pincode: {
	      	minlength: 4,
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
	  
	  $('#role-form').validate({
	    rules: {
	      roles: {
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
	  
	  $('#login-form').validate({
	    rules: {
	     username: {
	        minlength: 2,
	        required: true
	      },
	      password: {
                   minlength: 2,
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
	  $('#permission-form').validate({
	    rules: {
	      roles: {
	        required: true
	      },
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
	          key: {
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
	          cafeterianame: {
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
	     name: {
	        required: true
	      },
	      parent: {
	        required: true
	      },
              description: {
	        required: true
	      },
              color: {
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
	     name: {
	        required: true
	      },
	      categories: {
	        required: true
	      },
              price: {
	        required: true
	      },
              photo: {
	        required: true
	      },
              description: {
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