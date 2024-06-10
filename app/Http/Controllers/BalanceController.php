<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'balance' => 'integer',
        ]);


        Balance::updateOrCreate(
            [
                'user_id' => Auth::user()->id
            ],
            [
                'balance' => $request['balance'],
            ]
        );
        session()->flash('success', 'Balance updated successfully.');
        return redirect()->back();
    }
}
