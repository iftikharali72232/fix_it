<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $table = 'service_orders';

    protected $fillable = [
        'service_id',
        'variables_json',
        'service_cost',
        'service_date',
        'tax',
        'discount',
        'status'
    ];

    protected $casts = [
        'variables_json' => 'array',
    ];
}
