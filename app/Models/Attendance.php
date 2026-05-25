<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'status',
        'overtime_hours'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    protected static function booted()
{
    static::saving(function ($attendance) {
        if ($attendance->status === 'absent') {
            $attendance->overtime_hours = 0;
        }
    });
}
}
