<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataRequest;
use Carbon\Carbon;
use App\Models\Data;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{

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

        session()->flash('success', 'Data updated successfully.');
        return redirect()->back();
    }
}
