<?php
/**
 * @author      Peter Fox <peter.fox@ylsideas.co>
 * @copyright   Copyright (c) YLS Ideas 2018
 */

namespace YlsIdeas\Graphical\Helpers;

use YlsIdeas\Graphical\Graph\Node;
use YlsIdeas\Graphical\Graph\Relationship;

class Neo4JHelper
{
    public static function formatObject(array $label = [], string $alias = null, array $properties = []) : string
    {
        $formattedLabels = self::formatLabels($label);
        $formattedProperties = self::formatProperties($properties);

        return implode('', [
            $alias,
            $formattedLabels,
            (($alias || $formattedLabels) && $formattedProperties ? ' ' : '').$formattedProperties
        ]);
    }

    public static function formatProperties(array $properties = []) : string
    {
        if (empty($properties)) {
            return '';
        }

        return '{ '.collect($properties)
                ->map(function ($item, $key) {
                    if (is_string($item)) {
                        $item = '\''.addslashes($item).'\'';
                    } else {
                        $item = (string) $item;
                    }

                    return "$key : $item";
                })
                ->implode(', ').' }';
    }

    public static function formatLabels(array $labels = []) : string
    {
        return implode('', array_map(function ($label) {
           return ':'.$label;
        }, $labels));
    }

    public static function formatNode(Node $node, string $alias = null) : string
    {
        return '('.self::formatObject($node->labels, $alias, $node->properties).')';
    }

    public static function formatRelationship(
        Relationship $relationship,
        string $alias = null
    ) : string
    {
        $formattedObject = self::formatObject($relationship->labels, $alias, $relationship->properties);

        $formattedObject = $formattedObject ? "[$formattedObject]" : '';

        if ($relationship->direction === '>') {
            return '-'.$formattedObject.'->';
        } elseif ($relationship->direction === '<') {
            return '<-'.$formattedObject.'-';
        }

        return '-'.$formattedObject.'-';
    }

    public static function formatAliasAndProperty(string $alias, string $property = null)
    {
        return $alias.($property ? '.'.$property : '');
    }
}