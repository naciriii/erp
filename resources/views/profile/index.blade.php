@extends('layouts.ukn')

@section('content')
<div class="app-content">
<div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> @lang('global.Profile')</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">@lang('global.Home')</li>
          <li class="breadcrumb-item"><a href="#">@lang('global.Profile')</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="container">
        	 <form method="post" action="{{route('Profile.post')}}">
        	 	  {{csrf_field()}}
        	 	   <div class="tile">
            <h3 class="tile-title">@lang('global.Edit')
            </h3>
             <div class="tile-body">

   
              
                <div class="form-group">
                  <label class="control-label"><strong>@lang('users::global.Name') <strong>*</strong></strong></label>
                  <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{Auth::user()->name}}" placeholder="Enter full name">
                   @if ($errors->has('name'))
             <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                </div>
                <div class="form-group">
                  <label class="control-label"><strong>@lang('users::global.Email') <strong>*</strong></strong></label>
                  <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" value="{{Auth::user()->email}}" name="email" placeholder="Enter email address">
                   @if ($errors->has('email'))
             <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                @endif
                </div>
                <div class="form-group">
                  <label class="control-label">
                    <strong>@lang('users::global.Password')  </strong></label>
                     <label class="pull-right" >
   <span class="badge badge-primary"> 
    <i role="button" id="randomize"  class="fa fa-random fa-lg p-1"></i></span>
                  <span class="badge badge-primary"><i role="button" id="passtoggle" class="fa fa-eye-slash fa-lg p-1"></i></span>

                  </label>
                  <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" placeholder="New Password">
                   @if ($errors->has('password'))
             <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                @endif

                </div>
                 <div class="form-group">
                  <label class="control-label"><strong>@lang('users::global.Password_confirmation') </strong> </label>
                  <input class="form-control{{ $errors->has('passwordl') ? ' is-invalid' : '' }}" type="password" name="password_confirmation" placeholder="Password Confirmation">
                   @if ($errors->has('password_confimation'))
             <div class="invalid-feedback">{{ $errors->first('password_confimation') }}</div>
                                @endif

                </div>
              
             </div>
              <div class="tile-footer">
              <button type="submit" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>@lang('global.Confirm')</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{url()->previous()}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>@lang('global.Cancel')</a>
            </div>

         </div>
        	 </form>
        </div>
    </div>
</div>

@stop
@section('js')
   <script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
      <script type="text/javascript">

      //Show password and confirmation on eye click
      $('#passtoggle').click(function() {
        if($(this).hasClass('fa-eye-slash')) {
         $("[name='password'],[name='password_confirmation']").prop('type','text');
          $(this).removeClass('fa-eye-slash').addClass('fa-eye');


        } else {
          $("[name='password'],[name='password_confirmation']").prop('type','password');
          $(this).removeClass('fa-eye').addClass('fa-eye-slash');

        }
      });

      //Generate random password on click
       $('#randomize').click(function() {
         $("[name='password'],[name='password_confirmation']").val(Math.random().toString(36).substring(3));
          if($('#passtoggle').hasClass('fa-eye-slash')) {
          $('#passtoggle').trigger('click');
        }
       
      });
  </script>
  @if(session('response'))
    <script>
   {!! bsNotify(session('response'))!!}
 </script>

    @endif
@stop