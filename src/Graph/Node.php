<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace YlsIdeas\Graphical\Graph;

class Node
{
    /**
     * @var array
     */
    public $labels;
    /**
     * @var array
     */
    public $properties;

    public function __construct(array $labels = [], array $properties = [])
    {
        $this->labels = $labels;
        $this->properties = $properties;
    }
}