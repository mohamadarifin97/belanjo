<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Spending;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HomeController extends BaseController
{
    public function spending(Request $request)
    {
        $spendings_total = Spending::orderBy('id', 'desc')->limit(12)->get('total')->toArray();
        $spendings_month = Spending::orderBy('id', 'desc')->limit(12)->get('month')->toArray();

        $spendings_data = [
            'data' => Arr::flatten(array_reverse($spendings_total)),
            'categories' => Arr::flatten(array_reverse($spendings_month))
        ];

        return response()->json($spendings_data, 200);
    }
}
