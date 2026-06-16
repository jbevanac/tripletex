<?php

namespace Tripletex\Tests\Unit\Query;

use Tripletex\Query\Filters\FieldsFilter;
use Tripletex\Query\Filters\IdsFilter;
use Tripletex\Tests\TestCase;

class FiltersTest extends TestCase
{
    public function test_fields_filter_single_value(): void
    {
        $filter = new FieldsFilter('id');

        $this->assertSame(['fields' => 'id'], $filter->toQuery());
    }

    public function test_fields_filter_multiple_values(): void
    {
        $filter = new FieldsFilter(['id', 'firstName', 'lastName']);

        $this->assertSame(['fields' => 'id,firstName,lastName'], $filter->toQuery());
    }

    public function test_ids_filter_single_value(): void
    {
        $filter = new IdsFilter(42);

        $this->assertSame(['ids' => '42'], $filter->toQuery());
    }

    public function test_ids_filter_multiple_values(): void
    {
        $filter = new IdsFilter([1, 2, 3]);

        $this->assertSame(['ids' => '1,2,3'], $filter->toQuery());
    }
}
