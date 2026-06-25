<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ServisApotek;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __construct(private ServisApotek $servisApotek) {}

    public function index(): View
    {
        $stats = $this->servisApotek->getDashboardStats();
        $apotekMap = $this->servisApotek->getAllForMap();

        return view('admin.dashboard', compact('stats', 'apotekMap'));
    }
}