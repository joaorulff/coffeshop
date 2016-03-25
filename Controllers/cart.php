<?php

	session_start();

	if(isset($_GET['add'])){

		$_SESSION["product_".$_GET['add'].""] += 1;

		header ('Location:  http://'.$_SERVER['HTTP_HOST'].'/CoffeeShop/Controllers/menuScreen_Controller.php');

		//echo 'TEST';
		//header ('Location:  http://'.$_SERVER['HTTP_HOST'].'/CoffeeShop/Controllers/menuScreen_Controller.php');
		//redirect("Controllers/menuScreen_Controller.php");
	}


?>