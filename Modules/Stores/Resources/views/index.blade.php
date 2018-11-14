@extends('stores::layouts.master')

@section('content')
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> {{trans('modules.Stores')}}</h1>
           <p class="mt-2">
            <a href="{{route('Stores.create')}}">
              <button class="btn btn-sm btn-primary">@lang('stores::global.NewStore')</button>
            </a></p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">{{trans('modules.Stores')}}</li>
          <li class="breadcrumb-item active"><a href="#">{{trans('global.List')}}</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <table class="table table-hover table-bordered" id="storesTable">
                <thead>
                  <tr>
                    <th>{{trans('stores::global.Name')}}</th>
                    <th>{{trans('stores::global.BaseUrl')}}</th>
                    <th>{{trans('stores::global.ApiUrl')}}</th>
                    <th>{{trans('stores::global.CreatedAt')}}</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="storesTableBody">
                	  @foreach($stores as $store)
                     <tr>
                    <td>{{$store->name}}</td>
                    <td>{{$store->base_url}}</td>
                    <td>{{$store->api_url}}</td>
                    <td>{{str_limit($store->created_at,16,'')}}</td>
                    <td><a href="{{route('Stores.show',['id' => encode($store->id)])}}"><button class="btn btn-sm btn-primary">{{trans('global.Edit')}}</button></a>
                      <form class="d-inline" method="post" action="{{route('Stores.delete',['id' => encode($store->id)])}}">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE">

                  <button type="submit" class="btn btn-sm btn-danger deleteStoreBtn">{{trans('global.Delete')}}</button>
                </form>
                <a href="{{route('Store.index',['id' => encode($store->id)])}}"><button class="btn btn-sm btn-primary">{{trans('global.Show')}}</button></a>
                  </td>
                   
                  </tr>

                  @endforeach
               
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
   
@stop
@section('js')
   <script type="text/javascript" src="{{asset('js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/dataTables.bootstrap.min.js')}}"></script>
     <script type="text/javascript" src="{{asset('js/plugins/sweetalert.min.js')}}"></script>

    <script type="text/javascript">
   $('#storesTable').DataTable();

    $("#storesTableBody").on('click','.deleteStoreBtn',function(e){
      e.preventDefault();
       bsAlert("@lang('global.AreYouSure')", 
        "@lang('stores::global.AreYouSureStore')",
        "warning",
        "@lang('global.Confirm')",
        "@lang('global.Cancel')",
           function(isConfirm) {
            if(isConfirm) {
             $(e.target).closest('form').submit();
         }
       });
      });

</script>
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
    @if(session('response'))
    <script>
   {!! bsNotify(session('response')) !!};
 </script>
    @endif
@stop
