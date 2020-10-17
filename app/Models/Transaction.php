<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "Transactions";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'nsu',
        'authorizationNumber',
        'amount',
        'transactionDate',
        'type',
    ];

    public static function search($id){
        return self::find($id);
    }
}
