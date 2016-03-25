<?php

	include($_SERVER['DOCUMENT_ROOT'].'/CoffeeShop/Model/Model.php');

	session_start();

	$productsFromDatabase = getAllTheProducts();
	$productsToShow = array();
	$totalValue = 0;

	foreach ($productsFromDatabase as $row) {

		$prodID = $row['Product_Id'];


		if($_SESSION["product_".$prodID]  >= 1){

			$temp = array("Product_Id"=>$prodID, "Product_Name" => $row["Product_Name"] ,"Product_Qty"=>$_SESSION["product_".$prodID], "Product_Price"=> $row['Product_Price']*$_SESSION["product_".$prodID]);
			$totalValue += $row['Product_Price']*$_SESSION["product_".$prodID];
			array_push($productsToShow, $temp);	
			

		}
	}

	if(isset($_GET['place'])){

		placeOrder($totalValue, $_SESSION["loginId"], $_SESSION["customerID"], $productsToShow);

		session_destroy();

		header ('Location:  http://'.$_SERVER['HTTP_HOST'].'/CoffeeShop/Controllers/finalScreen_Controller.php');

	}

	if(isset($_GET['logout'])){

		session_destroy();

		header ('Location:  http://'.$_SERVER['HTTP_HOST'].'/CoffeeShop/index.php');
	}

			
	include($_SERVER['DOCUMENT_ROOT'].'/CoffeeShop/Views/checkoutScreen.html');

?>