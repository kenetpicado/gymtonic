<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return inertia('Services/Index', [
            'services' => Service::with('prices')->paginate(10),
            'periods' => Service::$periods,
        ]);
    }

    public function store(ServiceRequest $request)
    {
        $created = Service::create($request->validated());
        $created->prices()->createMany($request->prices);

        return redirect()->route('dashboard.services.index');
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->validated());
        $service->prices()->delete();
        $service->prices()->createMany($request->prices);

        return redirect()->route('dashboard.services.index');
    }
}
