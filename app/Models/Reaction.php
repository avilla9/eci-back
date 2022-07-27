<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
        'action_id',
        'clicks',
        'active',
        'created_at',
        'updated_at',
    ];
}
