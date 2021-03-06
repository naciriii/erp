@extends('stores::layouts.master')

@section('content')
    <div class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i> @lang('stores::global.NewProduct')</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">@lang('modules.Stores')</li>
                <li class="breadcrumb-item"><a href="#">@lang('stores::global.NewProduct')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{route('Store.Products.store',['id' => encode($store->id)])}}"
                      enctype="multipart/form-data">
                    {{csrf_field()}}

                    <div class="tile">
                        <h3 class="tile-title">@lang('global.Add')</h3>
                        <div class="tile-body ">
                            <div class="row">
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
                                        <label class="control-label">@lang('stores::global.Price')
                                            <strong>*</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text">€</span>
                                            </div>
                                            <input class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                                                   type="text" name="price" value="{{old('price')}}" placeholder="">
                                        </div>
                                        @if ($errors->has('price'))
                                            <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">@lang('stores::global.Sku')
                                            <strong>*</strong></label>
                                        <input class="form-control{{ $errors->has('sku') ? ' is-invalid' : '' }}"
                                               type="text" name="sku" value="{{old('sku')}}" placeholder="">
                                        @if ($errors->has('sku'))
                                            <div class="invalid-feedback">{{ $errors->first('sku') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">@lang('stores::global.Quantity')
                                            <strong>*</strong></label>
                                        <input class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}"
                                               type="text" name="quantity" value="{{old('quantity')}}" placeholder="">
                                        @if ($errors->has('quantity'))
                                            <div class="invalid-feedback">{{ $errors->first('quantity') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">@lang('stores::global.Category')
                                            <strong>*</strong></label>

                                        <select multiple="" id="selectCategories" name="category[]"
                                                class="form-control">
                                            @foreach($categories as $c)
                                                <option
                                                        value="{{$c->id}}">
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

                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#advancedPricing">{{trans('stores::global.AdvancedPricing')}}</button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="advancedPricing" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="exampleModalLabel">{{trans('stores::global.AdvancedPricing')}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label">@lang('stores::global.SpecialPrice')
                                                                        <strong>*</strong></label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span
                                                                                    class="input-group-text">€</span>
                                                                        </div>
                                                                        <input class="form-control{{ $errors->has('special_price') ? ' is-invalid' : '' }}"
                                                                               type="text" name="special_price"
                                                                               value="{{old('special_price')}}"
                                                                               placeholder="">
                                                                    </div>
                                                                    @if ($errors->has('special_price'))
                                                                        <div class="invalid-feedback">{{ $errors->first('special_price') }}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">{{trans('stores::global.specialFromDate')}}
                                                                        <strong>*</strong></label>
                                                                    <input class="form-control{{ $errors->has('special_from_date') ? ' is-invalid' : '' }}"
                                                                           id="special-from" type="text" placeholder=""
                                                                           name="special_from_date"
                                                                           value="{{old('special_from_date')}}">

                                                                    @if ($errors->has('special_from_date'))
                                                                        <div class="invalid-feedback">{{ $errors->first('special_from_date') }}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">{{trans('stores::global.specialToDate')}}
                                                                        <strong>*</strong></label>
                                                                    <input class="form-control{{ $errors->has('special_to_date') ? ' is-invalid' : '' }}"
                                                                           id="special-to" type="text" placeholder=""
                                                                           name="special_to_date"
                                                                           value="{{old('special_to_date')}}">

                                                                    @if ($errors->has('special_to_date'))
                                                                        <div class="invalid-feedback">{{ $errors->first('special_to_date') }}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary"
                                                                data-dismiss="modal">
                                                            {{trans('stores::global.Ok')}}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal /-->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">{{trans('stores::global.Image')}}
                                            <strong>*</strong></label>
                                        <input class="form-control-file" name="image" id="image" type="file"
                                               aria-describedby="fileHelp">
                                        @if ($errors->has('image'))
                                            <small class="form-text text-muted" id="fileHelp">
                                                {{ $errors->first('image') }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="form-group" id="img-show" style="display: none">
                                        <img style="width: 250px; height: 250px" class="img-fluid" id="img-preview"
                                             src="" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <button type="submit" class="btn btn-primary" type="button">
                                <i class="fa fa-fw fa-lg fa-check-circle"></i>@lang('global.Confirm')
                            </button>&nbsp;&nbsp;&nbsp;
                            <a class="btn btn-secondary" href="{{url()->previous()}}">
                                <i class="fa fa-fw fa-lg fa-times-circle"></i>@lang('global.Cancel')
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
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap-datepicker.min.js')}}"></script>

    <script type="text/javascript">
        @if ($errors->has('special_price') || $errors->has('special_from_date') || $errors->has('special_to_date'))
        $('#advancedPricing').modal('show');
        @endif
        $('#special-from').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true,
            startDate: '0d'
        });

        $('#special-to').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true,
            startDate: '0d'
        });
        $('#selectCategories').select2();

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img-show').show();
                    $('#img-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function () {

            readURL(this);
        });
    </script>

@endsection
