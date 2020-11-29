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
		$condition = "";
		if(isset($_GET['store_name'])){
			$condition = "store_name=".$_GET['store_name'];
		}
		$query = "SELECT * FROM food WHERE ".$condition;
		$statement = $db->prepare($query);
		$statement->execute();
		while ($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			$data[] = $row;
		}
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}	
?>