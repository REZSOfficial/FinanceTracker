<?php

namespace App\Http\Controllers;

use App\Models\Incoming;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AvarageController extends Controller
{
    public function index()
    {
        $averageIncoming = Incoming::getAvarage();
        $averageOutgoing = Payment::getAvarage();

        return Inertia::render('Avarages/Show', ['averageIncoming' => $averageIncoming, 'averageOutgoing' => $averageOutgoing]);
    }
}
