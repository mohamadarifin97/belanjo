<?php

namespace App\Http\Controllers;

use App\Models\Spending;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $spendings_total = Spending::get('total')->toArray();
        $spendings_month = Spending::get(['month', 'year'])
                                    ->map(function ($spending) {
                                        $year = substr(strval($spending->year), 2); //remove first 2 character from 4 digit year
                                        return [
                                            "$spending->month, $year",
                                        ];
                                    })
                                    ->toArray();
        $spendings_data = [
            'data' => Arr::flatten($spendings_total),
            'categories' => Arr::flatten($spendings_month)
        ];

        return view('home', compact('months_years', 'spendings_data'));
    }
}