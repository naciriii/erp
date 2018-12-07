@extends('stores::layouts.master')

@section('content')
    <div class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i> @lang('global.Edit')</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">@lang('modules.Stores')</li>
                <li class="breadcrumb-item"><a href="#">@lang('global.Edit')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post"
                      action="{{route('Store.Categories.update',['id' => encode($store->id),'cat' => encode($category->id)])}}">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="tile">
                        <h3 class="tile-title">@lang('global.Edit')</h3>
                        <div class="tile-body ">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="control-label">@lang('stores::global.Name') <strong>*</strong></label>
                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           type="text" name="name" value="{{$category->name}}" placeholder="">
                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label">@lang('stores::global.IsActive')
                                        <strong>*</strong></label>
                                    <select id="selectIsActive" name="is_active" class="form-control">
                                        <option value="0"
                                                @if($category->is_active === false) selected @endif>{{trans('stores::global.False')}}</option>
                                        <option value="1"
                                                @if($category->is_active === true) selected @endif>{{trans('stores::global.True')}}</option>
                                    </select>
                                    @if ($errors->has('is_active'))
                                        <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label">@lang('stores::global.Parent') @lang('stores::global.Category')</label>
                                    <select name="parent_id" id="selectCategories" class="form-control">
                                        <option value="">Choose</option>
                                        @foreach($categories as $c)
                                            @if($c->id != $category->id)
                                                <option value="{{$c->id}}"
                                                        @if($c->id == $category->parent_id) selected @endif>
                                                    {{$c->name}}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="tile-footer">
                                <button type="submit" class="btn btn-primary" type="button"><i
                                            class="fa fa-fw fa-lg fa-check-circle"></i>@lang('global.Confirm')</button>&nbsp;&nbsp;&nbsp;<a
                                        class="btn btn-secondary" href="{{url()->previous()}}"><i
                                            class="fa fa-fw fa-lg fa-times-circle"></i>@lang('global.Cancel')</a>
                            </div>
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

