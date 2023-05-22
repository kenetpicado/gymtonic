<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('prices')->paginate(10);

        return inertia('Services/Index', [
            'services' => $services
        ]);
    }

    public function store(ServiceRequest $request)
    {
        Service::create($request->validated());
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->validated());
    }
}
