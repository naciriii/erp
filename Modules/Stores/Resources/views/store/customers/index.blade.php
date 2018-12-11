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
                    <div class="tile-body">

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
                                @foreach(collect($result->items) as $customer)
                                    <tr>
                                        <td>{{$customer->email}}</td>
                                        <td>{{$customer->firstname}}</td>
                                        <td>{{$customer->lastname}}</td>
                                        <td>@if(count($customer->addresses))
                                                {{$customer->addresses[0]->telephone}}
                                            @endif</td>
                                        <td>@if(count($customer->addresses))
                                                {{$customer->addresses[0]->country_id.' '.$customer->addresses[0]->city.' '.$customer->addresses[0]->postcode}}
                                            @endif</td>
                                        <td>{{$customer->created_at}}</td>
                                        <td></td>
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
    <script type="text/javascript" src="{{asset('js/jquery.simplePagination.js')}}"></script>

    <script type="text/javascript">
        {!! simplePagination($result,'#simple-pagination') !!}

        $('#customersTable').DataTable({
            paginate: false,
            bInfo: false
        });


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
