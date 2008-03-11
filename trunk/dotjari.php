<?php
extract($_GET); 
$url = "http://cxiol.incruit.com/api/?method=search&apikey=A45F959AEA04D2799C4C1824DF101FE7FC0EB507&out=xml";
$q = file_get_contents($q);
$url .= "&q=$q&start=$start&count=$count";
if (0 < strlen($rgn1)) {
	$url .= "&rgn1=$rgn1";
}
if (0 < strlen($sry)) {
	$url .= "&sry=$sry";
}
if (0 < strlen($crr)) {
	$url .= "&crr=$crr";
}
if (0 < strlen($schol)) {
	$url .= "&schol=$schol";
}
if (0 < strlen($scale)) {
	$url .= "&schale=$scale";
}

$today = date('Ymd', mktime()); 
switch($closeDate) { 
    case 'weekly':
        $icd = $today; 
        $picd = $today+7; 
        break;
    case 'moonthly':
        $icd = $today; 
        $picd = $today+31; 
        break;
}
if (0 < (int)$icd) { // 부터
    $url .= "&icd=$icd";
}
if (0 < (int)$picd) { // 까지
    $url .= "&picd=$picd";
}


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
