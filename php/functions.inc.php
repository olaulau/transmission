<?php

function vd ($var) {
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}
function vdd ($var) {
	vd ($var);
	die;
}

function unit_scale ($value, $scales, $divisor) {
	$i = 0;
	while ($value >= $divisor) {
		$i ++;
		$value = $value / $divisor;
	}
	return (round($value, 1) . ' ' . $scales[$i]);
}

function convert_bandwidth ($value) {
	$scales = ['bps', 'kbps', 'mbps', 'gbps', 'tbps'];
	$divisor = 1000;
	return unit_scale($value, $scales, $divisor);
}

function convert_size ($value) {
	$scales = ['o', 'kb', 'mb', 'gb', 'tb'];
	$divisor = 1024;
	return unit_scale($value, $scales, $divisor);
}
