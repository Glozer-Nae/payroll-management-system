<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'employee_id',
        'type',
        'start_date',
        'end_date',
        'status',
        'is_paid'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
