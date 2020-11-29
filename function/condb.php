<?php
	$user = 'root'; //資料庫使用者名稱
	$password = 'root'; //資料庫的密碼
	try{
		$db = new PDO ('mysql: host=localhost;dbname=myxiaoyae; charset=utf8', $user, $password);
		//之後若要結束與資料庫的連線，則使用「$db = null;」
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
	}catch(PDOException $e){ //若上述程式碼出現錯誤，便會執行以下動作
		Print "ERROR!:" . $e->getMessage();
		die();
	}
	
	$data = array();
	$received_data = json_decode(file_get_contents("php://input"));

	if($received_data->action == 'fetchStore'){
		$query = "SELECT * FROM store";
		$statement = $db->prepare($query);
		$statement->execute();
		while ($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			$data[] = $row;
		}
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}	

	if($received_data->action == 'fetchFood'){
		$query = "SELECT * FROM food WHERE store_ID=".$received_data->id;
		$statement = $db->prepare($query);
		$statement->execute();
		while ($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			$data[] = $row;
		}
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}	

	if($received_data->action == 'fetchStoreName'){
		$query = "SELECT store_name FROM store WHERE store_ID=".$received_data->id;
		$statement = $db->prepare($query);
		$statement->execute();
		while ($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			$data = $row;
		}
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	if($received_data->action == 'addOrder'){
		$cus_name = $received_data->cus_name;
		$food_ID = $received_data->food_ID;
		$fnumber = $received_data->fnumber;
		$query = "INSERT INTO order_list(cus_name,food_ID,numbers) VALUES ('".$cus_name."','".$food_ID."', '".$fnumber."')";
		$statement = $db->prepare($query);
		$statement->execute();
		echo "成功";
	}

	if($received_data->action == 'fetchOrder'){
		$query = "SELECT * FROM order_list LEFT OUTER JOIN food USING(food_ID)";
		$statement = $db->prepare($query);
		$statement->execute();
		while ($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			$data[] = $row;
		}
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	if($received_data->action == 'fetchSum'){
		$query = "SELECT sum(price*numbers) as order_sum FROM order_list LEFT OUTER JOIN food USING(food_ID)";
		$statement = $db->prepare($query);
		$statement->execute();
		while ($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			$data = $row;
		}
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}	

	if($received_data->action == 'countByPerson'){
		$query = "SELECT cus_name,sum(price*numbers) as person_sum FROM order_list LEFT OUTER JOIN food USING(food_ID) GROUP BY cus_name";
		$statement = $db->prepare($query);
		$statement->execute();
		while ($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			$data[] = $row;
		}
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}	

?>