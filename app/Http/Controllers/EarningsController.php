<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EarningsController extends Controller
{
    public function earnings()
    {
        return view('freelancer.earnings');
    }
}
