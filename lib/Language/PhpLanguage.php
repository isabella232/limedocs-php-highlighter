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

use Lime\Highlighter\Formatter\PhpFormatter;
use Lime\Highlighter\Tokenizer\PhpTokenizer;

/**
 * Class PhpLanguage
 */
class PhpLanguage implements LanguageInterface {

    public function __construct()
    {

    }

    public function getTokenizer()
    {
        return new PhpTokenizer();
    }

    public function getFormatter()
    {
        return new PhpFormatter();
    }


}