<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Data;
use Inertia\Inertia;
use App\Models\Saving;
use App\Models\Balance;
use App\Models\Payment;
use App\Models\Incoming;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DataController;

class HomeController extends Controller
{

    public static function index()
    {
        $data = Data::where('user_id', Auth::user()->id)->first() ?? null;

        $payments = Payment::getPaymentsByUserId(Auth::user()->id);
        $regularPayments = Payment::getRegularPaymentsByUserId(Auth::user()->id);

        $incomings = Incoming::getIncomingByUserId(Auth::user()->id);
        $regularIncomings = Incoming::getRegularIncomingByUserId(Auth::user()->id);

        //Bejövő fizetésekből visszamaradó hónapok kiszámítása
        foreach ($regularIncomings as $incoming) {
            $incoming->remaining_months = $incoming->remainingMonths();
        }

        //Kimenő fizetésekből visszamaradó hónapok kiszámítása
        foreach ($regularPayments as $payment) {
            $payment->remaining_months = $payment->remainingMonths();
        }

        $in_and_out = ["in" => 0, "out" => 0];
        foreach ($payments as $payment) {
            $in_and_out['out'] += intval($payment->amount);
        }
        foreach ($incomings as $incoming) {
            $in_and_out['in'] += intval($incoming->amount);
        }

        $balance = Balance::getBalanceByUserId(Auth::user()->id);

        return Inertia::render('Dashboard', [
            'regularPayments' => $regularPayments,
            'regularIncomings' => $regularIncomings,
            'incomings' => $incomings,
            'payments' => $payments,
            'data' => $data,
            'inAndOut' => $in_and_out,
            'balance' => $balance,
        ]);
    }

    public function payments()
    {
        $payments = Payment::getPaymentsByUserId(Auth::user()->id);
        $incomings = Incoming::getIncomingByUserId(Auth::user()->id);
        return Inertia::render('Payments/Show', ['outgoings' => $payments, 'incomings' => $incomings]);
    }

    public function profile()
    {

        $savings = Saving::where('user_id', Auth::user()->id)->first();
        $data = Data::where('user_id', Auth::user()->id)->first() ?? null;
        $balance = Balance::getBalanceByUserId(Auth::user()->id);
        return view('profile', ['data' => $data, 'savings' => $savings, 'balance' => $balance]);
    }
}
