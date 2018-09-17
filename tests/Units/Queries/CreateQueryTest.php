<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace Test\Units\Queries;

use PHPUnit\Framework\TestCase;
use YlsIdeas\Graphical\Queries\CreateQuery;

class CreateQueryTest extends TestCase
{
    public function test_it_stores_create_queries()
    {
        $query = new CreateQuery();

        $this->assertEquals(
            '',
            (string) $query
        );
    }
}