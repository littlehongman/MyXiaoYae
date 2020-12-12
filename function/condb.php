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
		$query = "SELECT * FROM food WHERE store_name=?";
		$statement = $db->prepare($query);
		$statement->execute(array($received_data->name));
		while ($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			$data[] = $row;
		}
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}	

	// if($received_data->action == 'fetchStoreName'){
	// 	$query = "SELECT store_name FROM store WHERE store_name=".$received_data->name;
	// 	$statement = $db->prepare($query);
	// 	$statement->execute();
	// 	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	// 	{
	// 		$data = $row;
	// 	}
	// 	echo json_encode($data, JSON_UNESCAPED_UNICODE);
	// }

	if($received_data->action == 'addOrder'){
		$old_number = 0;
		$cus_name = $received_data->cus_name;
		$food_ID = $received_data->food_ID;
		$fnumber = $received_data->fnumber;
		$query = "SELECT numbers FROM order_list WHERE cus_name=? and food_ID =?";
		$statement = $db->prepare($query);
		$statement->execute(array($cus_name, $food_ID));
		if($row = $statement->fetch(PDO::FETCH_ASSOC)){
			$old_number = json_encode($row['numbers'], JSON_UNESCAPED_UNICODE);
		}
		if($old_number != null){
			$fnumber = $fnumber + $old_number;
			$query = "UPDATE order_list SET numbers=? WHERE cus_name=? and food_ID =?";
			$statement = $db->prepare($query);
			$statement->execute(array($fnumber,$cus_name, $food_ID));
			if($statement){
				echo "訂單追加成功";
			}
			else{
				echo "訂單追加失敗".$statement->errorInfo();
			}
		}
		else{
			$query = "INSERT INTO order_list(cus_name,food_ID,numbers) VALUES ('".$cus_name."','".$food_ID."', '".$fnumber."')";
			$statement = $db->prepare($query);
			$statement->execute();
			if($statement){
				echo "訂單新增成功";
			}
			else{
				echo "訂單新增失敗".$statement->errorInfo();
			}
		}		
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

	if($received_data->action == 'countByStore'){
		$query = "SELECT store_name,sum(price*numbers) as store_sum FROM order_list LEFT OUTER JOIN food USING(food_ID) GROUP BY store_name";
		$statement = $db->prepare($query);
		$statement->execute();
		while ($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			$data[] = $row;
		}
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	if($received_data->action == 'countByFood'){
		$query = "SELECT food_name,sum(numbers) as food_sum FROM order_list LEFT OUTER JOIN food USING(food_ID) GROUP BY food_name";
		$statement = $db->prepare($query);
		$statement->execute();
		while ($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			$data[] = $row;
		}
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}	
	
	if($received_data->action == 'deleteOrder'){
		$cus_name = $received_data->cus_name;
		$food_ID = $received_data->food_ID;

		$query = "DELETE FROM order_list WHERE cus_name=? and food_ID=?";
		$statement = $db->prepare($query);
		$statement->execute(array($cus_name, $food_ID));

		if(!$statement) {
			echo "刪除失敗".$statement->errorInfo();
		}
		else{
			echo "Success";
		}
	}

	if($received_data->action == 'deleteStore'){
		$store_name = $received_data->store_name;
		$query = "DELETE FROM store WHERE store_name=?";
		$statement = $db->prepare($query);
		$statement->execute(array($store_name));
		if($statement) {
			echo "刪除成功";
		}
		else{
			echo "刪除失敗".$statement->errorInfo();
		}
	}

	function checkStoreRepeat($name,$db){
		$query = "SELECT * FROM store WHERE store_name=?";
		$statement = $db->prepare($query);
		$statement->execute(array($name));
		if($statement->fetch(PDO::FETCH_ASSOC) != null){
			return true;
		}
		return false;
	}
	if($received_data->action == 'addStore' || $received_data->action == 'editStore'){
		$store_name = $received_data->store_name;
		$address = $received_data->address;
		$business_hour = $received_data->business_hour;
		$phone = $received_data->phone;

		
		if($received_data->action == 'addStore'){
			if(checkStoreRepeat($store_name,$db) == true){
				echo "店名不得重複";
			}
			else{
				$query = "INSERT INTO store(store_name,address,business_hour,phone) VALUES (?,?,?,?)";
				$statement = $db->prepare($query);
				$statement->execute(array($store_name,$address,$business_hour,$phone));
				if($statement){
					echo "新增成功";
				}
				else{
					echo "新增失敗".$statement->errorInfo();
				}
			}
			
		}
		else if($received_data->action == 'editStore'){
			//"UPDATE order_list SET numbers=? WHERE cus_name=? and food_ID =?";
			$query = "UPDATE store SET store_name=?,address=?,business_hour=?,phone=? WHERE store_name=?";
			$statement = $db->prepare($query);
			$statement->execute(array($store_name,$address,$business_hour,$phone,$store_name));
			if($statement){
				echo "更改成功";
			}
			else{
				echo "更改失敗".$statement->errorInfo();
			}
		}
	}
?>