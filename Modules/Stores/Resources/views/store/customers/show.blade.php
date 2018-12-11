@extends('stores::layouts.master')

@section('content')
    <div class="app-content" onload="initialize()">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i> @lang('stores::global.NewCustomer')</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">@lang('modules.Stores')</li>
                <li class="breadcrumb-item"><a href="#">@lang('stores::global.NewCustomer')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{route('Store.Customers.update',['id' => encode($store->id)])}}">
                    {{csrf_field()}}

                    <div class="tile">
                        <h3 class="tile-title">@lang('global.Add')</h3>
                        <div class="tile-body ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">{{trans('stores::global.FirstName')}}
                                        <strong>*</strong></label>
                                    <input class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                           type="text" name="first_name" value="{{old('first_name')}}" placeholder="">
                                    @if ($errors->has('first_name'))
                                        <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{{trans('stores::global.LastName')}}
                                        <strong>*</strong></label>
                                    <input class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                           type="text" name="last_name" value="{{old('last_name')}}" placeholder="">
                                    @if ($errors->has('last_name'))
                                        <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{{trans('stores::global.Email')}}
                                        <strong>*</strong></label>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           type="text" name="email" value="{{old('email')}}" placeholder="">
                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{{trans('stores::global.Password')}}
                                        <strong>*</strong></label>
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           type="password" name="password" value="{{old('password')}}" placeholder="">
                                    @if ($errors->has('password'))
                                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{{trans('stores::global.ConfirmPassword')}}
                                        <strong>*</strong></label>
                                    <input class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                           type="password" name="password_confirmation" value="{{old('password_confirmation')}}"
                                           placeholder="">
                                    @if ($errors->has('password_confirmation'))
                                        <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
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
    <script type="text/javascript" src="{{asset('js/plugins/select2.min.js')}}"></script>

    <script type="text/javascript">
        $('#selectCategories').select2();
    </script>



@endsection
