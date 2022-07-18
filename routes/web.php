<?php
/*
|------------------------------------------------------------------------------------
| Website Route Management
|------------------------------------------------------------------------------------
*/
/*
|------------------------------------------------------------------------------------
| Frontend
|------------------------------------------------------------------------------------
*/
Route::group(array('middleware'=>['web'],'prefix'=>''),function(){
	//For a fornt end page
  	Route::get('/','EventController@index');

	//For a Login
	Route::get('/login','LoginController@index')->name('login');
	Route::post('/login', ['uses'=>'LoginController@auth', 'as'=>'author']);

	//For a Forgot Password management
	Route::get('/forgot-password','ForgotpasswordController@index');	
	Route::post('/forgot-password','ForgotpasswordController@setpass');

	//For a reset password management
	Route::get('/reset-password/{userId}/{passToken}','ForgotpasswordController@resetPassword');
	Route::post('/reset-password','ForgotpasswordController@setNewPassword')->name('newpassword');

	//For a member registration
	Route::get('/register','RegisterController@index');

	//For a member management & verify user after registration
	Route::resource('members','MemberController');
	Route::get('/verify-email/{userId}/{userToken}','MemberController@verifyEmail');

	//Route for cron sending mail to user after 1 hour
	Route::any('/user-score-predictions-mail','CronController@userScorePridictionMailSend');

	//Tearms & condition
	Route::get('/terms-and-condition','TermsandconditionController@index')->name('termsandcondition');
	
	//Privacy policy
	Route::get('/privacy-policy','PrivacypolicyController@index')->name('privacypolicy');

	Route::get('/testmail','TestController@index');
});

//Frontend Routes with authentication
Route::group(array('middleware'=>['web','frontendauth'],'prefix'=>''),function(){

	//Save user prediction data
	Route::post('/save-predictions','EventController@index');

	//My account management
	Route::get('/myaccount','MyaccountController@index');
	Route::post('/myaccount', ['uses'=>'MyaccountController@auth', 'as'=>'myauth']);

	//Delete User Prediction	 
	Route::delete('/delete-prediction/{userPredictionId}','MyaccountController@deletePrediction')->name('deleteMemberPrediction');

	//Front end logout 
	Route::get('/logout','LoginController@logout');
	
	//Delete member account details
	Route::delete('delete-memeber-account/{id}', 'MyaccountController@deleteMemberAccount')->name('destroyMemberAccount');
});


/*
|------------------------------------------------------------------------------------
| Admin
|------------------------------------------------------------------------------------
*/
Route::get('admin', function () {
    return redirect('admin/login');
});

// Start Authentication Routes...
Route::group(array('middleware'=>['web'],'prefix'=>'admin'),function(){
	
	Route::get('login','Auth\LoginController@showLoginForm')->name('login');
	Route::post('login','Auth\LoginController@login');
	Route::post('logout','Auth\LoginController@logout')->name('logout');

	// Password Reset Routes...
	Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('passwordeditst');
	Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password/email','Auth\ResetPasswordController@reset');
});
// End Authentication Routes...

Route::group(['prefix' => ADMIN, 'as' => ADMIN . '.', 'middleware'=>['auth','web']], function() {
    
    Route::get('/', ['uses'=>'Admin\DashboardController@index', 'as'=>'dash']);

    //Memebr management at admin
    Route::resource('members', 'Admin\MemberController');
    Route::get('members/show-predictions/{userId}','Admin\MemberController@showPredictions')->name('showpredictions');

    //Event management at admin
    Route::resource('events', 'Admin\EventController');

    //Profile management at admin
    Route::get('profileedit/{id}', 'Admin\ProfileController@edit');
    Route::any('profileupdate/{id}', 'Admin\ProfileController@update');

    //Subevent management at admin
    Route::resource('subevents', 'Admin\SubeventController');
    Route::get('subevents/show-events/{eventId}','Admin\SubeventController@index')->name('showevents');

    //For reports - start
    #overall records
    Route::get('generate-reports', 'Admin\ReportController@index')->name('overallreports');
    Route::post('generate-reports', 'Admin\ReportController@index');

    #eventwise records
	Route::get('generate-event-report', 'Admin\ReportController@eventsrpt')->name('eventsreports');
    Route::post('generate-event-report', 'Admin\ReportController@eventsrpt');

    #Mothwise records
	Route::get('generate-month-report', 'Admin\ReportController@monthrpt')->name('monthreports');
    Route::post('generate-month-report', 'Admin\ReportController@monthrpt');
    //For reports - end

    #Winnner records
    Route::get('winners-selection', 'Admin\WinnersController@saveLastMonthWinners')->name('winnersselection');
    Route::post('winners-selection', 'Admin\WinnersController@saveLastMonthWinners');
});
