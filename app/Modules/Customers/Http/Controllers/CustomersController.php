<?php

namespace App\Modules\Customers\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Customers\Contracts\CustomersRepositoryInterface;
use App\Modules\Customers\Http\Requests\CustomerUpdateRequest;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    private $customerRepo;

    public function __construct(CustomersRepositoryInterface $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function getAllCustomers()
    {
        return $this->customerRepo->getAllCustomers();
    }

    public function createNewCustomer(CustomerUpdateRequest $request)
    {
        $saveData = [
            'name' => $request->get('customerName'),
            'address' => $request->get('customerAddress'),
            'email' => $request->get('customerEmail'),
            'phone_number' => $request->get('customerContactNumber')
        ];

        $customer = $this->customerRepo->create($saveData);
        return response()->json(['data' => $customer], 200);
    }

    public function updateCustomer(CustomerUpdateRequest $request, $id)
    {
        $saveData = [
            'name' => $request->get('customerName'),
            'address' => $request->get('customerAddress'),
            'email' => $request->get('customerEmail'),
            'phone_number' => $request->get('customerContactNumber')
        ];
        $customer = $this->customerRepo->update($saveData, $id);
        return response()->json(['data' => $customer], 200);

    }

    public function deleteCustomer(Request $request, $id)
    {
        $customer = $this->customerRepo->delete($id);
        return response()->json(['data' => $customer], 200);
    }
}
