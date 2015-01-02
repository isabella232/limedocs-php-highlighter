<?php
/**
 * Multi comment
 * Bla
 */
require __DIR__ . '/../vendor/autoload.php';

use Lime\Highlighter\Highlighter;
use Lime\Highlighter\Language\PhpLanguage,
    Lime\Highlighter\Theme\LimedocsTheme;

$phpstr = file_get_contents(__FILE__);
//$phpstr = 'echo \'foo "bar" \\\'hey \'';

$tokens = token_get_all($phpstr);
foreach ($tokens as $tok) {
    if (!is_array($tok)) {
        $tok = [$tok];
    } else {
        $tok['token_name'] = token_name($tok[0]);
    }
    //echo json_encode($tok)."\n";
}

$h = new Highlighter();
$html =  $h->setLanguage(new PhpLanguage())
    ->setTheme(new LimedocsTheme('limedocs/basic'))
    ->highlight($phpstr);


file_put_contents('high.html', $html);
/**
 * Multi comment
 * Bla
 */

/**
 * Multi comment
 * Bla
 */



/**
 * Multi comment
 * Bla
 */
