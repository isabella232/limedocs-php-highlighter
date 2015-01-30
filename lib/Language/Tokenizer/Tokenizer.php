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

abstract class Tokenizer implements TokenizerInterface {

    protected static $constantsByName;
    protected static $constantsByValue;

    public function getTokenizerConstants($by_name = true)
    {
        if (false === isset(self::$constantsByName)) {
            $ref = new \ReflectionClass(get_called_class());
            self::$constantsByName = $ref->getConstants();
            self::$constantsByValue = array_flip(self::$constantsByName);
        }
        return $by_name ? self::$constantsByName : self::$constantsByValue;
    }

    public function getTokenName($token)
    {
        $constants = $this->getTokenizerConstants(false);

        if (isset($constants[$token])) {
            return $constants[$token];
        }

        return token_name($token);
    }

    public function getTokenCode($token_name)
    {
        $constants = $this->getTokenizerConstants();
        return $constants[$token_name];
    }

    public function tokenize($source)
    {
        $patterns = $this->getTokenizerConfig();
        $regex = '~(' . implode(')|(', $patterns) . ')~A';
        $len = 0;
        $final_tokens = [];

        preg_match_all($regex, $source, $tokens, PREG_SET_ORDER);

        foreach ($tokens as $match) {
            $token = $this->getToken($match, $len);
            $len += strlen($token->getValue());
            $final_tokens[] = $token;
        }

        if ($len !== strlen($source)) {
            $errorOffset = $len;
        }

        if (isset($errorOffset)) {
            list($line, $col) = $this->getCoordinates($source, $errorOffset);
            $token = str_replace("\n", '\n', substr($source, $errorOffset, 10));
            throw new \RuntimeException("Unexpected '$token' on line $line, column $col. (Source len = ".strlen($source).' - Token length = ' . $len . ')');
        }

        $iterator = new TokenIterator($final_tokens);

        return $iterator;
    }

    protected function getToken($arr, $offset) {
        foreach ($arr as $key => $val) {
            if (false === is_int($key) && '' !== $val) {
                return new Token($this->getTokenCode($key), $val, $offset);
            }
        }
        return null;
    }


    /**
     * Returns position of token in input string.
     * @param  string
     * @param  int
     * @return array of [line, column]
     */
    protected function getCoordinates($text, $offset)
    {
        $text = substr($text, 0, $offset);
        return array(substr_count($text, "\n") + 1, $offset - strrpos("\n" . $text, "\n") + 1);
    }

}