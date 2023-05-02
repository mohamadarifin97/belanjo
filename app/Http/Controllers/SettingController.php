<?php

namespace App\Http\Controllers;

use App\Models\Commitment;
use App\Models\Spending;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
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

        return view('setting', compact('months_years'));
    }

    public function listCommitment(Request $request)
    {
        $data = Commitment::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="javascript:void(0)" class="edit text-primary me-1"><i class="bi bi-pen"></i></a> <a href="javascript:void(0)" class="delete text-danger"><i class="bi bi-trash"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function storeCommitment(Request $request)
    {
        $request->validate([
            'commitment' => 'required',
            'value' => 'required'
        ]);

        DB::beginTransaction();
        try {
            Commitment::create([
                'commitment' => $request->commitment,
                'value' => $request->value,
            ]);
    
            DB::commit();
            return back()->with('message', 'Ok, mantap!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return back()->with('error', 'Ado yang tak kono haa!');
        }
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
            $new_spending_arr[$explode[0]] = $explode[1];
            $count = $count + $explode[1];
        }

        DB::beginTransaction();
        try {
            $spending = Spending::create([
                'spend_list' => json_encode($new_spending_arr),
                'total' => $count,
                'month' => intval($month_year[0]),
                'year' => intval($month_year[1])
            ]);

            foreach ($request->sourceOfIncome_arr as $sourceOfIncome) {
                $spending->monthlyIncomes()->create([
                    'name' => $sourceOfIncome['source_of_income'],
                    'value' => $sourceOfIncome['value']
                ]);
            }

            DB::commit();
            return back()->with('message', 'Ok, mantap!');

        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
            
            return back()->with('error', 'Ado yang tak kono haa!');
        }
    }
}
