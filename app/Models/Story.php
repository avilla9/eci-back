<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model {
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filter_code',
        'file_id',
        'link',
        'button_name',
        'active',
        'publish_at',
        'unpublished',
        'created_at',
        'updated_at',
    ];
}
