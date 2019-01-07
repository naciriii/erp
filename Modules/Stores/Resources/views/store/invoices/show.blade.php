@extends('stores::layouts.master')
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> @lang('stores::global.Invoice') # {{$invoice->increment_id}}
                </h1>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Order # <span id="increment-id">{{$order->increment_id}}</span></h6>
                                        <table class="table table-striped">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <span class="pull-left">{{trans('stores::global.OrderDate')}} </span>
                                                    <span class="pull-right"
                                                          id="order-date"> {{$order->created_at or ''}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="pull-left">{{trans('stores::global.OrderStatus')}} </span>
                                                    <span class="pull-right"
                                                          id="order-status">{{$order->status or ''}}</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="pull-left">{{trans('stores::global.PurchasedFrom')}} </span>
                                                    <span class="pull-right"
                                                          id="store-name">{{$order->store_name or ''}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="pull-left">{{trans('stores::global.PlacedFromIP')}}</span>
                                                    <span id="remote-ip"
                                                          class="pull-right">{{$order->remote_ip or ''}}</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 id="account-information">{{trans('stores::global.AccountInformation')}}

                                        </h6>
                                        <table class="table table-striped">

                                            <tbody>
                                            <tr>
                                                <td>
                                                    <span class="pull-left">Customer Name </span>
                                                    <a class="pull-right" id="customer"
                                                       href="#">{{$order->customer_firstname or ''}} {{$order->customer_lastname or ''}}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="pull-left">Email </span>
                                                    <a id="customer-email" class="pull-right"
                                                       href="#">{{$order->customer_email or ''}}</a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <h6> {{trans('stores::global.AddressInformation')}}</h6>
                                        <hr>
                                    </div>
                                    @if ($order->billing_address->address_type == 'billing')
                                        <div class="col-md-6" id="billing-address">
                                            <h6>{{trans('stores::global.BillingAddress')}}</h6>
                                            <p>
                                                <span>
                                                    {{$order->billing_address->firstname or ''}} {{$order->billing_address->lastname or ''}}
                                                </span></br>
                                                @if(count($order->billing_address->street))
                                                    <span>
                                                    {{$order->billing_address->street[0] or ''}}
                                                </span></br>
                                                @endif
                                                <span>
                                                    {{$order->billing_address->city or ''}}
                                                    {{$order->billing_address->region or ''}}
                                                    {{$order->billing_address->postcode or ''}}
                                                </span></br>
                                                <span>
                                                    {{$order->billing_address->country_id or ''}}
                                                </span></br>
                                                <span>
                                                    <a href="tel:{{$order->billing_address->telephone or '#'}}">{{$order->billing_address->telephone or ''}}</a>
                                                </span>
                                            </p>
                                        </div>
                                    @endif

                                    @if(count($order->extension_attributes->shipping_assignments)
                                         && collect($order->extension_attributes->shipping_assignments)->first()->shipping->address->address_type == 'shipping')
                                        <div class="col-md-6" id="shipping-address">
                                            <h6>{{trans('stores::global.ShippingAddress')}}</h6>
                                            <p>
                                                <span>
                                                    {{collect($order->extension_attributes->shipping_assignments)->first()->shipping->address->firstname}}
                                                    {{collect($order->extension_attributes->shipping_assignments)->first()->shipping->address->lastname}}
                                                </span></br>
                                                @if(count(collect($order->extension_attributes->shipping_assignments)->first()->shipping->address->street))
                                                    <span>
                                                    {{collect($order->extension_attributes->shipping_assignments)->first()->shipping->address->street[0]}}
                                                </span></br>
                                                @endif
                                                <span>
                                                    {{collect($order->extension_attributes->shipping_assignments)->first()->shipping->address->city}}
                                                    {{collect($order->extension_attributes->shipping_assignments)->first()->shipping->address->region}}
                                                    {{collect($order->extension_attributes->shipping_assignments)->first()->shipping->address->postcode}}
                                                </span></br>
                                                <span>
                                                    {{collect($order->extension_attributes->shipping_assignments)->first()->shipping->address->country_id}}
                                                </span></br>
                                                <span>
                                                    <a href="tel:{{collect($order->extension_attributes->shipping_assignments)->first()->shipping->address->telephone}}">
                                                        {{collect($order->extension_attributes->shipping_assignments)->first()->shipping->address->telephone}}
                                                    </a>
                                                </span>
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h6>{{trans('stores::global.ItemsOrdered')}}</h6>
                                        <table class="table" id="products">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{trans('stores::global.Product')}}</th>
                                                <th scope="col">{{trans('stores::global.ItemStatus')}}</th>
                                                <th scope="col">{{trans('stores::global.OriginalPrice')}}</th>
                                                <th scope="col">{{trans('stores::global.Price')}}</th>
                                                <th scope="col">{{trans('stores::global.Qty')}}</th>
                                                <th scope="col">{{trans('stores::global.Subtotal')}}</th>
                                                <th scope="col">{{trans('stores::global.TaxAmount')}}</th>
                                                <th scope="col">{{trans('stores::global.TaxPercent')}}</th>
                                                <th scope="col">{{trans('stores::global.DiscountAmount')}}</th>
                                                <th scope="col">{{trans('stores::global.RowTotal')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody id="products-body">

                                            @foreach($order->items as $item)
                                                <tr>
                                                    <td>{{$item->name}} </br>
                                                        {{trans('stores::global.Sku')}}: {{$item->sku}}</td>
                                                    <td>Ordered</td>
                                                    <td>{{$item->original_price}}</td>
                                                    <td>{{$item->price}}</td>
                                                    <td>Ordered {{$item->qty_ordered}}</td>
                                                    <td>€ xxx</td>
                                                    <td>€ {{$item->tax_amount}}</td>
                                                    <td>{{$item->tax_percent}} %</td>
                                                    <td>{{$item->discount_amount}}</td>
                                                    <td>€ {{$item->row_total}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h6>{{trans('stores::global.OrderTotal')}}</h6>
                                        <hr>

                                        <table class="table table-striped">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <span class="pull-left">{{trans('stores::global.Subtotal')}} </span>
                                                    <span class="pull-right" id="subtotal">{{$order->subtotal}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="pull-left">{{trans('stores::global.Shipping&Handling')}} </span>
                                                    <span class="pull-right" id="shipping-amount">{{$order->shipping_amount}}</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <table class="table table-borderless">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <span class="pull-left">{{trans('stores::global.GrandTotal')}} </span>
                                                    <span class="pull-right" id="grand-total">{{$order->grand_total}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="pull-left">{{trans('stores::global.TotalPaid')}} </span>
                                                    <span class="pull-right" id="amount-paid">
                                                        @if(!isset($order->payment->amount_paid))
                                                            € 0
                                                        @else
                                                            {{$order->payment->amount_paid}}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="pull-left">{{trans('stores::global.TotalRefunded')}} </span>
                                                    <span class="pull-right" id="amount-refunded">
                                                        @if(!isset($order->payment->amount_refunded))
                                                            € 0
                                                        @else
                                                            {{$order->payment->amount_refunded}}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="pull-left">{{trans('stores::global.TotalDue')}} </span>
                                                    <span class="pull-right" id="total-due">€ {{$order->total_due}}</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


@stop