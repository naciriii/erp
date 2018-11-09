@extends('authorization::layouts.master')

@section('content')
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> {{trans('modules.Authorization')}}</h1>
          <p>Table to display analytical data effectively</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">{{trans('modules.Authorization')}}</li>
          <li class="breadcrumb-item active"><a href="#">{{trans('authorization::global.Role')}}</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <table class="table table-hover table-bordered" id="rolesTable">
                <thead>
                  <tr>
                    <th>{{trans('authorization::global.RoleName')}}</th>
                    <th>{{trans('authorization::global.CreatedAt')}}</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="rolesTableBody">
                	  @foreach($roles as $role)
                     <tr>
                    <td>{{$role->name}}</td>
                    <td>{{str_limit($role->created_at,16,'')}}</td>
                    <td><a href="{{route('Role.show',['id' => encode($role->id)])}}"><button class="btn btn-sm btn-primary">{{trans('global.Edit')}}</button></a>
                      <form class="d-inline" method="post" action="{{route('Role.delete',['id' => encode($role->id)])}}">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE">

                  <button type="submit" class="btn btn-sm btn-danger deleteRoleBtn">{{trans('global.Delete')}}</button>
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
   $('#rolesTable').DataTable();

    $("#rolesTableBody").on('click','.deleteRoleBtn',function(e){
      e.preventDefault();
       bsAlert("@lang('global.AreYouSure')", 
        "@lang('authorization::global.AreYouSureRole')",
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
