<?php
/**
 * This file is part of Limedocs
 *
 * Copyright (C) Matthias ETIENNE <matthias@etienne.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lime\Highlighter\Node;

class Node implements NodeInterface {

    protected $type;
    protected $value;
    protected $attributes = [];

    /**
     * Create an attribute with the specified type & value
     *
     * @param string $type
     * @param mixed $value
     */
    public function __construct($type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Set an attribute for the node
     *
     * @param string $attr_name Attribute name
     * @param mixed $attr_value Attribute value
     * @return $this
     */
    public function setAttribute($attr_name, $attr_value)
    {
        $this->attributes[$attr_name] = $attr_value;
        return $this;
    }

    /**
     * Set multiple attributes for the node
     *
     * @param \Traversable|array $attributes
     * @returns $this
     */
    public function setAttributes(\Traversable $attributes)
    {
        foreach ($attributes as $attr_name => $attr_value) {
            $this->setAttribute($attr_name, $attr_value);
        }
        return $this;
    }

    /**
     * Check if the node has an attribute set
     *
     * @param $attr_name Attribute name
     * @return bool
     */
    public function hasAttribute($attr_name)
    {
        return isset($this->attributes[$attr_name]);
    }

    /**
     * Return the value of an attribute
     *
     * @param $attr_name Attribute name
     * @return mixed
     */
    public function getAttribute($attr_name)
    {
        return false === $this->hasAttribute($attr_name) ? null :  $this->attributes[$attr_name];
    }

    /**
     * Return all attributes set
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }


} 