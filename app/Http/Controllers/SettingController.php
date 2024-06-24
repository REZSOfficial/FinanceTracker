<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Inertia\Inertia;
use App\Models\Balance;
use App\Models\Preference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function show()
    {
        if (Preference::where('user_id', Auth::user()->id)->first() == null) {
            Preference::create([
                'user_id' => Auth::user()->id,
            ]);
        }
        $preferences = Preference::where('user_id', Auth::user()->id)->first();
        $data = Data::where('user_id', Auth::user()->id)->first();
        $balance = Balance::getBalanceByUserId(Auth::user()->id);

        return Inertia::render('Settings/Show', [
            'data' => $data,
            'balance' => $balance,
            'preferences' => $preferences
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

    public function updatePreferences(Request $request)
    {
        $preference = Preference::where('user_id', Auth::user()->id)->first();

        $preference->food_and_drink = $request['food_and_drink'];
        $preference->housing = $request['housing'];
        $preference->transportation = $request['transportation'];
        $preference->healthcare = $request['healthcare'];
        $preference->entertainment = $request['entertainment'];
        $preference->other = $request['other'];

        $preference->save();

        return redirect()->back();
    }
}
