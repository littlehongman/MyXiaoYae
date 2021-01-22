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
		try{
			$query = "SELECT * FROM store";
			if($statement = $db->prepare($query)){
				$statement->execute();
				while ($row = $statement->fetch(PDO::FETCH_ASSOC))
				{
					$data[] = $row;
				}
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}	

	if($received_data->action == 'fetchFood'){
		try{
			$query = "SELECT * FROM food WHERE store_name=?";
			if($statement = $db->prepare($query)){
				$statement->execute(array($received_data->name));
				while ($row = $statement->fetch(PDO::FETCH_ASSOC))
				{
					$data[] = $row;
				}
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}

	if($received_data->action == 'fetchAllFood'){
		try{
			$query = "SELECT * FROM food";
			if($statement = $db->prepare($query)){
				$statement->execute();
				while ($row = $statement->fetch(PDO::FETCH_ASSOC))
				{
					$data[] = $row;
				}
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}

	/*
	if($received_data->action == 'fetchStoreName'){
		try{
			$query = "SELECT store_name FROM store WHERE store_name=".$received_data->name;
			if($statement = $db->prepare($query)){
				$statement->execute();
				while ($row = $statement->fetch(PDO::FETCH_ASSOC))
				{
					$data = $row;
				}
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
			}	
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}
	*/

	if($received_data->action == 'addOrder'){
		try{
			$old_number = 0;
			$cus_name = $received_data->cus_name;
			$food_ID = $received_data->food_ID;
			$fnumber = $received_data->fnumber;
			$query = "SELECT numbers FROM order_list WHERE cus_name=? and food_ID =?";
			if($statement = $db->prepare($query)){
				$statement->execute(array($cus_name, $food_ID));
	
				if($row = $statement->fetch(PDO::FETCH_ASSOC)){
					$old_number = json_encode($row['numbers'], JSON_UNESCAPED_UNICODE);
				}
				if($old_number != null){
					$fnumber = $fnumber + $old_number;
					$query = "UPDATE order_list SET numbers=? WHERE cus_name=? and food_ID =?";
					if($statement = $db->prepare($query)){
						$success = $statement->execute(array($fnumber,$cus_name, $food_ID));
						if($success){
							echo "訂單追加成功";
						}
						else{
							echo "訂單追加失敗".$statement->errorInfo();
						}
					}
				}
				else{
					$query = "INSERT INTO order_list(cus_name,food_ID,numbers) VALUES ('".$cus_name."','".$food_ID."', '".$fnumber."')";
					if($statement = $db->prepare($query)){
						$success = $statement->execute();
						if($success){
							echo "訂單新增成功";
						}
						else{
							echo "訂單新增失敗".$statement->errorInfo();
						}
					}
				}
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
		
	}

	if($received_data->action == 'fetchOrder'){
		try{
			$query = "SELECT * FROM order_list LEFT OUTER JOIN food USING(food_ID)";
			if($statement = $db->prepare($query)){
				$statement->execute();
				while ($row = $statement->fetch(PDO::FETCH_ASSOC))
				{
					$data[] = $row;
				}
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}

	if($received_data->action == 'fetchSum'){
		try{
			if($received_data->keyword != ''){
				$keyword = $received_data->keyword;
				$keyword = '%'.$keyword.'%';
				$query = "SELECT IFNULL(sum(price*numbers),0) as order_sum FROM order_list LEFT OUTER JOIN food USING(food_ID) WHERE food_name LIKE ?";
	
				if($statement = $db->prepare($query)){
					$statement->execute(array($keyword));
					while ($row = $statement->fetch(PDO::FETCH_ASSOC))
					{
						$data = $row;
					}
					echo json_encode($data, JSON_UNESCAPED_UNICODE);
				}
			}
			else{
				$query = "SELECT sum(price*numbers) as order_sum FROM order_list LEFT OUTER JOIN food USING(food_ID)";
	
				if($statement = $db->prepare($query)){
					$statement->execute();
					while ($row = $statement->fetch(PDO::FETCH_ASSOC))
					{
						$data = $row;
					}
					echo json_encode($data, JSON_UNESCAPED_UNICODE);
				}
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}	

	if($received_data->action == 'countByPerson'){
		try{
			$query = "SELECT cus_name,sum(price*numbers) as person_sum FROM order_list LEFT OUTER JOIN food USING(food_ID) GROUP BY cus_name";
			if($statement = $db->prepare($query)){
				$statement->execute();
				while ($row = $statement->fetch(PDO::FETCH_ASSOC))
				{
					$data[] = $row;
				}
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}

	if($received_data->action == 'countByStore'){
		try{
			$query = "SELECT store_name,sum(price*numbers) as store_sum FROM order_list LEFT OUTER JOIN food USING(food_ID) GROUP BY store_name";
			if($statement = $db->prepare($query)){
				$statement->execute();
				while ($row = $statement->fetch(PDO::FETCH_ASSOC))
				{
					$data[] = $row;
				}
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}

	if($received_data->action == 'countByFood'){
		try{
			$query = "SELECT food_name,sum(numbers) as food_sum FROM order_list LEFT OUTER JOIN food USING(food_ID) GROUP BY food_name";
			if($statement = $db->prepare($query)){
				$statement->execute();
				while ($row = $statement->fetch(PDO::FETCH_ASSOC))
				{
					$data[] = $row;
				}
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}	
	
	if($received_data->action == 'deleteOrder'){
		try{
			$cus_name = $received_data->cus_name;
			$food_ID = $received_data->food_ID;

			$query = "DELETE FROM order_list WHERE cus_name=? and food_ID=?";
			if($statement = $db->prepare($query)){
				$success = $statement->execute(array($cus_name, $food_ID));
	
				if(!$success) {
					echo "刪除失敗".$statement->errorInfo();
				}
				else{
					echo "Success";
				}
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}

	if($received_data->action == 'deleteStore'){
		try{
			$store_name = $received_data->store_name;
			$query = "DELETE FROM store WHERE store_name=?";
			if($statement = $db->prepare($query)){
				$success = $statement->execute(array($store_name));
				if($success) {
					echo "刪除成功";
				}
				else{
					echo "刪除失敗".$statement->errorInfo();
				}
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}

	function checkStoreRepeat($name,$db){
		try{
			$query = "SELECT * FROM store WHERE store_name=?";

			if($statement = $db->prepare($query)){
				$statement->execute(array($name));
				if($statement->fetch(PDO::FETCH_ASSOC) != null){
					return true;
				}
				return false;
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}
	if($received_data->action == 'addStore' || $received_data->action == 'editStore'){
		try{
			$store_name = $received_data->store_name;
			$address = $received_data->address;
			$business_hour = $received_data->business_hour;
			$phone = $received_data->phone;
			$url = $received_data->url;

			if($received_data->action == 'addStore'){
				if(checkStoreRepeat($store_name,$db) == true){
					echo "店名不得重複";
				}
				else{
					$query = "INSERT INTO store(store_name,address,business_hour,phone,URL) VALUES (?,?,?,?,?)";
					if($statement = $db->prepare($query)){
						$success = $statement->execute(array($store_name,$address,$business_hour,$phone,$url));
						if($success){
							echo "新增成功";
						}
						else{
							echo "新增失敗".$statement->errorInfo();
						}
					}
				}
			}
			else if($received_data->action == 'editStore'){
				$storeID = $received_data->store_ID;
				$query = "UPDATE store SET store_name=?,address=?,business_hour=?,phone=? WHERE store_ID=?";
				if($statement = $db->prepare($query)){
					$success = $statement->execute(array($store_name,$address,$business_hour,$phone,$storeID));
					if($success){
						echo "更改成功";
					}
					else{
						echo "更改失敗".$statement->errorInfo();
					}
				}	
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}
	if($received_data->action == 'deleteFood'){
		try{
			$food_ID = $received_data->food_ID;
			$query = "DELETE FROM food WHERE food_ID=?";
			if($statement = $db->prepare($query)){
				$success = $statement->execute(array($food_ID));
				if($success) {
					echo "刪除成功";
				}
				else{
					echo json_encode($statement->errorInfo(),JSON_UNESCAPED_UNICODE);
				}
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}

	if($received_data->action == 'addFood' || $received_data->action == 'editFood'){
		try{
			$food_name = $received_data->food_name;
			$price = $received_data->price;
			$store_name = $received_data->store_name;

			if($received_data->action == 'addFood'){
				$query = "SELECT food_name FROM food WHERE store_name=?";
				if($statement = $db->prepare($query)){
					$statement->execute(array($store_name));
					
					while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
						$data[] = $row['food_name'];
					}
					if (in_array($food_name, $data)) {
						echo "此食物已存在於此店家";
					}
					else{
						$query = "INSERT INTO food(food_name,price,store_name) VALUES (?,?,?)";
						if($statement = $db->prepare($query)){
							$success = $statement->execute(array($food_name,$price,$store_name));
							if($success){
								echo "新增成功";
							}
							else{
								echo "新增失敗".$statement->errorInfo();
							}
						}
					}
				}
			}
			else if($received_data->action == 'editFood'){
				$food_ID = $received_data->food_ID;
				$query = "UPDATE food SET food_name=?,price=?,store_name=? WHERE food_ID =?";
				if($statement = $db->prepare($query)){
					$success = $statement->execute(array($food_name,$price,$store_name,$food_ID));
					if($success){
						echo "更改成功";
					}
					else{
						echo "更改失敗".$statement->errorInfo();
					}
				}
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}

	if($received_data->action == 'search'){
		try{
			if($received_data->keyword != ''){
				$keyword = $received_data->keyword;
				$keyword = '%'.$keyword.'%';
	
				if($received_data->name){
					$storeName = $received_data->name;
					$query = "SELECT * FROM food WHERE store_name = ? AND food_name LIKE ?";
	
					if($statement = $db->prepare($query)){
						$statement->execute(array($storeName,$keyword));
						while ($row = $statement->fetch(PDO::FETCH_ASSOC))
						{
							$data[] = $row;
						}
						echo json_encode($data, JSON_UNESCAPED_UNICODE);
					}
				}
				else{
					if($received_data->ui == 'food'){
						$query = "SELECT * FROM food WHERE food_name LIKE ? OR store_name LIKE ?";
						if($statement = $db->prepare($query)){
							$statement->execute(array($keyword,$keyword));
							while ($row = $statement->fetch(PDO::FETCH_ASSOC))
							{
								$data[] = $row;
							}
							echo json_encode($data, JSON_UNESCAPED_UNICODE);
						}
					}
					else if($received_data->ui == 'order_list'){
						$query = "SELECT * FROM order_list LEFT OUTER JOIN food USING(food_ID) WHERE food_name LIKE ? OR cus_name LIKE ? OR store_name LIKE ?";
						if($statement = $db->prepare($query)){
							$statement->execute(array($keyword,$keyword,$keyword));
							while ($row = $statement->fetch(PDO::FETCH_ASSOC))
							{
								$data[] = $row;
							}
							echo json_encode($data, JSON_UNESCAPED_UNICODE);
						}
					}
					else if($received_data->ui == 'store'){
						$query = "SELECT * FROM store WHERE store_name LIKE ?";
						if($statement = $db->prepare($query)){
							$statement->execute(array($keyword));
							while ($row = $statement->fetch(PDO::FETCH_ASSOC))
							{
								$data[] = $row;
							}
							echo json_encode($data, JSON_UNESCAPED_UNICODE);
						}
					}
				
				}
			}
			else{
				if($received_data->name){
					$storeName = $received_data->name;
					$query = "SELECT * FROM food WHERE store_name = ?";
	
					if($statement = $db->prepare($query)){
						$statement->execute(array($storeName));
						while ($row = $statement->fetch(PDO::FETCH_ASSOC))
						{
							$data[] = $row;
						}
						echo json_encode($data, JSON_UNESCAPED_UNICODE);
					}
				}
				else{
					if($received_data->ui == 'food'){
						$query = "SELECT * FROM food";
					}
					else if($received_data->ui == 'order_list'){
						$query = "SELECT * FROM order_list LEFT OUTER JOIN food USING(food_ID)";
					}
					else if($received_data->ui == 'store'){
						$query = "SELECT * FROM store";
					}
	
					if($statement = $db->prepare($query)){
						$statement->execute();
						while ($row = $statement->fetch(PDO::FETCH_ASSOC))
						{
							$data[] = $row;
						}
						echo json_encode($data, JSON_UNESCAPED_UNICODE);
					}
				}
			}
		}catch(PDOException $e){
			Print "ERROR!:" . $e->getMessage();
			die();
		}
	}
?>