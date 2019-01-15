<?php

namespace Modules\Stores\Http\Controllers\Store;

use Modules\Stores\Http\Controllers\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;


class OrderController extends StoreController
{
    public function index()
    {
        $current_page = $this->page;
        $result = $this->repository->all(['page_size' => 20, 'current_page' => $current_page]);
        //dd($result);

        $data = [
            'store' => $this->getStore(),
            'result' => $result,
            'findBy' => ''
        ];

        return view('stores::store.orders.index')->with($data);
    }

    //first step: get customers list => select customer
    public function create($id)
    {
        $customers = $this->repository->getCustomers(['page_size' => 20, 'current_page' => $this->page]);

        $data = [
            'store' => $this->getStore(),
            'result' => $customers,
            'findBy' => ''
        ];

        return view('stores::store.orders.steps.customers')->with($data);
    }

    //first step: get products => select products
    public function stepOne($id, $customerId)
    {
        $products = $this->repository->getProducts(['page_size' => 20, 'current_page' => $this->page]);
        $data = [
            'store' => $this->getStore(),
            'result' => $products,
            'findBy' => '',
            'customerId' => $customerId
        ];
        return view('stores::store.orders.steps.productCards')->with($data);
    }

    //get customer, select products (items) => create the order
    public function stepTow(Request $request, $id, $customerId)
    {
        $customer = $this->repository->getCustomer(decode($customerId));

        if (!$customer) {
            return redirect()->back();
        }

        $orderObj = $this->getOrderModel();

        //prepare items
        foreach ($request->products as $product) {
            $item = new \StdClass;
            $item->base_original_price = json_decode($product['prop'])->price;
            $item->base_price = json_decode($product['prop'])->price;
            $item->name = json_decode($product['prop'])->name;
            $item->original_price = json_decode($product['prop'])->price;
            $item->price = json_decode($product['prop'])->price;
            $item->product_id = json_decode($product['prop'])->id;
            $item->product_type = json_decode($product['prop'])->type_id;
            $item->qty_ordered = $product['qty'];
            $item->sku = json_decode($product['prop'])->sku;
            $item->weight = json_decode($product['prop'])->weight;
            //we need to check product tax
            $item->store_id = 0;
            $item->price_incl_tax = 0;
            $item->base_price_incl_tax = 0;
            $item->base_row_total = 0;
            $item->base_row_total_incl_tax = 0;
            $item->row_total = 0;
            $item->row_total_incl_tax = 0;
            $items [] = $item;
        }

        $orderObj->entity->items = $items;
        //prepare billingAddress
        $billingAddress = new \StdClass;
        foreach ($customer->addresses as $address) {
            if (isset($address->default_billing) && $address->default_billing == true) {
                $billingAddress->address_type = 'billing';
                $billingAddress->city = $address->city;
                $billingAddress->company = $address->company;
                $billingAddress->country_id = $address->country_id;
                $billingAddress->customer_address_id = $address->customer_id;
                $billingAddress->email = $customer->email;
                $billingAddress->firstname = $address->firstname;
                $billingAddress->lastname = $address->lastname;
                $billingAddress->postcode = $address->postcode;
                $billingAddress->region = $address->region->region;
                $billingAddress->street[0] = $address->street[0];
                $billingAddress->telephone = $address->telephone;
            }
        }

        $orderObj->entity->billing_address = $billingAddress;
        collect($orderObj->entity->extension_attributes->shipping_assignments)->first()->shipping->address = $billingAddress;
        collect($orderObj->entity->extension_attributes->shipping_assignments)->first()->items = $items;

        //user information
        $orderObj->entity->customer_dob = '';
        $orderObj->entity->customer_email = $customer->email;
        $orderObj->entity->customer_firstname = $customer->firstname;
        $orderObj->entity->customer_gender = (isset($customer->gender)) ? $customer->gender : 0;
        $orderObj->entity->customer_id = $customer->id;
        $orderObj->entity->customer_lastname = $customer->lastname;
        $orderObj->entity->state = 'pending';
        $orderObj->entity->status = 'pending';
        $orderObj->entity->store_currency_code = 'EUR';
        $orderObj->entity->base_currency_code = 'EUR';
        $orderObj->entity->global_currency_code = 'EUR';

        $order = $this->repository->add($orderObj);

        return redirect()->route('Store.Orders.index', ['id' => $id])->with(['response' =>
            [
                trans('stores::global.Order_added'),
                trans('stores::global.Order_added_success', ['order' => '<b>' . $order->increment_id . '</b>']),
                'info'
            ]]);
    }

    public function search(Request $request)
    {
        // TODO: search an order
        $data = [
            'store' => $this->getStore()
        ];
        return view('stores::store.orders.index')->with($data);
    }


    public function updateStatus($id, Request $request)
    {
        if ($request->status == 1) {
            $status = 'cancel';
        } elseif ($request->status == 2) {
            $status = 'hold';
        } elseif ($request->status == 3) {
            $status = 'unhold';
        } else {
            return redirect()->back();
        }

        $statusObj = json_decode('{
            "entity": {
                "entity_id": 0,
                "state":"",
                "status": ""
            }
        }');

        $statusObj->entity->entity_id = $request->entity_id;
        $statusObj->entity->state = $status;
        $statusObj->entity->status = $status;

        $this->repository->updateStatus($statusObj);

        return redirect()->route('Store.Orders.index', ['id' => $id])->with(['response' =>
            [
                trans('stores::global.Order_status_updated'),
                trans('stores::global.Order_updated_success', ['order' => '<b>' . $request->order_id . '</b>']),
                'info'
            ]]);
    }

    function getOrderModel()
    {
        $order = json_decode('{
                  "entity": {
                      "base_currency_code": "EUR",
                      "base_discount_amount": null,
                      "base_grand_total": null,
                      "base_shipping_amount": null,
                      "base_shipping_incl_tax": null,
                      "base_shipping_tax_amount": null,
                      "base_shipping_discount_amount": null,
                      "base_subtotal": null,
                      "base_subtotal_incl_tax": null,
                      "base_total_due": null,
                      "base_to_global_rate": null,
                      "base_to_order_rate": null,
                      "discount_tax_compensation_amount": null,
                      "base_discount_tax_compensation_amount": null,
                      "shipping_discount_tax_compensation_amount": null,
                      "customer_is_guest": 0,
                      "customer_dob": "",
                      "customer_email": "",
                      "customer_firstname": "",
                      "customer_gender": 1,
                      "customer_group_id": 0,
                      "customer_id": 23,
                      "customer_lastname": "",
                      "customer_note_notify": 1,
                      "discount_amount": null,
                      "email_sent": 0,
                      "global_currency_code": "EUR",
                      "grand_total": null,
                      "order_currency_code": "EUR",
                      "remote_ip": "",
                      "shipping_amount": null,
                      "shipping_tax_amount": null,
                      "shipping_description": "",
                      "shipping_discount_amount": null,
                      "shipping_incl_tax": null,
                      "state": "pending",
                      "status": "pending",
                      "store_currency_code": "EUR",
                      "store_to_base_rate": 0,
                      "store_to_order_rate": 0,
                      "store_id": 1,
                      "subtotal": null,
                      "subtotal_incl_tax": null,
                      "total_due": null,
                      "total_item_count": 1,
                      "total_qty_ordered": 1,
                      "tax_amount": null,
                      "weight": 1,
                      "items": [],
                      "billing_address": {
                          "address_type": "billing",
                          "city": "",
                          "company": "",
                          "country_id": "",
                          "customer_address_id": 0,
                          "email": "",
                          "firstname": "",
                          "lastname": "",
                          "postcode": "",
                          "region": "",
                          "street": [],
                          "telephone": ""
                      },
                      "payment": {
                          "amount_ordered": null,
                          "base_amount_ordered": null,
                          "base_shipping_amount": null,
                          "method": "checkmo",
                          "shipping_amount": null
                      },
                      "status_histories": [],
                      "extension_attributes": {
                          "shipping_assignments": [
                              {
                                  "shipping": {
                                      "address": {
                                          "address_type": "",
                                          "city": "",
                                          "company": "",
                                          "country_id": "",
                                          "customer_address_id": 0,
                                          "email": "",
                                          "firstname": "",
                                          "lastname": "",
                                          "postcode": "",
                                          "region": "",
                                          "street": [""],
                                          "telephone": ""
                                      },
                                      "method": "",
                                      "total": {
                                          "base_shipping_amount": null,
                                          "base_shipping_incl_tax": null,
                                          "shipping_amount": null,
                                          "shipping_incl_tax": null
                                      },
                                      "extension_attributes": []
                                  },
                                  "items": [],
                                  "extension_attributes": []
                              }
                          ],
                          "applied_taxes": [],
                          "item_applied_taxes": [],
                          "converting_from_quote": true
                      }
                  }
                }');
        return $order;
    }
}
