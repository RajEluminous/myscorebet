<?php
Form::macro('myInput', function($type="text", $name, $label="", $options=[], $default = null)
{    
    $label = ($label =='') ? '' : html_entity_decode(Form::label($name, $label));

    $errors = Session::get('errors', new Illuminate\Support\MessageBag);
    $strErrorClass = '';
    if($errors->first($name))
    {
        $strErrorClass = 'has-error';       
    }

    return "
        <div class='form-group ".$strErrorClass."' >
            ". $label .
              Form::input($type, $name, $default, array_merge(["class" => "form-control"], $options)). "
              <span class='text-danger'>".$errors->first($name)."</span>
        </div>
    ";
});

Form::macro('myTimepickerInput', function($type="text", $name, $label="", $options=[], $default = null, $class="")
{
    $label = ($label =='') ? '' : html_entity_decode(Form::label($name, $label));
    $errors = Session::get('errors', new Illuminate\Support\MessageBag);
    $strErrorClass = '';
    if($errors->first($name))
    {
        $strErrorClass = 'has-error';       
    }

    return "
        <div class='bootstrap-timepicker ".$class."'>
            <div class='form-group ".$strErrorClass."'>
                ". $label ."<br>".
                  Form::input($type, $name, $default, array_merge(["class" => "form-control timepicker"], $options)). "
                  <span class='text-danger'>".$errors->first($name)."</span>
            </div>
        </div>
    ";
});


Form::macro('myTimepickerInputFormat', function($type="text", $name, $label="", $options=[], $default = null, $class="")
{
    $label = ($label =='') ? '' : html_entity_decode(Form::label($name, $label));
    $errors = Session::get('errors', new Illuminate\Support\MessageBag);
    $strErrorClass = '';
    if($errors->first($name))
    {
        $strErrorClass = 'has-error';       
    }

    return "
        <div class='bootstrap-timepicker ".$class."'>
            <div class='form-group ".$strErrorClass."'>
                ". $label ."<br>".
                  Form::input($type, $name, $default, array_merge(["class" => "form-control timepickerformat"], $options)). "
                  <span class='text-danger'>".$errors->first($name)."</span>
            </div>
        </div>
    ";
});

Form::macro('mySelect', function($name, $label="", $values=[], $selected=null, $options=[])
{
    $label = ($label =='') ? '' : html_entity_decode(Form::label($name, $label));
    
    $errors = Session::get('errors', new Illuminate\Support\MessageBag);
    $strErrorClass = '';
    if($errors->first($name))
    {
        $strErrorClass = 'has-error';       
    }

    return "
        <div class='form-group ".$strErrorClass."'>
            ". $label .
              Form::select($name, $values, $selected,array_merge(["class" => "form-control"], $options)). "
              <span class='text-danger'>".$errors->first($name)."</span>
        </div>
    ";
});

Form::macro('myFileImage', function($name, $label="", $img_url="", $options=[])
{
    $label = ($label =='') ? '' : html_entity_decode(Form::label($name, $label));
    $errors = Session::get('errors', new Illuminate\Support\MessageBag);
    $strErrorClass = '';
    if($errors->first($name))
    {
        $strErrorClass = 'has-error';       
    }

    return "
        <div class='form-group ".$strErrorClass."'>
            ". $label . "
            <img src='".$img_url."'
            style='width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;'> " .
            Form::file($name, array_merge(["class" => "inputfile"], $options)). "
            <span class='text-danger'>".$errors->first($name)."</span>
        </div>
    ";
});

Form::macro('myFile', function($name, $label="", $img_url="", $options=[])
{
    $label = ($label =='') ? '' : html_entity_decode(Form::label($name, $label));

    $errors = Session::get('errors', new Illuminate\Support\MessageBag);
    $strErrorClass = '';
    if($errors->first($name))
    {
        $strErrorClass = 'has-error';       
    }

    return "
        <div class='form-group ".$strErrorClass."'>
            ". $label .             
            Form::file($name, array_merge(["class" => "inputfile"], $options)). "
            <span class='text-danger'>".$errors->first($name)."</span>
        </div>
    ";
});

Form::macro('myTextArea', function($name, $label="", $options=[], $default = null)
{
    $label = ($label =='') ? '' : html_entity_decode(Form::label($name, $label));
    $errors = Session::get('errors', new Illuminate\Support\MessageBag);
    $strErrorClass = '';
    if($errors->first($name))
    {
        $strErrorClass = 'has-error';       
    }

    return "
        <div class='form-group ".$strErrorClass."'>
            ". $label .
              Form::textarea($name, $default, array_merge(["class" => "form-control", "rows"=> 3], $options)). "
              <span class='text-danger'>".$errors->first($name)."</span>
        </div>
    ";
});

Form::macro('myCheckbox', function($name, $label="", $value='', $checked='', $options=[])
{
    return " 
        <div class='form-group icheck'>
            <label>
                <input $checked id='$name' name='$name' type='checkbox' value='$value'> " .   $label . "
            </label>
        </div>
    ";
});

Form::macro('myRange', function($name, $start, $end, $selected='', $options=[])
{
    return "
        <div class='form-group'>
            " . Form::selectRange($name, $start, $end, $selected,array_merge(["class" => "form-control"], $options)). "
        </div>
    ";
});

Form::macro('myTogglebox', function($name, $label="", $value='', $checked='', $options=[])
{
    return " 
        <div class='form-group'>
            <label class='switch btn-switch'>
                <input type='checkbox' $checked id='$name' name='$name' value='$value'>
                <span class='slider round'></span>
            </label>
        </div>
    ";
});

Form::macro('myDateTimepickerInput', function($type="text", $name, $label="", $options=[], $default = null, $class="")
{
    $label = ($label =='') ? '' : html_entity_decode(Form::label($name, $label));
    $errors = Session::get('errors', new Illuminate\Support\MessageBag);
    $strErrorClass = '';
    if($errors->first($name))
    {
        $strErrorClass = 'has-error';       
    }
    return "<div class='form-group ".$strErrorClass."'>
                ". $label .
                 Form::input($type, $name, $default, array_merge(["class" => "form-control", "data-date-format" => "dd-mm-yyyy HH:ii P" ], $options)). "
                  <span class='text-danger'>".$errors->first($name)."</span>
            </div>
           ";
});