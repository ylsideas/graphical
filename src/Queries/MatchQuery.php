<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace YlsIdeas\Graphical\Queries;

use Tightenco\Collect\Support\Arr;
use YlsIdeas\Graphical\Exceptions\MatchQueryException;
use YlsIdeas\Graphical\Graph\Node;
use YlsIdeas\Graphical\Graph\Relationship;
use YlsIdeas\Graphical\Helpers\Neo4JHelper;

class MatchQuery
{
    protected $steps = [];
    protected $alias = [];

    private const DIRECTION_TOWARDS = '>';
    private const DIRECTION_AWAY_FROM = '<';
    private const DIRECTION_ANY = '-';

    public function anyNodes(string $alias = null, array $properties = [])
    {
        return $this->nodesLabelled([], $alias, $properties);
    }

    /**
     * @param array $labels
     * @param string|null $alias
     * @param array $properties
     * @return MatchQuery
     */
    public function nodesLabelled(array $labels = [], string $alias = null, array $properties = []) : self
    {
        if ($alias) {
            $this->alias[$alias] = true;
        }
        $this->steps[] = ['node' => new Node($labels, $properties), 'alias' => $alias ?? false];
        return $this;
    }

    public function connecting(string $alias = null) : self
    {
        return $this->connectionBy([], self::DIRECTION_ANY, $alias);
    }

    /**
     * @param array $labels
     * @param string $direction
     * @param string|null $alias
     * @param array $properties
     * @return MatchQuery
     * @throws MatchQueryException
     */
    public function connectionBy(
        array $labels = [],
        $direction = self::DIRECTION_ANY,
        string $alias = null,
        array $properties = []
    ) : self
    {
        if (array_key_exists('relationship', Arr::last($this->steps, null, []))) {
            throw new MatchQueryException('statements must have relationships between nodes');
        }
        if ($alias) {
            $this->alias[$alias] = true;
        }
        $this->steps[] = [
            'relationship' => new Relationship($labels, $direction, $properties),
            'alias' => $alias ?? false
        ];
        return $this;
    }

    public function connectingAwayFrom(array $labels = [], string $alias = null, array $properties = []) : self
    {
        return $this->connectionBy($labels, self::DIRECTION_AWAY_FROM, $alias, $properties);
    }

    public function connectingTowards(array $labels = [], string $alias = null, array $properties = []) : self
    {
        return $this->connectionBy($labels, self::DIRECTION_TOWARDS, $alias, $properties);
    }

    public function __toString()
    {
        $queryString = collect($this->steps)
            ->map(function ($queryStep) {
                if (array_key_exists('relationship', $queryStep)) {
                    return Neo4JHelper::formatRelationship(
                        $queryStep['relationship'],
                        $queryStep['alias']
                    );
                } else {
                    return Neo4JHelper::formatNode(
                        $queryStep['node'],
                        $queryStep['alias']
                    );
                }
            })
            ->implode('');

        return $queryString;
    }
}