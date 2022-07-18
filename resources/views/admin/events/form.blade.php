<?php
	//Variable declartion 
	$title = isset($objEvent) ? $objEvent->first_name: "add new event"; 
?>
{!! Form::myInput('text', 'event_name', 'Event Name*', ['maxlength' => '50']) !!}
{!! Form::myTextArea('description', 'Description', ['maxlength' => '255']) !!}
{!! Form::mySelect('month', 'Month*', config('variables.months'), NULL, ['class'=>'chosen', 'id'=>'month', 'placeholder'=>'Select Month']) !!}
{!! Form::mySelect('isActive', 'Status*', config('variables.status'), NULL, ['class'=>'chosen', 'id'=>'status']) !!}
