@extends('auth.authlayout')

@section('content')

    <p class="login-box-msg"><b>Please Sign in</b></p>

    @if (Session::has('warning'))
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <ul class="list-unstyled">
              <li>{{ Session::get('warning') }}</li>
            </ul>
        </div>
    @endif

    <form role="form" method="POST" action="{{ url('/admin/login') }}" autocomplete="off">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
            <input type="email" class="form-control" placeholder="Email" id="email" name="email" value="{{ old('email') }}" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

            @if ($errors->has('email'))
                    <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                    </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password'))
                    <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                    </span>
            @endif
        </div>



        <div class="row" style="margin-top:30px;margin-bottom:20px;">
            <div class="col-xs-6">
               <!--  <div class="checkbox icheck">
                   <label>
                       <input type="checkbox" name="remember" > {{ trans('app.remember_me') }}
                   </label>
               </div> -->
               <button type="submit" onclick="return validate();" class="btn btn-primary btn-block btn-flat">{{ trans('app.login_btn') }}</button>
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
               <a href="{{ url('/admin/password/reset') }}" class="text-right pull-right">Forgot Password</a>
           </div>
            <!-- /.col -->
        </div>


    </form>

   <!--  <div class="row">
      <div class="col-xs-6">
          <a href="{{ url('/register') }}">Register</a>
      </div>/.col
       <div class="col-xs-6">
           <a href="{{ url('/password/reset') }}" class="text-right pull-right">Forgot Password</a>
       </div>/.col
   </div> -->
@endsection
