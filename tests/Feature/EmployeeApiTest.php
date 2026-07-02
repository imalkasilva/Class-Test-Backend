<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Employee;

class EmployeeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_an_employee_via_api(): void
    {
        $payload = [
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'phone' => '0712345678',
            'designation' => 'Intern',
            'monthly_salary_package' => 150000,
        ];

        $response = $this->postJson('/api/employees', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('name', 'Alice Johnson')
            ->assertJsonPath('email', 'alice@example.com');
    }

    public function test_can_search_employees(): void
    {
        Employee::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '0777123456',
            'designation' => 'Intern',
            'monthly_salary_package' => 150000,
        ]);

        Employee::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '0888123456',
            'designation' => 'Associate',
            'monthly_salary_package' => 120000,
        ]);

        $response = $this->getJson('/api/employees/search/john');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonPath('0.name', 'John Doe');
    }
}
