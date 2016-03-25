<?php

	include($_SERVER['DOCUMENT_ROOT'].'/CoffeeShop/Model/Model.php');


	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		if( login($_POST['username'], $_POST['password'])  ){

			session_start();
			//session_destroy();
			$sessionInfo = getSessionInfo($_POST['username']);
			$_SESSION["firstName"] = $sessionInfo['Customer_FirstName'];
			$_SESSION["lastName"] = $sessionInfo['Customer_LastName'];
			$_SESSION["phone"] = $sessionInfo['Customer_Phone_No'];
			$_SESSION["email"] = $sessionInfo['email'];
			$_SESSION["customerID"] = $sessionInfo['Customer_Id'];
			
			//implement login
			$_SESSION["loginId"] = loginLog(date('Y-m-d h:i:s', time()), $sessionInfo['Customer_Id'], $_SERVER['REMOTE_ADDR']);

			
			header ('Location:  http://'.$_SERVER['HTTP_HOST'].'/CoffeeShop/Controllers/menuScreen_Controller.php');

		}else{

			header ('Location:  http://'.$_SERVER['HTTP_HOST'].'/CoffeeShop/Views/ErrorScreen.html');
		}
	}

	include($_SERVER['DOCUMENT_ROOT'].'/CoffeeShop/Views/loginScreen.html');

?>