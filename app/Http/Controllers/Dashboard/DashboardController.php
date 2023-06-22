<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    )
    {

    }
    public function __invoke()
    {
        return inertia('Dashboard', $this->dashboardService->index());
    }
}
