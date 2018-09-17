<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace Test\Units\Queries;

use PHPUnit\Framework\TestCase;
use YlsIdeas\Graphical\Queries\DeleteQuery;

class DeleteQueryTest extends TestCase
{
    public function test_it_stores_delete_queries()
    {
        $query = new DeleteQuery();

        $query->object('a');

        $this->assertEquals(
            '',
            (string) $query
        );
    }
}