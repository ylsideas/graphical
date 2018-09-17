<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace YlsIdeas\Graphical\Graph;

class Relationship
{
    /**
     * @var array
     */
    public $labels;
    /**
     * @var string
     */
    public $direction;
    /**
     * @var array
     */
    public $properties;

    public function __construct(
        array $labels = [],
        $direction = '-',
        array $properties = []
    )
    {
        $this->labels = $labels;
        $this->direction = $direction;
        $this->properties = $properties;
    }
}