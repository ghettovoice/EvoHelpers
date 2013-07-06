<?php
/**
 * Date snippet
 * Returns date formatted according to the given format string &format using the given integer timestamp &timestamp
 */
 /** @var string $format The format of the outputted date string*/
 $format = !empty($format) ? trim($format) : 'd-m-Y H:i:s';
 /** @var int $timestamp */
 $timestamp = isset($timestamp) ? (int) $timestamp : time();
 
 return date($format, $timestamp);
