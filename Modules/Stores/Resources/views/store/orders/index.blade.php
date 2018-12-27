@extends('stores::layouts.master')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> @lang('stores::global.StoreMenus.Orders')</h1>
                <p class="mt-2">
                    <a href="{{route('Store.Orders.create',['id'=>encode($store->id)])}}">
                        <button class="btn btn-sm btn-primary">@lang('stores::global.NewOrder')</button>
                    </a>
                </p>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{trans('modules.Stores')}}</li>
                <li class="breadcrumb-item active"><a href="#">@lang('stores::global.StoreMenus.Orders')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <nav class="navbar navbar-light bg-light pull-right">
                                    <form class="form-inline" method="get"
                                          action="{{route('Store.Orders.search',['id'=>encode($store->id)])}}">
                                        <input id="search" name="search" class="form-control mr-sm-2" type="search"
                                               placeholder="Search" aria-label="Search" value="{{$findBy or ''}}">
                                    </form>
                                </nav>
                            </div>
                        </div>
                        <table class="table table-hover table-bordered" id="ordersTable">
                            <thead>
                            <tr>
                                <th>{{trans('stores::global.Id')}}</th>
                                <th>{{trans('stores::global.PurchasePoint')}}</th>
                                <th>{{trans('stores::global.PurchaseDate')}}</th>
                                <th>{{trans('stores::global.BillToName')}}</th>
                                <th>{{trans('stores::global.ShipToName')}}</th>
                                <th>{{trans('stores::global.GrandTotalBase')}}</th>
                                <th>{{trans('stores::global.GrandTotalPruchased')}}</th>
                                <th>{{trans('stores::global.Status')}}</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody id="OrdersTableBody">
                            @if(isset($result->items))
                                @foreach(collect($result->items)->sortByDesc('created_at') as $order)
                                    <tr>
                                        <td>{{$order->increment_id}}</td>
                                        <td>{{$order->store_name or ''}}</td>
                                        <td>{{$order->created_at}}</td>
                                        <td>{{$order->customer_firstname or ''}} {{$order->customer_lastname or ''}}</td>
                                        <td>{{$order->billing_address->firstname or ''}} {{$order->billing_address->lastname or ''}}</td>
                                        <td>€ {{$order->base_grand_total or ''}}</td>
                                        <td>€ {{$order->total_due or ''}}</td>
                                        <td>{{$order->status or ''}}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                    onclick="showDetails({{json_encode($order)}},'{{encode($order->customer_id)}}','{{encode($store->id)}}')">
                                                @lang('stores::global.View')
                                            </button>
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

@include('stores::store.orders.detailmodal');

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
        {!! dataTable('#ordersTable') !!}
        {!! simplePagination($result,'#simple-pagination',$findBy) !!}

        $("#OrdersTableBody").on('click', '.deleteOrderBtn', function (e) {
            e.preventDefault();
            bsAlert("@lang('global.AreYouSure')",
                "@lang('stores::global.AreYouSureOrder')",
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
