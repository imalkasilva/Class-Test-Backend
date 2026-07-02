<?php

namespace Modules\Employee\Repositaries;

use Modules\Employee\Models\Employee;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function getAllEmployees()
    {
        return Employee::all();
    }

    public function findEmployee($id)
    {
        return Employee::findOrFail($id);
    }

    public function createEmployee(array $data)
    {
        $salary = $data['monthly_salary_package'];

        // Tax Calculation
        if ($salary >= 150000) {
            $tax = $salary * 0.05;
        } elseif ($salary >= 100000) {
            $tax = $salary * 0.03;
        } else {
            $tax = 0;
        }

        // Bonus Calculation
        switch ($data['designation']) {
            case 'Manager':
                $bonus = $salary * 0.05;
                break;

            case 'Senior':
                $bonus = $salary * 0.03;
                break;

            case 'Associate':
                $bonus = $salary * 0.01;
                break;

            default:
                $bonus = 0;
        }

        $data['monthly_tax_value'] = $tax;
        $data['yearly_increasing_bonus'] = $bonus;
        $data['monthly_net_salary'] = $salary - $tax;

        return Employee::create($data);
    }

    public function updateEmployee($id, array $data)
    {
        $employee = Employee::findOrFail($id);

        if (isset($data['phone'])) {
            $employee->phone = $data['phone'];
        }

        if (isset($data['monthly_salary_package'])) {

            $salary = $data['monthly_salary_package'];

            if ($salary >= 150000) {
                $tax = $salary * 0.05;
            } elseif ($salary >= 100000) {
                $tax = $salary * 0.03;
            } else {
                $tax = 0;
            }

            switch ($employee->designation) {

                case 'Manager':
                    $bonus = $salary * 0.05;
                    break;

                case 'Senior':
                    $bonus = $salary * 0.03;
                    break;

                case 'Associate':
                    $bonus = $salary * 0.01;
                    break;

                default:
                    $bonus = 0;
            }

            $employee->monthly_salary_package = $salary;
            $employee->monthly_tax_value = $tax;
            $employee->yearly_increasing_bonus = $bonus;
            $employee->monthly_net_salary = $salary - $tax;
        }

        $employee->save();

        return $employee;
    }

    public function deleteEmployee($id)
    {
        return Employee::destroy($id);
    }

    public function searchEmployee($phone)
    {
        return Employee::where('phone', 'LIKE', "%{$phone}%")->get();
    }
}