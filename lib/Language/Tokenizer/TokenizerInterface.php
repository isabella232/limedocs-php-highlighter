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

interface TokenizerInterface {

    const T_TEXT                = 9001;
    const T_NEWLINE             = 9002;
    const T_MULTILINE_COMMENT   = 9003;
    const T_ONELINE_COMMENT     = 9004;

    const T_OTHER_STRING        = 9005;
    const T_HEREDOC             = 9006;

    /**
     * @param string $source Source code
     * @return TokenIterator
     */
    public function tokenize($source);

    /**
     * Return the tokenizer configuration
     *
     * @return array
     */
    public function getTokenizerConfig();

    public function getTokenName($token);

    public function getTokenizerConstants();

}