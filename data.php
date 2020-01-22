
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Calcular a diferença entre de duas datas</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<?php 
/**
 * [ToDateMysql  data pt_BR para data db]
 * @param [type] $date [description]
 */
function ToDateMysql($date)
{
	return implode("-", array_reverse(explode("/", $date)));
}
/**
 * [ToDateView data db para data pt_BR]
 * @param [string] $date [data 01/01/1970]
 */
function ToDateView($date)
{
	return implode("/", array_reverse(explode("-", $date)));
}
/**
 * verifica se a string e uma data 01/01/1970
 * @param  [string]  $str [data 01/01/1970]
 * @return boolean     
 */
function is_date($str)
{
	$stamp = strtotime(ToDateMysql($str));
	if (is_numeric($stamp)) {
		return checkdate(date('m', $stamp), date('d', $stamp), date('Y', $stamp));
	}
	return false;
}
/*
 * [diferencaDatas diferença exata Intervalo Aberto considera o ultimo]
 * @param  [string] $date_1           [string date "dd/mm/yyyy" or "yyyy-mm-dd"]
 * @param  string $differenceFormat   [RESULT FORMAT]
 * @param  [string] $date_2           [ string date "dd/mm/yyyy" or "yyyy-mm-dd"]
 * @return [string]                   [string date_diff result]
		RESULT FORMAT:
		'%y Year %m Month %d Day %h Hours %i Minute %s Seconds'  =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
		'%y Year %m Month %d Day'                                =>  1 Year 3 Month 14 Days
		'%m Month %d Day'                                        =>  3 Month 14 Day
		 %d Day %h Hours'                                        =>  14 Day 11 Hours
		'%d Day'                                                 =>  14 Days
		'%h Hours %i Minute %s Seconds'                          =>  11 Hours 49 Minute 36 Seconds
		'%i Minute %s Seconds'                                   =>  49 Minute 36 Seconds
		'%h Hours                                                =>  11 Hours
		'%a Days                                                 =>  468 Days
 */
		/*function diferencaDatas($date_1 , $differenceFormat = '%a', $date_2 = null )
		{
			try {


				$date_2 = (!empty($date_2))? $date_2 :  date("Y-m-d");

				$date_1 = (strpos($date_1, '/'))? ToDateMysql($date_1) : $date_1;
				$date_2 = (strpos($date_2, '/'))? ToDateMysql($date_2) : $date_2;

				$datetime1 = date_create($date_1);
				$datetime2 =  date_create($date_2); 

				$interval = date_diff($datetime1, $datetime2);

				if (!empty($interval)) {

					return $interval->format($differenceFormat);
				}
				
			} catch (Exception $e) {
				echo $e;
			}


	}*/

	/*
 * [diferencaDatas diferença exata Intervalo Aberto considera o ultimo dia]
 * @param  [string] $date_1           [string date "dd/mm/yyyy" or "yyyy-mm-dd"]
 * @param  string $differenceFormat   [RESULT FORMAT]
 * @param  [string] $date_2           [ string date "dd/mm/yyyy" or "yyyy-mm-dd"]
 * @return [string]                   [string date_diff result]
	RESULT FORMAT:
	'%y Year %m Month %d Day %h Hours %i Minute %s Seconds'  =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
	'%y Year %m Month %d Day'                                =>  1 Year 3 Month 14 Days
	'%m Month %d Day'                                        =>  3 Month 14 Day
	 %d Day %h Hours'                                        =>  14 Day 11 Hours
	'%d Day'                                                 =>  14 Days
	'%h Hours %i Minute %s Seconds'                          =>  11 Hours 49 Minute 36 Seconds
	'%i Minute %s Seconds'                                   =>  49 Minute 36 Seconds
	'%h Hours                                                =>  11 Hours
	'%a Days                                                 =>  468 Days
 */
function dataDiffContagemDeTempo($date_1, $differenceFormat = '%a', $date_2 = null)
{
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

if (filter_input(INPUT_POST, 'type') == "Calcular") {

	$data1 = filter_input(INPUT_POST, 'data1');
	$data2 = filter_input(INPUT_POST, 'data2');

	$diferencaDt = dataDiffContagemDeTempo($data1, '%y Anos %m Meses %d Dias', $data2);
	$diferencaDias = dataDiffContagemDeTempo($data1, '%a', $data2);

}


function YearMonthDaysToFormate($convert) {
	if (!empty($convert)) {
		// $years = ($convert / 365.25) ; // days / 365 days
		// $years = floor($years); // Remove all decimals

		// $month = ($convert % 365.25) / 30.5; // I choose 30.5 for Month (30,31) ;)
		// $month = floor($month); // Remove all decimals

		// $days = ($convert % 365.5) % 30.5; // the rest of days


		// $xValor = $convert;

		// //  console.log(xValor);
	
		// $dttAno = floor($xValor);
		// $xVarMes = ($xValor - $dttAno) * 12;
		// $dttMes = floor($xVarMes);
		// $dttDias = ($xVarMes - $dttMes) * 30.436875;
		// $dttTotalDias = $dttDias;


		$xValor =  (ceil($convert) / 365.25);

		$years = floor($xValor);
		$xVarMes = ($xValor - $years) * 12;
		$month = floor($xVarMes);
		$dttDias = ($xVarMes - $month) * 30.436875;
		$days = round($dttDias);

		return $years.' anos - '.$month.' meses - '.$days.' dias';
	}
}

if (filter_input(INPUT_POST, 'type') == "converter") {
	$days = filter_input(INPUT_POST, 'days');
	$conversao = YearMonthDaysToFormate($days);
}

?>
</head>
<body class="container">
	<div class="row">
		<div class="jumbotron ">
			<h3>Teste calcular diferença de datas </h3>
				<h5>anos, meses, dias e total em dias</h5>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<form method="POST" action="#" class="form-inline input-group">
					<input type="text" name="data1" class="date input-lg"  value="<?php echo filter_input(INPUT_POST, 'data1') ?>">
					<input type="text" name="data2" class="date input-lg" value="<?php echo filter_input(INPUT_POST, 'data2') ?>">
					<input class="btn btn-success btn-lg" type="submit" name="type" value="Calcular">
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<br><br><br>
			<button class="btn btn-primary btn-block" style="font-size: 16px !important; font-weight: 700 !important;">
				<?php 
			if (!empty($diferencaDt)) {
				echo "$diferencaDt ($diferencaDias dias)";
			} else {
				echo "Resultado: 0";
			}
			?> 
			</button>
			</div>
		</div>
	</div>
</div>
</div>
</div>

<div class="row">
	<div class="col-md-12">
	<form method="POST" action="#" class="form-inline input-group">
		<input type="number"  name="days" class="input-lg"  value="<?php echo filter_input(INPUT_POST, 'days') ?>">
		<input class="btn btn-success btn-lg" type="submit" name="type" value="converter">
	</form>
	</div>
</div>
<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<br><br><br>
			<button class="btn btn-primary btn-block" style="font-size: 16px !important; font-weight: 700 !important;">
				<?php 
			if (!empty($conversao)) {
				echo "$conversao ($days dias)";
			} else {
				echo "Resultado: 0";
			}
			?> 
			</button>
			</div>
		</div>



</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.12/jquery.mask.js" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js" type="text/javascript" ></script>
<script type="text/javascript">
$(".date").datepicker({
        format: "dd/mm/yyyy",
        clearBtn: true,
        language: "pt-BR",
        todayHighlight: true
    });
	$('.date').mask('00/00/0000');
</script>
</html>

