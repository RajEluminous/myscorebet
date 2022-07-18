<?php

return [

	// My controllers
	"success_store"   => "Record added",
	"success_update"  => "Updated successfully",
	"success_destroy" => "Removed successfully",

	// My Views
	"manage"       => "manage",
	"view_title"   => "View",
	"edit_title"   => "Edit",
	"delete_title" => "Delete",

	// View buttons
	"add_button"    => "Add",
	"edit_button"    => "Edit",
	"update_button"    => "Update",

	// Login, Logout ..etc
	"start_session"      => "Sign in",
	"remember_me"        => "Remember Me",
	"forgot_password"    => "Forgot your password ?",
	"login_btn"          => "Sign In",
	"reset_password"     => "Reset Password",
	"reset_password_btn" => "Send reset link",
	"connect"            => "Login",
	
	//Member constant
	"member_store"		=> "Member added successfully",
	"memeber_update"	=> "Member updated successfully",
	"member_destroy"	=> "Member deleted successfully",

	//Event constant
	"event_store"		=> "Event added successfully",
	"event_update"		=> "Event updated successfully",
	"event_destroy"		=> "Event deleted successfully",

	//Sub Event constant
	"subevent_store"	=> "Sub event added successfully",
	"subevent_update"	=> "Sub event updated successfully",
	"subevent_destroy"	=> "Sub event deleted successfully",

	//User score at frontend panel
	"user_score_saved"	=> "Predicted score saved successfully. Check My Account for all your predictions and points",

	//Front end messages
	"user_pw_link"		=> "We have e-mailed your password reset link!",
	"already_reset_pw"	=> "We already changed your password. Please login here",
	"user_reset_pw"		=> "We have changed your password. Please login here",
	"user_pw_token"		=> "Invalid token. Please login here",
	"valid_details"		=> "Please enter valid details",
	"pw_match"			=> "New password & confirm password doesnt match",
	"user_register"		=> "Thank you for registering with us. Please check your email and activate account. If you don’t see an email, check your spam/junk folder",
	"user_exist"		=> "Record already exists",

	"email_verified"		=> "Email verified. Please login here.",
	"email_not_verified"	=> "Email not verified. Please provide a valid credentials",
	"email_already_verified"=> "Email already verified. Please login here",

	//Predictions msg
	"records_not_found"    => "No records found",
	"prediction_destroy"   => "Your prediction deleted successfully",
	"member_account_destroy" => "Your account permanently deleted successfully",

	//If memebr account destroy
	"member_inactive_account"  => "Your account is inactive or not verified. If you have any questions, just email at ".env('MAIL_FROM_ADDRESS')."",
	"member_deleted_account"   => "You don't have accessed to your account. It's permanently deleted",

	//Front end login authentication msg
	"member_authentication_invalid" => "Authentication failed. Provide valid credentials",
	"member_inactive_auth_status" 	=> "Your account is inactive or not verified",

	//save winnins data
	"winning_member_invalid" => "Please select a winner",
	"winning_member" 		 => "Winners saved successfully",

	//save winnins data
	"winning_member_invalid" => "Please select a winner",
	"winning_member" 		 => "Winners saved successfully",
];
