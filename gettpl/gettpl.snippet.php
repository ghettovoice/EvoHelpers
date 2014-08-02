<?php
/**
 * getTpl
 * Returns file content, may be used to include template files
 */
/* @var $modx DocumentParser */
/** @var string $file Path to the file */
$file   = isset($file) ? $file : '';
/** @var string $basePath Base path to templates folder */
$basePath = !empty($basePath) ? $basePath : MODX_BASE_PATH . 'assets/templates/';
/** @var string $ext Extension of the file */
$ext = !empty($ext) ? $ext : 'tpl';
$file = $basePath . $file . '.' . $ext;
return @file_get_contents($file);