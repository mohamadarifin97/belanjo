<?php

namespace App\Http\Controllers;

use App\Models\Spending;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
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
        $period = now()->subMonths(20)->monthsUntil(now());

        $months_years = [];
        foreach ($period as $date)
        {
            $months_years[] = [
                'month' => $date->month,
                'month_name' => $date->shortMonthName,
                'year' => $date->year,
            ];
        }
        krsort($months_years);

        return view('home', compact('months_years'));
    }

    public function storeSpendingList(Request $request)
    {
        // dd($request->all());
        $month_year = explode(' - ', $request->month_year);
        $spending_arr = preg_split('/\n|\r\n?/', $request->spending_list);

        $new_spending_arr = [];
        $count = 0;
        foreach ($spending_arr as $spending) {
            $explode = explode(' - ', $spending);
            info($explode);
            $new_spending_arr[$explode[0]] = $explode[1];
            $count = $count + $explode[1];
        }

        DB::beginTransaction();
        try {
            Spending::create([
                'spend_list' => json_encode($new_spending_arr),
                'total' => $count,
                'month' => intval($month_year[0]),
                'year' => intval($month_year[1])
            ]);

            DB::commit();
            return back()->with('message', 'Ok, mantap!');

        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
            
            return back()->with('error', 'Ado yang tak kono haa!');
        }
    }
}