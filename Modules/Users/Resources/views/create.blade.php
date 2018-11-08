@extends('users::layouts.master')

@section('content')
<div class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> @lang('global.Add')</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">@lang('modules.Users')</li>
          <li class="breadcrumb-item"><a href="#">@lang('global.Add')</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
        	<form method="post" action="{{route('Users.store')}}">
              	{{csrf_field()}}
          <div class="tile">
            <h3 class="tile-title">@lang('global.Add')</h3>
            <div class="tile-body col-md-6">
   
              
                <div class="form-group">
                  <label class="control-label">@lang('users::global.Name') <strong>*</strong></label>
                  <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{old('name')}}" placeholder="Enter full name">
                   @if ($errors->has('name'))
             <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                </div>
                <div class="form-group">
                  <label class="control-label">@lang('users::global.Email') <strong>*</strong></label>
                  <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" value="{{old('email')}}" name="email" placeholder="Enter email address">
                   @if ($errors->has('email'))
             <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                @endif
                </div>
                <div class="form-group">
                  <label class="control-label">@lang('users::global.Password') </label>
                  <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" placeholder="New Password">
                   @if ($errors->has('password'))
             <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                @endif

                </div>
                 <div class="form-group">
                  <label class="control-label">@lang('users::global.Password_confirmation') </label>
                  <input class="form-control{{ $errors->has('passwordl') ? ' is-invalid' : '' }}" type="password" name="password_confirmation" placeholder="Password Confirmation">
                   @if ($errors->has('password_confimation'))
             <div class="invalid-feedback">{{ $errors->first('password_confimation') }}</div>
                                @endif

                </div>
              
            </div>
            <div class="tile-footer">
              <button type="submit" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>@lang('global.Confirm')</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#"><i class="fa fa-fw fa-lg fa-times-circle"></i>@lang('global.Cancel')</a>
            </div>
          </div>
          </form>
        </div>
        <div class="clearix"></div>
      </div>
    </div>

@stop
@section('js')
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
    @if(session('response'))
    <script>
   @bsNotify(session('response'))
 </script>

    @endif
@stop