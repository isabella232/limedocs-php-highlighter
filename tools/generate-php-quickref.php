<?php
define('QUICKREF_URL', 'http://php.net/manual/en/indexes.functions.php');

$quickref = [];
$contents = file_get_contents(QUICKREF_URL);

preg_match_all('/<li><a href="([^"]+)" class="index">([^<]+)<\/a> - ([^<]+)/m', $contents, $tokens, PREG_SET_ORDER);

//var_dump($tokens);exit;

foreach ($tokens as $tok) {

    if(preg_match('/purpose$/', $tok[3]) || 'Description' === $tok[3]) {
        $tok[3] = '';
    }

    $quickref[$tok[2]] = ['file' => $tok[1]];

    if(!empty($tok[3])) {
        $quickref[$tok[2]]['desc'] = $tok[3];
    }
}

echo '<?php'."\n// PHP Quickref generated at ".date(DATE_ISO8601)."\nreturn ".var_export($quickref, true).";";
//var_dump($quickref);

