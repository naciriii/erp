<?php

namespace Modules\Stores\Http\Controllers\Store;

use Modules\Stores\Http\Controllers\StoreController;
use Illuminate\Http\Request;


class CustomerController extends StoreController
{


    public function index()
    {

        $current_page = $this->page;
        $result = $this->repository->getAllCustomers(10, $current_page);

        $data = [
            'store' => $this->getStore(),
            'result' => $result
        ];

        return view('stores::store.customers.index')->with($data);
    }

    public function create($id)
    {
        $data = ['store' => $this->getStore()];
        return view('stores::store.customers.create')->with($data);
    }

    public function store($id, Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|min:4',
            'last_name' => 'required|min:4',
            'email' => 'required|email',
            'street_address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
            'phone_number' => 'required',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required',
        ],
            [
                'password.regex' => 'Classes of characters: Lower Case, Upper Case, Digits, Special Characters.'
            ]);


        $customerObj = $this->getCustomerModel();
        //user
        $customerObj->customer->firstname = $request->first_name;
        $customerObj->customer->lastname = $request->last_name;
        $customerObj->customer->email = $request->email;
        $customerObj->customer->prefix = ($request->name_prefix) ? $request->name_prefix : '';
        $customerObj->customer->middlename = ($request->middle_name) ? $request->middle_name : '';
        $customerObj->customer->suffix = ($request->name_suffix) ? $request->name_suffix : '';
        $customerObj->customer->taxvat = ($request->tax_vat) ? $request->tax_vat : '';
        $customerObj->customer->gender = ($request->gender) ? $request->gender : '';
        $customerObj->customer->dob = ($request->birth_date) ? $request->birth_date : '';
        $customerObj->password = $request->password;

        //address
        $customerObj->customer->addresses[0]->customer_id = 0;
        $customerObj->customer->addresses[0]->region_id = 0;
        $customerObj->customer->addresses[0]->country_id = $request->country;
        $customerObj->customer->addresses[0]->street[0] = $request->street_address;
        $customerObj->customer->addresses[0]->firstname = $request->first_name;
        $customerObj->customer->addresses[0]->lastname = $request->last_name;
        $customerObj->customer->addresses[0]->telephone = $request->phone_number;
        $customerObj->customer->addresses[0]->city = $request->city;
        $customerObj->customer->addresses[0]->postcode = $request->postal_code;

        return redirect()->route('Store.Customers.index', ['id' => $id])
            ->with(
                ['response' => [
                    trans('stores::global.Customer_added'),
                    trans('stores::global.Customer_added_success', ['customer' => '<b>' . $request->first_name . '</b>']),
                    'info'
                ]]);
    }

    public function show($id, $customer)
    {
        $result = $this->repository->getCustomer(decode($customer));
        if ($result == null) {
            return abort(404);
        }

        $data = [
            'customer' => $result,
            'store' => $this->getStore()
        ];
        return view('stores::store.customers.show')->with($data);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|min:4',
            'last_name' => 'required|min:4',
            'email' => 'required|email',
            'street_address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
            'phone_number' => 'required',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required',
        ],
            [
                'password.regex' => 'Classes of characters: Lower Case, Upper Case, Digits, Special Characters.'
            ]);


        $customerObj = $this->getCustomerModel();
        //user
        $customerObj->customer->firstname = $request->first_name;
        $customerObj->customer->lastname = $request->last_name;
        $customerObj->customer->email = $request->email;
        $customerObj->customer->prefix = ($request->name_prefix) ? $request->name_prefix : '';
        $customerObj->customer->middlename = ($request->middle_name) ? $request->middle_name : '';
        $customerObj->customer->suffix = ($request->name_suffix) ? $request->name_suffix : '';
        $customerObj->customer->taxvat = ($request->tax_vat) ? $request->tax_vat : '';
        $customerObj->customer->gender = ($request->gender) ? $request->gender : '';
        $customerObj->customer->dob = ($request->birth_date) ? $request->birth_date : '';
        $customerObj->password = $request->password;

        //address
        $customerObj->customer->addresses[0]->customer_id = 0;
        $customerObj->customer->addresses[0]->region_id = 0;
        $customerObj->customer->addresses[0]->country_id = $request->country;
        $customerObj->customer->addresses[0]->street[0] = $request->street_address;
        $customerObj->customer->addresses[0]->firstname = $request->first_name;
        $customerObj->customer->addresses[0]->lastname = $request->last_name;
        $customerObj->customer->addresses[0]->telephone = $request->phone_number;
        $customerObj->customer->addresses[0]->city = $request->city;
        $customerObj->customer->addresses[0]->postcode = $request->postal_code;

        $customer = $this->repository->updateCustomer($customerObj);
        return redirect()->route('Store.Customers.index', ['id' => $id])->with(['response' =>
            [
                trans('stores::global.Customer_updated'),
                trans('stores::global.Customer_updated_success', ['customer' => '<b>' . $request->name . '</b>']),
                'info'
            ]]);
    }

    public function delete($id, $customer)
    {
        $result = $this->repository->deleteCustomers(decode($customer));
        $data = [
            'result' => $result,
            'store' => $this->getStore()
        ];
        return redirect()->route('Store.Customers.index', ['id' => $id])->with(['response' =>
            [
                trans('stores::global.Customer_deleted'),
                trans('stores::global.Customer_deleted_success', ['customer' => '<b>' . decode($customer) . '</b>']),
                'info'
            ]]);

        return view('stores::store.customers.index')->with($data);
    }


    private function getCustomerModel()
    {
        $customer = json_decode('{
                          "customer": {
                            "id": 0,
                            "groupId": 0,
                            "defaultBilling": "string",
                            "defaultShipping": "string",
                            "confirmation": "string",
                            "createdAt": "string",
                            "updatedAt": "string",
                            "createdIn": "string",
                            "dob": "string",
                            "email": "string",
                            "firstname": "string",
                            "lastname": "string",
                            "middlename": "string",
                            "prefix": "string",
                            "suffix": "string",
                            "gender": 0,
                            "storeId": 0,
                            "taxvat": "string",
                            "websiteId": 0,
                            "addresses": [
                              {
                                "id": 0,
                                "customerId": 0,
                                "region": {
                                  "regionCode": "string",
                                  "region": "string",
                                  "regionId": 0,
                                  "extensionAttributes": {}
                                },
                                "regionId": 0,
                                "countryId": "string",
                                "street": [
                                  "string"
                                ],
                                "company": "string",
                                "telephone": "string",
                                "fax": "string",
                                "postcode": "string",
                                "city": "string",
                                "firstname": "string",
                                "lastname": "string",
                                "middlename": "string",
                                "prefix": "string",
                                "suffix": "string",
                                "vatId": "string",
                                "defaultShipping": true,
                                "defaultBilling": true,
                                "extensionAttributes": {},
                                "customAttributes": []
                              }
                            ],
                            "disableAutoGroupChange": 0,
                            "extensionAttributes": {},
                            "customAttributes": []
                          },
                          "password": "strinG_123",
                          "redirectUrl": "string"
                        }');

        return $customer;
    }
}
