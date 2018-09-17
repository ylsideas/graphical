<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace Test\Units\Helpers;

use YlsIdeas\Graphical\Graph\Node;
use YlsIdeas\Graphical\Graph\Relationship;
use YlsIdeas\Graphical\Helpers\Neo4JHelper;
use PHPUnit\Framework\TestCase;

class Neo4JHelperTest extends TestCase
{
    public function test_it_can_format_labels()
    {
        $generated = Neo4JHelper::formatLabels(['Actor', 'Movie']);

        $this->assertEquals(':Actor:Movie', $generated);
    }

    /**
     * @dataProvider aliasAndProperty
     */
    public function test_it_can_format_aliases_and_properties($alias, $property, $expected)
    {
        $generated = Neo4JHelper::formatAliasAndProperty($alias, $property);

        $this->assertEquals($expected, $generated);
    }

    /**
     * @dataProvider properties
     */
    public function test_it_can_format_attributes($properties, $expected)
    {
        $generated = Neo4JHelper::formatProperties($properties);

        $this->assertEquals(
            $expected,
            $generated
        );
    }

    /**
     * @dataProvider objects
     */
    public function test_it_can_format_an_object($labels, $alias, $properties, $result)
    {
        $generated = Neo4JHelper::formatObject($labels, $alias, $properties);

        $this->assertEquals($result, $generated);
    }

    /**
     * @dataProvider nodes
     */
    public function test_it_can_format_as_a_node($node, $alias, $result)
    {
        $generated = Neo4JHelper::formatNode($node, $alias);

        $this->assertEquals($result, $generated);
    }

    /**
     * @dataProvider relationships
     */
    public function test_it_can_format_as_a_relationship($relationship, $alias, $result)
    {
        $generated = Neo4JHelper::formatRelationship($relationship, $alias);

        $this->assertEquals($result, $generated);
    }

    public function properties()
    {
        return [
            [['name' => 'Peter', 'age' => 29], '{ name : \'Peter\', age : 29 }']
        ];
    }

    public function nodes()
    {
        return [
            [new Node([]), null, '()'],
            [new Node(['Actor']), null, '(:Actor)'],
            [new Node([]), 'a', '(a)'],
            [new Node(['Actor']), 'a', '(a:Actor)'],
            [new Node(['Actor', 'Movie']), 'a', '(a:Actor:Movie)'],
        ];
    }

    public function relationships()
    {
        return [
            [new Relationship([], '-'), null, '--'],
            [new Relationship(['STARRED_IN'], '-'), null, '-[:STARRED_IN]-'],
            [new Relationship(['STARRED_IN'], '>'), null, '-[:STARRED_IN]->'],
            [new Relationship(['STARRED_IN'], '<'), null, '<-[:STARRED_IN]-'],
            [new Relationship(['STARRED_IN', 'DIRECTED'], '-'), null, '-[:STARRED_IN:DIRECTED]-'],
            [new Relationship(['STARRED_IN', 'DIRECTED'], '-'), 'a', '-[a:STARRED_IN:DIRECTED]-'],
            [new Relationship([], '-', ['name' => 'Peter']), null, '-[{ name : \'Peter\' }]-'],
            [
                new Relationship(['STARRED_IN'], '-', ['name' => 'Peter']),
                'b',
                '-[b:STARRED_IN { name : \'Peter\' }]-'
            ],
        ];
    }

    public function objects()
    {
        return [
            [[], null, [], ''],
            [['Actor'], null, [], ':Actor'],
            [[], 'a', [], 'a'],
            [['Actor'], 'a', [], 'a:Actor'],
            [['Actor', 'Movie'], 'a', [], 'a:Actor:Movie'],
            [['STARRED_IN', 'DIRECTED'], 'b', [], 'b:STARRED_IN:DIRECTED'],
            [[], null, ['name' => 'Peter'], '{ name : \'Peter\' }'],
            [['Actor'], null, ['name' => 'Peter'], ':Actor { name : \'Peter\' }'],
            [[], 'a', ['name' => 'Peter'], 'a { name : \'Peter\' }'],
        ];
    }

    public function aliasAndProperty()
    {
        return [
            ['a', 'name', 'a.name'],
            ['a', null, 'a'],
        ];
    }
}