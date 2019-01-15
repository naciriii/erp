@extends('stores::layouts.master')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> @lang('stores::global.StoreMenus.Providers')
                </h1>
                <p class="mt-2">
                    <a href="{{route('Store.Providers.create',['id'=>encode($store->id)])}}">
                        <button class="btn btn-sm btn-primary">@lang('stores::global.NewProvider')</button>
                    </a>
                </p>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{trans('modules.Stores')}}</li>
                <li class="breadcrumb-item active"><a href="#">@lang('stores::global.StoreMenus.Providers')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body table-responsive">
                        <table class="table table-hover table-bordered" id="providersTable">
                            <thead>
                            <tr>
                                <th>{{trans('stores::global.Name')}}</th>
                                <th>{{trans('stores::global.Slug')}}</th>
                                <th>{{trans('stores::global.IsActive')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="providersTableBody">

                            @if(isset($result))
                                @foreach($result as $provider)
                                    <tr>
                                        <td>{{$provider->name}}</td>
                                        <td>{{$provider->slug}}</td>
                                        <td>
                                            @if($provider->is_active == 1)
                                                <label class="badge badge-primary">
                                                    <i class="fa fa-check"></i>
                                                </label>
                                            @else
                                                <label class="badge badge-danger">
                                                    <i class="fa fa-times"></i>
                                                </label>
                                            @endif
                                        </td>
                                        <td>
                                               <button onclick="showAddresses({{$provider->addresses->toJson()}})" class="btn btn-sm btn-info">{{trans('stores::global.Addresses')}}</button>
                                            <a href="{{route('Store.Providers.show',['id'=>encode($store->id),'provider_id' => encode($provider->id)])}}">
                                                <button class="btn btn-sm btn-primary">{{trans('global.Edit')}}</button>
                                            </a>
                                            <form class="d-inline" method="post"
                                                  action="{{route('Store.Providers.destroy',['id' => encode($store->id),'provider'=>encode($provider->id)])}}">
                                                {{csrf_field()}}
                                                <input type="hidden" name="_method" value="DELETE">

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger deleteProviderBtn">{{trans('global.Delete')}}</button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Modal -->
<div class="modal fade" id="addressesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{trans('stores::global.Addresses')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <th>{{trans('stores::global.Address')}}</th>
                <th>{{trans('stores::global.City')}}</th>
                <th>{{trans('stores::global.Street')}}</th>
                <th>{{trans('stores::global.IsPrimary')}}</th>

                <th>{{trans('stores::global.Map')}}</th>
          </thead>
            <tbody id="body">
               
            </tbody>
            
        </table>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('stores::global.Close')</button>
        
      </div>
    </div>
  </div>
</div>

@stop


@section('js')
    <script type="text/javascript" src="{{asset('js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/sweetalert.min.js')}}"></script>

    <script type="text/javascript">
        $('#providersTable').DataTable();

        $("#providersTableBody").on('click', '.deleteProviderBtn', function (e) {
            e.preventDefault();
            bsAlert("@lang('global.AreYouSure')",
                "@lang('stores::global.AreYouSureProvider')",
                "warning",
                "@lang('global.Confirm')",
                "@lang('global.Cancel')",
                function (isConfirm) {
                    if (isConfirm) {
                        $(e.target).closest('form').submit();
                    }
                });
        });
        function showAddresses(addresses) {
            
            let html = '';
            let key = "{{config('stores.google_token')}}";
            $(addresses).each(function(index,item) {
                console.log(item);
                let address = item.address;
                let city = (item.city != '_')? item.city:'';
                let street = (item.street!= '_')?item.street:'';
                let lat = item.lat;
                let lng = item.lng;
                let is_primary = (item.is_primary ==1) ? '<label class="badge badge-primary"><i class="fa fa-check"></i></label>':'';
              let map = '<iframe width="150" height="150" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key='+key+'&q='+address+'" allowfullscreen></iframe>';
          

                html+='<tr><td>'+address+'</td> <td>'+city+'</td>'+'<td>'+street+'</td><td>'+is_primary+'</td><td>'+map+'</td> </tr>';
            });
            $('#addressesModal #body').html(html);
            $('#addressesModal').modal();
        }

    </script>
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
    @if(session('response'))
        <script>
            {!! bsNotify(session('response')) !!};
        </script>
    @endif
@stop