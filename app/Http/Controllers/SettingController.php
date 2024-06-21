<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Inertia\Inertia;
use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function show()
    {
        return Inertia::render('Settings/Show', [
            'data' => Data::where('user_id', Auth::user()->id)->first(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'food_drink' => 'integer',
            'housing' => 'integer',
            'transportation' => 'integer',
            'healthcare' => 'integer',
            'entertainment' => 'integer',
            'other' => 'integer',
        ]);


        Data::updateOrCreate(
            [
                'user_id' => Auth::user()->id
            ],
            [
                'food_drink' => $request['food_drink'],
                'housing' => $request['housing'],
                'transportation' => $request['transportation'],
                'healthcare' => $request['healthcare'],
                'entertainment' => $request['entertainment'],
                'other' => $request['other'],
            ]
        );

        return redirect()->back();
    }

    public function updateBalance(Request $request)
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
        return redirect()->back();
    }
}
