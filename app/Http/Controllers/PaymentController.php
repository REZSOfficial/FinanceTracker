<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public static function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'out_title' => 'required|max:32',
            'out_amount' => 'required',
            'out_regular' => 'required',
            'out_type' => 'required',
            'out_type_of_payment' => 'required'
        ]);

        $validator->setAttributeNames([
            'out_title' => 'title',
            'out_amount' => 'amount',
            'out_regular' => 'regular',
            'out_type' => 'type',
            'out_type_of_payment' => 'type of payment'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $data = Payment::Create(
            [
                'user_id' => $request['user_id'],
                'title' => $request['out_title'],
                'amount' => $request['out_amount'],
                'regular' => $request['out_regular'],
                'period' => $request['out_period'],
                'type' => $request['out_type'],
                'type_of_payment' => $request['out_type_of_payment']
            ]
        );

        $balance = Balance::where('user_id', $request['user_id'])->first();
        $amount = $balance->balance;
        $newBalance = $amount - $request['out_amount'];
        Balance::where('user_id', $request['user_id'])->update(array('balance' => $newBalance));

        return response()->json(['incoming' => $data, 'newBalance' => $newBalance], 200);
    }
}
