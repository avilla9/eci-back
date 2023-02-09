<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleFilter extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'groups',
        'quartiles',
        'delegations',
        'roles',
        'users',
    ];

    protected $casts = [
        'groups' => 'array',
        'quartiles' => 'array',
        'delegations' => 'array',
        'roles' => 'array',
        'users' => 'array',
    ];
}
