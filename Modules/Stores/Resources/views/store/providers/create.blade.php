@extends('stores::layouts.master')

@section('content')
    <div class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i> @lang('stores::global.NewProvider')</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">@lang('modules.Stores')</li>
                <li class="breadcrumb-item"><a href="#">@lang('stores::global.NewProvider')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form id="postProviderForm" method="post" action="{{route('Store.Providers.store',['id' => encode($store->id)])}}">
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
                                    <label class="control-label">{{trans('stores::global.Slug')}}
                                        <strong>*</strong></label>
                                    <input class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                           type="text" name="slug" value="{{old('slug')}}" placeholder="">
                                    @if ($errors->has('slug'))
                                        <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
                                    @endif
                                </div>
                               <div class="form-group" id="addresses-component">

                                    <label class="control-label">{{trans('stores::global.Address')}}
                                        <strong>*</strong>
                                  </label>

                                     <button type="button" onclick="appendAddress(event)" class="mb-1 pull-right btn btn-sm btn-primary">{{trans('stores::global.AddMore')}}</button>
                                     <div class="input-group mt-2">
                                  

                               
                                    <input class="form-control{{ $errors->has('addresses') ? ' is-invalid' : '' }}" type="text" id="address">
                                    
                                            <input type='hidden' id='city' value=''>
                                            <input type='hidden' id='street' value=''>
                                            <input type='hidden' id='lat' value=''>
                                            <input type='hidden' id='lng' value=''>
                   
                                           <div class="input-group-append">
                                            <span class="input-group-text">
                                      
                                       
                                            <div class="toggle">
                  <label>
                    <input class="is-primary"  id="is_primary"   type="checkbox"><span class="button-indecator">{{trans('stores::global.IsPrimary')}}</span>
                  </label>
                </div>
            </span>
                </div>
                 @if ($errors->has('addresses'))
                                        <div class="invalid-feedback">{{ $errors->first('addresses') }}</div>
                                    @endif
                </div>
               
            </div>


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
        $('#selectProviders').select2();
        $('#selectIsActive').select2();
    </script>
     <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{config('stores.google_token')}}&libraries=places&callback=init" async defer></script>
     <script type="text/javascript">
       function processResult(el,address) {

       
                    $(el).parent().find("#city").val(address.country);
                    $(el).parent().find("#street").val(address.route);
                    $(el).parent().find("#lat").val(address.lat);
                    $(el).parent().find("#lng").val(address.lng);



        }
        function init(el) {
            if(el === undefined) {
         var input = document.getElementById('address');

     } else {
        var input = el;
     }
          var autocomplete = new google.maps.places.Autocomplete(input);
           autocomplete.addListener('place_changed', function() { 
          var place = autocomplete.getPlace();
       
          console.log(place);
      
      
      var full_address = {
        route: '_hghg',
      country:'_gh',
      lat:'',
      lng:''
  };
          var lat = place.geometry.location.lat();
          var lng = place.geometry.location.lng();
          full_address.lat = lat;
          full_address.lng = lng;
              for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (full_address[addressType]) {
            var val = place.address_components[i][full_address[addressType]];
            full_address[addressType] = val;
          }
        }
      
        processResult(input,full_address);

          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }
      });
  }
   $('#addresses-component').on('change','.is-primary',function() {
    $('.is-primary').prop('checked',false);
    $(this).prop('checked',true);

  });
    $('#addresses-component').on('click','.remove-address',function() {
        $(this).closest('.input-group').remove();
   

  });

  function appendAddress(e) 
  {
    let el = e.target;
    let html = ` <div class="input-group mt-2">
                                    <input class="form-control"
                                           type="text" id="address"> <input type='hidden' id='city' value=''>
                                            <input type='hidden' id='street' value=''>
                                            <input type='hidden' id='lat' value=''>
                                            <input type='hidden' id='lng' value=''>
                                           <div class="input-group-append">
                                            <span class="input-group-text">                                       
                                            <div class="toggle">
                  <label>
                    <input  id="is_primary" class="is-primary" type="checkbox"><span class="button-indecator">{{trans('stores::global.IsPrimary')}}</span>
                  </label>
                </div>
            </span>
            <span class="input-group-text">                                       
                 <button type="button" class="close remove-address" aria-label="Close">
  <span class="text-danger" aria-hidden="true">&times;</span>
</button>
            </span>
                </div>
                </div>`;
                $(el).closest('.form-group').append(html)
                let newel = $(el).closest('.form-group').children('.input-group:last-child').find('#address');
             init(newel[0]);
               
  }
  
  $('#postProviderForm').submit(function(e) {
    let addresses = [];
    $("#postProviderForm #addresses-component .input-group").each(function() {
        let address = {};
        address.address = $(this).find('#address').val();
        address.city = $(this).find('#city').val();
        address.street = $(this).find('#street').val();
        address.is_primary = $(this).find('#is_primary').prop('checked');
        address.lat=$(this).find('#lat').val();
        address.lng=$(this).find('#lng').val();
        if(address.address.length>0 && address.lat != null && address.lng != null) {
        addresses.push(address);
    }


    });
    if(addresses.length) {
    let element = "<input name='addresses' type='hidden' value='"+JSON.stringify(addresses)+"'>";
    $("#postProviderForm").append(element);
}


  })
 




     </script>
@endsection
