<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class CalendarController extends Controller
{
    public function index()
    {
        return Inertia::render('Calendar/Show');
    }
}
