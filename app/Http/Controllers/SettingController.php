<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Inertia\Inertia;
use App\Models\Balance;
use App\Models\Preference;
use Illuminate\Http\Request;
use App\Http\Requests\DataRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PreferenceRequest;
use App\Models\User;

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

        $currentCurrency = Auth::user()->currency;

        return Inertia::render('Settings/Show', [
            'data' => $data,
            'balance' => $balance,
            'preferences' => $preferences,
            'currentCurrency' => $currentCurrency
        ]);
    }

    public function update(DataRequest $request)
    {
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

    public function updatePreferences(PreferenceRequest $request)
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

    public function updateCurrency(Request $request)
    {
        $request->validate([
            'currency' => 'string',
        ]);

        $user = User::find(Auth::user()->id);

        $user->currency = $request['currency'];

        $user->save();

        return redirect()->back();
    }
}
