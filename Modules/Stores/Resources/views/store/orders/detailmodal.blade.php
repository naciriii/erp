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

                            </div>
                            <div class="col-md-6">
                                <form class="form-inline pull-right">

                                    <div class="form-group mb-2">
                                        <select id="status" name="status" class="form-control">
                                            <option value="">Pending</option>
                                            <option value="">Cancel</option>
                                            <option value="">Hold</option>
                                            <option value="">Unhold</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-2" style="margin-left: 6px;">Save
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
                                    <span class="pull-left">Order Date </span>
                                    <span class="pull-right" id="order-date"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="pull-left">Order Status </span>
                                    <span class="pull-right" id="order-status"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="pull-left">Purchased From </span>
                                    <span class="pull-right" id="store-name"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="pull-left">Placed from IP </span>
                                    <span id="remote-ip" class="pull-right"></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 id="account-information"> Account Information

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
                        <h6> Address Information </h6>
                        <hr>
                    </div>
                    <div class="col-md-6" id="billing-address">
                        <h6>Billing Address</h6>
                        <p></p>
                    </div>
                    <div class="col-md-6" id="shipping-address">
                        <h6>Shipping Address</h6>
                        <p></p>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <h6> Items Ordered</h6>
                        <table class="table" id="products">
                            <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Item Status</th>
                                <th scope="col">Original Price</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Tax Amount</th>
                                <th scope="col">Tax Percent</th>
                                <th scope="col">Discount Amount</th>
                                <th scope="col">Row Total</th>
                            </tr>
                            </thead>
                            <tbody id="products-body">

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h6> Order Total </h6>
                        <hr>
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td><span class="pull-left">Subtotal </span><span class="pull-right"
                                                                                  id="subtotal"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="pull-left">Shipping & Handling  </span><span
                                            class="pull-right" id="shipping-amount"></span></td>
                            </tr>
                            </tbody>
                        </table>
                        <hr>
                        <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <td>
                                    <span class="pull-left">Grand Total </span><span class="pull-right"
                                                                                     id="grand-total"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="pull-left">Total Paid </span><span
                                            class="pull-right" id="amount-paid"></span></td>
                            </tr>
                            <tr>
                                <td><span class="pull-left">Total Refunded </span><span
                                            class="pull-right" id="amount-refunded"></span></td>
                            </tr>
                            <tr>
                                <td><span class="pull-left">Total Due </span><span
                                            class="pull-right" id="total-due"></span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal /-->

@section('js')
    <script type="text/javascript" src="{{asset('js/plugins/select2.min.js')}}"></script>

    <script type="text/javascript">
        $('#status').select2();

        function showDetails(data, customer_id, store_id) {

            $('#orderDetail #increment-id').text(data.increment_id);
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
                    '<td>' + value.name + '</br>SKU: ' + value.sku + '</td>' +
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
@endsection