<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productivity extends Model {
    use HasFactory;

    protected $fillable = [
        'policy_objective',
        'policy_raised',
        'bonus',
        'incentive',
        'user_id',
        'campaign_id',
        'created_at',
        'updated_at',
    ];
}
