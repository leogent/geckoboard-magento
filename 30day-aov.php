<?php

require_once('core.php');
require_once('config.php');

// first of the month
// $ts = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m'), 1, date('Y')));
// $te = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y')));

// $ys = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m')-1, 1, date('Y')));
// $ye = $ts;

// compare with this time a month ago
$ts = date('Y-m-d H:i:s', strtotime('-1 month'));
$te = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y')));

$ys = date('Y-m-d H:i:s', strtotime('-1 month',strtotime('-1 month')));
$ye = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m')-1, date('d'), date('Y')));



// if (isset($_POST) && isset($_SERVER['PHP_AUTH_USER'])) {


// 	/* Check API key */
//     if ($apiKey === $_SERVER['PHP_AUTH_USER']) {
		$sales1 = getOrders($ts,$te);
		$count1 = getSoldCount($sales1);
		$total1 = getSoldValue($sales1);

		$sales2 = getOrders($ys,$ye);
		$count2 = getSoldCount($sales2);
		$total2 = getSoldValue($sales2);

		$prefix = '£';

		if($count1 != 0) {
			$aov1 = round($total1/$count1,2);
		}
		else {
			$aov1 = 0;
		}
		if($count2 != 0) {
			$aov2 = round($total2/$count2,2);
		}
		else {
			$aov2 = 0;
		}

		$currentAov = array("text"=>"AOV last 30 days", "value"=>$aov1, "prefix"=>$prefix);
		$previousAov = array("text"=>"on previous", "value"=>$aov2);

		$response = array("item"=>array($currentAov,$previousAov));

		$json = json_encode($response);

		echo $json;        
    
//     } else {
//         Header("HTTP/1.1 403 Access denied");
//         $data = array('error' => 'Nice try, asshole.');
//         echo $data;
//     }

// } else {
// 	Header("HTTP/1.1 404 Page not found");
// }



?>