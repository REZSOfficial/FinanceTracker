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
}
