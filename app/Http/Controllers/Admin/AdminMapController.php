<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ServisApotek;
use Illuminate\View\View;

class AdminMapController extends Controller
{
    public function __construct(private ServisApotek $servisApotek) {}

    public function index(): View
    {
        $apotekMap = $this->servisApotek->getAllForMap();

        return view('admin.peta.index', compact('apotekMap'));
    }
}