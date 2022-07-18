<?php $title = isset($arrMembers) ? $arrMembers->first_name: "add new member" ?>
{!! Form::myInput('text', 'first_name', 'First Name*', ['maxlength' => '35']) !!}
{!! Form::myInput('text', 'last_name', 'Last Name*', ['maxlength' => '35']) !!}
{!! Form::myInput('text', 'email', 'Email*', ['readonly']) !!}
<div class="form-group"><br/>
	<label for="new password">New Password</label>
	<button type="button" name="fp_btn_generate_new_pw" id="fp_btn_generate_new_pw" class="btn fp_btn_generate_new_pw">Generate Password</button>
	{!! Form::input('password', 'fp_txt_generate_new_pw', '',array('id' => 'fp_txt_generate_new_pw', 'class' => 'form-control hide-control', 'autocomplete' => 'off' )) !!}
	<span class="text-danger" id="fp_err_new_pw"></span>
</div>
{!! Form::mySelect('isActive', 'Status*', config('variables.status'), NULL, ['class'=>'chosen', 'id'=>'status']) !!}
