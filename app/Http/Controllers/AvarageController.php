<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Payment;
use App\Models\Incoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvarageController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->has('month') ? intval($request->month) : Carbon::now()->month;
        $type = $request->has('type') ? $request->type : null;

        $averageIncomingByType = Incoming::getAverageByType($month, Auth::user()->id, $type);
        $averagePaymentByType = Payment::getAverageByType($month, Auth::user()->id, $type);

        if ($request->wantsJson()) {
            return response()->json([
                'averageIncomingByType' => $averageIncomingByType,
                'averageOutgoingByType' => $averagePaymentByType,
                'currentMonth' => $month,
                'currentType' => $type,
            ]);
        }

        return Inertia::render('Avarages/Show', [
            'averageIncoming' => Incoming::getAverage(Auth::user()->id),
            'averageOutgoing' => Payment::getAverage(Auth::user()->id),
            'averageIncomingByType' => $averageIncomingByType,
            'averageOutgoingByType' => $averagePaymentByType,
            'currentMonth' => $month,
            'currentType' => $type,
        ]);
    }
}
