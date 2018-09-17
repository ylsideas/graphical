<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace Test\Units\Queries;

use PHPUnit\Framework\TestCase;
use YlsIdeas\Graphical\Queries\ReturnQuery;

class ReturnQueryTest extends TestCase
{
    /**
     * @dataProvider returnQueries
     */
    public function test_it_can_generate_queries($distinct, $alias, $property, $column, $expected)
    {
        $query = new ReturnQuery($distinct);

        $generated = (string) $query->alias($alias, $property, $column);

        $this->assertEquals($expected, $generated);
    }

    public function returnQueries()
    {
        return [
            [false, 'a', 'name', null, 'a.name'],
            [true, 'a', 'name', null, 'DISTINCT a.name'],
            [false, 'a', 'name', 'Full Name', 'a.name AS \'Full Name\''],
        ];
    }
}