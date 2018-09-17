<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace Test\Units\Queries;

use PHPUnit\Framework\TestCase;
use YlsIdeas\Graphical\Queries\MatchQuery;

class MatchQueryTest extends TestCase
{
    public function test_it_generates_basic_match_queries()
    {
        $query = new MatchQuery();

        $query->nodesLabelled(['Actor'], 'a', ['name' => 'Keanu Reeves'])
            ->connectingTowards(['STARRING_IN'], 'b')
            ->nodesLabelled(['Movie'], 'c');

        $this->assertEquals(
            '(a:Actor { name : \'Keanu Reeves\' })-[b:STARRING_IN]->(c:Movie)',
            (string) $query
        );
    }
}