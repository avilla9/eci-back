<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
    use HasFactory;

    protected $fillable = [
        'is_open',
        'user_id',
        'title',
        'body',
        'image',
        'post',
        'created_at',
        'updated_at',
    ];
}
