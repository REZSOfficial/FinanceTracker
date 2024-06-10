<?php

namespace App\Http\Controllers;

use Gemini;
use Carbon\Carbon;
use App\Models\Goal;
use App\Models\Saving;
use App\Models\Balance;
use App\Models\Payment;
use App\Models\Incoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function create()
    {
        return view('goals.creategoal');
    }

    public function save(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Goal::create([
            'user_id' => Auth()->id(),
            'title' => $request->title,
            'price' => $request->price,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        session()->flash('success', 'Goal saved successfully.');

        return redirect()->back();
    }

    public function show()
    {
        $goals = Goal::where('user_id', Auth::user()->id)->get();
        $data = DataController::getDataByUserId(Auth::user()->id);

        $regularPayments = Payment::getRegularPaymentsByUserId(Auth::user()->id);

        $regularIncomings = Incoming::getRegularIncomingByUserId(Auth::user()->id);

        $savings = Saving::where('user_id', Auth::user()->id)->get();
        //Bejövő fizetésekből visszamaradó hónapok kiszámítása
        $monthsLeft = [];
        //Hátralévő hónapok Carbonnal
        $currentDate = Carbon::now();
        foreach ($regularIncomings as $rI) {
            $dbDate = Carbon::parse($rI->created_at);
            $monthsDifference = $currentDate->diffInMonths($dbDate);
            array_push($monthsLeft,  ["regularIncoming" => $rI, "monthsDiff" => $monthsDifference]);
        }

        //Kimenő fizetésekből visszamaradó hónapok kiszámítása
        $paymentMonthsLeft = [];
        //Hátralévő hónapok Carbonnal
        $currentDate = Carbon::now();
        foreach ($regularPayments as $rP) {
            $dbDate = Carbon::parse($rP->created_at);
            $monthsDifference = $currentDate->diffInMonths($dbDate);
            array_push($paymentMonthsLeft,  ["regularPayment" => $rP, "monthsDiff" => $monthsDifference]);
        }


        $balance = Balance::getBalanceByUserId(Auth::user()->id);

        $prompt = GoalController::generatePrompt();

        return view('goals.show', [
            'prompt' => $prompt,
            'goals' => $goals,
        ]);
    }

    public function view($id)
    {
        $goal = Goal::find($id);
        return view('goals.view', ['goal' => $goal]);
    }

    public function delete($id, Request $request)
    {
        Goal::find($id)->delete();

        return redirect()->back();
    }

    public function generateResponse(Request $request)
    {
        $yourApiKey = getenv('GEMINI_API_KEY');
        $client = Gemini::client($yourApiKey);

        $result = $client->geminiPro()->generateContent($request->input('text'));

        return response()->json(['response' => $result->text()]);
    }

    public static function generatePrompt()
    {
        return "Give me financial advice.";
    }
}
