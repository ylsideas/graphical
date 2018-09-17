<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace Test\Units\Queries;

use PHPUnit\Framework\TestCase;
use YlsIdeas\Graphical\Queries\UpdateQuery;

class UpdateQueryTest extends TestCase
{
    public function test_it_stores_update_queries()
    {
        $query = new UpdateQuery();

        $this->assertEquals(
            '',
            (string) $query
        );
    }
}