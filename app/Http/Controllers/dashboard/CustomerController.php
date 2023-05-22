<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(
        private CustomerService $customerService
    ) {
    }

    public function index(Request $request): \Inertia\Response
    {
        return inertia('Customers/Index', [
            'customers' => $this->customerService->index($request),
        ]);
    }

    public function create(): \Inertia\Response
    {
        return inertia('Customers/Create', $this->customerService->create());
    }

    public function show(Customer $customer): \Inertia\Response
    {
        return inertia('Customers/Show', $this->customerService->show($customer));
    }

    public function store(CustomerRequest $request)
    {
        $this->customerService->store($request->validated());
    }

    public function edit(Customer $customer): \Inertia\Response
    {
        return inertia('Customers/Create', $this->customerService->edit($customer));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $this->customerService->update($request->validated(), $customer);
    }
}
