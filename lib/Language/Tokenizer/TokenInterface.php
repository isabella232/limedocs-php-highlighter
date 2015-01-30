<?php
/**
 * This file is part of Limedocs
 *
 * Copyright (C) Matthias ETIENNE <matthias@etienne.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lime\Highlighter\Language\Tokenizer;

/**
 * Token Interface
 */
interface TokenInterface {
    /**
     * Create a new token with the given type and value
     *
     * @param int $type Token type
     * @param string $value Token value
     * @param int $offset Token offset in source code
     */
    public function __construct($type, $value, $offset);

    /**
     * Get the type
     * @return int
     */
    public function getType();

    /**
     * Get the value
     * @return string
     */
    public function getValue();

    /**
     * Set the token type
     * @param int $type Token type
     * @return $this
     */
    public function setType($type);

    /**
     * Set the token value
     * @param string $value Token value
     * @return $this
     */
    public function setValue($value);

    /**
     * Set the token offset
     *
     * @param int $offset Token offset
     * @return $this
     */
    public function setOffset($offset);

    /**
     * Get the token offset
     *
     * @return int
     */
    public function getOffset();
}