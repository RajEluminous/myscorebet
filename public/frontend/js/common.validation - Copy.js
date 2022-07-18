$(document).ready(function () {
	
	// Additional method for email validation
	jQuery.validator.addMethod("validate_email", function(value, element) {
		 
		if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
			return true;
		} else {
			return false;
		}
	}, "Please enter a valid Email.");

	// For alphabets only in first/last name etc.
	jQuery.validator.addMethod("lettersonly", function(value, element) {
		return this.optional(element) || /^[a-z]+$/i.test(value);
	}, "Letters only please");
	
	// Registration form validation	
    $('#frm_member_registration').validate({ // initialize the plugin
        rules: {
				first_name: {
					required: true,
					lettersonly: true
				},
				last_name: {
					required: true,
					lettersonly: true
				},
				email: {
					required: true,
					validate_email: true 
				},
				password: {
					required: true
				},
				agree: {
					required: true
				},
        },
		messages: {
				first_name: "Enter your firstname",
				last_name: "Enter your lastname",
				email: "Enter your valid email id",
				password: "Enter your password",
				agree: "Please select a checkbox to agree to the terms and conditions",
		},
		// in the "action" attribute of the form when valid
    	submitHandler: function(form) {
    		$(':input[type="submit"]').prop('disabled', true);
    		jQuery.ajax({
		      type:'POST',
		      url:postRegistrationUrl,
		      data: {
		         'first_name': $('#first_name').val(),
		         'last_name': $('#last_name').val(),
		         'email': $('#email').val(),
		         'password': $('#password').val(),
		         '_token': token
		      },
		      dataType: 'json',
    		  cache: false,
		      success:function(data){
		      	 if(data.type=='success') { //Success
		      	 	$('#display_msg').html('<div class="text-center custom-alert custom-success">'+data.msg+' <input type="button" class="btn btn-info" onclick="funcCloseMsg();" value="Got it!" /></div>');
		      	 }
		      	 else { //Error
		      	 	$('#display_msg').html('<div class="text-center custom-alert custom-danger">'+data.msg+'</div>');
		      	 }
		      	 $(':input[type="submit"]').prop('disabled', false);
		      }
		    });
    	}
    });
	
	// Login form validations
	 $('#frm_member_login').validate({ // initialize the plugin
        rules: {
				 
				email: {
					required: true,
					validate_email: true 
				},
				password: {
					required: true
				},
        },
		messages: {				 
				email: "Enter your valid email id",
				password: "Enter your password"
		}
    });

	// Myaccount Reset Password
	 $('#frm_member_myaccount').validate({ // initialize the plugin
        rules: {
				 
				old_password: {
					required: true,					 
				},
				new_password: {
					required: true
				},
				confirm_password: {
					required: true
				},
        },
		messages: {				 
				old_password: "Enter registered password",
				new_password: "Enter your new password",
				confirm_password: "Confirm your newly provided password"
		}
    });

	// Forgot password
	 $('#frm_member_forgotpassword').validate({ // initialize the plugin
        rules: {				 
				fp_useremail: {
					required: true,
					validate_email: true 
				},
        },
		messages: {				 
				fp_useremail: "Enter your registered email id"				 
		}
    });
	
	// If flash msg is open, hide it after 5 secs
	if ($(".alert-danger,.alert-success").is(":visible")) { 
	    tId=setTimeout(function(){
		  $(".alert-danger,.alert-success").slideUp();        
		}, 5000);
	}

	//Validation for reset password form
	jQuery("form[id='frm_member_resetpassword']").validate({
    // Specify validation rules
    rules: {
      	// on the right side
		fp_new_password: {
			required: true,
			minlength: 6
		},
		fp_confirm_password: {
			required: true,
			minlength: 6
		},
    },
    // Specify validation error messages
    messages: {
		fp_new_password: {
        required: "Please enter a valid password",
        minlength: "Your password must be at least 6 characters long"
      },
      fp_confirm_password: {
        required: "Please enter a valid password",
        minlength: "Your password must be at least 6 characters long"
      },
    },
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      //Password verification
      $isError                      = 0;
      var cd_user_password          = jQuery('#fp_new_password').val();
      var cd_user_confirm_password  = jQuery('#fp_confirm_password').val();
      if(cd_user_password != cd_user_confirm_password) {
        jQuery('#err_pw').html('Both password must be same');
        $isError = 1;
      }
      //If no error
      if($isError == 0) {
        form.submit();
      }
    }
  });
});

//Close div based on the button click
function funcCloseMsg() {
	location.reload();
}

//Only numbers are allowed
function checkDigit(getEle) {
	if (/\D/g.test(getEle.value)) {
	    // Filter non-digits from input value.
	    getEle.value = getEle.value.replace(/\D/g, '');
	}
}

//Delete user prediction
function funcDeletePrediction(eventid, subeventid) {

	 if(confirm('Are you sure?')) {
       $.ajax({
         type: "POST",
         url: deletePredictionUrl,
         data: {
		     'eventid': eventid,
		     'subeventid': subeventid,
		     '_token': token
	 	 },
         success: function(data)
         {
            var successHtml = '';
          	successHtml = '<div class="alert alert-success">'+data+'</div>';
            $('#display_msg').html(successHtml);
            setTimeout(function(){ 
               location.reload(); 
            }, 2000);
         }
      });
    }
}

//Validate user prediction data
function dataValidate(getId) {
	var fpFrmName 	= 'frm_userprediction_'+getId;
	var isValid1 	=  isValid2 =  0;

	$("#"+fpFrmName+" input[name='pred_score_team1[]']").each(function() {
	    var value = $(this).val();
	    if (value) {
	    	isValid1 = 1;
	    }
	});

	$("#"+fpFrmName+" input[name='pred_score_team2[]']").each(function() {
	    var value = $(this).val();
	    if (value) {
	    	isValid2 = 1;
	    }
	});

	if(isValid1==0 && isValid2==0) {
		jQuery('#err_score_'+getId).html('<p>Please enter a valid score for atleast one subevent</p>');
		return false;
	}
	else {
		jQuery('#err_score_'+getId).html('');
		var callFuncVal = function_validateArrayValues(fpFrmName); 
		if(callFuncVal==true)
			return true;
		else
			return false;
	}
}

//Validate user prediction for current form data
function function_validateArrayValues(getFrmID) {
	//Loop Team 1 Validation
	var fpFrmName 	= getFrmID;
	var isValid 	= true;

	$.each($('#'+fpFrmName+' input[name="pred_score_team1[]"]'), function(i, item) {
		var elem = $('#'+fpFrmName+' input[name="pred_score_team2[]"]')[i];
		if($.trim($('#'+fpFrmName+' input[name="pred_score_team1[]"')[i].value) != "") {
			if(elem.value) {
				$(elem).css({
	                    "border": "",
	                    "background": ""
	            });
			}
			else {
				isValid = false;
				$(elem).css({
	                    "border": "1px solid red",
	                    "background": "#FFCECE"
	                });
			}
	    }
	    else {
	    	$(elem).css({
                    "border": "",
                    "background": ""
            });

	    }
	});

	//Loop Team 2 Validation
	$.each($('#'+fpFrmName+' input[name="pred_score_team2[]"]'), function(i, item) {
		var elem = $('#'+fpFrmName+' input[name="pred_score_team1[]"]')[i];
		if($.trim($('#'+fpFrmName+' input[name="pred_score_team2[]"')[i].value) != "") {
			if(elem.value) {
				$(elem).css({
	                    "border": "",
	                    "background": ""
	            });
			}
			else {
				isValid = false;
				$(elem).css({
	                    "border": "1px solid red",
	                    "background": "#FFCECE"
	                });
			}
	    }
	    else {
	    	$(elem).css({
                    "border": "",
                    "background": ""
            });

	    }
	});

	if (isValid == false)
    	return false;
	else
		return true;
}