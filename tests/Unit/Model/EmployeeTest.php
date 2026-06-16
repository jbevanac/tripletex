<?php

namespace Tripletex\Tests\Unit\Model;

use Tripletex\Enum\UserType;
use Tripletex\Model\Employee;
use Tripletex\Tests\TestCase;

class EmployeeTest extends TestCase
{
    public function test_constructor_defaults_are_null(): void
    {
        $employee = new Employee();

        $this->assertNull($employee->id);
        $this->assertNull($employee->firstName);
        $this->assertNull($employee->email);
    }

    public function test_make_maps_fields(): void
    {
        $employee = Employee::make([
            'firstName' => 'John',
            'lastName' => 'Smith',
            'email' => 'john@example.com',
            'employeeNumber' => 'EMP001',
        ]);

        $this->assertInstanceOf(Employee::class, $employee);
        $this->assertSame('John', $employee->firstName);
        $this->assertSame('Smith', $employee->lastName);
        $this->assertSame('john@example.com', $employee->email);
        $this->assertSame('EMP001', $employee->employeeNumber);
    }

    public function test_make_maps_enum_fields(): void
    {
        $employee = Employee::make([
            'firstName' => 'John',
            'lastName' => 'Smith',
            'userType' => 'STANDARD',
        ]);

        $this->assertSame(UserType::STANDARD, $employee->userType);
    }

    public function test_to_json_excludes_null_fields(): void
    {
        $employee = new Employee(firstName: 'John', lastName: 'Smith');
        $json = json_decode($employee->toJson(), true);

        $this->assertArrayHasKey('firstName', $json);
        $this->assertArrayNotHasKey('id', $json);
        $this->assertArrayNotHasKey('email', $json);
    }
}
