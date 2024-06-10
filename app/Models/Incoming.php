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
}
