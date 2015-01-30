<?php
/**
 * Multi comment
 * Bla
 */
require __DIR__ . '/../vendor/autoload.php';

use Lime\Highlighter\Highlighter;
use Lime\Highlighter\Language\PhpLanguage,
    Lime\Highlighter\Extension\PhpManualLinksExtension,
    Lime\Highlighter\Theme\Theme,
    Lime\Highlighter\Output\OutputHtmlFormat;

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

// really long line really long line really long line really long line really long line really long line really long line really long line really long line really long line really long line really long line really long line

$h = new Highlighter();
$html =  $h ->setTheme(new Theme('limedocs/basic'))
            ->setOutputFormat(new OutputHtmlFormat())
            ->registerExtension(new PhpManualLinksExtension())
            ->highlightString($phpstr);


file_put_contents('high.html', $html);
/**
 * Multi comment
 * Bla
 */

//foo