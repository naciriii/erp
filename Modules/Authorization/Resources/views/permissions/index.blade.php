@extends('authorization::layouts.master')

@section('content')
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> {{trans('modules.Authorization')}}</h1>
          <p class="mt-2">
          	<a href="{{route('Permissions.create')}}">
          		<button class="btn btn-sm btn-primary">@lang('authorization::global.NewPermission')</button>
          	</a></p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">{{trans('modules.Authorization')}}</li>
          <li class="breadcrumb-item active"><a href="#">@lang('authorization::global.Permission')</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <table class="table table-hover table-bordered" id="permissionsTable">
                <thead>
                  <tr>
                    <th>{{trans('authorization::global.PermissionName')}}</th>
                    <th>{{trans('authorization::global.CreatedAt')}}</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="permissionsTableBody">
                	  @foreach($permissions as $permission)
                     <tr>
                    <td>{{$permission->name}}</td>
                    <td>{{str_limit($permission->created_at,16,'')}}</td>
                    <td><a href="{{route('Permissions.show',['id' => encode($permission->id)])}}"><button class="btn btn-sm btn-primary">{{trans('global.Edit')}}</button></a>
                      <form class="d-inline" method="post" action="{{route('Permissions.destroy',['id' => encode($permission->id)])}}">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE">

                  <button type="submit" class="btn btn-sm btn-danger deletePermissionBtn">{{trans('global.Delete')}}</button>
                </form>
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
   $('#permissionsTable').DataTable();

    $("#permissionsTableBody").on('click','.deletePermissionBtn',function(e){
      e.preventDefault();
       bsAlert("@lang('global.AreYouSure')", 
        "@lang('authorization::global.AreYouSurePermission')",
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
