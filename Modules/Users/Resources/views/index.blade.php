@extends('users::layouts.master')

@section('content')
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> {{trans('modules.Users')}}</h1>
          <p>Table to display analytical data effectively</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">{{trans('modules.Users')}}</li>
          <li class="breadcrumb-item active"><a href="#">{{trans('gobal.List')}}</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <table class="table table-hover table-bordered" id="usersTable">
                <thead>
                  <tr>
                    <th>{{trans('users::global.Name')}}</th>
                    <th>{{trans('users::global.Email')}}</th>
                    <th>{{trans('users::global.CreatedAt')}}</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="usersTableBody">
                	  @foreach($users as $user)
                     <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{str_limit($user->created_at,16,'')}}</td>
                    <td><a href="{{route('Users.show',['id' => encode($user->id)])}}"><button class="btn btn-sm btn-primary">{{trans('global.Edit')}}</button></a>
                      <form class="d-inline" method="post" action="{{route('Users.delete',['id' => encode($user->id)])}}">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE">

                  <button type="submit" class="btn btn-sm btn-danger deleteUserBtn">{{trans('global.Delete')}}</button>
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
   $('#usersTable').DataTable();

    $("#usersTableBody").on('click','.deleteUserBtn',function(e){
      e.preventDefault();
       bsAlert("@lang('global.AreYouSure')", 
        "@lang('users::global.AreYouSureUser')",
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
