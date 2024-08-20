<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public static function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:32',
            'amount' => 'required',
            'regular' => 'required',
            'type' => 'required',
            'type_of_payment' => 'required'
        ]);

        if ($validator->fails()) {
            return back();
        }
        Payment::Create(
            [
                'user_id' => Auth::user()->id,
                'title' => $request['title'],
                'amount' => $request['amount'],
                'regular' => $request['regular'],
                'period' => $request['period'],
                'type' => $request['type'],
                'type_of_payment' => $request['type_of_payment']
            ]
        );

        $user_id = Auth::user()->id;

        $balance = Balance::where('user_id', $user_id)->first();

        if ($balance == null) {
            Balance::create([
                'user_id' => $user_id,
                'balance' => $request['amount']
            ]);
        } else {
            $amount = $balance->balance;
            $newBalance = $amount - $request['amount'];
            Balance::where('user_id', $user_id)->update(array('balance' => $newBalance));
        }

        return back();
    }
}
