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
                                                    onclick="showDetails({{json_encode($order)}},'{{@encode($order->customer_id)}}','{{encode($store->id)}}')">
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

    <script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/select2.min.js')}}"></script>
    <script type="text/javascript">
        {!! dataTable('#ordersTable') !!}
        {!! simplePagination($result,'#simple-pagination',$findBy) !!}
    </script>

    <script type="text/javascript">
        $('#status').select2();
        function showDetails(data, customer_id, store_id) {

            $('#orderDetail #increment-id').text(data.increment_id);
            $('#orderDetail #order-id').val(data.increment_id);
            $('#orderDetail #entity-id').val(data.entity_id);
            $('#orderDetail #remote-ip').text(data.remote_ip);
            $('#orderDetail #order-date').text(data.created_at);
            $('#orderDetail #order-status').text(data.status);
            $('#orderDetail #store-name').text(data.store_name);
            $('#orderDetail #customer').text(data.customer_firstname + ' ' + data.customer_lastname);
            $('#orderDetail #customer').attr('href', '/store/' + store_id + '/customers/' + customer_id);
            $('#orderDetail #customer-email').text(data.customer_email);
            $('#orderDetail #customer-email').attr('href', 'mailto:' + data.customer_email);

            //product list
            $.each(data.items, function (index, value) {
                $('#products tr').after('<tr>' +
                    '<td>' + value.name + '</br>{{trans('stores::global.Sku')}}: ' + value.sku + '</td>' +
                    '<td>Ordered</td>' +
                    '<td>' + value.original_price + '</td>' +
                    '<td>' + value.price + '</td>' +
                    '<td>Ordered ' + value.qty_ordered + '</td>' +
                    '<td>€ xxx </td>' +
                    '<td>€ ' + value.tax_amount + '</td>' +
                    '<td>' + value.tax_percent + '%</td>' +
                    '<td>' + value.discount_amount + '</td>' +
                    '<td>€ ' + value.row_total + '</td>' +
                    '</tr>');
            });

            $('#orderDetail #subtotal').text('€ ' + data.subtotal);
            $('#orderDetail #shipping-amount').text('€ ' + data.shipping_amount);
            $('#orderDetail #grand-total').text('€ ' + data.grand_total);
            $('#orderDetail #total-due').text('€ ' + data.total_due);
            $('#orderDetail #amount-paid').text(data.payment.amount_paid == null ? '€ ' + 0 : '€ ' + data.payment.amount_paid);
            $('#orderDetail #amount-refunded').text(data.payment.amount_refunded == null ? '€ ' + 0 : '€ ' + data.payment.amount_refunded);

            var billing = '';
            var shipping = '';
            if (data.billing_address.address_type == 'billing') {
                billing = '<span id="billing-customer">' + data.billing_address.firstname + ' ' + data.billing_address.lastname + '</span>' +
                    '</br>' +
                    '<span id="billing-street">' + data.billing_address.street[0] + '</span>' +
                    '</br>' +
                    '<span id="billing-address">' + data.billing_address.city + ', ' + data.billing_address.region + ', ' + data.billing_address.postcode + '</span>' +
                    '</br>' +
                    '<span id="billing-country">' + data.billing_address.country_id + '</span>' +
                    '</br>' +
                    '<span id="billing-tel">T:<a href="tel:' + data.billing_address.telephone + '">' + data.billing_address.telephone + '</a></span>'
                $('#orderDetail #billing-address p').html(billing);
            }

            if (data.extension_attributes.shipping_assignments[0].shipping.address.address_type == 'shipping') {
                shipping = '<span id="shipping-customer">' + data.extension_attributes.shipping_assignments[0].shipping.address.firstname + ' ' + data.extension_attributes.shipping_assignments[0].shipping.address.lastname + '</span>' +
                    '</br>' +
                    '<span id="shipping-street">' + data.extension_attributes.shipping_assignments[0].shipping.address.street[0] + '</span>' +
                    '</br>' +
                    '<span id="shipping-address">' + data.extension_attributes.shipping_assignments[0].shipping.address.city + ', ' + data.extension_attributes.shipping_assignments[0].shipping.address.region + ', ' + data.extension_attributes.shipping_assignments[0].shipping.address.postcode + '</span>' +
                    '</br>' +
                    '<span id="shipping-country">' + data.extension_attributes.shipping_assignments[0].shipping.address.country_id + '</span>' +
                    '</br>' +
                    '<span id="shipping-tel">T:<a href="tel:' + data.extension_attributes.shipping_assignments[0].shipping.address.telephone + '">' + data.extension_attributes.shipping_assignments[0].shipping.address.telephone + '</a></span>'
                $('#orderDetail #shipping-address p').html(shipping);
            }

            var link = '<a target="_blank" href="' + '/store/' + store_id + '/customers/' + customer_id + '">' +
                '{{trans('global.Edit')}}' +
                '</a>'
            $('#orderDetail #account-information').html(link);

            //show Modal
            $('#orderDetail').modal('show');
        }

        $('#orderDetail').on('hidden.bs.modal', function () {
            $('#products tr').not(function () {
                return !!$(this).has('th').length;
            }).remove();
        });
    </script>

    @if(session('response'))
        <script>
            {!! bsNotify(session('response')) !!};
        </script>
    @endif
@stop

