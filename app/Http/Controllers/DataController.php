<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Data;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{
    static function getDataByUserId($id)
    {
        $data = DB::table('data')->where('user_id', $id)->first();

        if ($data) {
            return $data;
        }

        return null;
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

        session()->flash('success', 'Data updated successfully.');
        return redirect()->back();
    }
}
