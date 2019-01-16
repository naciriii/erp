@extends('stores::layouts.master')
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> @lang('stores::global.StoreMenus.Customers')
                </h1>
                <p class="mt-2">
                    <a href="{{route('Store.Customers.create',['id'=>encode($store->id)])}}">
                        <button class="btn btn-sm btn-primary">@lang('stores::global.NewCustomer')</button>
                    </a>
                </p>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{trans('modules.Store')}}</li>
                <li class="breadcrumb-item active"><a href="#">@lang('stores::global.StoreMenus.Customers')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body table-responsive">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <nav class="navbar navbar-light bg-light pull-right">
                                    <form class="form-inline" method="get" action="{{route('Store.Customers.Search',['id'=>encode($store->id)])}}">
                                        <input id="search" name="search" class="form-control mr-sm-2" type="search"
                                               placeholder="Search" aria-label="Search" value="{{$findBy or ''}}">
                                    </form>
                                </nav>
                            </div>
                        </div>
                        <table class="table table-hover table-bordered" id="customersTable">
                            <thead>
                            <tr>
                                <th>{{trans('stores::global.Email')}}</th>
                                <th>{{trans('stores::global.FirstName')}}</th>
                                <th>{{trans('stores::global.LastName')}}</th>
                                <th>{{trans('stores::global.Phone')}}</th>
                                <th>{{trans('stores::global.Address')}}</th>
                                <th>{{trans('stores::global.CreatedAt')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="customersTableBody">
                            @if(isset($result->items))
                                @foreach(collect($result->items)->sortByDesc('created_at') as $customer)
                                    <tr>
                                        <td>{{$customer->email}}</td>
                                        <td>{{$customer->firstname}}</td>
                                        <td>{{$customer->lastname}}</td>
                                        <td>
                                            @if(count($customer->addresses))
                                                {{$customer->addresses[0]->telephone}}
                                            @endif
                                        </td>
                                        <td>
                                            @if(count($customer->addresses))
                                                {{$customer->addresses[0]->country_id.' '.$customer->addresses[0]->city.' '.$customer->addresses[0]->postcode}}
                                            @endif
                                        </td>
                                        <td>{{$customer->created_at}}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary"
                                               href="{{route('Store.Customers.show',['id'=>encode($store->id),'customer' => encode($customer->id)])}}">
                                                {{trans('global.Edit')}}
                                            </a>
                                            <form class="d-inline" method="post" action="{{route('Store.Customers.destroy',['id' => encode($store->id),'customer'=>encode($customer->id)])}}">
                                                {{csrf_field()}}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-sm btn-danger deleteCustomerBtn">{{trans('global.Delete')}}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <nav id="simple-pagination" class="pull-right"></nav>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </main>

@stop
@section ('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/simplePagination.css')}}">
@stop
@section('js')
    <script type="text/javascript" src="{{asset('js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/sweetalert.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/jquery.simplePagination.js')}}"></script>

    <script type="text/javascript">

        {!! dataTable('#customersTable') !!}
        {!! simplePagination($result,'#simple-pagination',$findBy) !!}





        $("#customersTableBody").on('click', '.deleteCustomerBtn', function (e) {
            e.preventDefault();
            bsAlert("@lang('global.AreYouSure')",
                "@lang('stores::global.AreYouSureCustomer')",
                "warning",
                "@lang('global.Confirm')",
                "@lang('global.Cancel')",
                function (isConfirm) {
                    if (isConfirm) {
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
