<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPhase extends Model
{
    use HasFactory;

    protected $table = "order_phases";
    protected $fillable = [
        'phase_id',
        'service_id',
        'order_id',
        'workshop_user_id',
        'images',
        'audios',
        'videos',
        'description',
        'status'
    ];

    protected $casts = [
        'images' => 'array',
        'audios' => 'array',
        'videos' => 'array',
    ];
}
