<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace YlsIdeas\Graphical\Queries;

use YlsIdeas\Graphical\Helpers\Neo4JHelper;

class ReturnQuery
{
    protected $distinct;
    protected $alias;
    protected $property;
    protected $column;

    public function __construct($distinct = false)
    {
        $this->distinct = $distinct;
    }

    public function alias(string $alias, string $property, string $column = null)
    {
        $this->alias = $alias;
        $this->property = $property;
        $this->column = $column;
        return $this;
    }

    public function __toString()
    {
        return ($this->distinct ? 'DISTINCT ' : '') .
            Neo4JHelper::formatAliasAndProperty($this->alias, $this->property) .
            ($this->column ? ' AS \''.addslashes($this->column).'\'' : '');
    }
}