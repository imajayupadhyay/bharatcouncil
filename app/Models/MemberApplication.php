<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberApplication extends Model
{
    protected $fillable = [
        'full_name', 'email', 'phone', 'city', 'designation', 'organisation',
        'membership_type', 'mode', 'background', 'contribution_area', 'board_relation',
        'answer_governance', 'answer_contribution', 'answer_reform', 'answer_bgc',
        'cv_path', 'sample_path', 'extra_path',
        'referees', 'additional_notes', 'status',
    ];
}
