@extends('stores::layouts.master')
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> @lang('stores::global.StoreMenus.Invoices')</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{trans('modules.Store')}}</li>
                <li class="breadcrumb-item active"><a href="#">@lang('stores::global.StoreMenus.Invoices')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                {{--}}<nav class="navbar navbar-light bg-light pull-right">
                                    <form class="form-inline" method="get" action="{{route('Store.Invoices.Search',['id'=>encode($store->id)])}}">
                                        <input id="search" name="search" class="form-control mr-sm-2" type="search"
                                               placeholder="Search" aria-label="Search" value="{{$findBy or ''}}">
                                    </form>
                                </nav>--}}
                            </div>
                        </div>
                        <table class="table table-hover table-bordered" id="incoicesTable">
                            <thead>
                            <tr>
                                <th>{{trans('stores::global.Invoice')}}</th>
                                <th>{{trans('stores::global.InvoiceDate')}}</th>
                                <th>{{trans('stores::global.OrderId')}}</th>
                                <th>{{trans('stores::global.OrderDate')}}</th>
                                <th>{{trans('stores::global.Bill-to Name ')}}</th>
                                <th>{{trans('stores::global.Status')}}</th>
                                <th>{{trans('stores::global.GrandTotalBase')}}</th>
                                <th>{{trans('stores::global.GrandTotalPruchased')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="invoicesTableBody">
                            @if(isset($result->items))
                                @foreach(collect($result->items)->sortByDesc('created_at') as $invoice)
                                    <tr>
                                        <td>{{$invoice->increment_id}}</td>
                                        <td>{{$invoice->created_at}}</td>
                                        <td>{{collect($invoice->order)->first()->increment_id}}</td>
                                        <td>{{collect($invoice->order)->first()->created_at}}</td>
                                        <td>{{collect($invoice->order)->first()->customer_firstname}} {{collect($invoice->order)->first()->customer_lastname}}</td>
                                        <td>{{collect($invoice->order)->first()->status}}</td>
                                        <td>€ {{$invoice->base_grand_total}}</td>
                                        <td>€ {{collect($invoice->order)->first()->grand_total}}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary"
                                               href="{{route('Store.Invoices.show',
                                               ['id'=>encode($store->id),'entityId' => encode($invoice->entity_id)])}}">
                                                @lang('stores::global.View')
                                            </a>
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

        {!! dataTable('#incoicesTable') !!}
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
