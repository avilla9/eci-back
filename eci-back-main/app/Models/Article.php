<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model {
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'short_description',
        'link_short_description',
        'button_name',
        'button_link',
        'internal_link',
        'external_link',
        'created_at',
        'updated_at',
        'unrestricted',
        'file_id',
        'section_id',
        'campaign_id',
        'active',
    ];
}
