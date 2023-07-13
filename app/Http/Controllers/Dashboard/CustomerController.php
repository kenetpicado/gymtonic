<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Inertia\Response;

class CustomerController extends Controller
{
    public function __construct(
        private CustomerService $customerService
    ) {
    }

    public function index(Request $request): Response
    {
        return inertia('Customers/Index', $this->customerService->index($request));
    }

    public function show(Customer $customer)
    {
        return inertia('Customers/Show', [
            'customer' => $customer->load('incomes'),
        ]);
    }

    public function create(): Response
    {
        return inertia('Customers/Create', $this->customerService->create());
    }

    public function store(CustomerRequest $request)
    {
        $this->customerService->store($request->validated());
    }

    public function edit(Customer $customer): Response
    {
        return inertia('Customers/Create', $this->customerService->edit($customer));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $this->customerService->update($request->validated(), $customer);
    }
}
