@extends('stores::layouts.master')

@section('content')
    <div class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i> @lang('global.Add')</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">@lang('modules.Stores')</li>
                <li class="breadcrumb-item"><a href="#">@lang('global.Add')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{route('Stores.store')}}">
                    {{csrf_field()}}
                    <div class="tile">
                        <h3 class="tile-title">@lang('global.Add')</h3>
                        <div class="tile-body ">
                            <div class="col-md-6">


                                <div class="form-group">
                                    <label class="control-label">@lang('stores::global.Name') <strong>*</strong></label>
                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           type="text" name="name" value="{{old('name')}}"
                                           placeholder="Enter full name">
                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">@lang('stores::global.BaseUrl')
                                        <strong>*</strong></label>
                                    <input class="form-control{{ $errors->has('base_url') ? ' is-invalid' : '' }}"
                                           type="text" name="base_url" value="{{old('base_url')}}"
                                           placeholder="Enter Base Url">
                                    @if ($errors->has('base_url'))
                                        <div class="invalid-feedback">{{ $errors->first('base_url') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">@lang('stores::global.ApiUrl')
                                        <strong>*</strong></label>
                                    <input class="form-control{{ $errors->has('api_url') ? ' is-invalid' : '' }}"
                                           type="text" name="api_url" value="{{old('api_url')}}"
                                           placeholder="Enter Api Url">
                                    @if ($errors->has('api_url'))
                                        <div class="invalid-feedback">{{ $errors->first('api_url') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">@lang('stores::global.ApiLogin')
                                        <strong>*</strong></label>
                                    <input class="form-control{{ $errors->has('api_login') ? ' is-invalid' : '' }}"
                                           type="text" name="api_login" value="{{old('api_login')}}"
                                           placeholder="Enter Api login">
                                    @if ($errors->has('api_login'))
                                        <div class="invalid-feedback">{{ $errors->first('api_login') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">@lang('stores::global.ApiPassword') <strong>*</strong></label>
                                    <label class="pull-right">

                                        <span class="badge badge-primary"><i role="button" id="passtoggle"
                                                                             class="fa fa-eye-slash fa-lg p-1"></i></span>

                                    </label>
                                    <input class="form-control{{ $errors->has('api_password') ? ' is-invalid' : '' }}"
                                           type="password" name="api_password" value="{{old('api_password')}}"
                                           placeholder="Enter Api Password">
                                    @if ($errors->has('api_password'))
                                        <div class="invalid-feedback">{{ $errors->first('api_password') }}</div>
                                    @endif
                                </div>
                            </div>


                        </div>
                        <div class="tile-footer">
                            <button type="submit" class="btn btn-primary" type="button"><i
                                        class="fa fa-fw fa-lg fa-check-circle"></i>@lang('global.Confirm')</button>&nbsp;&nbsp;&nbsp;<a
                                    class="btn btn-secondary" href="{{url()->previous()}}"><i
                                        class="fa fa-fw fa-lg fa-times-circle"></i>@lang('global.Cancel')</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="clearix"></div>
        </div>
    </div>

@stop
@section('js')
    <script>
        //Show password and confirmation on eye click
        $('#passtoggle').click(function () {
            if ($(this).hasClass('fa-eye-slash')) {
                $("[name='api_password']").prop('type', 'text');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');


            } else {
                $("[name='api_password']").prop('type', 'password');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');

            }
        });
    </script>
@stop
