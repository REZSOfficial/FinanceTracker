<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Incoming extends Model
{
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
        return DB::table('incomings')->where('user_id', $id)->where('regular', 1)->whereNot('period', 0)->get();
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
}
