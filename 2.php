<?php

/**
 * @charset UTF-8
 *
 * Задание 2. Работа с массивами и строками.
 *
 * Есть список временных интервалов (интервалы записаны в формате чч:мм-чч:мм).
 *
 * Необходимо написать две функции:
 *
 *
 * Первая функция должна проверять временной интервал на валидность
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 * 	возвращать boolean
 *
 *
 * Вторая функция должна проверять "наложение интервалов" при попытке добавить новый интервал в список существующих
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 *  возвращать boolean
 *
 *  "наложение интервалов" - это когда в промежутке между началом и окончанием одного интервала,
 *   встречается начало, окончание или то и другое одновременно, другого интервала
 *
 *  пример:
 *
 *  есть интервалы
 *  	"10:00-14:00"
 *  	"16:00-20:00"
 *
 *  пытаемся добавить еще один интервал
 *  	"09:00-11:00" => произошло наложение
 *  	"11:00-13:00" => произошло наложение
 *  	"14:00-16:00" => наложения нет
 *  	"14:00-17:00" => произошло наложение
 */

# Можно использовать список:

$list = array (
	'09:00-11:00',
	'11:00-13:00',
	'15:00-16:00',
	'17:00-20:00',
	'20:30-21:30',
	'21:30-22:30',
);

$reg1="/^\d{2}:\d{2}-\d{2}:\d{2}$/";
$reg2="/^([0-1][0-9]||[2][0-4]):([0-5][0-9])-([0-1][0-9]||[2][0-4]):([0-5][0-9])$/";
function timeMatch($str) {
	preg_match('/^([0-1][0-9]||[2][0-4]):([0-5][0-9])-([0-1][0-9]||[2][0-4]):([0-5][0-9])$/is', $str, $m);
	if($m[0]) {
		return true;
	} else {
		return false;
	}
}

var_dump(timeMatch('10:00-14:00'));

function compareTime ($str) {
	global $list;
	$intervals = explode('-', $str);
	$freeList0 = [];
	$freeList = [];
	$result = false;
	
	// создаём массив контрольных точек свободных интервалов
	for($i = 0; $i < count($list); $i++) {
		if ($i == 0) {
			$freeList0[] = explode('-', $list[$i])[1]; // последний час первого элемента массива
		} elseif ($i == (count($list) -1)) {
			$freeList0[] = explode('-', $list[$i])[0]; // первый час последнего элемента массива
		} else {
			$freeList0[] = explode('-', $list[$i])[0];
			$freeList0[] = explode('-', $list[$i])[1];
		}
	}

	// Создаём массив со строками свободных интервалов
	for ($i = 0; $i < count($freeList0); $i++) {
		$freeList[] = $freeList0[$i].'-'.$freeList0[++$i];
	}
	
	foreach ($freeList as $freeInterval) {
		$startNewInterval = new DateTimeImmutable($intervals[0]);
		$endNewInterval = new DateTimeImmutable($intervals[1]);
		$freeIntervalsArray = explode('-', $freeInterval); // разбили интервал на массив
		$startInterval = new DateTimeImmutable($freeIntervalsArray[0]);
		$endInterval = new DateTimeImmutable($freeIntervalsArray[1]);
		global $result;

		// если старт и конец нового интервала входит в свободный интервал, то true, если нет - false
		if (($startInterval <= $startNewInterval && $startNewInterval <= $endInterval) && ($startInterval <= $endNewInterval && $endNewInterval <= $endInterval)) {
			return $result = true;
		} else {
			$result = false;
		}
	}

	return $result;
}

var_dump(compareTime('10:00-14:00'));

?>
