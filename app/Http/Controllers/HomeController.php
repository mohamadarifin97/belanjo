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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $spendings_total = Spending::orderBy('id', 'desc')->limit(12)->get('total')->toArray();
        $spendings_month = Spending::orderBy('id', 'desc')->limit(12)->get(['month', 'year'])
                                    ->map(function ($spending) {
                                        $year = substr(strval($spending->year), 2); //remove first 2 character from 4 digit year
                                        return [
                                            "$spending->month, $year",
                                        ];
                                    })
                                    ->toArray();
        $years = Spending::orderBy('year', 'desc')->distinct()->get(['year'])->toArray();

        $spendings_data = [
            'data' => Arr::flatten(array_reverse($spendings_total)),
            'categories' => Arr::flatten(array_reverse($spendings_month))
        ];

        return view('home', compact('spendings_data', 'years'));
    }

    public function spendingStat(Request $request)
    {
        if ($request->show == null) {
            $show = 12;
        } else if ($request->show == 'all') {
            $show = null;
        } else {
            $show = $request->show;
        }

        if ($request->year) {
            $spendings_total = Spending::orderBy('id', 'desc')
                                        ->limit($show)
                                        ->where('year', $request->year)
                                        ->get('total')
                                        ->sortByDesc('id')
                                        ->toArray();

            $spendings_month = Spending::orderBy('id', 'desc')
                                        ->limit($show)
                                        ->where('year', $request->year)
                                        ->get(['month', 'year'])
                                        ->map(function($spending) {
                                            $year = substr(strval($spending->year), 2); //remove first 2 character from 4 digit year
                                            return [
                                                "$spending->month, $year",
                                            ];
                                        })
                                        ->toArray();
    
            $spendings_data = [
                'data' => Arr::flatten(array_reverse($spendings_total)),
                'categories' => Arr::flatten(array_reverse($spendings_month))
            ];
    
            return response()->json($spendings_data);
        } else {
            $spendings_total = Spending::orderBy('id', 'desc')
                                        ->limit($show)
                                        ->get('total')
                                        ->sortByDesc('id')
                                        ->toArray();

            $spendings_month = Spending::orderBy('id', 'desc')
                                        ->limit($show)
                                        ->get(['month', 'year'])
                                        ->map(function($spending) {
                                            $year = substr(strval($spending->year), 2); //remove first 2 character from 4 digit year
                                            return [
                                                "$spending->month, $year",
                                            ];
                                        })
                                        ->toArray();

            $spendings_data = [
                'data' => Arr::flatten(array_reverse($spendings_total)),
                'categories' => Arr::flatten(array_reverse($spendings_month))
            ];

            return response()->json($spendings_data);
        }
    }
}