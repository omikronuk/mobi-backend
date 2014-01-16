<?php


/**
 * @author Kwaku Antwi
 *
 *
 */

class Db{
	//TODO - Insert your code here
  var $username = DB_USERNAME; 
  var $password = DB_PASSWORD; 
  var $server = DB_HOST; 
  var $port = "3306"; 
  var $databasename = DB_DATABASE; 
  private $result;
  
  var $connection; 
	
	function __construct() {
		    $this->connection = mysqli_connect( 
                       $this->server,  
                       $this->username,  
                       $this->password, 
                       $this->databasename, 
                       $this->port 
                       ); 
    
    $this->throwExceptionOnError($this->connection); 
	
	}

	/**
	 *
	 */
	function __destruct() {

		//TODO - Insert your code here
	}
	
	
		########### DataBase CLASS
 public function dbConn(){
		global $data;
		$data['cid'] = @mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
		if(!$data['cid']){
			echo(
				'<font style="font:10px Verdana;color:#FF0000">'.mysql_error().
				".<br>Please contact to site administrator".
				"</a>.</font>"
			);
			exit;
		}
		@mysql_select_db(DB_DATABASE, $data['cid']);
		return (bool)$data['cid'];
	}
	
	function dbDisconnect(){
		global $data;
		return (bool)@mysql_close($data['cid']);
	}
	
	function dbQuery($statement,$print=false){
		global $data;
		if($print) echo("-->{$statement}<--<br>");
		return @mysql_query($statement, $data['cid']);
	}
	
	function newId(){
		global $data;
		return @mysql_insert_id($data['cid']);
	}
	
	function dbCount($result){
		return (int)@mysql_num_rows($result);
	}
	
	function dbRows($statement,$print=false) {
		$result = array();
		if($print) echo("-->{$statement}<--<br>");
		$query = DB::dbQuery($statement);
		$count= DB::dbCount($query);
		for($i=0; $i<$count; $i++){
			$record = @mysql_fetch_array($query, MYSQL_ASSOC);
			foreach($record as $key => $value) $result[$i][$key] = $value;
		}
		return $result;
	}
		
	
	function dbCountRows($table, $field='*', $where='') {
		
		if($where)$where = ' WHERE '.$where;
		$rs = DB::dbRows('SELECT COUNT('.$field.') AS `count` FROM '.$table.$where);
		
		
	
		return $rs[0]['count'];
	}
	
	function dbSum($field, $table, $where='') {
		
		if($where)$where = ' WHERE '.$where;
		$rs = DB::dbRows( 'SELECT SUM(`'.$field.'`) AS `summ` FROM '.$table.$where);
			
		$summ = (double)$rs[0]['summ'];
	
		return $summ;
	}


	// run SQL query
	
	public function query($query){
	
		if(!$this->result=mysql_query($query)){
		
			throw new Exception('Error performing query '.
				eventNotice('Oops! There is an error in your query, you may need to fill in all required fields to proceed'.$query, 'error'));
		
		}
	
	}

	
	// fetch one row
	
	public function fetchRow(){
	
		while($row=mysql_fetch_array($this->result)){
		
			return $row;
			
		}
		
		return false;
		
	}

	// fetch all rows
	
	public function fetchAll($table, $orderBy='', $print=false){
	  
	   if($orderBy) $orderBy = ' ORDER BY '.trim($orderBy);
		$rows = DB::dbRows('SELECT * FROM '.$table.$orderBy, $print);
		
		return $rows;
	
	}


public function fetchAllWhere($table='', $where='', $orderBy='', $limit=''){
	 if($where)$where = ' WHERE '.$where;
	 if($orderBy) $orderBy = ' ORDER BY '.$orderBy;
	 if($limit) $limit = ' LIMIT '. $limit;
	 $rows = DB::dbRows('SELECT * FROM '.$table.$where.$orderBy.$limit );

	
	return $rows;

}

function getSpecificRecordFields($field, $table, $where='', $orderBy='') {
		 if($orderBy) $orderBy = ' ORDER BY '.trim($orderBy);
		if($where)$where = ' WHERE '.$where;
		$rows = DB::dbRows( 'SELECT '.$field.' FROM '.$table.$where.$orderBy);
		
		return $rows;
	}


// insert row

public function insert($params=array(),$table='default_table'){
	//$params = cleanOut($params);
	
	$sql="INSERT INTO ".$table." (".implode(',',array_keys($params)).") VALUES ('".implode("','",array_values($params))."')";
	
	DB::dbQuery($sql);

}

public function insertMetaData($params=array(),$table, $foreignKey){
		$params = cleanOut($params); // escape all 
		$createdOn = date('Y-m-d h:m:s');
		$splitGui = explode('=', $foreignKey);
		$count = count($params);	//count no. of items in the array
		$qryKeys   = array_keys($params); // get the array keys of the currency list
		$qryValues = array_values($params) ; // get the array values of the currency list
		
		// Break down the array collection and create new arrays from the master collection by looping through
		for ($i=0; $i < $count; $i++ ){
			 $key = $qryKeys[$i] ;
			 $val = $qryValues[$i] ;
			 
			 // create a new array collection
			 $newMetaData = array($splitGui[0]=>$splitGui[1], 'meta_key'=>$key, 'meta_value'=>$val, 'created_on'=>$createdOn);
		  DB::insert($newMetaData, $table);  
		}	
	
}


// Update Records

public function updatePost($params=array(), $table='default_table', $where){
	    $params = cleanOut($params); // escape all 
		if($where)$where = ' WHERE '.$where;
		$qryValues = array_values($params) ; // get the array values of the currency list
		$qryKeys   = array_keys($params); // get the array keys of the currency list
		
		$sum = count($params);
		
		$sql = "UPDATE ".$table." SET ";
		
			   // Loop through the Post array
				for( $i=0; $i < count($params); $i++ ){
			    	 $col = $qryKeys[$i] ;
					 $val = $qryValues[$i] ;
					$sql .= "`$col` = '$val', ";
					if($sum - $i == 1)$sql .= "`$col` = '$val' ";		
				}
			
		$sql .= $where ;	
	
	
	DB::dbQuery($sql);

	return mysql_affected_rows();
}

/* Update  Single Records */

function dbUpdateSingle($table='', $set, $where){
	if($where)$where = ' WHERE '.$where;
	DB::dbQuery("UPDATE ".$table." SET ".$set.$where);
	
	return true;

}



/* Delete records from the specified table */


	
function dbDelete($table='', $where=''){
	
	 if($where)$where = ' WHERE '.$where;
	 $rows = DB::dbQuery('DELETE FROM '.$table.$where );	
	 
	 return true;
	
}


function dbBulkDelete($table=''){
	$checkbox = $_POST['checkbox'];
	$count = count($checkbox);
	
	 for ($i=0;$i<=$count;$i++){
		$rs = DB::dbQuery('DELETE FROM '.$table.' WHERE `id` = '.mysql_real_escape_string($checkbox[$i]));	
	 }
	
	 
	 return true;
	
}


/** 
  * Utitity function to throw an exception if an error occurs 
  * while running a mysql command. 
  */ 
  private function throwExceptionOnError($link = null) { 
    if($link == null) { 
      $link = $this->connection; 
    } 
    if(mysqli_error($link)) { 
      $msg = mysqli_errno($link) . ": " . mysqli_error($link); 
      throw new Exception('MySQL Error - '. $msg); 
    }         
  } 
 
}
	
?>