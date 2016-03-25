<?php

	include($_SERVER['DOCUMENT_ROOT'].'/CoffeeShop/Model/Model.php');

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		insertUser($_POST['firstName'], $_POST['lastName'], $_POST['phoneNumber'], $_POST['email'], $_POST['password']);

		header ('Location:  http://'.$_SERVER['HTTP_HOST'].'/CoffeeShop/index.php');
	}


	include($_SERVER['DOCUMENT_ROOT'].'/CoffeeShop/Views/SignUpScreen.html');

?>