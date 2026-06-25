<?php

namespace App\Http\Controllers;

use App\Services\ServisApotek;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private ServisApotek $servisApotek) {}

    public function index(): View
    {
        $stats     = $this->servisApotek->getDashboardStats();
        $apotekMap = $this->servisApotek->getAllForMap();

        return view('user.dashboard', compact('stats', 'apotekMap'));
    }
}
