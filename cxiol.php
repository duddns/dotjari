<?php
$html = file_get_contents('http://cxiol.incruit.com/');
$reg = '/\<a.*\>\<SCI\>(.*)\<\/SCI\>\<\/a\>/';
preg_match($reg, $html, $match);
echo $match[1];