<?php

// Developer Identity: Backend Developer - Employee Management System

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return Employee::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string',
            'designation' => 'nullable|string',
            'monthly_salary_package' => 'required|numeric',
            'monthly_tax_value' => 'nullable|numeric',
            'yearly_increasing_bonus' => 'nullable|numeric',
            'monthly_net_salary' => 'nullable|numeric',
        ]);

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
        switch ($data['designation'] ?? 'Intern') {
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

        $employee = Employee::create($data);

        return response()->json($employee, 201);
    }

    public function show(Employee $employee)
    {
        return $employee;
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:employees,email,' . $employee->id,
            'phone' => 'sometimes|required|string',
            'designation' => 'nullable|string',
            'monthly_salary_package' => 'sometimes|required|numeric',
            'monthly_tax_value' => 'nullable|numeric',
            'yearly_increasing_bonus' => 'nullable|numeric',
            'monthly_net_salary' => 'nullable|numeric',
        ]);

        $salary = $data['monthly_salary_package'] ?? $employee->monthly_salary_package;
        $designation = $data['designation'] ?? $employee->designation;

        if (isset($data['monthly_salary_package']) || isset($data['designation'])) {
            // Tax Calculation
            if ($salary >= 150000) {
                $tax = $salary * 0.05;
            } elseif ($salary >= 100000) {
                $tax = $salary * 0.03;
            } else {
                $tax = 0;
            }

            // Bonus Calculation
            switch ($designation) {
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
        }

        $employee->update($data);

        return response()->json($employee);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json(['message' => 'Employee deleted']);
    }

    public function search(string $phone)
    {
        return Employee::where('phone', 'like', "%$phone%")
            ->orWhere('name', 'like', "%$phone%")
            ->orWhere('email', 'like', "%$phone%")
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
