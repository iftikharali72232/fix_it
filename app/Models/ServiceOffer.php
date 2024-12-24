<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOffer extends Model
{
    use HasFactory;

    protected $table = 'service_offers';
    protected $fillable = [
        'id',
        'service_id',
        'image',
        'discount',
        'status',
    ];
}
