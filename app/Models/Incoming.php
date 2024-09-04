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
        return DB::table('incomings')->where('user_id', $id)->get();
    }

    public static function getRegularIncomingByUserId(String $id)
    {
        return Incoming::where('user_id', $id)->where('regular', 1)->whereNot('period', 0)->get();
    }

    public static function getAvarage(): array
    {
        $averageIncoming = DB::select("
            SELECT 
                m.month, 
                COALESCE(AVG(i.amount), 0) AS amount 
            FROM 
                (SELECT 1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
                UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 
                UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 
                UNION ALL SELECT 11 UNION ALL SELECT 12) AS m
            LEFT JOIN incomings i ON m.month = MONTH(i.created_at)
            GROUP BY m.month
            ORDER BY m.month ASC
        ");

        $averageIncomingArray = array_map(function ($item) {
            return $item->amount;
        }, $averageIncoming);

        return $averageIncomingArray;
    }

    public static function getAverageByType(int $month, String $type = null)
    {
        // Base SQL query with subquery to ensure no implicit columns are included
        $query = "
        SELECT subquery.type, subquery.avg_amount
        FROM (
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

        // Close subquery and group by type
        $query .= " GROUP BY type) as subquery";

        // Execute the query with parameters
        $averageIncoming = DB::select($query, $params);

        if (!$averageIncoming) {
            return [];
        }

        return $averageIncoming;
    }

    public function remainingMonths()
    {
        $currentDate = Carbon::now();
        $dbDate = Carbon::parse($this->created_at);
        $monthsDifference = $currentDate->diffInMonths($dbDate);

        return max(-$this->period, $monthsDifference);
    }
}
