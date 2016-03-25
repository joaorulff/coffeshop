<?php

	include($_SERVER['DOCUMENT_ROOT'].'/CoffeeShop/Model/Model.php');

	session_start();
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		updateProfile($_SESSION["customerID"], $_POST['firstName'], $_POST['lastName'], $_POST['phoneNumber'], $_POST['email'], $_POST['password']);

		$_SESSION["firstName"] = $_POST['firstName'];
		$_SESSION["lastName"] = $_POST['lastName'];
		$_SESSION["phone"] = $_POST['phoneNumber'];
		$_SESSION["email"] = $_POST['email'];

		header ('Location:  http://'.$_SERVER['HTTP_HOST'].'/CoffeeShop/Controllers/menuScreen_Controller.php');

	}
	include($_SERVER['DOCUMENT_ROOT'].'/CoffeeShop/Views/updateScreen.html');

?>