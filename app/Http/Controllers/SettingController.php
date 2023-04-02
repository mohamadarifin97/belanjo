<?php

namespace App\Http\Controllers;

use App\Models\Commitment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting');
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
}
