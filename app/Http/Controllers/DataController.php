<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Data;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{
    static function getDataByUserId($id)
    {
        $data = DB::table('data')->where('user_id', $id)->first();


        if ($data) {
            return $data;
        } else if (Payment::where('user_id', $id)->exists()) {
            $payments = Payment::where('user_id', $id)->get();
            /*
            $data = [];
            foreach ($payments as $payment) {
                if (!isset($data[$payment->type])) {
                    $data[$payment->type] = 0;
                }

                $data[$payment->type] += $payment->amount;
            }
            return $data;*/
            $paymentTypes = ['food_drink', 'housing', 'transportation', 'healthcare', 'entertainment', 'other'];

            $monthlyPaymentsByType = []; // Array to store total payments for each type and month-year
            $totalPaymentsByType = [];   // Array to store total payments for each type
            $uniqueMonthsByType = [];    // Array to store unique months for each type

            // Initialize arrays for each payment type
            foreach ($paymentTypes as $type) {
                $monthlyPaymentsByType[$type] = [];
                $totalPaymentsByType[$type] = 0;
                $uniqueMonthsByType[$type] = [];
            }

            $allDates = []; // Array to store all unique year-month dates

            foreach ($payments as $payment) {
                // Extract the year and month from the created_at date using Carbon
                $date = Carbon::parse($payment->created_at);
                $yearMonth = $date->format('Y-m'); // Format as 'YYYY-MM'
                $type = $payment->type;

                // Sum payments for each type and month-year
                if (!isset($monthlyPaymentsByType[$type][$yearMonth])) {
                    $monthlyPaymentsByType[$type][$yearMonth] = 0;
                }
                $monthlyPaymentsByType[$type][$yearMonth] += $payment->amount;

                // Track unique months for each type
                if (!in_array($yearMonth, $uniqueMonthsByType[$type])) {
                    $uniqueMonthsByType[$type][] = $yearMonth;
                }

                // Add to the total payments for each type
                $totalPaymentsByType[$type] += $payment->amount;

                // Track all unique year-month dates
                if (!in_array($yearMonth, $allDates)) {
                    $allDates[] = $yearMonth;
                }
            }

            // Sort all dates to determine the full range
            sort($allDates);
            $firstDate = Carbon::parse($allDates[0]);
            $lastDate = Carbon::parse(end($allDates));
            $startDate = $firstDate->copy()->startOfMonth();
            $endDate = $lastDate->copy()->endOfMonth();

            // Generate all months between the first and last date
            $allMonths = [];
            $currentDate = $startDate;
            while ($currentDate->lte($endDate)) {
                $allMonths[] = $currentDate->format('Y-m');
                $currentDate->addMonth();
            }

            // Calculate the average monthly payment for each type
            $averageMonthlyPaymentsByType = [];

            foreach ($paymentTypes as $type) {
                $numMonths = count($allMonths);
                $averageMonthlyPaymentsByType[$type] = ($numMonths > 0) ? ($totalPaymentsByType[$type] / $numMonths) : 0;
            }

            // Return the average monthly payment by type
            return $averageMonthlyPaymentsByType;
        }

        return null;
    }

    /*
    'food_drink',
        'housing',
        'transportation',
        'healthcare',
        'entertainment',
        'other'
        */

    public function update(Request $request)
    {
        $request->validate([
            'food_drink' => 'integer',
            'housing' => 'integer',
            'transportation' => 'integer',
            'healthcare' => 'integer',
            'entertainment' => 'integer',
            'other' => 'integer',
        ]);


        Data::updateOrCreate(
            [
                'user_id' => Auth::user()->id
            ],
            [
                'food_drink' => $request['food_drink'],
                'housing' => $request['housing'],
                'transportation' => $request['transportation'],
                'healthcare' => $request['healthcare'],
                'entertainment' => $request['entertainment'],
                'other' => $request['other'],
            ]
        );
        session()->flash('success', 'Data updated successfully.');
        return redirect()->back();
    }
}
