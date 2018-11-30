@extends('stores::layouts.master')

@section('content')
    <div class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i> @lang('stores::global.NewCategory')</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">@lang('modules.Stores')</li>
                <li class="breadcrumb-item"><a href="#">@lang('stores::global.NewCategory')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{route('Store.Categories.store',['id' => encode($store->id)])}}">
                    {{csrf_field()}}

                    <div class="tile">
                        <h3 class="tile-title">@lang('global.Add')</h3>
                        <div class="tile-body ">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="control-label">{{trans('stores::global.Name')}}
                                        <strong>*</strong></label>
                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           type="text" name="name" value="{{old('name')}}" placeholder="">
                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">@lang('stores::global.IsActive')</label>
                                    <select id="selectIsActive" name="is_active" class="form-control">
                                        <option value="0">{{trans('stores::global.False')}}</option>
                                        <option value="1">{{trans('stores::global.True')}}</option>
                                    </select>
                                    @if ($errors->has('is_active'))
                                        <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
                                    @endif
                                </div>
                                 <div class="form-group">
                                     <label class="control-label">@lang('stores::global.Parent') @lang('stores::global.Category')</label>
                                     <select id="selectCategories" name="parent_id" class="form-control">
                                         <option value="">Choose</option>
                                         @foreach($categories as $c)
                                             <option value="{{$c->id}}">
                                                 {{$c->name}}
                                             </option>
                                             @if(count($c->children_data))
                                                 @foreach($c->children_data as $cd)
                                                     <option value="{{$cd->id}}">{{$cd->name}}
                                                     </option>
                                                     @if(count($cd->children_data))
                                                         @foreach($cd->children_data as $cdd)
                                                             <option value="{{$cdd->id}}">{{$cdd->name}}</option>
                                                         @endforeach
                                                     @endif
                                                 @endforeach
                                             @endif
                                         @endforeach
                                     </select>
                                     @if ($errors->has('category'))
                                         <div class="invalid-feedback">{{ $errors->first('category') }}</div>
                                     @endif
                                 </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <button type="submit" class="btn btn-primary" type="button">
                                <i class="fa fa-fw fa-lg fa-check-circle"></i>
                                @lang('global.Confirm')</button>&nbsp;&nbsp;&nbsp;
                            <a class="btn btn-secondary" href="{{url()->previous()}}">
                                <i class="fa fa-fw fa-lg fa-times-circle"></i>
                                @lang('global.Cancel')
                            </a>
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
        $('#selectIsActive').select2();
    </script>
@endsection
