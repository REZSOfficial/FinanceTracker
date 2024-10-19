<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavingRequest;
use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingController extends Controller
{
    public function update(SavingRequest $request)
    {
        Saving::updateOrCreate(
            [
                'user_id' => Auth::user()->id
            ],
            [
                'title' => $request['title'],
                'amount' => $request['amount'],
                'description' => $request['description'],
                'date' => $request['date'],
            ]
        );
        session()->flash('success', 'Savings updated successfully.');
        return redirect()->back();
    }
}
