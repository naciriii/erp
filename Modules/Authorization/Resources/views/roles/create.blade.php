@extends('authorization::layouts.master')

@section('content')
<div class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> @lang('global.Add')</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">@lang('modules.Authorization')</li>
          <li class="breadcrumb-item"><a href="#">@lang('global.Add')</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
        	<form method="post" action="{{route('Roles.store')}}">
              	{{csrf_field()}}
          <div class="tile">
            <h3 class="tile-title">@lang('global.Add')</h3>
            <div class="tile-body ">
            	<div class="col-md-6">
   
                <div class="form-group">
                  <label class="control-label">@lang('authorization::global.RoleName') <strong>*</strong></label>
                  <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{old('name')}}" placeholder="Enter full name">
                   @if ($errors->has('name'))
             <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                </div>
                </div>
                	<div class="panel panel-default">
                		<div class="panel-heading col-md-12">
                		 <label class="control-label">@lang('global.Permissions') </label>
                      <span class="badge badge-secondary ml-1"><i role="button" id="checkAll" class="fa fa-check "></i></span>

                		</div>
                		<div class="panel-body row col-md-12">
                         @php $ch = $permissions->count() >4 ? $permissions->count()/4 : 1 @endphp
                			@foreach($permissions->chunk($ch) as $chunks)
                			<div class="col-md-3 col-sm-6">
                <div class="form-group">
                	  @foreach($chunks as $chunk)
                	<div class="toggle">
                  <label>
                    <input value="{{$chunk->id}}" name="permissions[]" type="checkbox"><span class="button-indecator">{{$chunk->name}}</span>
                  </label>
                </div>
                @endforeach
                
                	
                </div>
                </div>
                @endforeach

                			
                		</div>
                	</div>
                	
              
              
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
@section('js')
<script type="text/javascript">
  $('#checkAll').click(function() {
    if($(this).parent().hasClass('badge-secondary')) {
      $("[name='permissions[]'").prop('checked',true);
      $(this).parent().removeClass('badge-secondary').addClass('badge-primary');

    }else {
       $("[name='permissions[]'").prop('checked',false);
      $(this).parent().removeClass('badge-primary').addClass('badge-secondary');

    }


  })
</script>


@stop
