<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Saving;
use App\Models\Balance;
use App\Models\Payment;
use App\Models\Incoming;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DataController;
use Inertia\Inertia;

class HomeController extends Controller
{

    public static function index()
    {
        $data = DataController::getDataByUserId(Auth::user()->id);

        $payments = Payment::getPaymentsByUserId(Auth::user()->id);
        $cashPayments = Payment::getPaymentsByUserIdAndType(Auth::user()->id, 'cash');
        $cardPayments = Payment::getPaymentsByUserIdAndType(Auth::user()->id, 'card');
        $regularPayments = Payment::getRegularPaymentsByUserId(Auth::user()->id);

        $incomings = Incoming::getIncomingByUserId(Auth::user()->id);
        $regularIncomings = Incoming::getRegularIncomingByUserId(Auth::user()->id);


        //Bejövő fizetésekből visszamaradó hónapok kiszámítása
        $monthsLeft = [];
        //Hátralévő hónapok Carbonnal
        $currentDate = Carbon::now();
        foreach ($regularIncomings as $rI) {
            $dbDate = Carbon::parse($rI->created_at);
            $monthsDifference = $currentDate->diffInMonths($dbDate);
            array_push($monthsLeft,  ["id" => $rI->id, "monthsDiff" => $monthsDifference]);
        }

        //Kimenő fizetésekből visszamaradó hónapok kiszámítása
        $paymentMonthsLeft = [];
        //Hátralévő hónapok Carbonnal
        $currentDate = Carbon::now();
        foreach ($regularPayments as $rP) {
            $dbDate = Carbon::parse($rP->created_at);
            $monthsDifference = $currentDate->diffInMonths($dbDate);
            array_push($paymentMonthsLeft,  ["id" => $rP->id, "monthsDiff" => $monthsDifference]);
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
            'monthsLeft' => $monthsLeft,
            'regularPayments' => $regularPayments,
            'paymentsMonthsLeft' => $paymentMonthsLeft,
            'regularIncomings' => $regularIncomings,
            'incomings' => $incomings,
            'payments' => $payments,
            'data' => $data,
            'cashPayments' => $cashPayments,
            'cardPayments' => $cardPayments,
            'inAndOut' => $in_and_out,
            'balance' => $balance
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
        $data = DataController::getDataByUserId(Auth::user()->id);
        $balance = Balance::getBalanceByUserId(Auth::user()->id);
        return view('profile', ['data' => $data, 'savings' => $savings, 'balance' => $balance]);
    }
}
