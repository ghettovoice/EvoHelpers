<?php
/**
 * menuRowIcon
 * 
 * Returns menu icon or menu row default text.
 */
/* @var $modx DocumentParser */
$fileUrl = isset($fileUrl) ? $fileUrl : '';
$title = isset($title) ? $title : '';
$tpl = isset($tpl) && $modx->getChunk($tpl) ? $modx->getChunk($tpl) : '<img src="[+src+]" title="[+title+]" alt="[+title+]" />'; // icon tpl

$output = '';
if ($fileUrl && is_file($modx->config['base_path'] . $fileUrl)) {
    $phs = array(
        'src' => $fileUrl,
        'title' => $title,
    );
    
    $output = $tpl;
    foreach ($phs as $key => $value) {
        $key = '[+' . $key . '+]';
        $output = str_replace($key, $value, $output);
    }
}
else {
    $output = $title;
}

return $output;



