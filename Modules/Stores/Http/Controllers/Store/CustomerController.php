<?php

namespace Modules\Stores\Http\Controllers\Store;

use Modules\Stores\Http\Controllers\StoreController;
use Illuminate\Http\Request;


class CustomerController extends StoreController
{


    public function index()
    {

        $page_size = 10;
        $current_page = $this->page;

        $result = $this->repository->getAllCustomers($page_size, $current_page);

        $data = [
            'store' => $this->getStore(),
            'result' => $result
        ];

        return view('stores::store.customers.index')->with($data);
    }

    public function show($id, $customerId)
    {
        $result = $this->repository->getCustomer($customerId);
        if ($result == null) {
            return abort(404);
        }
        $data = [
            'customer' => $result,
            'store' => $this->getStore()];
        return view('stores::store.customers.show')->with($data);
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
        $customerObj->password = $request->password;


        //address
        $address = new \StdClass;

        $address->street = $request->street_address;
        $address->postcode = $request->postal_code;
        $address->city = $request->city;
        $address->telephone = $request->phone_number;

        $customerObj->customer->addresses [] = $address;
        dd($customerObj);
        /*
        $customer = $this->repository->addCustomer($customerObj);
        return redirect()->route('Store.Customers.index', ['id' => $id])->with(['response' =>
            [
                trans('stores::global.Customer_added'),
                trans('stores::global.Customer_added_success', ['customer' => '<b>' . $request->name . '</b>']),
                'info'
            ]]);*/
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|min:4',
            'last_name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $customerObj = $this->getCustomerModel();
        $customerObj->customer->firstname = $request->first_name;
        $customerObj->customer->lastname = $request->last_name;
        $customerObj->customer->email = $request->email;
        $customerObj->password = $request->password;
        $customer = $this->repository->updateCustomer($customerObj);
        return redirect()->route('Store.Customers.index', ['id' => $id])->with(['response' =>
            [
                trans('stores::global.Customer_updated'),
                trans('stores::global.Customer_updated_success', ['customer' => '<b>' . $request->name . '</b>']),
                'info'
            ]]);
    }

    public function delete($id, $customerId)
    {
        $result = $this->repository->deleteCustomer($customerId);
        $data = [
            'result' => $result,
            'store' => $this->getStore()
        ];
        return redirect()->route('Store.Customers.index', ['id' => $id])->with(['response' =>
            [
                trans('stores::global.Customer_deleted'),
                trans('stores::global.Customer_deleted_success', ['customer' => '<b>' . $customerId . '</b>']),
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
                                "customAttributes": [
                                  {
                                    "attributeCode": "string",
                                    "value": "string"
                                  }
                                ]
                              }
                            ],
                            "disableAutoGroupChange": 0,
                            "extensionAttributes": {},
                            "customAttributes": [
                              {
                                "attributeCode": "string",
                                "value": "string"
                              }
                            ]
                          },
                          "password": "string",
                          "redirectUrl": "string"
                        }');

        return $customer;
    }
}
