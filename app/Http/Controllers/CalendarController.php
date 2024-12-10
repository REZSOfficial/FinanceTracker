<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Payment;
use App\Models\Incoming;

class CalendarController extends Controller
{
    public function index()
    {
        $outgoing = Payment::where('user_id', auth()->user()->id)->get();
        $incoming = Incoming::where('user_id', auth()->user()->id)->get();
        return Inertia::render('Calendar/Show', ['outgoing' => $outgoing, 'incoming' => $incoming]);
    }
}
