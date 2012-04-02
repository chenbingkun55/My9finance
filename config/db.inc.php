<?PHP
	
class DBSQL{
	private $CONN="";
	
/*------------------------------------------------------------------------------------------*/
	public function _construct()
	{	
		try{
			$conn = mysql_connect(ServerName,UserName,PassWord);
			mysql_query("SET CHARACTER utf8",$conn);
			mysql_query("SET NAMES utf8",$conn);
			//mysql_query("SET COLLATION_CONNECTION utf8_general_ci",$conn);
			//mysql_query("SET COLLATION_DATABASE utf8_general_ci",$conn);
		}catch(Exception $e)
		{
			$msg = $e;
			include(ERRORFILE);
		}
		try{
			mysql_select_db(DBName,$conn);
		}catch(Exception $e)
		{
			$msg = $e;
			include(ERRORFILE);
		}
		$this->CONN = $conn;
		}

/*------------------------------------------------------------------------------------------*/
		public function select($sql = "")
		{
			if(empty($sql)) return false;
			if(empty($this->CONN)) return false;
			try{
				$results = mysql_query($sql,$this->CONN);
			}catch (Exception $e){
				@mysql_free_result($results);
				return false;
			}

			$count = 0;
			$data = array();

			while ($row = @mysql_fetch_array($results))
			{
				$data[$count] = $row;
				$count++;
			}
			@mysql_free_result($results);

			return $data;
		}

/*------------------------------------------------------------------------------------------*/

	public function insert($sql = "" )
	{
		if(empty($sql)) return false;
		if(empty($this->CONN)) return false;
		try{
			$results = mysql_query($sql,$this->CONN);
		}catch(Exception $e){
			$msg = $e;
			include(ERRORFILE);
		}
		if (!$results)
		{
			return false;
		}else{
			return @mysql_insert_id($this->CONN);
		}
	}


/*------------------------------------------------------------------------------------------*/

	public function update($sql = "" )
	{
		if(empty($sql)) return false;
		if(empty($this->CONN)) return false;
		try{
			$results = mysql_query($sql,$this->CONN);
		}catch(Exception $e){
			$msg = $e;
			include(ERRORFILE);
		}
		if (!$results)
		{
			return false;
		} else {
			return @mysql_affected_rows($this->CONN);
		}
	}


/*------------------------------------------------------------------------------------------*/

	public function delete($sql = "" )
	{
		if(empty($sql)) return false;
		if(empty($this->CONN)) return false;
		try{
			$results = mysql_query($sql,$this->CONN);
		}catch(Exception $e){
			$msg = $e;
			include(ERRORFILE);
		}
		if (!$results)
		{
			return false;
		} else {
			return @mysql_affected_rows($this->CONN);
		}
	}


/*------------------------------------------------------------------------------------------*/

	public function begintransaction()
	{
		mysql_query("SET AUTOCOMMIT=0");
		mysql_query("BEGIN");
	}

/*------------------------------------------------------------------------------------------*/

	public function rollback()
	{
		mysql_query("ROOLBACK");
	}

/*------------------------------------------------------------------------------------------*/

	public function commit()
	{
		mysql_query("COMMIT");
	}
}

?>
