<?php if (! defined('BASEPATH')) {
	exit('No direct script access allowed');
}
function getNowDateHour() {
	return date('Y/m/d H:i:s');
}

function getArrayMonthForSum() {
	return [
		'ene' => 0,
		'feb' => 0,
		'mar' => 0,
		'abr' => 0,
		'may' => 0,
		'jun' => 0,
		'jul' => 0,
		'ago' => 0,
		'sep' => 0,
		'oct' => 0,
		'nov' => 0,
		'dic' => 0
	];
}


function getNameMonth($mes_fecha) {
	switch ($mes_fecha) {
		case 1:
			$texto = 'ene';
			break;
		case 2:
			$texto = 'feb';
			break;
		case 3:
			$texto = 'mar' ;
			break;
		case 4:
			$texto = 'abr';
			break;
		case 5:
			$texto = 'may';
			break;
		case 6:
			$texto = 'jun' ;
			break;
		case 7:
			$texto = 'jul';
			break;
		case 8:
			$texto = 'ago';
			break;
		case 9:
			$texto = 'sep' ;
			break;
		case 10:
			$texto = 'oct';
			break;
		case 11:
			$texto = 'nov';
			break;
		case 12:
			$texto = 'dic' ;
			break;
		default:
			$texto = false ;
			break;
	}

	return $texto;
}


function getMes($mes_fecha) {
	return (int) $mes_fecha;
}
