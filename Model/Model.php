<?php

	$dbUsername = 'root';
	$dbPassword = 'root';


	try{
		$connection = new PDO('mysql:host=localhost;dbname=SE357_coffeeshop;', $dbUsername , $dbPassword );
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	}catch(PDOException $e){

		echo $e -> getMessage();

	}

	
	function login($email, $password){

		global $connection;

		$query = "SELECT email, password FROM customer_portal_access_credentials WHERE email = '".$email."'  AND password = '".$password."'";

		$result = $connection->query($query);
		$row = $result->fetchAll(PDO::FETCH_ASSOC);

		$numberOfResults = count($row);

		if($numberOfResults == 1){
			return true;
		}else{
			return false;
		}
	}



	function getAllTheProducts(){

		global $connection;

		$query = "SELECT * FROM Products INNER JOIN ProductTypes ON Products.Product_Type_Id = ProductTypes.Product_Type_Id";

		$result = $connection->query($query);

		$row = $result->fetchAll(PDO::FETCH_ASSOC);

		return $row;
	}

	function getPreviousOrders($id){

		global $connection;


		//$query = "SELECT T.Order_Id, T.Order_Totalprice, Products.Product_Name, T.Product_Quantity, Products.Product_Price  FROM (SELECT Orders.Order_Id, Orders.Order_Totalprice, OrderedProducts.Product_Quantity, OrderedProducts.Product_Price, OrderedProducts.Order_Product_Id  FROM Orders INNER JOIN OrderedProducts ON Orders.Order_Id = OrderedProducts.Order_Id WHERE Orders.Customer_Id =".$id.") as T INNER JOIN Products ON Products.Product_Id = T.Product_Id";

		$query = "SELECT T.Order_Id, T.Order_Totalprice, Products.Product_Name, T.Product_Quantity, Products.Product_Price  FROM (SELECT Orders.Order_Id, Orders.Order_Totalprice, OrderedProducts.Product_Quantity, OrderedProducts.Product_Price, OrderedProducts.Order_Product_Id, OrderedProducts.Product_Id FROM Orders INNER JOIN OrderedProducts ON Orders.Order_Id = OrderedProducts.Order_Id WHERE Orders.Customer_Id = ".$id.") as T INNER JOIN Products ON Products.Product_Id = T.Product_Id";

		$result = $connection->query($query);

		$row = $result->fetchAll(PDO::FETCH_ASSOC);

		return $row;
	}



	function placeOrder($totalPrice, $loginID, $customerID, $arrayOfProducts){

		global $connection;

		$stmt = $connection->prepare("INSERT INTO Orders (Order_Date, Order_Totalprice, Customer_Id, login_id) VALUES (:Order_Date, :Order_Totalprice, :Customer_Id, :login_id)");
		
		$stmt->bindParam(':Order_Date', date('Y-m-d h:i:s', time()), PDO::PARAM_STR);
		$stmt->bindParam(':Order_Totalprice', $totalPrice, PDO::PARAM_STR);
		$stmt->bindParam(':Customer_Id', $customerID, PDO::PARAM_STR);
		$stmt->bindParam(':login_id', $loginID, PDO::PARAM_STR);
		
		$stmt->execute();
		
		$lastID = $connection->lastInsertId();

		foreach($arrayOfProducts as $productsBought){

			$stmt = $connection->prepare("INSERT INTO OrderedProducts (Order_Id, Product_Id, Product_Quantity, Product_Price) VALUES (:Order_Id, :Product_Id, :Product_Quantity, :Product_Price)");

			
			$stmt->bindParam(':Order_Id', $lastID, PDO::PARAM_STR);
			$stmt->bindParam(':Product_Id', $productsBought['Product_Id'], PDO::PARAM_STR);
			$stmt->bindParam(':Product_Quantity', $productsBought['Product_Qty'], PDO::PARAM_STR);
			$stmt->bindParam(':Product_Price', $productsBought['Product_Price'], PDO::PARAM_STR);


			$stmt->execute();
			

		}
		

	}

	function updateProfile($id, $firstName, $lastName, $phone, $email, $password){

		global $connection;

		$stmt = $connection->prepare("UPDATE Customers SET Customer_FirstName = :firstName , Customer_LastName = :lastName, Customer_Phone_No = :phone WHERE Customer_Id = :id");

		$stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
		$stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
		$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);

		$stmt->execute();

		$stmt = $connection->prepare("UPDATE customer_portal_access_credentials SET email = :email , password = :password WHERE Customer_Id = :id");

		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':password', $password, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);

		$stmt->execute();



	}

	function getSessionInfo($username){

		global $connection;

		$query = "SELECT * FROM Customers INNER JOIN customer_portal_access_credentials 
		ON Customers.Customer_Id = customer_portal_access_credentials.customer_id WHERE customer_portal_access_credentials.email='".$username."'";

		$result = $connection->query($query);

		$row = $result->fetchAll(PDO::FETCH_ASSOC);

		return $row[0];

	}


	function insertUser($firstName, $lastName, $phone, $email, $password){


		global $connection;

		$stmt = $connection->prepare("INSERT INTO Customers (Customer_FirstName, Customer_LastName, Customer_Phone_No) VALUES (:Customer_FirstName, :Customer_LastName, :Customer_Phone_No)");

		$stmt->bindParam(':Customer_FirstName', $firstName, PDO::PARAM_STR);
		$stmt->bindParam(':Customer_LastName', $lastName, PDO::PARAM_STR);
		$stmt->bindParam(':Customer_Phone_No', $phone, PDO::PARAM_STR);
		
		$stmt->execute();

		$stmt = $connection->prepare("INSERT INTO customer_portal_access_credentials(customer_id, email, password) VALUES (:customer_id,:email,:password)");

		$stmt->bindParam(':customer_id', $connection->lastInsertId(), PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':password', $password, PDO::PARAM_STR);
		
		$stmt->execute();
	}


	function loginLog($loginDate, $costumerId, $loginIp){

		global $connection;

		$stmt = $connection->prepare("INSERT INTO customer_logins(last_login_date_time, customer_id, login_IP) VALUES (:last_login_date_time, :customer_id ,:login_IP)");

		$stmt->bindParam(':last_login_date_time', $loginDate, PDO::PARAM_STR);
		$stmt->bindParam(':customer_id', $costumerId, PDO::PARAM_STR);
		$stmt->bindParam(':login_IP', $loginIp, PDO::PARAM_STR);


		$stmt->execute();

		//echo $connection->lastInsertId();

		return $connection->lastInsertId();
	}


?>