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
 * TokenIterator
 */
class TokenIterator implements \SeekableIterator {

    /**
     * @var array
     */
    protected $tokens;
    private $chekpoints = [];
    private $position = 0;


    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
        $this->position = 0;
    }

    public function getTokens()
    {
        return $this->tokens;
    }

    public function rewind() {
        $this->position = 0;
        return $this->current();
    }

    public function current() {
        return $this->valid() ? $this->tokens[$this->position] : null;
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        $this->position++;
        return $this->current();
    }

    public function nextTokenOfType($token_type) {
        return $this->mTokenOfType($token_type, false);
    }

    public function prevTokenOfType($token_type) {
        return $this->mTokenOfType($token_type, true);
    }

    private function mTokenOfType($token_type, $prev = false) {
        $method = $prev ? 'prev' : 'next';
        do {
            $tok = $this->$method();
        } while($tok && $tok->getType() != $token_type);

        return $tok;
    }

    public function addCheckpoint($label)
    {
        $this->chekpoints[$label] = $this->position;
        return $this;
    }

    public function removeCheckpoint($label)
    {
        unset($this->chekpoints[$label]);
        return $this;
    }

    public function isBefore($before_token_types = [], $break_on = [], $break_on_not = [])
    {
        return $this->isAfter($before_token_types, $break_on, $break_on_not, true);
    }

    public function isAfter($after_token_types = [], $break_on = [], $break_on_not = [], $reverse = false)
    {
        $pos = $this->key();
        $method = $reverse ? 'next' : 'prev';
        $found = false;

        if (false === is_array($after_token_types)) {
            $after_token_types = [$after_token_types];
        }

        if (false === is_array($break_on)) {
            $break_on = [$break_on];
        }

        if (false === is_array($break_on_not)) {
            $break_on_not = [$break_on_not];
        }

        $this->$method();

        do {
            $current = $this->current();

            if (in_array($current->getType(), $after_token_types, true) || in_array($current->getValue(), $after_token_types, true)) {
                $found = $current;
                break;
            }

            if (in_array($current->getType(), $break_on, true) || in_array($current->getValue(), $break_on, true)) {
                break;
            }

            if (count($break_on_not) && (!in_array($current->getType(), $break_on_not, true) && !in_array($current->getValue(), $break_on_not, true))) {
                break;
            }

        } while($this->$method());

        // return to the previous position
        $this->seek($pos);

        return $found;
    }

    public function gotoCheckpoint($label)
    {
        if (isset($this->chekpoints[$label])) {
            $this->position = $this->chekpoints[$label];
            return $this->current();
        }
        throw new \Exception("Checkpoint '{$label}' does not exist.'");
    }

    function prev() {
        $this->position--;
        return $this->current();
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Seeks to a position
     * @link http://php.net/manual/en/seekableiterator.seek.php
     * @param int $position <p>
     * The position to seek to.
     * </p>
     * @return mixed
     */
    public function seek($position)
    {
        $this->position = $position;
        return $this->current();
    }

    function valid() {
        return isset($this->tokens[$this->position]);
    }
}