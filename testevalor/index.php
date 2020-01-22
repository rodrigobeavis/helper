<?php

$converterValorPagseguro = function ($valor) {

	$valorRST = 0;
	preg_match('/(\,)/', $valor, $matches);
	var_dump(count($matches));

	if (is_string($valor) && (count($matches) > 0)) {

		$valor = (count($matches) > 1) ? preg_replace('/(\,)/', '', $valor) : $valor;
		$valorRST = (float) preg_replace('/(\.)/', '', $valor);
		$valorRST = number_format($valorRST, 2, '.', '');

	} else {

		$valor = (is_string($valor)) ? (float) $valor : $valor;
		$valorRST = number_format($valor, 2, '.', '');

	}

	return $valorRST;

};

$arrayValues = ['999,9', '999', 999, '1.001.200,00', 790.50, 790.10, 790.00, '200.0', '1.200,00', '781,50', 1200.0, '1,001,200.00'];

foreach ($arrayValues as $item) {

	var_dump($converterValorPagseguro($item));

}