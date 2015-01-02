<?php
/**
 * This file is part of Limedocs
 *
 * Copyright (C) Matthias ETIENNE <matthias@etienne.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lime\Highlighter\Formatter;

use Lime\Highlighter\Tokenizer\TokenIterator;

interface FormatterInterface {

    /**
     * @param TokenIterator $tokenIterator
     * @return array
     */
    public function format(TokenIterator $tokenIterator);

    /**
     * @return array
     */
    public function getCssMap();

    /**
     * @param int $token_code Token code
     * @return string
     */
    public function getCssClass($token_code);

}