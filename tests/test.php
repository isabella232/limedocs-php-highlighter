<?php
$regex = '~(foo)|((?P<T_HEREDOC>(<<<([\w]+)[\r\n]+([\s\S]+)(\g-3))(?:;)))~A';
$source = <<<SOURCE
<<<MYS

zjadk azdjljakzld
zadkmkazd
zadkld

MYS;

foo

SOURCE;


preg_match_all($regex, $source, $tokens, PREG_SET_ORDER);

var_dump($tokens);