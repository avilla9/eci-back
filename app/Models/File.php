<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model {
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'overview',
        'media_name',
        'media_type',
        'media_path',
        'media_size',
    ];

}
