<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalRequest;
use Gemini;
use Carbon\Carbon;
use App\Models\Goal;
use App\Models\Saving;
use App\Models\Balance;
use App\Models\Payment;
use App\Models\Incoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GoalController extends Controller
{
    public function create()
    {
        return Inertia::render('Goals/Create');
    }

    public function save(GoalRequest $request)
    {
        Goal::create([
            'user_id' => Auth()->id(),
            'title' => $request->title,
            'price' => $request->price,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        $goals = Goal::where('user_id', Auth::user()->id)->get();

        return Inertia::render('Goals/Show', ['goals' => $goals]);
    }

    public function show()
    {
        $goals = Goal::where('user_id', Auth::user()->id)->get();

        return Inertia::render('Goals/Show', [
            'goals' => $goals,
        ]);
    }

    public function delete($id, Request $request)
    {
        Goal::find($id)->delete();

        return redirect()->back();
    }

    public function generateResponse(Request $request)
    {
        $goal = Goal::find($request->input('goalId'));
        $client = $this->getClient();
        $text = $this->createGeminiText($goal);
        $result = $client->geminiPro()->generateContent($text);

        return response()->json(['response' => $result->text()]);
    }

    public function getClient()
    {
        return Gemini::client(getenv('GEMINI_API_KEY'));
    }

    public function createGeminiText(Goal $goal)
    {
        $allGoals = Goal::where('user_id', Auth::user()->id)->get();
        $incoming = Incoming::where('user_id', Auth::user()->id)->where('regular', 1)->get();
        $payments = Payment::where('user_id', Auth::user()->id)->where('regular', 1)->get();
        $balance = Balance::getBalanceByUserId(Auth::user()->id);
        $savings = Saving::where('user_id', Auth::user()->id)->first();

        if ($savings == null) {
            $savings = 0;
        } else {
            $savings = $savings->amount;
        }

        $other_goal_text = "";

        foreach ($allGoals as $g) {
            if ($g->id != $goal->id) {
                $other_goal_text = $other_goal_text . $g->title . " - " . $g->price . " - " . $g->date . "\n";
            }
        }

        $incomingText = "";
        $outgoingText = "";

        foreach ($incoming as $i) {
            $incomingText = $incomingText . $i->title . "(title) - " . $i->amount . "(amount) Im receiving this amount from " . $i->created_at . " for " . $i->period . " months \n";
        }

        foreach ($payments as $p) {
            $outgoingText = $outgoingText . $p->title . "(title) - " . $p->amount . "(amount) Im paying this amount from " . $p->created_at . " for " . $p->period . " months \n";
        }

        $text = "Hi, i have some financial goals that i want to achieve, the current date is " . Carbon::now() .
            ". The one im asking you about is titled: " . $goal->title . ".
         The amount i need to save up is: " . $goal->price . "
         The date i need to achieve this goal is: " . $goal->date . "
         I also have other goals that i want to achieve (if this is empty then ignore it):" . $other_goal_text .
            "My current balance is " . $balance->balance . ". I have " . $incoming->count() . " incoming transactions and " . $payments->count() . " payments.
         These payments are: " . $outgoingText . "These incoming transactions are: " . $incomingText . "I have " . $savings . " in savings. (this might be 0, then ignore it). Can you tell me if this goal is achiavable based on my balance and outgoing and incoming payments?";

        return $text;
    }
}
