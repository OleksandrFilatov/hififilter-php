<?php

	require("dbconn.php");
	require("Search.php");
	require("Api.php");

	$search = new Search();
	$api = new Api();

	if(isset($_GET['search'])){
		echo json_encode($search->searchItemsByID($_GET['search']));
	}


	if(isset($_GET['reference'])){
		$api->connectAPI();
		foreach ($api->getDataByReference($_GET['reference'])->articles as $key => $value) {
			$array = $api->getPrice($value->cell[2]->value);
			echo '<a class="suggestions__item suggestions__product" href="https://creativesales.hu/munkalatok/hififilter/product/'.$value->cell[2]->value.'">'.
			'<div class="suggestions__product-image image image--type--product">'.
				'<div class="image__body">'.
					'<img class="image__tag" src="https://hifi-filter.com/img/filtre/'.$value->logo.'" alt="">'.
				'</div>'.
			'</div>'.
			'<div class="suggestions__product-info">'.
				'<div class="suggestions__product-name">'.$value->designation.'<br>'.$value->indexField.'</div>'.
			'</div>'.
			'<div class="suggestions__product-price">'.$array[0]->unitPrice.' '.$array[0]->currency.'</div>'.
			'</a>';
		}
		$api->closeAPI();
	}
?>