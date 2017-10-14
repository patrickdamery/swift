<?php
/*$period = array('09/24/2017', '11/09/2017');
$current = date('o-W', strtotime($period[0]));
$current_timestamp = date('Y-m-d', strtotime($period[0]));
while($current <= date('o-W', strtotime($period[1]))) {
	echo $current;
	$current_timestamp = date('Y-m-d', strtotime($current_timestamp.' +1 week'));
	$current = date('o-W', strtotime($current_timestamp));
	//$current = date('o-W', strtotime($period[1]));
}*/

//$t = array(array('Activos', 0, 'Pasivos', 0), array('', '', 'Patrimonio', 0), array('Balance', 0));
function array_flatten($array) {
    $return = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $return = array_merge($return, array_flatten($value));
        } else {
            $return[$key] = $value;
        }
    }
    return $return;
}

$row = 0;
$col = 0;

$final = array();



$t = array(array('Moo', array(array('2017-37', 0),array('2017-38', 0),array('2017-39', 0),array('2017-40', 0),array('2017-41', 4900))), array('asfd', 18));

$result = array_flatten($t);

print_r($result);


?>
