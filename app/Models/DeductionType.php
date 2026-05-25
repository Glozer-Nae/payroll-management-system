<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeductionType extends Model
{
    protected $fillable = [
        'name',
        'type',
        'value',
        'is_active'
    ];

    public function payrollDeductions()
    {
        return $this->hasMany(PayrollDeduction::class);
    }
}
