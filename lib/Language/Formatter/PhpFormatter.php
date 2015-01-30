<?php
/**
 * This file is part of Limedocs
 *
 * Copyright (C) Matthias ETIENNE <matthias@etienne.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lime\Highlighter\Language\Formatter;

use Lime\Highlighter\Language\Tokenizer\PhpTokenizer;
use Lime\Highlighter\Language\Tokenizer\TokenIterator;

class PhpFormatter extends Formatter {

    private $quickref = [];

    public function __construct()
    {
        $this->quickref = include(__DIR__ . '/../../../config/quickref-php.php');
    }

    public function format(TokenIterator $tokenIterator)
    {
        $elements = [];

        while($el = $tokenIterator->current()) {

            if($el['code'] === PhpTokenizer::T_OTHER_STRING) {

                // Check a namespace name
                if ($tokenIterator->isAfter('namespace', ["\n", ";"], [])
                    or $tokenIterator->isAfter('use', [";", 'function'])
                ) {
                    $el['code'] = PhpTokenizer::T_NAMESPACE;
                }
                elseif ($tokenIterator->isAfter('new', [], [" "]) || $tokenIterator->isBefore('::', [], [" ", "\n", "\r", "\t"])) {
                    $el['code'] = PhpTokenizer::T_CLASS;
                }
                elseif ($tokenIterator->isAfter('function', [";", "\n"], [])) {
                    $el['code'] = PhpTokenizer::T_FUNCTION;
                }
                elseif ($tokenIterator->isBefore('(', [], [" "])) {
                    $el['code'] = PhpTokenizer::T_FUNCTION;
                }
            }

            $element = ['class' => $this->getCssClass($el['code']), 'value' => $el['value']];
            $elements[] = $this->getContainer()->get('highlighter')->hook('element.create', $element);
            $tokenIterator->next();
        }
        return $elements;
    }

    public function getCssMap()
    {
        return [
            PhpTokenizer::T_PHP_TAG => 'limedocs-generic-tag',
            PhpTokenizer::T_NEWLINE => 'limedocs-generic-new-line',
            PhpTokenizer::T_KEYWORD => 'limedocs-generic-keyword',
            PhpTokenizer::T_WHITESPACE => 'limedocs-generic-whitespace',
            PhpTokenizer::T_OTHER_STRING => 'limedocs-generic-language-string',
            PhpTokenizer::T_OPERATOR => 'limedocs-generic-operator',
            PhpTokenizer::T_MULTILINE_COMMENT => 'limedocs-generic-comment',
            PhpTokenizer::T_ONELINE_COMMENT => 'limedocs-generic-comment',
            PhpTokenizer::T_BRACKET => 'limedocs-generic-bracket',
            PhpTokenizer::T_MAGIC_CONSTANT => 'limedocs-generic-magic-constant',
            PhpTokenizer::T_PREDEFINED_CONSTANT => 'limedocs-generic-predefined-constant',
            PhpTokenizer::T_USER_CONSTANT => 'limedocs-generic-user-constant',
            PhpTokenizer::T_SIMPLE_QUOTED_STRING => 'limedocs-generic-quoted-string',
            PhpTokenizer::T_DOUBLE_QUOTED_STRING => 'limedocs-generic-quoted-string',
            PhpTokenizer::T_VARIABLE => 'limedocs-generic-variable',
            PhpTokenizer::T_NAMESPACE => 'limedocs-generic-namespace',
            PhpTokenizer::T_FUNCTION => 'limedocs-generic-function',
            PhpTokenizer::T_CLASS => 'limedocs-generic-class',
            PhpTokenizer::T_HEREDOC => 'limedocs-generic-heredoc',
        ];
    }
}