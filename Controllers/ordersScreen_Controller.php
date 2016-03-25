<?php

	include($_SERVER['DOCUMENT_ROOT'].'/CoffeeShop/Model/Model.php');

	session_start();

	$orders = getPreviousOrders($_SESSION["customerID"]);

	include($_SERVER['DOCUMENT_ROOT'].'/CoffeeShop/Views/ordersScreen.html');


?>