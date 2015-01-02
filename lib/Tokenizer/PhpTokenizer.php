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
 * Php Tokenzier
 */
class PhpTokenizer extends Tokenizer {

    const T_SEMICOLON               = 10001;
    const T_OPERATOR                = 10002;
    const T_KEYWORD                 = 10003;
    const T_PREDEFINED_CONSTANT     = 10004;
    const T_CASTING                 = 10005;
    const T_BRACKET                 = 10006;
    const T_SIMPLE_QUOTED_STRING    = 10007;
    const T_DOUBLE_QUOTED_STRING    = 10008;
    const T_NUMBER                  = 10010;
    const T_PHP_TAG                 = 10012;
    const T_VARIABLE                = 10013;
    const T_WHITESPACE              = 10014;
    const T_TEXT                    = 10015;
    const T_NAMESPACE               = 10016;
    const T_FUNCTION                = 10017;
    const T_CLASS                   = 10018;


    /**
     * Return the tokenizer configuration
     *
     * @return array
     */
    public function getTokenizerConfig()
    {
        $keywords = array(
            '__halt_compiler',
            'abstract',
            'and',
            'array',
            'as',
            'break',
            'callable',
            'case',
            'catch',
            'class',
            'clone',
            'const',
            'continue',
            'declare',
            'default',
            'die',
            'do',
            'echo',
            'else',
            'elseif',
            'empty',
            'enddeclare',
            'endfor',
            'endforeach',
            'endif',
            'endswitch',
            'endwhile',
            'eval',
            'exit',
            'extends',
            'false',
            'final',
            'finally',
            'for',
            'foreach',
            'function',
            'global',
            'goto',
            'if',
            'implements',
            'include',
            'include_once',
            'instanceof',
            'insteadof',
            'interface',
            'isset',
            'list',
            'namespace',
            'new',
            'null',
            'or',
            'print',
            'private',
            'protected',
            'public',
            'require',
            'require_once',
            'return',
            'self',
            'static',
            'switch',
            'throw',
            'trait',
            'true',
            'try',
            'unset',
            'use',
            'var',
            'while',
            'xor',
            'yield'
        );

        $predefined_constants = array(
            '__CLASS__',
            '__DIR__',
            '__FILE__',
            '__FUNCTION__',
            '__LINE__',
            '__METHOD__',
            '__NAMESPACE__',
            '__TRAIT__'
        );

        $operators = array(
            '&=',
            '=',
            '*=',
            '**=',
            '**',
            '+=',
            '-=',
            '%=',
            '/=',
            '.=',
            '==',
            '===',
            '>=',
            '<=',
            '!=',
            '<>',
            '|=',
            '<<=',
            '>>=',
            '^=',
            '&&',
            '||',
            '++',
            '--',
            '.',
            '::',
            '->',
            ';',
            ',',
            '!',
        );

        $casting = [
            '(array)',
            '(bool)',
            '(boolean)',
            '(string)',
            '(real)',
            '(double)',
            '(float)',
            '(int)',
            '(integer)',
            '(object)',
            '(unset)'
        ];

        $brackets = ['{', '}', '(', ')', '[', ']'];
        $new_lines = ["\n", "\r\n"];

        $multiline_comment = '/\*\*?\s*((?:(?!\*/)[\s\S]+))\*/';
        $multiline_comment = '(?P<T_MULTILINE_COMMENT>(/\*\*((?:(?!\*/)[\s\S])*)\*/))';
        $oneline_comment = '((#|//)[^\r\n]*)';

        $tokens = array(

            // Opening and closing tags
            self::T_PHP_TAG => $this->getNamedExpression('<\?php|\?>', self::T_PHP_TAG, false),

            // Multiline Comments
            self::T_MULTILINE_COMMENT => $multiline_comment,

            // Single line comment
            self::T_ONELINE_COMMENT => $this->getNamedExpression(
                $oneline_comment,
                self::T_ONELINE_COMMENT
            ),

            self::T_HEREDOC => '(?P<T_HEREDOC>(<<<\'?([\w]+)\'?[\r\n]+([\s\S]+)(\g-3)))(?=;)',



            // Brackets
            self::T_BRACKET => $this->getArrayMask($brackets, self::T_BRACKET),

            // keywords
            self::T_KEYWORD => $this->getArrayMask($keywords, self::T_KEYWORD),

            // Predefiend contants
            self::T_PREDEFINED_CONSTANT => $this->getArrayMask($predefined_constants, self::T_PREDEFINED_CONSTANT),

            // assignment operators & logical operators
            self::T_OPERATOR => $this->getArrayMask($operators, self::T_OPERATOR),

            // casting
            self::T_CASTING => $this->getArrayMask($casting, self::T_CASTING),

            // new line
            self::T_NEWLINE => $this->getArrayMask($new_lines, self::T_NEWLINE),

            self::T_DOUBLE_QUOTED_STRING => $this->getNamedExpression(
                //'(?:(?:\"(?:\\\\\"|[^\"])+\")|(?:\\\\\'(?:\'|[^\'])+\'))',
                '(?:(?:\"(?:\\\\\"|[^\"])+\"))',
                self::T_DOUBLE_QUOTED_STRING
            ),

            self::T_SIMPLE_QUOTED_STRING => $this->getNamedExpression(
                "(?:(?:\'(?:\\\\\'|[^\'])+\'))",
                self::T_SIMPLE_QUOTED_STRING
            ),


            self::T_VARIABLE => $this->getNamedExpression('\$\w+', self::T_VARIABLE),

            self::T_NUMBER => $this->getNamedExpression('[\d.]+', self::T_NUMBER),

            self::T_WHITESPACE => $this->getNamedExpression('\s+', self::T_WHITESPACE),

            self::T_OTHER_STRING => $this->getNamedExpression('[\w\\\\]+', self::T_OTHER_STRING),

            //self::T_TEXT => $this->getNamedExpression('\S+', self::T_TEXT)
        );

        return $tokens;
    }

    protected function getNamedExpression($exp, $name, $quote = false)
    {
        $name = is_int($name) ? $this->getTokenName($name) : $name;
        return '(?P<'.$name.'>' . ($quote ? $this->quoteExpression($exp) : $exp ). ')';
    }

    protected function quoteExpression($exp, $delimiter = '~') {
        return preg_quote($exp, $delimiter);
    }

    protected function getArrayMask($arr, $name) {
        usort($arr,[$this, 'sortByLengthDesc']);
        return $this->getNamedExpression(implode('|', array_map([$this, 'quoteExpression'], $arr)), $name);
    }


    protected function sortByLengthDesc($a, $b){
        return strlen($b) - strlen($a);
    }

}