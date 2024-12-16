<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_name',
        'description',
        'thumbnail',
        'images',
        'category_id',
        'estimated_time',
        'start_time',
        'service_cost',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


}
