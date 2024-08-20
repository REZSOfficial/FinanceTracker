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
use Inertia\Inertia;

class GoalController extends Controller
{
    public function create()
    {
        return Inertia::render('Goals/Create');
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

        return back();
    }

    public function show()
    {
        $goals = Goal::where('user_id', Auth::user()->id)->get();

        return Inertia::render('Goals/Show', [
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
        $incoming = Incoming::getIncomingByUserId(Auth::user()->id);
        $payments = Payment::getPaymentsByUserId(Auth::user()->id);
        $balance = Balance::getBalanceByUserId(Auth::user()->id);
        $savings = Saving::where('user_id', Auth::user()->id)->first();

        $other_goal_text = "";

        foreach ($allGoals as $g) {
            if ($g->id != $goal->id) {
                $other_goal_text = $other_goal_text . $g->title . " - " . $g->price . " - " . $g->date . "\n";
            }
        }

        $text = "Hi, i have some financial goals that i want to achieve.
         The one im asking you about is titled: " . $goal->title . ".
         The amount i need to save up is: " . $goal->price . "
         The date i need to achieve this goal is: " . $goal->date . "
         I also have other goals that i want to achieve (if this is empty then ignore it):" . $other_goal_text;

        return $text;
    }
}
