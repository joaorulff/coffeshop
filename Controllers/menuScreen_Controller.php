<?php

	

	include($_SERVER['DOCUMENT_ROOT'].'/CoffeeShop/Model/Model.php');

	session_start();

	$products = getAllTheProducts();

			
	include($_SERVER['DOCUMENT_ROOT'].'/CoffeeShop/Views/menuScreen.html');

?>