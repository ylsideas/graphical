<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace Test\Units;

use PHPUnit\Framework\TestCase;
use YlsIdeas\Graphical\GraphicalQueryBuilder;
use YlsIdeas\Graphical\Queries\MatchQuery;

class GraphicalQueryBuilderTest extends TestCase
{
    public function test_it_can_generate_match_statements()
    {
        $builder = new GraphicalQueryBuilder();

        $builder->match(function (MatchQuery $query) {
            $query->nodesLabelled(['Actor'], 'a', ['name' => 'Keanu Reeves'])
                ->connectingTowards(['STARRING_IN'], 'b')
                ->nodesLabelled(['Movie'], 'c');
        });

        $this->assertEquals(
            (string) $builder->statments['match'][0],
            '(a:Actor { name : \'Keanu Reeves\' })-[b:STARRING_IN]->(c:Movie)'
        );
    }
}