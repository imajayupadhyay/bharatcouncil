<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternApplication extends Model
{
    protected $fillable = [
        'full_name', 'email', 'phone', 'city',
        'institution', 'programme', 'discipline', 'grad_year',
        'track', 'cohort', 'mode', 'duration',
        'statement', 'governance_problem', 'status',
    ];
}
