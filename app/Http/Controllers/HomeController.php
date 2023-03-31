<?php

namespace App\Http\Controllers;

use App\Models\Spending;
use Illuminate\Http\Request;

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
        return view('home');
    }

    public function storeSpendingList(Request $request)
    {
        $spending_arr = preg_split('/\n|\r\n?/', $request->spending_list);

        $new_spending_arr = [];
        $count = 0;
        // foreach ($spending_arr as $spending) {
        //     $explode = explode(' - ', $spending);
        //     $new_spending_arr[$explode[0]] = $explode[1];
        //     $count = $count + $explode[1];
        // }

        // Spending::create([
        //     'spend_list' => json_encode($new_spending_arr),
        //     'total' => $count
        // ]);

        // dd('here');
        return back()->with('error', 'test');
    }
}