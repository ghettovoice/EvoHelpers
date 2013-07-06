<?php

/**
 * neighborDoc snippet.
 *
 * Returns url of the next/prev document
 *
 * @author Vladimir Vershinin
 * @version 1.0.0
 * @date 19.02.2013
 */
/* @var $modx DocumentParser */
$docId    = isset($docId) ? (int) $docId : $modx->documentIdentifier;
$dir      = isset($dir) ? trim($dir) : 'next';
$cls      = isset($cls) ? $cls : '';
$linkText = isset($linkText) ? $linkText : 'Next';
$tpl      = isset($tpl) && $modx->getChunk($tpl) != '' ? $tpl : '<a id="[+linkid+]" href="[+href+]" title="[+linktext+] - [+doctitle+]" class="[+cls+]">[+linktext+]</a>';
$join     = isset($join) ? $join : '';
$select   = isset($select) ? $select : '`r`.`id`, `r`.`pagetitle`, `r`.`longtitle`';
$where    = isset($where) ? $where : '';
$phs      = array('[+linkid+]', '[+href+]', '[+linktext+]', '[+doctitle+]', '[+cls+]');

// include external config
$config = isset($config) ? $config : ''; // config name
if ($config) {
    include_once realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'cfg' . DIRECTORY_SEPARATOR . $config . '.cfg.php';
}

$output = '';

$res          = $modx->db->select('parent, menuindex', $modx->getFullTableName('site_content'), 'id = ' . $docId, '', 1);
$arCurrentDoc = $modx->db->getRow($res);

if ($arCurrentDoc) {

    $sql = "SELECT {$select} FROM " . $modx->getFullTableName('site_content') . " AS `r` ";

    $sql .= $join;

    $sql .= " WHERE `r`.`parent` = {$arCurrentDoc['parent']} AND `r`.`id` != {$docId} AND `r`.`published` = 1";

    switch ($dir) {
        case 'next':
            $sql .= " AND IF(`r`.`menuindex` = {$arCurrentDoc['menuindex']}, `r`.`id` > {$docId}, `r`.`menuindex` > {$arCurrentDoc['menuindex']}) ";
            break;
        case 'prev':
        case 'previous':
            $sql .= " AND IF(`r`.`menuindex` = {$arCurrentDoc['menuindex']}, `r`.`id` < {$docId}, `r`.`menuindex` < {$arCurrentDoc['menuindex']}) ";
            break;
        default:
            break;
    }

    $where = $where ? ' AND ' . $where : '';

    $sql .= "{$where} ORDER BY `r`.`menuindex` LIMIT 1 ";

    $res = $modx->db->query($sql);
    $doc = $modx->db->getRow($res);

    if ($doc) {
        $doc['doctitle'] = $doc['longtitle'] ? $doc['longtitle'] : $doc['pagetitle'];
        $doc['href'] = $modx->makeUrl($doc['id']);
        $doc['cls'] = $cls;
        $doc['linkid'] = $dir;
        $doc['linktext'] = $linkText;

        $output = $modx->parseChunk($tpl, $doc, '[+', '+]');
    }
}

return $output;
