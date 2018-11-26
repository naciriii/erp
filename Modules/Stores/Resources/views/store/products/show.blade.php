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
          <form method="post" action="{{route('Store.Products.update',['id' => encode($store->id),'sku' => $product->sku])}}">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PUT">
          <div class="tile">
            <h3 class="tile-title">@lang('global.Edit')</h3>
            <div class="tile-body ">
              <div class="col-md-6">
   
              
                <div class="form-group">
                  <label class="control-label">@lang('stores::global.Name') <strong>*</strong></label>
                  <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{$product->name}}" placeholder="">
                   @if ($errors->has('name'))
             <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                </div>
                <div class="form-group">
                  <label class="control-label">@lang('stores::global.Price') <strong>*</strong></label>
                  <input class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" type="text" name="price" value="{{$product->price}}" placeholder="">
                   @if ($errors->has('price'))
             <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                                @endif
                </div>
                <div class="form-group">
                  <label class="control-label">@lang('stores::global.Sku') <strong>*</strong></label>
                  <input class="form-control{{ $errors->has('sku') ? ' is-invalid' : '' }}" type="text" name="sku" value="{{$product->sku}}" placeholder="">
                   @if ($errors->has('sku'))
             <div class="invalid-feedback">{{ $errors->first('sku') }}</div>
                                @endif
                </div>
                 <div class="form-group">
                  <label class="control-label">@lang('stores::global.Quantity') <strong>*</strong></label>
                  <input class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" type="text" name="quantity" value="{{$product->extension_attributes->stock_item->qty}}" placeholder="">
                   @if ($errors->has('quantity'))
             <div class="invalid-feedback">{{ $errors->first('quantity') }}</div>
                                @endif
                </div>
                 <div class="form-group">
                  <label class="control-label">@lang('stores::global.Category') <strong>*</strong></label>
                 
                  <select multiple @if(isset($product->extension_attributes->category_links)))

                    value="{{collect($product->extension_attributes->category_links)->pluck('category_id')}}"
                    @endif
                     name="category" class="form-control">
                     @foreach($categories as $c)

                     <option
                      @if(isset($product->extension_attributes->category_links) && collect($product->extension_attributes->category_links)->contains('category_id',$c->id))selected @endif value="{{$c->id}}">
                      {{$c->name}}
                     </option>

                     @if(count($c->children_data))
                     @foreach($c->children_data as $cd)
                     <option @if(isset($product->extension_attributes->category_links) && collect($product->extension_attributes->category_links)->contains('category_id',$cd->id))selected @endif  value="{{$cd->id}}">{{$cd->name}}
                     </option>
                      @if(count($cd->children_data))
                     @foreach($cd->children_data as $cdd)
                      <option @if(isset($product->extension_attributes->category_links) && collect($product->extension_attributes->category_links)->contains('category_id',$cdd->id))selected @endif  value="{{$cdd->id}}">{{$cdd->name}}</option>

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
                </div class="col-md-6">
                  
              
              
            </div>
            <div class="tile-footer">
              <button type="submit" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>@lang('global.Confirm')</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{url()->previous()}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>@lang('global.Cancel')</a>
            </div>
          </div>
          </form>
        </div>
        <div class="clearix"></div>
      </div>
    </div>

@stop

