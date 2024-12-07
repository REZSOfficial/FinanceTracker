<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incoming extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'amount',
        'regular',
        'period',
        'type',
        'type_of_payment'
    ];

    public static function getIncomingByUserId(String $id)
    {
        return DB::table('incomings')->where('user_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public static function getRegularIncomingByUserId(String $id)
    {
        return Incoming::where('user_id', $id)->where('regular', 1)->whereNot('period', 0)->orderBy('created_at', 'desc')->get();
    }

    public static function getAverage(): array
    {
        $averageIncoming = DB::table('incomings')
            ->selectRaw('MONTH(created_at) AS month, COALESCE(AVG(amount), 0) AS amount')
            ->whereYear('created_at', '=', date('Y')) // Limit to the current year if needed
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Populate all months to ensure each month from 1 to 12 has a value
        $averageIncomingArray = [];
        for ($month = 1; $month <= 12; $month++) {
            $averageIncomingArray[] = $averageIncoming->get($month)->amount ?? 0;
        }

        return $averageIncomingArray;
    }

    public static function getAverageByType(int $month, ?string $type = null): array
    {
        // Base SQL query to get average by type
        $query = "
        SELECT type, AVG(amount) as avg_amount
        FROM incomings
        WHERE MONTH(created_at) = ?
    ";

        // Parameters for the query
        $params = [$month];

        // Append type condition if provided
        if ($type) {
            $query .= " AND type = ?";
            $params[] = $type;
        }

        // Add grouping and ordering directly
        $query .= " GROUP BY type ORDER BY type";

        // Execute the query and return the result
        return DB::select($query, $params);
    }


    public function remainingMonths()
    {
        $currentDate = Carbon::now();
        $dbDate = Carbon::parse($this->created_at);
        $monthsDifference = $this->period - $dbDate->diffInMonths($currentDate);

        return max($monthsDifference, 0);
    }
}
