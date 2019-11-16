<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalarySlip extends Model
{
    protected $fillable = [
        'user_id', 'slip', 'file_path', 'status',
    ];
}
