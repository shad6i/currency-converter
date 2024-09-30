<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CurrencyRate;

class CurrencyController extends Controller
{
    public function index()
    {
        $rates = CurrencyRate::all();
        return view('admin.currency.index', compact('rates'));
    }
}
