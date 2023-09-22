<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    public $timestamps = false;

    // Отношения "один к одному"
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    // Отношения "один к одному"
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
