<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'designation',
        'monthly_salary_package',
        'monthly_tax_value',
        'yearly_increasing_bonus',
        'monthly_net_salary',
    ];
}
