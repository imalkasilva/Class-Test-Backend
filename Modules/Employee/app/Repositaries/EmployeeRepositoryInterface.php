<?php

namespace Modules\Employee\Repositaries;

interface EmployeeRepositoryInterface
{
    public function getAllEmployees();

    public function createEmployee(array $data);

    public function updateEmployee($id, array $data);

    public function deleteEmployee($id);

    public function searchEmployee($phone);

    public function findEmployee($id);
}