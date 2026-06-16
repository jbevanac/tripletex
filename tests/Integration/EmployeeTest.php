<?php

namespace Tripletex\Tests\Integration;

use Tripletex\Model\Employee;
use Tripletex\Model\ListResponse;
use Tripletex\Tests\TestCase;

class EmployeeTest extends TestCase
{
    public function test_list_returns_list_response(): void
    {
        $this->skipIfNoCredentials();

        $result = $this->sdkFromEnv()->employee()->list();

        $this->assertInstanceOf(ListResponse::class, $result);
    }

    public function test_list_values_are_employee_instances(): void
    {
        $this->skipIfNoCredentials();

        $result = $this->sdkFromEnv()->employee()->list();

        $this->assertInstanceOf(ListResponse::class, $result);

        if ($result->values === null || $result->values->count() === 0) {
            $this->markTestSkipped('No employees in account to assert on');
        }

        $this->assertInstanceOf(Employee::class, $result->values->first());
    }

    public function test_find_returns_employee(): void
    {
        $this->skipIfNoCredentials();

        $sdk = $this->sdkFromEnv();
        $list = $sdk->employee()->list();

        if ($list->values === null || $list->values->count() === 0) {
            $this->markTestSkipped('No employees in account to assert on');
        }

        $firstId = $list->values->first()->id;
        $employee = $sdk->employee()->find($firstId);

        $this->assertInstanceOf(Employee::class, $employee);
        $this->assertSame($firstId, $employee->id);
    }
}
