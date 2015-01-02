<?php
/**
 * This file is part of Limedocs
 *
 * Copyright (C) Matthias ETIENNE <matthias@etienne.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lime\Highlighter\Tokenizer;

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

    /**
     * Be carefull, these contants correponds to token keys ! no not change !!
     */
    const BREAK_ON_TOKEN_CODE   = 'code';
    const BREAK_ON_TOKEN_VALUE  = 'value';

    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
        $this->position = 0;
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
        do {
            $next = $this->next();
        } while($next && $next['code'] != $token_type);
        return $next;
    }

    public function prevTokenOfType($token_type) {
        do {
            $prev = $this->prev();
        } while($prev && $prev['code'] != $token_type);

        return $prev;
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
        $global_method = $reverse ? 'isBefore' : 'isAfter';
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

            if (in_array($current['code'], $after_token_types, true) || in_array($current['value'], $after_token_types, true)) {
                //echo "$global_method : found " . $current['code'] . " / " . $current['value']."\n";
                $found = $current;
                break;
            } else {
                //echo "$global_method : '{$current['value']}' not matching ".json_encode($after_token_types)." \n";
            }

            if (in_array($current['code'], $break_on, true) || in_array($current['value'], $break_on, true)) {
                //echo "$global_method : Breaking on  '" . $current['value']."'\n";
                break;
            } else{
                //echo "$global_method : Not breaking on '" . $current['value']."'\n";
            }

            if (count($break_on_not) && (!in_array($current['code'], $break_on_not, true) && !in_array($current['value'], $break_on_not, true))) {
                //echo "$global_method : Breaking on NOT '" . $current['value']."' ".json_encode($break_on_not)."\n";
                break;
            } else{
                //echo "$global_method : Not breaking on NOT  '" . $current['value']."'\n";
            }

        } while($this->$method());

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