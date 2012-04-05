<<<<<<< HEAD
<?PHP
	require_once(INCLUDE_PATH.'db.inc.php');
	require_once(INCLUDE_PATH.'language_CN.php');

	class Finance extends DBSQL
	{
		/* 定义表名称变量*/
		public $_in_corde = 'in_corde';
		public $_out_corde = 'out_corde';
		public $_in_mantype = 'in_mantype';
		public $_in_subtype = 'in_subtype';
		public $_out_mantype = 'out_mantype';
		public $_out_subtype = 'out_subtype';
		public $_users = 'users';
		public $_groups = 'groups';
		public $_user_group = 'user_group';
		public $_log_resolve = 'log_resolve';
		public $_address = 'address';

		public $_pagesize = 10;
		public $_is_display = array("0"=>"禁用",
			"1"=>"启用");

		/*  连接数据库函数 */
		public function _construct()
		{
			parent::_construct();
		}
		
		/*  获取用户列表函数 */
		public function getUserList()
		{
			$sql = "SELECT * FROM ".$this->_users;
			return $this->select($sql);
		}

		  /*取得当前用户会话函数*/
		public function getUserSession($user_id)
		{
			$sql = "SELECT session FROM ".$this->_users." WHERE id = '".$user_id."'";
			$result = $this->select($sql);
			foreach( $result as $key => $value)
			{
				return $value[0];
			}
		}



		  /* 转换用户ID为用户名函数*/
		public function convertUserID($user_id)
		{
			$sql = "SELECT username FROM ".$this->_users." WHERE id = '".$user_id."'";
			$result =  $this->select($sql);
			foreach( $result as $key => $value)
			{
				return $value[0];
			}
		}

		/* 转换用户ID为用户别名函数*/
		public function convertUserAliasID($user_id)
		{
			$sql = "SELECT user_alias FROM ".$this->_users." WHERE id = '".$user_id."'";
			$result =  $this->select($sql);
			foreach( $result as $key => $value)
			{
				return $value[0];
			}
		}


		/* 提取用户ID数据函数*/
		public function drawUserID($user_id)
		{
			$sql = "SELECT * FROM ".$this->_users." WHERE id = '".$user_id."'";
			return  $this->select($sql);
		}


		/*  添加用户函数 */
		public function insertUser($user_name,$user_alias,$user_password,$notes)
		{
			$sql = "INSERT INTO ".$this->_users." (id,username,user_alias,password,notes,create_date)   VALUES  ('','".$user_name."','".$user_alias."','".$user_password."','".$notes."','".date("Y-m-d H:i:s")."')";
			return $this->insert($sql);
		}

		/*更新用户函数 */
		public function updateUser($user_name,$user_alias,$user_password,$notes)
		{
			if  ( $_SESSION['__useralive'][0] == 1 )
			{
					$sql = "UPDATE ".$this->_users." SET username = '".$user_name."',user_alias = '".$user_alias."', password = '".$user_password."' ,notes = '".$notes."'  WHERE id = '".$_SESSION['__gettype_id']."'";
			} else {
					$sql = "UPDATE ".$this->_users." SET username = '".$user_name."',user_alias = '".$user_alias."', password = '".$user_password."' ,notes = '".$notes."'  WHERE id = '".$_SESSION['__useralive'][0]."'";
			}
			return $this->update($sql);
		}

		/*删除用户函数 */
		public function deleteUser($user_id)
		{
			if ($_SESSION['__useralive'][0] == 1 )
			{
					$sql = "DELETE FROM ".$this->_users." WHERE id = '".$user_id."'";
					return $this->delete($sql);
			} else {
					return false;
			}
		}



		 /*更新用户会话ID与最后登录时间函数 */
		public function refurbishUserSession($user_id)
		{
			$sql = "UPDATE users SET last_date = '".date("Y-m-d H:i:s")."' , session = '".session_id()."' WHERE id = '".$user_id."'";
			return $this->update($sql);
		}



		 /* 用户登录验证函数 */
		public function login($username,$password)
		{
				$sql = "SELECT id,user_alias FROM ".$this->_users." WHERE username = '".$username."' AND password = '".$password."'";
			 if( $this->select($sql))
			{
						$result =  $this->select($sql);
						foreach( $result as $key => $value)
						{
							return $value;
						}
			 } else {				
				$sql = "SELECT count(*) FROM ".$this->_users." WHERE username = '".$username."'";
						 if( $this->select($sql)) 
						 {
							return "useralive";
						 } else {
							return "userrnalive";
						 }
			}
	}
	
		/* 获取组列表 */
		public function getGroupList()
		{
			$sql = "SELECT * FROM ".$this->_groups;
			return $this->select($sql);
		}


		/*更新组函数 */
		public function updateGroup($group_name,$group_alias,$group_password,$notes)
		{
			$sql = "UPDATE ".$this->_groups." SET groupname = '".$group_name."',group_alias = '".$group_alias."', password = '".$group_password."' ,notes = '".$notes."'  WHERE id = '".$_SESSION['__gettype_id']."'";
			return $this->update($sql);
		}


		/* 提取组ID数据函数*/
		public function getGroupAdmin($user_id)
		{
			$sql = "SELECT * FROM ".$this->_groups." WHERE id = '".$group_id."' AND groupadmin_id = '".$_SESSION['__useralive'][0]."'";
			return  $this->select($sql);
		}


		/*  添加组函数 */
		public function insertGroup($group_name,$group_alias,$group_password,$notes)
		{
			$sql = "INSERT INTO ".$this->_groups." (id,groupname,group_alias,groupadmin_id,password,notes,create_date)   VALUES  ('','".$group_name."','".$group_alias."','".$_SESSION['__useralive'][0]."','".$group_password."','".$notes."','".date("Y-m-d H:i:s")."')";
			return $this->insert($sql);
		}


		/*删除组函数 */
		public function deleteGroup($group_id)
		{
			if ($_SESSION['__useralive'][0] == 1 )
			{
					$sql = "DELETE FROM ".$this->_groups." WHERE id = '".$group_id."'";
					return $this->delete($sql);
			} else {
					return false;
			}
		}

		/*　获取用户所属于的组ID　*/
		public function getUserResideGroup()
		{
			$sql = "SELECT group_id FROM ".$this->_user_group." WHERE user_id = '".$_SESSION['__useralive'][0]."'";
			
			$result = $this->select($sql);
			foreach( $result as $key => $value)
			{
				return $value[0];
			}
		}

		/* 转换组ID为组别名函数*/
		public function convertGroupAliasID($group_id)
		{
			$sql = "SELECT groupname,group_alias FROM ".$this->_groups." WHERE id = '".$group_id."'";
			$result =  $this->select($sql);
			foreach( $result as $key => $value)
			{
				return $value;
			}
		}


		/* 判断用户是否有权限更改组函数*/
		public function drawGroupID($group_id)
		{
			$sql = "SELECT * FROM ".$this->_groups." WHERE id = '".$group_id."'";
			return  $this->select($sql);
		}




		/*  列出收入与支出的分类函数*/
		public function getInOutType($in_out_type)
		{
			$sql = "SELECT * FROM  ".$this->$in_out_type."  WHERE  user_id = '".$_SESSION['__useralive'][0]."' order by store";
			return $this->select($sql);
		}


		/*写入收入主类函数 */
		public function insertInManType($user_id,$store,$is_display,$addmantypename)
		{
			$sql = "INSERT INTO   ".$this->_in_mantype . "  VALUES ('','".$user_id."','".$store."','".$is_display."','".$addmantypename."','".date("Y-m-d H:i:s")."')";
			return $this->insert($sql);
		}


		/*更新主类函数 */
		public function updateManType($in_out_type,$is_display,$altermantypename,$mantype_id)
		{
			$sql = "UPDATE ".$this->$in_out_type." SET name = '".$altermantypename."',is_display = '".$is_display."' WHERE id = '".$mantype_id."' AND user_id = '". $_SESSION['__useralive'][0]."'";
			return $this->update($sql);
		}


		/*删除主类函数 */
		public function deleteManType($in_out_type,$mantype_id)
		{
			$sql = "DELETE FROM ".$this->$in_out_type." where id = '".$mantype_id."' AND user_id = '".$_SESSION['__useralive'][0]."'";
			return $this->delete($sql);
		}




		  /* 列出支出主类函数  */
		public function getOutType()
		{
			$sql = "SELECT * FROM  ".$this->_out_mantype;
			return $this->select($sql);
		}

		public  function  getManTypeList($typelist)
		{
			$sql = "SELECT id,name FROM  ".$this->$typelist." WHERE user_id = '".$_SESSION['__useralive'][0]."' AND is_display = '1' order by store";
			return $this->select($sql);
		}

		public  function  getSubTypeList($typelist)
		{
			$sql = "SELECT id,man_id,name FROM  ".$this->$typelist." WHERE user_id = '".$_SESSION['__useralive'][0]."' AND is_display = '1' order by man_id,store";
			return $this->select($sql);
		}

		  /*写入支出主类函数 */
		public function insertOutManType($user_id,$store,$is_display,$addmantypename)
		{
			$sql = "INSERT INTO   ".$this->_out_mantype . "  VALUES ('','".$user_id."','".$store."','".$is_display."','".$addmantypename."','".date("Y-m-d H:i:s")."')";
			return $this->insert($sql);
		}


		/*  把数据写入收入支出表函数 */
		public function insertInOutRecord($in_out_corde,$money,$mantype_id,$subtype_id,$address_id,$notes)
		{
			$sql = "INSERT INTO ".$this->$in_out_corde ."  VALUES ('','".$money."','".$_SESSION['__useralive'][0]."','".$_SESSION['__group_id']."','".$mantype_id."','".$subtype_id."','".$address_id."','".$notes."','".date("Y-m-d H:i:s")."')";
			return $this->insert($sql);
		}


		/*更新支出记录函数 */
		public function 	updateOutCorde($id,$money,$mantype_id,$subtype_id,$address_id,$notes)
		{
			$sql = "UPDATE ".$this->_out_corde." SET money = '".$money."',out_mantype_id = '".$mantype_id."',out_subtype_id = '".$subtype_id."',addr_id = '".$address_id."', notes = '".$notes."'  WHERE id = '".$id."' AND user_id = '". $_SESSION['__useralive'][0]."'";
			return $this->update($sql);
		}

		/*更新收入记录函数 */
		public function 	updateInCorde($id,$money,$mantype_id,$subtype_id,$address_id,$notes)
		{
			$sql = "UPDATE ".$this->_in_corde." SET money = '".$money."',in_mantype_id = '".$mantype_id."',in_subtype_id = '".$subtype_id."',addr_id = '".$address_id."', notes = '".$notes."'  WHERE id = '".$id."' AND user_id = '". $_SESSION['__useralive'][0]."'";
			return $this->update($sql);
		}



		/*删除收入支出记录函数 */
		public function deleteInOutCorde($in_out_corde,$corde_id)
		{
			$sql = "DELETE FROM ".$this->$in_out_corde." where id = '".$corde_id."' AND user_id = '".$_SESSION['__useralive'][0]."'";
			return $this->delete($sql);
		}





		  /* 把传过来的类ID转换为名称函数  */
		public function convertIdToNmae($in_out_type,$type_id)
		{
			$sql = "SELECT name FROM  ".$this->$in_out_type."  WHERE  id = ".$type_id;
			$result = $this->select($sql);
			foreach($result as $key => $value )
			{
				$value_done = $value[0] ;
			}
				return $value_done;
		} 

		/*  把数据写入主类表函数*/
		public function insertManType($typetable,$store,$is_display,$name)
		{
			$sql = "INSERT INTO ".$this->$typetable."  VALUES ('','".$store."','".$is_display."','".$name."')";
			
			return $this->insert($sql);
		}


		/* 把数据写入子类表函数 */
		public function insertSubType($typetable,$man_id,$store,$is_display,$name)
		{
			$sql = "INSERT INTO ".$this->$typetable." values ('','".$_SESSION['__useralive'][0]."','".$man_id."','".$store."','".$is_display."','".$name."','".date("Y-m-d H:i:s")."')";
			
			return $this->insert($sql);
		}


		/*更新子类函数 */
		public function updateSubType($in_out_type,$subtype_id,$is_display,$altersubtypename)
		{
			$sql = "UPDATE ".$this->$in_out_type." SET name = '".$altersubtypename."',is_display = '".$is_display."' WHERE id = '".$subtype_id."' AND user_id = '". $_SESSION['__useralive'][0]."'";
			return $this->update($sql);
		}


		/*删除子类函数 */
		public function deleteSubType($in_out_type,$subtype_id)
		{
			$sql = "DELETE FROM ".$this->$in_out_type." where id = '".$subtype_id."' AND user_id = '".$_SESSION['__useralive'][0]."'";
			return $this->delete($sql);
		}





	   /* 列出支出表函数 */
		public function listInOutCorde($in_out_corde)
		{
			if ( $_SESSION['__useralive'][0] == 1 )
			{
				$sql = "SELECT * FROM  ".$this->$in_out_corde." WHERE create_date like '".date("Y-m-d")."%'  ORDER BY  create_date desc";
			} else {
				$sql = "SELECT * FROM  ".$this->$in_out_corde." WHERE create_date like '".date("Y-m-d")."%' AND group_id = '".$_SESSION['__group_id']."'  ORDER BY  create_date desc";
			}
			return $this->select($sql);
		}



		 /* 列出子类函数  */
		public function getSubType($subtype,$mantype_id)
		{
			$sql = "SELECT * FROM  ".$this->$subtype." WHERE man_id = '".$mantype_id."' AND user_id = '".$_SESSION['__useralive'][0]."' order by store";
			return $this->select($sql);
		}



		/*  添加新日志解释函数 */
		public function insertLogResolve($log_id,$content)
		{
			$sql = "INSERT INTO ".$this->_log_resolve." values ('','".$log_id."','".$content."')";		
			return $this->insert($sql);
		}


		  /* 转换LOG_ID为日志内容函数 */
		public function convertLogIdToContent($log_id)
		{
			$sql = "SELECT content FROM  ".$this->_log_resolve." WHERE log_id = '".$log_id."'";		
			$result = $this->select($sql);
			foreach($result as $key => $value )
			{
				$value_done = $value[0];
			}
			return $value_done;
		}

		/*更新日志函数 */
		public function updateLog($id,$log_id,$content)
		{
			$sql = "UPDATE ".$this->_log_resolve." SET log_id = '".$log_id."',content = '".$content."' WHERE id = '".$id."'";
			return $this->update($sql);
		}


		/*删除日志函数 */
		public function deleteLog($id)
		{
			$sql = "DELETE FROM ".$this->_log_resolve." where id = '".$id."'";
			return $this->delete($sql);
		}




	   /* 列出日志内容函数 */
		public function getLogContentList()
		{
			$sql = "SELECT * FROM ".$this->_log_resolve." ORDER BY  log_id asc";		
			return $this->select($sql);
		}


	   /* 列出地址函数 */
		public function getAddress()
		{
			$sql = "SELECT * FROM ".$this->_address." WHERE user_id = '".$_SESSION['__useralive'][0]."'  order by store";		
			return $this->select($sql);
		}

		/*  列出要显示的地址函数*/
		public function getAddressDisplay()
		{
			$sql = "SELECT * FROM  ".$this->_address."  WHERE  user_id = '".$_SESSION['__useralive'][0]."' AND is_display = '1' order by store";
			return $this->select($sql);
		}

		/*  添加地址函数 */
		public function insertAddress($store,$is_display,$addr_name)
		{
			$sql = "INSERT INTO ".$this->_address."  VALUES ('','".$_SESSION['__useralive'][0]."','".$store."','".$is_display."','".$addr_name."','".date("Y-m-d H:i:s")."')";
			
			return $this->insert($sql);
		}

		/*更新地址函数 */
		public function updateAddress($address_id,$addr_name,$is_display)
		{
			$sql = "UPDATE ".$this->_address." SET name = '".$addr_name."',is_display = '".$is_display."' WHERE id = '".$address_id."' AND user_id = '".$_SESSION['__useralive'][0]."'";
			return $this->update($sql);
		}


		
		/*删除地址函数 */
		public function deleteAddress($address_id)
		{
			$sql = "DELETE FROM ".$this->_address." where id = '".$address_id."' AND user_id = '".$_SESSION['__useralive'][0]."'";
			return $this->delete($sql);
		}

		/*获取传过来的ID对应Store值函数 */
		public function getIsDisplay($table,$id)
		{
			$sql = "SELECT is_display FROM ".$this->$table." where id = '".$id."'";
			return $this->select($sql);
		}



		/*获得每月数据函数 */
		public function getReportOutMonth($month)
		{
			if($_SESSION['__useralive'][0] == 1 )
			{
				$sql = "SELECT * FROM ".$this->_out_corde." WHERE create_date like '".$month."%'";	
			} else {
				$sql = "SELECT * FROM ".$this->_out_corde." WHERE create_date like '".$month."%' AND group_id = '".$_SESSION['__group_id']."'";	
			}
			return $this->select($sql);
		}

		/*获得每月支出数据*/
		public function getReportOutMonthTotal($month)
		{
			if($_SESSION['__useralive'][0] == 1 )
			{
				$sql = "SELECT count(*),sum(money),user_id,group_id FROM ".$this->_out_corde." WHERE create_date like '".$month."%'  group by user_id";
			} else {
				$sql = "SELECT count(*),sum(money),user_id,group_id FROM ".$this->_out_corde." WHERE create_date like '".$month."%' AND group_id = '".$_SESSION['__group_id']."' group by user_id";
			}
			return $this->select($sql);
		}


		/*获得指定用户每月数据函数 */
		public function getReportPersonOutMonth($user_id,$month1)
		{
			$sql = "SELECT * FROM ".$this->_out_corde." WHERE user_id = '".$user_id."' AND create_date like '".$month1."%'";		
			return $this->select($sql);
		}




		 /* SELECT数字选择函数*/
		public function NumList()
		{
			$i = 0;
			echo "<select  name = \"numlist_1000\" >";
			while($i<10)
			{
				echo "<option value =".$i.">" . $i . "</option>";
				$i++;
			}
				echo "</select >";

			//===========================================================
			$i = 0;
			echo "<select  name = \"numlist_100\" >";
			while($i<10)
			{
				echo "<option value =".$i.">" . $i . "</option>";
				$i++;
			}
				echo "</select >";

			//===========================================================
			$i = 0;
			echo "<select  name = \"numlist_10\" >";
			while($i<10)
			{
				echo "<option value =".$i.">" . $i . "</option>";
				$i++;
			}
				echo "</select >";
			
			//===========================================================
			$i = 0;
			echo "<select  name = \"numlist_1\" >";
			while($i<10)
			{
				echo "<option value =".$i.">" . $i . "</option>";
				$i++;
			}
				echo "</select >";

			echo " . ";

		   	//===========================================================
			$i = 0;
			echo "<select  name = \"numlist_01\">";
			while($i<10)
			{
				echo "<option value =".$i.">" . $i . "</option>";
				$i++;
			}
				echo "</select >";

		   	//===========================================================
			$i = 0;			
			echo "<select  name = \"numlist_001\" >";
			while($i<10)
			{
				echo "<option value =".$i.">" . $i . "</option>";
				$i++;
			}
				echo "</select >";
		   }

		/*  往前主类排序函数 */
		public function TaxisManFront($table,$id)
		{
			$num = 0;
			
			if ($id != 1 )
			{
				$num = $id-1;
				$sql = "UPDATE ".$this->$table." SET store = '0' where store = '".$num."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$num."' where store = '".$id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$id."' where store = '0'";
				$this->update($sql);
			} else {
				return false;
			}
		}

		/*  往后主类排序函数 */
		public function TaxisManAfter($table,$id)
		{
			$num = 0;
			$sql = "select max(store) from ".$this->$table;
			$max = $this->select($sql);

			if ($id <= $max['0']['0'] )
			{
				$num = $id+1;
				$sql = "UPDATE ".$this->$table." SET store = '0' where store = '".$num."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$num."' where store = '".$id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$id."' where store = '0'";
				$this->update($sql);
			} else {
				return false;
			}
		}

		/*  往前子类排序函数 */
		public function TaxisSubFront($table,$man_id,$id)
		{
			$num = 0;
			
			if ($id != 1 )
			{
				$num = $id-1;
				$sql = "UPDATE ".$this->$table." SET store = '0' where store = '".$num."' AND man_id = '".$man_id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$num."' where store = '".$id."' AND man_id = '".$man_id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$id."' where store = '0' AND man_id = '".$man_id."'";
				$this->update($sql);
			} else {
				return false;
			}
		}

		/*  往后子类排序函数 */
		public function TaxisSubAfter($table,$man_id,$id)
		{
			$num = 0;
			$sql = "select max(store) from ".$this->$table;
			$max = $this->select($sql);

			if ($id <= $max['0']['0'] )
			{
				$num = $id+1;
				$sql = "UPDATE ".$this->$table." SET store = '0' where store = '".$num."' AND man_id = '".$man_id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$num."' where store = '".$id."' AND man_id = '".$man_id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$id."' where store = '0' AND man_id = '".$man_id."'";
				$this->update($sql);
			} else {
				return false;
			}
		}

		/*  往前地址排序函数 */
		public function TaxisAddrFront($table,$id)
		{
			$num = 0;
			
			if ($id != 1 )
			{
				$num = $id-1;
				$sql = "UPDATE ".$this->$table." SET store = '0' where store = '".$num."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$num."' where store = '".$id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$id."' where store = '0'";
				$this->update($sql);
			} else {
				return false;
			}
		}

		/*  往后地址排序函数 */
		public function TaxisAddrAfter($table,$id)
		{
			$num = 0;
			$sql = "select max(store) from ".$this->$table;
			$max = $this->select($sql);

			if ($id <= $max['0']['0'] )
			{
				$num = $id+1;
				$sql = "UPDATE ".$this->$table." SET store = '0' where store = '".$num."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$num."' where store = '".$id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$id."' where store = '0'";
				$this->update($sql);
			} else {
				return false;
			}
		}

		/*  获取主类最大排序号函数 */
		public function getMaxManStore($table)
		{
			$sql = "select max(store) from ".$this->$table;
			return $this->select($sql);
		}

		/*  获取子类最大排序号函数 */
		public function getMaxSubStore($table,$man_id)
		{
			$sql = "select max(store) from ".$this->$table." WHERE man_id = '".$man_id."'";
			return $this->select($sql);
		}

		/*  获取地址最大排序号函数 */
		public function getMaxAddrStore()
		{
			$sql = "select max(store) from address WHERE user_id = '".$_SESSION['__useralive'][0]."'";
			return $this->select($sql);
		}




	}

	/* 创建一个类变量 */
	$Finance = new Finance();

	/* 连接到数据库 */
	$Finance->_construct();



=======
<?PHP
	require_once(INCLUDE_PATH.'db.inc.php');
	require_once(INCLUDE_PATH.'language_CN.php');

	class Finance extends DBSQL
	{
		/* 定义表名称变量*/
		public $_in_corde = 'in_corde';
		public $_out_corde = 'out_corde';
		public $_in_mantype = 'in_mantype';
		public $_in_subtype = 'in_subtype';
		public $_out_mantype = 'out_mantype';
		public $_out_subtype = 'out_subtype';
		public $_users = 'users';
		public $_groups = 'groups';
		public $_user_group = 'user_group';
		public $_log_resolve = 'log_resolve';
		public $_address = 'address';

		public $_pagesize = 10;
		public $_is_display = array("0"=>"禁用",
			"1"=>"启用");

		/*  连接数据库函数 */
		public function _construct()
		{
			parent::_construct();
		}
		
		/*  获取用户列表函数 */
		public function getUserList()
		{
			$sql = "SELECT * FROM ".$this->_users;
			return $this->select($sql);
		}

		  /*取得当前用户会话函数*/
		public function getUserSession($user_id)
		{
			$sql = "SELECT session FROM ".$this->_users." WHERE id = '".$user_id."'";
			$result = $this->select($sql);
			foreach( $result as $key => $value)
			{
				return $value[0];
			}
		}



		  /* 转换用户ID为用户名函数*/
		public function convertUserID($user_id)
		{
			$sql = "SELECT username FROM ".$this->_users." WHERE id = '".$user_id."'";
			$result =  $this->select($sql);
			foreach( $result as $key => $value)
			{
				return $value[0];
			}
		}

		/* 转换用户ID为用户别名函数*/
		public function convertUserAliasID($user_id)
		{
			$sql = "SELECT user_alias FROM ".$this->_users." WHERE id = '".$user_id."'";
			$result =  $this->select($sql);
			foreach( $result as $key => $value)
			{
				return $value[0];
			}
		}


		/* 提取用户ID数据函数*/
		public function drawUserID($user_id)
		{
			$sql = "SELECT * FROM ".$this->_users." WHERE id = '".$user_id."'";
			return  $this->select($sql);
		}


		/*  添加用户函数 */
		public function insertUser($user_name,$user_alias,$user_password,$notes)
		{
			$sql = "INSERT INTO ".$this->_users." (id,username,user_alias,password,notes,create_date)   VALUES  ('','".$user_name."','".$user_alias."','".$user_password."','".$notes."','".date("Y-m-d H:i:s")."')";
			return $this->insert($sql);
		}

		/*更新用户函数 */
		public function updateUser($user_name,$user_alias,$user_password,$notes)
		{
			if  ( $_SESSION['__useralive'][0] == 1 )
			{
					$sql = "UPDATE ".$this->_users." SET username = '".$user_name."',user_alias = '".$user_alias."', password = '".$user_password."' ,notes = '".$notes."'  WHERE id = '".$_SESSION['__gettype_id']."'";
			} else {
					$sql = "UPDATE ".$this->_users." SET username = '".$user_name."',user_alias = '".$user_alias."', password = '".$user_password."' ,notes = '".$notes."'  WHERE id = '".$_SESSION['__useralive'][0]."'";
			}
			return $this->update($sql);
		}

		/*删除用户函数 */
		public function deleteUser($user_id)
		{
			if ($_SESSION['__useralive'][0] == 1 )
			{
					$sql = "DELETE FROM ".$this->_users." WHERE id = '".$user_id."'";
					return $this->delete($sql);
			} else {
					return false;
			}
		}



		 /*更新用户会话ID与最后登录时间函数 */
		public function refurbishUserSession($user_id)
		{
			$sql = "UPDATE users SET last_date = '".date("Y-m-d H:i:s")."' , session = '".session_id()."' WHERE id = '".$user_id."'";
			return $this->update($sql);
		}



		 /* 用户登录验证函数 */
		public function login($username,$password)
		{
				$sql = "SELECT id,user_alias FROM ".$this->_users." WHERE username = '".$username."' AND password = '".$password."'";
			 if( $this->select($sql))
			{
						$result =  $this->select($sql);
						foreach( $result as $key => $value)
						{
							return $value;
						}
			 } else {				
				$sql = "SELECT count(*) FROM ".$this->_users." WHERE username = '".$username."'";
						 if( $this->select($sql)) 
						 {
							return "useralive";
						 } else {
							return "userrnalive";
						 }
			}
	}
	
		/* 获取组列表 */
		public function getGroupList()
		{
			$sql = "SELECT * FROM ".$this->_groups;
			return $this->select($sql);
		}


		/*更新组函数 */
		public function updateGroup($group_name,$group_alias,$group_password,$notes)
		{
			$sql = "UPDATE ".$this->_groups." SET groupname = '".$group_name."',group_alias = '".$group_alias."', password = '".$group_password."' ,notes = '".$notes."'  WHERE id = '".$_SESSION['__gettype_id']."'";
			return $this->update($sql);
		}


		/* 提取组ID数据函数*/
		public function getGroupAdmin($user_id)
		{
			$sql = "SELECT * FROM ".$this->_groups." WHERE id = '".$group_id."' AND groupadmin_id = '".$_SESSION['__useralive'][0]."'";
			return  $this->select($sql);
		}


		/*  添加组函数 */
		public function insertGroup($group_name,$group_alias,$group_password,$notes)
		{
			$sql = "INSERT INTO ".$this->_groups." (id,groupname,group_alias,groupadmin_id,password,notes,create_date)   VALUES  ('','".$group_name."','".$group_alias."','".$_SESSION['__useralive'][0]."','".$group_password."','".$notes."','".date("Y-m-d H:i:s")."')";
			return $this->insert($sql);
		}


		/*删除组函数 */
		public function deleteGroup($group_id)
		{
			if ($_SESSION['__useralive'][0] == 1 )
			{
					$sql = "DELETE FROM ".$this->_groups." WHERE id = '".$group_id."'";
					return $this->delete($sql);
			} else {
					return false;
			}
		}

		/*　获取用户所属于的组ID　*/
		public function getUserResideGroup()
		{
			$sql = "SELECT group_id FROM ".$this->_user_group." WHERE user_id = '".$_SESSION['__useralive'][0]."'";
			
			$result = $this->select($sql);
			foreach( $result as $key => $value)
			{
				return $value[0];
			}
		}

		/* 转换组ID为组别名函数*/
		public function convertGroupAliasID($group_id)
		{
			$sql = "SELECT groupname,group_alias FROM ".$this->_groups." WHERE id = '".$group_id."'";
			$result =  $this->select($sql);
			foreach( $result as $key => $value)
			{
				return $value;
			}
		}


		/* 判断用户是否有权限更改组函数*/
		public function drawGroupID($group_id)
		{
			$sql = "SELECT * FROM ".$this->_groups." WHERE id = '".$group_id."'";
			return  $this->select($sql);
		}




		/*  列出收入与支出的分类函数*/
		public function getInOutType($in_out_type)
		{
			$sql = "SELECT * FROM  ".$this->$in_out_type."  WHERE  user_id = '".$_SESSION['__useralive'][0]."' order by store";
			return $this->select($sql);
		}


		/*写入收入主类函数 */
		public function insertInManType($user_id,$store,$is_display,$addmantypename)
		{
			$sql = "INSERT INTO   ".$this->_in_mantype . "  VALUES ('','".$user_id."','".$store."','".$is_display."','".$addmantypename."','".date("Y-m-d H:i:s")."')";
			return $this->insert($sql);
		}


		/*更新主类函数 */
		public function updateManType($in_out_type,$is_display,$altermantypename,$mantype_id)
		{
			$sql = "UPDATE ".$this->$in_out_type." SET name = '".$altermantypename."',is_display = '".$is_display."' WHERE id = '".$mantype_id."' AND user_id = '". $_SESSION['__useralive'][0]."'";
			return $this->update($sql);
		}


		/*删除主类函数 */
		public function deleteManType($in_out_type,$mantype_id)
		{
			$sql = "DELETE FROM ".$this->$in_out_type." where id = '".$mantype_id."' AND user_id = '".$_SESSION['__useralive'][0]."'";
			return $this->delete($sql);
		}




		  /* 列出支出主类函数  */
		public function getOutType()
		{
			$sql = "SELECT * FROM  ".$this->_out_mantype;
			return $this->select($sql);
		}

		public  function  getManTypeList($typelist)
		{
			$sql = "SELECT id,name FROM  ".$this->$typelist." WHERE user_id = '".$_SESSION['__useralive'][0]."' AND is_display = '1' order by store";
			return $this->select($sql);
		}

		public  function  getSubTypeList($typelist)
		{
			$sql = "SELECT id,man_id,name FROM  ".$this->$typelist." WHERE user_id = '".$_SESSION['__useralive'][0]."' AND is_display = '1' order by man_id,store";
			return $this->select($sql);
		}

		  /*写入支出主类函数 */
		public function insertOutManType($user_id,$store,$is_display,$addmantypename)
		{
			$sql = "INSERT INTO   ".$this->_out_mantype . "  VALUES ('','".$user_id."','".$store."','".$is_display."','".$addmantypename."','".date("Y-m-d H:i:s")."')";
			return $this->insert($sql);
		}


		/*  把数据写入收入支出表函数 */
		public function insertInOutRecord($in_out_corde,$money,$mantype_id,$subtype_id,$address_id,$notes)
		{
			$sql = "INSERT INTO ".$this->$in_out_corde ."  VALUES ('','".$money."','".$_SESSION['__useralive'][0]."','".$_SESSION['__group_id']."','".$mantype_id."','".$subtype_id."','".$address_id."','".$notes."','".date("Y-m-d H:i:s")."')";
			return $this->insert($sql);
		}


		/*更新支出记录函数 */
		public function 	updateOutCorde($id,$money,$mantype_id,$subtype_id,$address_id,$notes)
		{
			$sql = "UPDATE ".$this->_out_corde." SET money = '".$money."',out_mantype_id = '".$mantype_id."',out_subtype_id = '".$subtype_id."',addr_id = '".$address_id."', notes = '".$notes."'  WHERE id = '".$id."' AND user_id = '". $_SESSION['__useralive'][0]."'";
			return $this->update($sql);
		}

		/*更新收入记录函数 */
		public function 	updateInCorde($id,$money,$mantype_id,$subtype_id,$address_id,$notes)
		{
			$sql = "UPDATE ".$this->_in_corde." SET money = '".$money."',in_mantype_id = '".$mantype_id."',in_subtype_id = '".$subtype_id."',addr_id = '".$address_id."', notes = '".$notes."'  WHERE id = '".$id."' AND user_id = '". $_SESSION['__useralive'][0]."'";
			return $this->update($sql);
		}



		/*删除收入支出记录函数 */
		public function deleteInOutCorde($in_out_corde,$corde_id)
		{
			$sql = "DELETE FROM ".$this->$in_out_corde." where id = '".$corde_id."' AND user_id = '".$_SESSION['__useralive'][0]."'";
			return $this->delete($sql);
		}





		  /* 把传过来的类ID转换为名称函数  */
		public function convertIdToNmae($in_out_type,$type_id)
		{
			$sql = "SELECT name FROM  ".$this->$in_out_type."  WHERE  id = ".$type_id;
			$result = $this->select($sql);
			foreach($result as $key => $value )
			{
				$value_done = $value[0] ;
			}
				return $value_done;
		} 

		/*  把数据写入主类表函数*/
		public function insertManType($typetable,$store,$is_display,$name)
		{
			$sql = "INSERT INTO ".$this->$typetable."  VALUES ('','".$store."','".$is_display."','".$name."')";
			
			return $this->insert($sql);
		}


		/* 把数据写入子类表函数 */
		public function insertSubType($typetable,$man_id,$store,$is_display,$name)
		{
			$sql = "INSERT INTO ".$this->$typetable." values ('','".$_SESSION['__useralive'][0]."','".$man_id."','".$store."','".$is_display."','".$name."','".date("Y-m-d H:i:s")."')";
			
			return $this->insert($sql);
		}


		/*更新子类函数 */
		public function updateSubType($in_out_type,$subtype_id,$is_display,$altersubtypename)
		{
			$sql = "UPDATE ".$this->$in_out_type." SET name = '".$altersubtypename."',is_display = '".$is_display."' WHERE id = '".$subtype_id."' AND user_id = '". $_SESSION['__useralive'][0]."'";
			return $this->update($sql);
		}


		/*删除子类函数 */
		public function deleteSubType($in_out_type,$subtype_id)
		{
			$sql = "DELETE FROM ".$this->$in_out_type." where id = '".$subtype_id."' AND user_id = '".$_SESSION['__useralive'][0]."'";
			return $this->delete($sql);
		}





	   /* 列出支出表函数 */
		public function listInOutCorde($in_out_corde)
		{
			if ( $_SESSION['__useralive'][0] == 1 )
			{
				$sql = "SELECT * FROM  ".$this->$in_out_corde." WHERE create_date like '".date("Y-m-d")."%'  ORDER BY  create_date desc";
			} else {
				$sql = "SELECT * FROM  ".$this->$in_out_corde." WHERE create_date like '".date("Y-m-d")."%' AND group_id = '".$_SESSION['__group_id']."'  ORDER BY  create_date desc";
			}
			return $this->select($sql);
		}



		 /* 列出子类函数  */
		public function getSubType($subtype,$mantype_id)
		{
			$sql = "SELECT * FROM  ".$this->$subtype." WHERE man_id = '".$mantype_id."' AND user_id = '".$_SESSION['__useralive'][0]."' order by store";
			return $this->select($sql);
		}



		/*  添加新日志解释函数 */
		public function insertLogResolve($log_id,$content)
		{
			$sql = "INSERT INTO ".$this->_log_resolve." values ('','".$log_id."','".$content."')";		
			return $this->insert($sql);
		}


		  /* 转换LOG_ID为日志内容函数 */
		public function convertLogIdToContent($log_id)
		{
			$sql = "SELECT content FROM  ".$this->_log_resolve." WHERE log_id = '".$log_id."'";		
			$result = $this->select($sql);
			foreach($result as $key => $value )
			{
				$value_done = $value[0];
			}
			return $value_done;
		}

		/*更新日志函数 */
		public function updateLog($id,$log_id,$content)
		{
			$sql = "UPDATE ".$this->_log_resolve." SET log_id = '".$log_id."',content = '".$content."' WHERE id = '".$id."'";
			return $this->update($sql);
		}


		/*删除日志函数 */
		public function deleteLog($id)
		{
			$sql = "DELETE FROM ".$this->_log_resolve." where id = '".$id."'";
			return $this->delete($sql);
		}




	   /* 列出日志内容函数 */
		public function getLogContentList()
		{
			$sql = "SELECT * FROM ".$this->_log_resolve." ORDER BY  log_id asc";		
			return $this->select($sql);
		}


	   /* 列出地址函数 */
		public function getAddress()
		{
			$sql = "SELECT * FROM ".$this->_address." WHERE user_id = '".$_SESSION['__useralive'][0]."'  order by store";		
			return $this->select($sql);
		}

		/*  列出要显示的地址函数*/
		public function getAddressDisplay()
		{
			$sql = "SELECT * FROM  ".$this->_address."  WHERE  user_id = '".$_SESSION['__useralive'][0]."' AND is_display = '1' order by store";
			return $this->select($sql);
		}

		/*  添加地址函数 */
		public function insertAddress($store,$is_display,$addr_name)
		{
			$sql = "INSERT INTO ".$this->_address."  VALUES ('','".$_SESSION['__useralive'][0]."','".$store."','".$is_display."','".$addr_name."','".date("Y-m-d H:i:s")."')";
			
			return $this->insert($sql);
		}

		/*更新地址函数 */
		public function updateAddress($address_id,$addr_name,$is_display)
		{
			$sql = "UPDATE ".$this->_address." SET name = '".$addr_name."',is_display = '".$is_display."' WHERE id = '".$address_id."' AND user_id = '".$_SESSION['__useralive'][0]."'";
			return $this->update($sql);
		}


		
		/*删除地址函数 */
		public function deleteAddress($address_id)
		{
			$sql = "DELETE FROM ".$this->_address." where id = '".$address_id."' AND user_id = '".$_SESSION['__useralive'][0]."'";
			return $this->delete($sql);
		}

		/*获取传过来的ID对应Store值函数 */
		public function getIsDisplay($table,$id)
		{
			$sql = "SELECT is_display FROM ".$this->$table." where id = '".$id."'";
			return $this->select($sql);
		}



		/*获得每月数据函数 */
		public function getReportOutMonth($month)
		{
			if($_SESSION['__useralive'][0] == 1 )
			{
				$sql = "SELECT * FROM ".$this->_out_corde." WHERE create_date like '".$month."%'";	
			} else {
				$sql = "SELECT * FROM ".$this->_out_corde." WHERE create_date like '".$month."%' AND group_id = '".$_SESSION['__group_id']."'";	
			}
			return $this->select($sql);
		}

		/*获得每月支出数据*/
		public function getReportOutMonthTotal($month)
		{
			if($_SESSION['__useralive'][0] == 1 )
			{
				$sql = "SELECT count(*),sum(money),user_id,group_id FROM ".$this->_out_corde." WHERE create_date like '".$month."%'  group by user_id";
			} else {
				$sql = "SELECT count(*),sum(money),user_id,group_id FROM ".$this->_out_corde." WHERE create_date like '".$month."%' AND group_id = '".$_SESSION['__group_id']."' group by user_id";
			}
			return $this->select($sql);
		}


		/*获得指定用户每月数据函数 */
		public function getReportPersonOutMonth($user_id,$month1)
		{
			$sql = "SELECT * FROM ".$this->_out_corde." WHERE user_id = '".$user_id."' AND create_date like '".$month1."%'";		
			return $this->select($sql);
		}




		 /* SELECT数字选择函数*/
		public function NumList()
		{
			$i = 0;
			echo "<select  name = \"numlist_1000\" >";
			while($i<10)
			{
				echo "<option value =".$i.">" . $i . "</option>";
				$i++;
			}
				echo "</select >";

			//===========================================================
			$i = 0;
			echo "<select  name = \"numlist_100\" >";
			while($i<10)
			{
				echo "<option value =".$i.">" . $i . "</option>";
				$i++;
			}
				echo "</select >";

			//===========================================================
			$i = 0;
			echo "<select  name = \"numlist_10\" >";
			while($i<10)
			{
				echo "<option value =".$i.">" . $i . "</option>";
				$i++;
			}
				echo "</select >";
			
			//===========================================================
			$i = 0;
			echo "<select  name = \"numlist_1\" >";
			while($i<10)
			{
				echo "<option value =".$i.">" . $i . "</option>";
				$i++;
			}
				echo "</select >";

			echo " . ";

		   	//===========================================================
			$i = 0;
			echo "<select  name = \"numlist_01\">";
			while($i<10)
			{
				echo "<option value =".$i.">" . $i . "</option>";
				$i++;
			}
				echo "</select >";

		   	//===========================================================
			$i = 0;			
			echo "<select  name = \"numlist_001\" >";
			while($i<10)
			{
				echo "<option value =".$i.">" . $i . "</option>";
				$i++;
			}
				echo "</select >";
		   }

		/*  往前主类排序函数 */
		public function TaxisManFront($table,$id)
		{
			$num = 0;
			
			if ($id != 1 )
			{
				$num = $id-1;
				$sql = "UPDATE ".$this->$table." SET store = '0' where store = '".$num."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$num."' where store = '".$id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$id."' where store = '0'";
				$this->update($sql);
			} else {
				return false;
			}
		}

		/*  往后主类排序函数 */
		public function TaxisManAfter($table,$id)
		{
			$num = 0;
			$sql = "select max(store) from ".$this->$table;
			$max = $this->select($sql);

			if ($id <= $max['0']['0'] )
			{
				$num = $id+1;
				$sql = "UPDATE ".$this->$table." SET store = '0' where store = '".$num."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$num."' where store = '".$id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$id."' where store = '0'";
				$this->update($sql);
			} else {
				return false;
			}
		}

		/*  往前子类排序函数 */
		public function TaxisSubFront($table,$man_id,$id)
		{
			$num = 0;
			
			if ($id != 1 )
			{
				$num = $id-1;
				$sql = "UPDATE ".$this->$table." SET store = '0' where store = '".$num."' AND man_id = '".$man_id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$num."' where store = '".$id."' AND man_id = '".$man_id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$id."' where store = '0' AND man_id = '".$man_id."'";
				$this->update($sql);
			} else {
				return false;
			}
		}

		/*  往后子类排序函数 */
		public function TaxisSubAfter($table,$man_id,$id)
		{
			$num = 0;
			$sql = "select max(store) from ".$this->$table;
			$max = $this->select($sql);

			if ($id <= $max['0']['0'] )
			{
				$num = $id+1;
				$sql = "UPDATE ".$this->$table." SET store = '0' where store = '".$num."' AND man_id = '".$man_id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$num."' where store = '".$id."' AND man_id = '".$man_id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$id."' where store = '0' AND man_id = '".$man_id."'";
				$this->update($sql);
			} else {
				return false;
			}
		}

		/*  往前地址排序函数 */
		public function TaxisAddrFront($table,$id)
		{
			$num = 0;
			
			if ($id != 1 )
			{
				$num = $id-1;
				$sql = "UPDATE ".$this->$table." SET store = '0' where store = '".$num."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$num."' where store = '".$id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$id."' where store = '0'";
				$this->update($sql);
			} else {
				return false;
			}
		}

		/*  往后地址排序函数 */
		public function TaxisAddrAfter($table,$id)
		{
			$num = 0;
			$sql = "select max(store) from ".$this->$table;
			$max = $this->select($sql);

			if ($id <= $max['0']['0'] )
			{
				$num = $id+1;
				$sql = "UPDATE ".$this->$table." SET store = '0' where store = '".$num."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$num."' where store = '".$id."'";
				$this->update($sql);

				$sql = "UPDATE ".$this->$table." SET store = '".$id."' where store = '0'";
				$this->update($sql);
			} else {
				return false;
			}
		}

		/*  获取主类最大排序号函数 */
		public function getMaxManStore($table)
		{
			$sql = "select max(store) from ".$this->$table;
			return $this->select($sql);
		}

		/*  获取子类最大排序号函数 */
		public function getMaxSubStore($table,$man_id)
		{
			$sql = "select max(store) from ".$this->$table." WHERE man_id = '".$man_id."'";
			return $this->select($sql);
		}

		/*  获取地址最大排序号函数 */
		public function getMaxAddrStore()
		{
			$sql = "select max(store) from address WHERE user_id = '".$_SESSION['__useralive'][0]."'";
			return $this->select($sql);
		}




	}

	/* 创建一个类变量 */
	$Finance = new Finance();

	/* 连接到数据库 */
	$Finance->_construct();



>>>>>>> e79fba4c37b2c02476590015a5952175b7fd5b25
?>