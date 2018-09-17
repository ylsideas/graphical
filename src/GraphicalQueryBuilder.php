<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace YlsIdeas\Graphical;

use YlsIdeas\Graphical\Queries\MatchQuery;
use YlsIdeas\Graphical\Queries\ReturnQuery;

class GraphicalQueryBuilder
{
    public $statments = [
        'match' => [],
        'create' => [],
        'set' => [],
        'delete' => [],
        'return' => [],
        'limit' => false,
        'orderBy' => [],
        'skip' => false,
    ];

    public function match(callable $callable) : self
    {
        $matchQuery = new MatchQuery();
        $this->statments['match'][] = $matchQuery;
        $callable($matchQuery);
        return $this;
    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function request(string $alias, string $property = null, string $column = null, $distinct = false)
    {
        $statement = (new ReturnQuery($distinct))
            ->alias($alias, $property, $column);
        $this->statments['return'][] = $statement;
    }

    public function requestDistinct(string $alias, string $property = null, string $column = null)
    {
        $this->request($alias, $property, $column, true);
    }
}