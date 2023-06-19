<?php

class Database{
	
	protected $conn;
	private $error;
	
	
	// declare construction
	
	public function __construct(){
		
		// create new pdo:

		$options	=	[
			PDO::ATTR_DEFAULT_FETCH_MODE 	=> PDO::FETCH_OBJ
		];
		
		try{
			
			//$this->conn	=	new PDO("sqlsrv:Server=DESKTOP-0MP0E3S\SQLSVR2008;Database=ad", "", "", $options);
			$this->conn	=	new PDO("mysql:host=localhost;dbname=e_equipment", 'root', '', $options);
			
			
		}catch(PDOException $e){
			
			$this->error = $e->getMessage();
		}
		
	}
	


	public function get_all_data($table, $wheres = [], $columns = [],  $order = null, $order_by = null) {

		$table_columns 	=	(isset($columns) && !empty($columns) ? implode(",", $columns) : "*");
		$sql 			= "SELECT $table_columns FROM $table";

		if(isset($wheres) && !empty($wheres)){
			$conditionSets = array();
			foreach ($wheres as $key => $value) {
				$conditionSets[] = $key . " = '" . $value . "'";
			}

			$sql .= " WHERE " . join(" AND ", $conditionSets);
		}

		if(isset($order_by) && !empty($order_by)){
			$sql .= " ORDER BY $order_by $order";
		}

		$stmt 			= $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	
	public function get_data($table, $wheres = [], $columns = []) {

		$table_columns 	=	(isset($columns) && !empty($columns) ? implode(",", $columns) : "*");
		$sql 			= "SELECT $table_columns FROM $table";

		if(isset($wheres) && !empty($wheres)){

			$conditionSets = array();

			foreach ($wheres as $key => $value) {
				$conditionSets[] = $key . " = '" . $value . "'";
			}

			$sql .= " WHERE " . join(" AND ", $conditionSets);
		}

		$stmt 			= $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetch();
	}


	public function store_data($table, $data){

		$fields = implode(',', array_keys($data));
		$values = "'" . implode("', '", array_values($data)) . "'";
		$sql = "INSERT INTO $table ($fields) VALUES ($values)";

		try{

			$this->conn->exec($sql);

			$status		= "success"; 	
			$message	= "Data have been successfully inserted"; 	
			$insert_id	= $this->conn->lastInsertId();
			$error 		= "";

		}catch(PDOException $e){

			$status		= "error"; 	
			$message	= "Failed to insert data";
			$insert_id	= "";
			$error		= $sql . "<br>" . $e->getMessage();

		}

		$response 	=	(object)[
			'status'	=>	$status,
			'message'	=>	$message,
			'insert_id'	=>	$insert_id,
			'error'		=>	$error,
		];

		return $response;

	}



	public function update_data($table, $dataParam, $where) {
		$valueSets = array();

		foreach ($dataParam as $key => $value) {
			$valueSets[] = $key . " = '" . $value . "'";
		}
	
		$conditionSets = array();

		foreach ($where as $key => $value) {
			$conditionSets[] = $key . " = '" . $value . "'";
		}

		$sql = "UPDATE $table SET " . join(",", $valueSets) . " WHERE " . join(" AND ", $conditionSets);

		try{


			$stmt	=	$this->conn->prepare($sql);
			$stmt->execute();			

			$status			= "success"; 	
			$message		= "Data have been successfully Updated"; 	
			$no_updated_row	= $stmt->rowCount();
			$error 		= "";

		}catch(PDOException $e){

			$status			= "error"; 	
			$message		= "Failed to insert data";
			$no_updated_row	= "";
			$error			= $sql . "<br>" . $e->getMessage();

		}

		$response 	=	(object)[
			'status'		=>	$status,
			'message'		=>	$message,
			'no_updated_row'=>	$no_updated_row,
			'error'			=>	$error,
		];

		return $response;

	}
	
	public function delete_data($table, $where) {

		$conditionSets = array();
		foreach ($where as $key => $value) {
			$conditionSets[] = $key . " = '" . $value . "'";
		}
		$sql = "DELETE FROM $table WHERE " . join(" AND ", $conditionSets);

		try {

			$this->conn->exec($sql);

			$status			= "success"; 	
			$message		= "Data have been successfully deleted";
			$error			= "";

		}catch(PDOException $e){

			$status			= "error"; 	
			$message		= "Failed to delete data";
			$error			= $sql . "<br>" . $e->getMessage();

		}

		$response 	=	(object)[
			'status'		=>	$status,
			'message'		=>	$message,
			'error'			=>	$error,
		];

		return $response;
	}


	public function delete_all_data($table) {

		$sql = "DELETE FROM $table";

		try {

			$this->conn->exec($sql);

			$status			= "success"; 	
			$message		= "Data have been successfully deleted";
			$error			= "";

		}catch(PDOException $e){

			$status			= "error"; 	
			$message		= "Failed to delete data";
			$error			= $sql . "<br>" . $e->getMessage();

		}

		$response 	=	(object)[
			'status'		=>	$status,
			'message'		=>	$message,
			'error'			=>	$error,
		];

		return $response;
	}

	public function get_table_total_row_count($table, $wheres = []){
		$sql = "SELECT COUNT(id) as total_row FROM $table";

		if(isset($wheres) && !empty($wheres)){

			$conditionSets = array();

			foreach ($wheres as $key => $value) {
				$conditionSets[] = $key . " = '" . $value . "'";
			}

			$sql .= " WHERE " . join(" AND ", $conditionSets);
		} 


		$stmt 			= 	$this->conn->prepare($sql);
		$stmt->execute();
		$number_of_rows = $stmt->fetchColumn(); 
		return $number_of_rows;
	}


	public function get_search_data($table_name, $search_column, $search_value)
	{
		$search = "%$search_value%";
		$stmt  = $this->conn->prepare("SELECT * FROM $table_name WHERE $search_column LIKE ?");

		$stmt->execute([$search]);
		$data = $stmt->fetchAll();

		return $data;
	}

	
}


 ?>