<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace YlsIdeas\Graphical\Queries;

class UpdateQuery
{
    protected $queries = [];

    public function setValue(string $object, string $key, $value) : self
    {
        $this->queries[] = [$object, $key, '=', $value];
        return $this;
    }

    public function setLabel(string  $object, array $labels) : self
    {
        $this->queries[] = [$object, ':', $labels];
        return $this;
    }

    public function __toString()
    {
        return '';
    }
}