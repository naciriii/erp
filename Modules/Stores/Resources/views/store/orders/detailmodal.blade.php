<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="orderDetail" tabindex="-1" role="dialog"
     aria-labelledby="orderDetail" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 80% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="exampleModalLabel">{{trans('stores::global.Order&AccountInformation')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <din class="row">
                            <div class="col-md-6">
                                <form class="form-inline" method="post" action="{{route('Store.Invoices.create',
                                ['id'=>encode($store->id)])}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="order_id" id="order-id">
                                    <input type="hidden" name="entity_id" id="entity-id">

                                    <button type="submit" class="btn btn-primary mb-2" style="margin-left: 6px;">
                                        {{trans('stores::global.CreateInvoice')}}
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form class="form-inline pull-right" method="post" action="{{route('Store.Orders.updateStatus',['id'=>encode($store->id)])}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="order_id" id="order-id">
                                    <input type="hidden" name="entity_id" id="entity-id">
                                    <div class="form-group mb-2">
                                        <select id="status" name="status" class="form-control">
                                            <option value="0">Action</option>
                                            <option value="1">Cancel</option>
                                            <option value="2">Hold</option>
                                            <option value="3">Unhold</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-2" style="margin-left: 6px;">
                                        {{trans('stores::global.Save')}}
                                    </button>
                                </form>
                            </div>
                        </din>

                    </div>
                    <div class="col-md-6">
                        <h6>Order # <span id="increment-id"></span></h6>
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td>
                                    <span class="pull-left">{{trans('stores::global.OrderDate')}} </span>
                                    <span class="pull-right" id="order-date"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="pull-left">{{trans('stores::global.OrderStatus')}} </span>
                                    <span class="pull-right" id="order-status"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="pull-left">{{trans('stores::global.PurchasedFrom')}} </span>
                                    <span class="pull-right" id="store-name"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="pull-left">{{trans('stores::global.PlacedFromIP')}}</span>
                                    <span id="remote-ip" class="pull-right"></span>
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
                                    <a class="pull-right" id="customer" href="#"></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="pull-left">Email </span>
                                    <a id="customer-email" class="pull-right" href="#"></a>
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
                    <div class="col-md-6" id="billing-address">
                        <h6>{{trans('stores::global.BillingAddress')}}</h6>
                        <p></p>
                    </div>
                    <div class="col-md-6" id="shipping-address">
                        <h6>{{trans('stores::global.ShippingAddress')}}</h6>
                        <p></p>
                    </div>
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
                                <td><span class="pull-left">{{trans('stores::global.Subtotal')}} </span><span class="pull-right"
                                                                                  id="subtotal"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="pull-left">{{trans('stores::global.Shipping&Handling')}} </span><span
                                            class="pull-right" id="shipping-amount"></span></td>
                            </tr>
                            </tbody>
                        </table>
                        <hr>
                        <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <td>
                                    <span class="pull-left">{{trans('stores::global.GrandTotal')}} </span><span class="pull-right"
                                                                                     id="grand-total"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="pull-left">{{trans('stores::global.TotalPaid')}} </span><span
                                            class="pull-right" id="amount-paid"></span></td>
                            </tr>
                            <tr>
                                <td><span class="pull-left">{{trans('stores::global.TotalRefunded')}} </span><span
                                            class="pull-right" id="amount-refunded"></span></td>
                            </tr>
                            <tr>
                                <td><span class="pull-left">{{trans('stores::global.TotalDue')}} </span><span
                                            class="pull-right" id="total-due"></span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('stores::global.Close')}}</button>
                <button type="button" class="btn btn-primary">{{trans('stores::global.Save')}}</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal /-->

