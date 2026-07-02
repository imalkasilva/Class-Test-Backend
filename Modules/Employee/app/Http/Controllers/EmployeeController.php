<?php

namespace Modules\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
       protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        return response()->json(
            $this->employeeRepository->getAllEmployees()
        );
    }

    public function store(StoreEmployeeRequest $request)
    {
        return response()->json(
            $this->employeeRepository->createEmployee($request->validated())
        );
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        return response()->json(
            $this->employeeRepository->updateEmployee($id, $request->validated())
        );
    }

    public function destroy($id)
    {
        return response()->json(
            $this->employeeRepository->deleteEmployee($id)
        );
    }

    public function search($phone)
    {
        return response()->json(
            $this->employeeRepository->searchEmployee($phone)
        );
    }
}