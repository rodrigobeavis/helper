<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * [ToDateMysql  data pt_BR para data db]
 * @param [type] $date [description]
 */
function ToDateMysql($date) {
	if (is_object($date)) {
		return $date->format("Y-m-d");
	}
	return implode("-", array_reverse(explode("/", $date)));
}
/**
 * [ToDateView data db para data pt_BR]
 * @param [string] $date [data 01/01/1970]
 */
function ToDateView($date) {
	if (is_object($date)) {
		return $date->format("d/m/Y");
	}

	return implode("/", array_reverse(explode("-", $date)));
}
/**
 * verifica se a string e uma data 01/01/1970
 * @param  [string]  $str [data 01/01/1970]
 * @return boolean
 */
function is_date($str) {
	$stamp = strtotime(ToDateMysql($str));
	if (is_numeric($stamp)) {
		return checkdate(date('m', $stamp), date('d', $stamp), date('Y', $stamp));
	}
	return false;
}
/**
 * [diferencaDatas diferença exata Intervalo Aberto considera o ultimo]
 * @param  [string] $date_1           [string date "dd/mm/yyyy" or "yyyy-mm-dd"]
 * @param  string $differenceFormat   [RESULT FORMAT]
 * @param  [string] $date_2           [ string date "dd/mm/yyyy" or "yyyy-mm-dd"]
 * @return [string]                   [string date_diff result]
 */
/*  RESULT FORMAT:
'%y Year %m Month %d Day %h Hours %i Minute %s Seconds'  =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
'%y Year %m Month %d Day'                                =>  1 Year 3 Month 14 Days
'%m Month %d Day'                                        =>  3 Month 14 Day
%d Day %h Hours'                                        =>  14 Day 11 Hours
'%d Day'                                                 =>  14 Days
'%h Hours %i Minute %s Seconds'                          =>  11 Hours 49 Minute 36 Seconds
'%i Minute %s Seconds'                                   =>  49 Minute 36 Seconds
'%h Hours                                                =>  11 Hours
'%a Days                                                 =>  468 Days*/
function diferencaDatas($date_1, $differenceFormat = '%a', $date_2 = null) {
	try {
		$date_2 = (!empty($date_2)) ? $date_2 : date("Y-m-d");

		$date_1 = (strpos($date_1, '/')) ? ToDateMysql($date_1) : $date_1;
		$date_2 = (strpos($date_2, '/')) ? ToDateMysql($date_2) : $date_2;

		$datetime1 = date_create($date_1);
		$datetime2 = date_create($date_2);

		$interval = date_diff($datetime1, $datetime2);

		if (!empty($interval)) {
			return $interval->format($differenceFormat);
		}
	} catch (Exception $e) {
		echo $e;
	}
}/**
 * [diferencaDatas diferença exata Intervalo Aberto considera o ultimo dia]
 * @param  [string] $date_1           [string date "dd/mm/yyyy" or "yyyy-mm-dd"]
 * @param  string $differenceFormat   [RESULT FORMAT]
 * @param  [string] $date_2           [ string date "dd/mm/yyyy" or "yyyy-mm-dd"]
 * @return [string]                   [string date_diff result]
 */
/*  RESULT FORMAT:
'%y Year %m Month %d Day %h Hours %i Minute %s Seconds'  =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
'%y Year %m Month %d Day'                                =>  1 Year 3 Month 14 Days
'%m Month %d Day'                                        =>  3 Month 14 Day
%d Day %h Hours'                                        =>  14 Day 11 Hours
'%d Day'                                                 =>  14 Days
'%h Hours %i Minute %s Seconds'                          =>  11 Hours 49 Minute 36 Seconds
'%i Minute %s Seconds'                                   =>  49 Minute 36 Seconds
'%h Hours                                                =>  11 Hours
'%a Days                                                 =>  468 Days*/
function dataDiffContagemDeTempo($date_1, $differenceFormat = '%a', $date_2 = null) {
	try {
		$date_2 = (!empty($date_2)) ? $date_2 : date("Y-m-d");

		$date_1 = (strpos($date_1, '/')) ? ToDateMysql($date_1) : $date_1;
		$date_2 = (strpos($date_2, '/')) ? ToDateMysql($date_2) : $date_2;

		if (date_create($date_1) < date_create($date_2)) {
			$datetime1 = date_create($date_1);
			$datetime2 = date_add(date_create($date_2), date_interval_create_from_date_string('1 day'));
		} else {
			$datetime1 = date_create($date_2);
			$datetime2 = date_add(date_create($date_1), date_interval_create_from_date_string('1 day'));
		}

		$interval = date_diff($datetime1, $datetime2);

		if (!empty($interval)) {
			return $interval->format($differenceFormat);
		}
	} catch (Exception $e) {
		echo $e;
	}
}

//function DaysToFormate($days, $format)
function DaysToFormate($dias) {
	if (!empty($dias)) {
		$years = ($dias / 365.25); // days / 365 days
		$years = floor($years); // Remove all decimals

		$month = ($dias % 365.25) / 30.4375; // I choose 30.5 for Month (30,31) ;)
		$month = floor($month); // Remove all decimals

		$days = ($dias % 365.25) % 30.4375; // the rest of days

		// Echo all information set
		/*echo 'DAYS RECEIVE : '.$dias.' days<br>';
        echo $years.' years - '.$month.' month - '.$days.' days';*/

		return $years . ' anos - ' . $month . ' meses - ' . $days . ' dias';
	}
}

//function DaysToFormate($days, $format)

function YearMonthDaysToFormate($dias) {
	if (!empty($dias)) {
		$years = ($dias / 365.25); // days / 365 days
		$years = floor($years); // Remove all decimals

		if ($dias > 30.4375) {
			$month = ($dias % 365.25) / 30.4375; // I choose 30.5 for Month (30,31) ;)
			$month = floor($month); // Remove all decimals
		} else {
			$month = ($dias % 365.25) / 30; // I choose 30.5 for Month (30,31) ;)
			$month = floor($month); // Remove all decimals
		}

		$days = ($dias % 365.25) % 30.4375; // the rest of days

		// Echo all information set
		/*echo 'DAYS RECEIVE : '.$dias.' days<br>';
        echo $years.' years - '.$month.' month - '.$days.' days';*/

		return $years . ' anos - ' . $month . ' meses - ' . $days . ' dias';
	}
}

// function YearMonthDaysToFormate($dias) {
// 	if (!empty($dias)) {

// 		$years = floor($dias / 365.25);
// 		$months = floor(($dias - ($years * 365.25)) / 30.4375);
// 		$days = round($dias - ($years * 365.25) - ($months * 30.4375));

// 		return $years . ' anos - ' . $months . ' meses - ' . $days . ' dias';
// 	}
// }

function comparar_datas($data1, $data2) {
	if (!empty($data1) && !empty($data2)) {
		$t1 = strtotime($data1);
		$t2 = strtotime($data2);
		return $t1 - $t2;
	}
}

function retorna_menor_data($data1, $data2) {
	$diffdate = comparar_datas($data1, $data2);

	if ($diffdate > 0) {
		return $data2;
	} else {
		return $data1;
	}
};

function retorna_maior_data($data1, $data2) {
	$diffdate = comparar_datas($data1, $data2);

	if ($diffdate < 0) {
		return $data2;
	} else {
		return $data1;
	}
};
