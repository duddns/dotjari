<?php
$html = file_get_contents('http://cxiol.incruit.com/');
$reg = '/\<SCI\>(.*)\<\/SCI\>/';
preg_match($reg, $html, $match);
echo $match[1];