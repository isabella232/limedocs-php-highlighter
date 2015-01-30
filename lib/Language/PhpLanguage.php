<?php
/**
 * This file is part of Limedocs
 *
 * Copyright (C) Matthias ETIENNE <matthias@etienne.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lime\Highlighter\Language;

use Lime\Highlighter\Language\Formatter\PhpFormatter;
use Lime\Highlighter\Language\Tokenizer\PhpTokenizer;

/**
 * Class PhpLanguage
 */
class PhpLanguage extends Language {

    public function getTokenizer()
    {
        return new PhpTokenizer();
    }

    public function getFormatter()
    {
        return (new PhpFormatter())->setContainer($this->getContainer());
    }
}