<?php
	//Variable declartion 
	$title = isset($objSubevent) ? $objSubevent->id: "add new sub event";
	$img_logo1_url = (isset($objSubevent->logo_team1) ? url('public/') . config('variables.images.public') . $objSubevent->logo_team1 : url('public/') . config('variables.avatar.public') . 'avatar0.png');
	$img_logo2_url = (isset($objSubevent->logo_team2) ? url('public/') . config('variables.images.public') . $objSubevent->logo_team2 : url('public/') . config('variables.avatar.public') . 'avatar0.png');
	$strExpiredTime = isset($objSubevent) ? $objSubevent->expiry_datetime: now();

	//Score of team1 and team2
	$intScoreTeam1  = isset($objSubevent->score_team1) ? '1' : '';
	$intScoreTeam2  = isset($objSubevent->score_team2) ? '1' : '';

	//Check ow and expired date are same or not
	$strExpiredTimeValid = '';
	if(isset($objSubevent->expiry_datetime)) {
		$strGetTime =  date('Y-m-d H:i:s', strtotime($objSubevent->expiry_datetime));
		$strExpiredTimeValid = ($strGetTime >= date('Y-m-d H:i:s')) ? '': '1';
	}
?>

{!! Form::mySelect('eventid', 'Event*', $arrEvents, NULL, ['class'=>'chosen', 'id'=>'eventid', 'placeholder'=>'Select Event']) !!}
{!! Form::myInput('text', 'name_team1', 'Team Name1*', ['maxlength' => '50']) !!}
{!! Form::myInput('text', 'name_team2', 'Team Name2*', ['maxlength' => '50']) !!}
{!! Form::myFileImage('logo_team1', 'Logo Team1', $img_logo1_url) !!}
{!! Form::myFileImage('logo_team2', 'Logo Team2', $img_logo2_url) !!}

{{ Form::hidden('fpIsScoreValid', $strExpiredTimeValid, array('id' => 'fpIsScoreValid')) }}
@if($strExpiredTimeValid=='1')
	@if($intScoreTeam1=='' AND $intScoreTeam2=='')
		{!! Form::myInput('text', 'score_team1', 'Score Team1*', ['onKeyUp' => 'checkDigit(this)','maxlength' => '2']) !!}
		{!! Form::myInput('text', 'score_team2', 'Score Team2*', ['onKeyUp' => 'checkDigit(this)','maxlength' => '2']) !!}
	@else
		{!! Form::myInput('text', 'score_team1', 'Score Team1*', ['readonly'], $objSubevent->score_team1) !!}
        {!! Form::myInput('text', 'score_team2', 'Score Team2*', ['readonly'], $objSubevent->score_team2) !!}
	@endif
@endif

@if($strExpiredTimeValid=='1')
	{!! Form::myInput('text', 'old_expiry_datetime', 'Expiry Time*', ['readonly'], date('d-m-Y h:i A', strtotime( $strExpiredTime ))) !!}
@else
	{!! Form::myDateTimepickerInput('text', 'expiry_datetime', 'Expiry Time*', ['size'=> '16', 'readonly'], date('d-m-Y h:i A', strtotime( $strExpiredTime )), 'event_time ') !!}
@endif

{!! Form::mySelect('isActive', 'Status*', $arrStatus, NULL, ['class'=>'chosen', 'id'=>'status']) !!}
