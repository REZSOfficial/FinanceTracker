<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomingRequest;
use App\Models\Balance;
use App\Models\Incoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IncomingController extends Controller
{



    public static function create(IncomingRequest $request)
    {
        $user_id = Auth::user()->id;
        Incoming::Create(
            [
                'user_id' => $user_id,
                'title' => $request['title'],
                'amount' => $request['amount'],
                'regular' => $request['regular'],
                'period' => $request['period'],
                'type' => $request['type'],
                'type_of_payment' => $request['type_of_payment']
            ]
        );

        $balance = Balance::where('user_id', $user_id)->first();

        if ($balance == null) {
            Balance::create([
                'user_id' => $user_id,
                'balance' => $request['amount']
            ]);
        } else {
            $amount = $balance->balance;
            $newBalance = $amount + $request['amount'];
            Balance::where('user_id', $user_id)->update(array('balance' => $newBalance));
        }

        return back();
    }

    public function delete(Incoming $incoming)
    {
        $incoming->delete();

        return response()->json(['success' => true]);
    }
}
