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

/**
 * Interface NodeInterface
 */
interface NodeInterface {
    public function __construct($type, $value);
    public function setAttribute($attr_name, $attr_value);
    public function setAttributes(\Traversable $attributes);
    public function hasAttribute($attr_name);
    public function getAttribute($attr_name);
    public function getAttributes();
}