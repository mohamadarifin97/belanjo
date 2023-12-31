<?php

namespace App\Http\Controllers;

use App\Models\Commitment;
use App\Models\Spending;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    public function index()
    {
        $period = now()->subMonths(1)->monthsUntil(now());

        $months_years = [];
        foreach ($period as $date) {
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
            ->addColumn('action', function ($row) {
                $data = [
                    'id' => $row->id,
                    'commitment' => $row->commitment,
                    'value' => $row->value
                ];
                $data_json = json_encode($data);

                $actionBtn = "<a href='javascript:void(0)' onClick='editCommitment($data_json)' class='edit text-primary me-1'><i class='bi bi-pen'></i></a>";

                $route = route('commitment.delete', ['id' => $row->id]);
                $actionBtn .= "<a href='$route' class='delete text-danger'><i class='bi bi-trash'></i></a>";
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

    public function updateCommitment(Request $request)
    {
        $validated_data = Validator::make($request->only(['commitment', 'value']), [
            'commitment' => 'required|max:255',
            'value' => 'required|regex:/^[0-9.]+$/'
        ]);

        if ($validated_data->fails()) {
            return back()->with('error', 'Masukkan data yang betol!');
        }

        DB::beginTransaction();
        try {
            Commitment::where('id', $request->commitment_id)->update($validated_data->getData());
            DB::commit();
            return back()->with('message', 'Ok, mantap!');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()->with('error', 'Ado yang tak kono haa!');
        }
    }

    public function deleteCommitment($id)
    {
        Commitment::find($id)->delete();
        return back()->with('message', 'Ok, mantap!');
    }

    public function storeSpendingList(Request $request)
    {
        $month_year = explode(' - ', $request->month_year);
        $spending_arr = preg_split('/\n|\r\n?/', $request->spending_list);

        $new_spending_arr = [];
        $group = '';
        $count = 0;

        foreach ($spending_arr as $spending) {
            $is_hyphen_exist = strpos($spending, ' - ');

            if ($is_hyphen_exist == false) {
                $group = $spending;
                continue;
            }

            $explode = explode(' - ', $spending);
            $new_spending_arr[$group][] = [
                'spend' => $explode[0],
                'value' => $explode[1]
            ];

            $count = $count + $explode[1];
        }

        DB::beginTransaction();
        try {
            $spending = Spending::create([
                'spend_list' => json_encode($new_spending_arr),
                'total' => number_format($count, 2, '.', ''),
                'month' => intval($month_year[0]),
                'year' => intval($month_year[1])
            ]);

            foreach ($new_spending_arr as $key => $items) {
                foreach ($items as $item) {
                    $spending->spendingDetails()->create([
                        'spend' => $item['spend'],
                        'value' => $item['value'],
                        'group' => $key
                    ]);
                }
            }

            foreach ($request->sourceOfIncome_arr as $sourceOfIncome) {
                if ($sourceOfIncome['source_of_income'] != null && $sourceOfIncome['value'] != null) {
                    $spending->monthlyIncomes()->create([
                        'name' => $sourceOfIncome['source_of_income'],
                        'value' => $sourceOfIncome['value']
                    ]);
                }
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
