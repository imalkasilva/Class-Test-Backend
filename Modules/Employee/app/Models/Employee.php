<?php

namespace Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    /**
     * Table Name
     */
    protected $table = 'employees';

    /**
     * Mass Assignable Fields
     */
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

    /**
     * Attribute Casting
     */
    protected $casts = [
        'monthly_salary_package' => 'decimal:2',
        'monthly_tax_value' => 'decimal:2',
        'yearly_increasing_bonus' => 'decimal:2',
        'monthly_net_salary' => 'decimal:2',
    ];

    /**
     * Accessor for Yearly Net Salary
     *
     * (Monthly Net Salary × 12) + Yearly Bonus
     */
    public function getYearlyNetSalaryAttribute()
    {
        return ($this->monthly_net_salary * 12) + $this->yearly_increasing_bonus;
    }

    /**
     * Append computed attribute to JSON responses
     */
    protected $appends = [
        'yearly_net_salary',
    ];
}