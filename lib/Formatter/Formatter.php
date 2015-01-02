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

abstract class Formatter implements FormatterInterface {

    public function getCssClass($token_code)
    {
        $map = $this->getCssMap();
        return empty($map[$token_code]) ? 'limedocs-unknown-element' : $map[$token_code];
    }

}