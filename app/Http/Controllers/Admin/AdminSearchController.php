<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ServisApotek;
use Illuminate\View\View;

class AdminSearchController extends Controller
{
    public function __construct(private ServisApotek $servisApotek) {}

    public function index(): View
    {
        $jalanList = $this->servisApotek->getAllJalan();

        return view('admin.search.index', compact('jalanList'));
    }
}
