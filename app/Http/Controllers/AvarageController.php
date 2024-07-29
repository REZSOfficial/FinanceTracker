<?php

namespace App\Http\Controllers;

use App\Models\Incoming;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AvarageController extends Controller
{
    public function index()
    {
        $averageIncoming = DB::select("SELECT MONTH(created_at) as month, AVG(amount) as amount FROM incomings GROUP BY MONTH(created_at) ORDER BY MONTH(created_at) ASC");
        $averageOutgoing = DB::select("SELECT MONTH(created_at) as month, AVG(amount) as amount FROM payments GROUP BY MONTH(created_at) ORDER BY MONTH(created_at) ASC");

        return Inertia::render('Avarages/Show', ['averageIncoming' => $averageIncoming, 'averageOutgoing' => $averageOutgoing]);
    }
}
