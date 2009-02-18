<?php
$html = file_get_contents('http://naeil.incruit.com/');
$reg = '/\<SCI\>(.*)\<\/SCI\>/';
preg_match($reg, $html, $match);
echo $match[1];