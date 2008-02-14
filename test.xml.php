<?php

extract($_GET); 


$url = "http://cxiol.incruit.com/api/?method=search&q=$q&apikey=A45F959AEA04D2799C4C1824DF101FE7FC0EB507&out=xml";

header ("content-type: text/xml");
echo getHtml($url); 
function getHtml($url, $referer=NULL, $type=NULL, $parameter=NULL)
{
    global $failCount;
    global $maxFailCount;
    $cu = curl_init($url);
    curl_setopt($cu, CURLOPT_RETURNTRANSFER, 1);

if($type&&$parameter) {
    $type = strtoupper($type);
    switch($type) {
        case "POST":
        curl_setopt($cu, CURLOPT_POST, true);
        curl_setopt($cu, CURLOPT_POSTFIELDS, $parameter);
    break;
    }
}
if($referer) {
    curl_setopt($cu, CURLOPT_REFERER, $referer);
}
$temp = curl_exec($cu);
if(!$temp && $failCount<$maxFailCount) {
    echo '파일을 여는데 실패했습니다. '.$failCount.'회, URL = '.$url.'<br>'.iconv('euc-kr','utf-8',$url).'<br>';
        $failCount+=1;
        $temp = getHtml($url);
}
if(!$temp) {
        echo 'failed open url : '.$url;
}
curl_close($cu);
return $temp;
}
