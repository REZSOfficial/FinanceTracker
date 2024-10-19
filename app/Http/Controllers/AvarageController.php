<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Payment;
use App\Models\Incoming;
use Illuminate\Http\Request;

class AvarageController extends Controller
{
    public function index(Request $request): \Inertia\Response
    {
        $month = Carbon::now()->month;

        if ($request->has('month')) {
            $month = intval($request->month);

            $averageIncomingByType = Incoming::getAverageByType($month);
            $averagePaymentByType = Payment::getAverageByType($month);

            return response()->json([
                'averageIncomingByType' => $averageIncomingByType,
                'averageOutgoingByType' => $averagePaymentByType,
                'currentMonth' => $month
            ]);
        }

        $averageIncoming = Incoming::getAverage();
        $averageOutgoing = Payment::getAverage();

        $averageIncomingByType = Incoming::getAverageByType($month);
        $averagePaymentByType = Payment::getAverageByType($month);

        return Inertia::render('Avarages/Show', [
            'averageIncoming' => $averageIncoming,
            'averageOutgoing' => $averageOutgoing,
            'averageIncomingByType' => $averageIncomingByType,
            'averageOutgoingByType' => $averagePaymentByType,
            'currentMonth' => $month
        ]);
    }
}
