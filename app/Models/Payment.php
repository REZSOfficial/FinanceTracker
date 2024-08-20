<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
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

    public static function getPaymentsByUserId(String $id)
    {
        return DB::table('payments')->where('user_id', $id)->get();
    }

    public static function getPaymentsByUserIdAndType(String $id, String $type)
    {
        return DB::table('payments')->where('user_id', $id)->where('type_of_payment', $type)->get();
    }

    public static function getRegularPaymentsByUserId($id)
    {
        return DB::table('payments')->where('user_id', $id)->where('regular', 1)->whereNot('period', 0)->get();
    }

    public static function getAvarage(): array
    {
        $averageOutgoing = DB::select("
            SELECT 
                m.month, 
                COALESCE(AVG(p.amount), 0) AS amount 
            FROM 
                (SELECT 1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
                UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 
                UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 
                UNION ALL SELECT 11 UNION ALL SELECT 12) AS m
            LEFT JOIN payments p ON m.month = MONTH(p.created_at)
            GROUP BY m.month
            ORDER BY m.month ASC
        ");

        $averageOutgoingArray = array_map(function ($item) {
            return $item->amount;
        }, $averageOutgoing);

        return $averageOutgoingArray;
    }
}
