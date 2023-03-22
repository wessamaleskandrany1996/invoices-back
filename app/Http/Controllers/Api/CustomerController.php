<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResourse;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::paginate(15);
        return CustomerResourse::collection($customers);
    }
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return new CustomerResourse($customer);
    }

    public function store(CustomerRequest $request)
    {
        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);
        return new CustomerResourse($customer);
    }

    public function update(CustomerRequest $request, $id)
    {

        $customer = Customer::findOrFail($id);
        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);
        return new CustomerResourse($customer);
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return "customer has been deleted";
    }

}
