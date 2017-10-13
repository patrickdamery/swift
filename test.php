<?php
$period = array('09/24/2017', '11/09/2017');
$current = date('o-W', strtotime($period[0]));
$current_timestamp = date('Y-m-d', strtotime($period[0]));
while($current <= date('o-W', strtotime($period[1]))) {
	echo $current;
	$current_timestamp = date('Y-m-d', strtotime($current_timestamp.' +1 week'));
	$current = date('o-W', strtotime($current_timestamp));
	//$current = date('o-W', strtotime($period[1]));
}
?>
