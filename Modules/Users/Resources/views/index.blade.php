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
          <li class="breadcrumb-item active"><a href="#">{{trans('gobal.List')}}}</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <table class="table table-hover table-bordered" id="usersTable">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                	  @foreach($users as $user)
                     <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->created_at}}</td>
                    <td><a href="{{route('Users.show',['id' => encode($user->id)])}}"><button class="btn btn-primary">Show</button></a></td>
                   
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
    <script type="text/javascript">
   $('#usersTable').DataTable();

</script>

@stop
