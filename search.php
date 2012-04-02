<HTML>
	<?PHP 
		require_once("head.php");
		$sub_search = isset($_POST['sub_search'])?$_POST['sub_search']:'';
		$search_group = isset($_POST['search_group'])?$_POST['search_group']:'';
		$notes = isset($_POST['notes'])?$_POST['notes']:'';
		$from_year = isset($_POST['from_year'])?$_POST['from_year']:'';
		$to_year = isset($_POST['to_year'])?$_POST['to_year']:'';
		$to_month = isset($_POST['to_month'])?$_POST['to_month']:'';
		$from_month = isset($_POST['from_month'])?$_POST['from_month']:'';
		$from_day = isset($_POST['from_day'])?$_POST['from_day']:'';
		$to_day = isset($_POST['to_day'])?$_POST['to_day']:'';
		$in_mantype_array = isset($_POST['in_mantype_array'])?$_POST['in_mantype_array']:'';
		$out_mantype_array = isset($_POST['out_mantype_array'])?$_POST['out_mantype_array']:'';
		$in_mantype_id = isset($_POST['in_mantype_id'])?$_POST['in_mantype_id']:'';
		$in_subtype_id = isset($_POST['in_subtype_id'])?$_POST['in_subtype_id']:'';
		$out_mantype_id = isset($_POST['out_mantype_id'])?$_POST['out_mantype_id']:'';
		$out_mantype_id = isset($_POST['out_mantype_id'])?$_POST['out_mantype_id']:'';
		$address_array = isset($_POST['address_array'])?$_POST['address_array']:'';

		$sql = '';
		$sql_sub_where = '';
		$time1 = '0';
		$day = '';
		$value_done = '';
	?>
	<BODY>

<?PHP
if ( $sub_search == 1 ) 
{
	if ($search_group == "on") 
	{
		$sql_where = " group_id = '".$_SESSION['__group_id']."' ";
	} else {
		$sql_where = " user_id = '".$_SESSION['__useralive'][0]."' ";
	}

	if ( ! empty($notes))
	{
		$sql_where .= " AND notes like '%".$notes."%' ";
		$type = "notes";
	}

	if ( (! empty($from_year)) && (! empty($from_month)))
	{
		$sql_where .= " AND create_date >=  '".$from_year."-".$from_month."-".$from_day."' ";
		$type = "date";
	}

	if ( (! empty($to_year)) && (! empty($to_month)))
	{
		$sql_where .= " AND create_date <=  '".$to_year."-".$to_month."-".$to_day."' ";
		$type = "date";
	}

	if (! empty($in_mantype_array) &&  empty($out_mantype_array))
	{

		$sql = "SELECT * FROM in_corde WHERE ";
		$type = "in";

		foreach( $in_mantype_array  as  $key => $value )
		{	
			$sql_man_where .= " in_mantype_id = '".$value."' OR ";
		}

	} else if ( empty($in_mantype_array) &&  ! empty($out_mantype_array)) {
		$sql = "SELECT * FROM out_corde WHERE ";
		$type = "out";

		foreach( $out_mantype_array  as  $key => $value )
		{
			$sql_man_where .= " out_mantype_id = '".$value."' OR ";
		}

	}else if (empty($in_mantype_array) && empty($out_mantype_array)){
		if ( !empty($in_mantype_id))
		{
			$type = "in";
			$sql = "SELECT * FROM in_corde WHERE ";
			$sql_man_where = " in_mantype_id = '".$in_mantype_id."' OR ";
			if ( !empty($in_subtype_id))
			{
				$sql_sub_where .= " AND in_subtype_id = '".$in_subtype_id."' ";
			}
		} else if ( !empty($out_mantype_id)) {
			$type = "out";
			$sql = "SELECT * FROM out_corde WHERE ";
			$sql_man_where = " out_mantype_id = '".$out_mantype_id."' OR ";
			if ( !empty($out_subtype_id))
			{
				$sql_sub_where .= " AND out_subtype_id = '".$out_subtype_id."' ";
			}		
		} else if (!empty($address_array)) {
			$type = "addr";
			$sql_out = "SELECT * FROM out_corde WHERE ";
			$sql_out .= $sql_where;
			$sql_in = "SELECT * FROM in_corde WHERE ";
			$sql_in .= $sql_where;
		}
	} else {
		echo "不能同时搜索 支出与收入。<BR>";
		exit;
	}
		$sql .= $sql_where;
		if ( !empty($sql_man_where))
		{
			$sql .= " AND ( ".$sql_man_where." NULL) ";
		}
	if ( !empty($address_array))
	{
		foreach( $address_array  as  $key => $value )
		{
			$sql_addr_where .= " addr_id = '".$value."' OR ";
		}
		$sql .= " AND ( ".$sql_addr_where." NULL) ";
		$sql_out .= " AND ( ".$sql_addr_where." NULL) ";
		$sql_in .= " AND ( ".$sql_addr_where." NULL) ";

	}

		$sql .= $sql_sub_where;
if ($type == "out")
{
?>

			<TABLE border="1">
			<tr>
				<td colspan="9" align="center">
					<h1> 
<?PHP 
						echo "支出搜索结果";
?>
					</h1>
				</td>
			</tr>
			  <tr>
				<th>序号</th>
				<th>用户</th>
				<th>家庭</th>
				<th>支出主类</th>
				<th>支出子类</th>
				<th>支出地址</th>
				<th>钱</th>
				<th>备注</th>
				<th>时间</th>
			  </tr>	
<?PHP
			$total_money = "0";
			$result = $Finance->search($sql);
			foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						$total_money = $total_money + $value[1];
						
						$time2 = explode(" ",$value[8]);
						if ( $time1['0'] != $time2['0'] )
						{
							$day++;
						}

						echo "<tr>";
						echo "<td>".++$key1."</td>";
						if($Finance->convertUserAliasID($value[2]))
						{
							echo "<td>".$Finance->convertUserAliasID($value[2])."</td>";
						} else {
							echo "<td>".$Finance->convertUserID($value[2])."</td>";
						}
						$group_alias = $Finance->convertGroupAliasID($value[3]);
						if(empty($group_alias['1']))
						{
							echo "<td>".$group_alias['0']."</td>";
						} else {
							echo "<td>".$group_alias['1']."</td>";
						}
						echo "<td>".$Finance->convertIdToNmae("_out_mantype",$value[4])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_out_subtype",$value[5])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[7]."</td>";
						echo "<td>".$value[8]."</td>";
						echo "</tr>";
						$time1 = explode(" ",$value[8]);
						$group_alias ="";
				}
					echo "<tr><td colspan=\"6\" align='right'>总共[".$day."天]总计：</td>";
					echo "<td >".$total_money."</td>";
					echo "<td align='right'>平均每天:</td>";
					echo "<td>".number_format($total_money/$day,2)."</td></tr>";
?>
	</TABLE>
<?PHP
} else if ($type == "in") {
?>
			<TABLE border="1">
			<tr>
				<td colspan="9" align="center">
					<h1> 
<?PHP 
						echo "收入搜索结果";
?>
					</h1>
				</td>
			</tr>
			  <tr>
				<th>序号</th>
				<th>用户</th>
				<th>家庭</th>
				<th>收入主类</th>
				<th>收入子类</th>
				<th>收入地址</th>
				<th>钱</th>
				<th>备注</th>
				<th>时间</th>
			  </tr>	
<?PHP
			$total_money = "0";
			$result = $Finance->search($sql);
			foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						$total_money = $total_money + $value[1];
						
						$time2 = explode(" ",$value[8]);
						if ( $time1['0'] != $time2['0'] )
						{
							$day++;
						}
						echo "<tr>";
						echo "<td>".++$key1."</td>";
						if($Finance->convertUserAliasID($value[2]))
						{
							echo "<td>".$Finance->convertUserAliasID($value[2])."</td>";
						} else {
							echo "<td>".$Finance->convertUserID($value[2])."</td>";
						}
						$group_alias = $Finance->convertGroupAliasID($value[3]);
						if(empty($group_alias['1']))
						{
							echo "<td>".$group_alias['0']."</td>";
						} else {
							echo "<td>".$group_alias['1']."</td>";
						}
						echo "<td>".$Finance->convertIdToNmae("_in_mantype",$value[4])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_in_subtype",$value[5])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[7]."</td>";
						echo "<td>".$value[8]."</td>";
						echo "</tr>";
						$time1 = explode(" ",$value[8]);
						$group_alias ="";
				}
					echo "<tr><td colspan=\"6\" align='right'>总共[".$day."天]总计：</td>";
					echo "<td >".$total_money."</td>";
					echo "<td align='right'>平均每天:</td>";
					echo "<td>".number_format($total_money/$day,2)."</td></tr>";
?>
	</TABLE>
<?PHP
} else if ($type == "addr") {
?>
			<TABLE border="1">
			<tr>
				<td colspan="9" align="center">
					<h1> 
<?PHP 
						echo "收入搜索结果";
?>
					</h1>
				</td>
			</tr>
			  <tr>
				<th>序号</th>
				<th>用户</th>
				<th>家庭</th>
				<th>收入主类</th>
				<th>收入子类</th>
				<th>收入地址</th>
				<th>钱</th>
				<th>备注</th>
				<th>时间</th>
			  </tr>	
<?PHP
			$total_money = "0";
			$result = $Finance->search($sql_in);
			foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						$total_money = $total_money + $value[1];
						
						$time2 = explode(" ",$value[8]);
						if ( $time1['0'] != $time2['0'] )
						{
							$day++;
						}
						echo "<tr>";
						echo "<td>".++$key1."</td>";
						if($Finance->convertUserAliasID($value[2]))
						{
							echo "<td>".$Finance->convertUserAliasID($value[2])."</td>";
						} else {
							echo "<td>".$Finance->convertUserID($value[2])."</td>";
						}
						$group_alias = $Finance->convertGroupAliasID($value[3]);
						if(empty($group_alias['1']))
						{
							echo "<td>".$group_alias['0']."</td>";
						} else {
							echo "<td>".$group_alias['1']."</td>";
						}
						echo "<td>".$Finance->convertIdToNmae("_in_mantype",$value[4])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_in_subtype",$value[5])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[7]."</td>";
						echo "<td>".$value[8]."</td>";
						echo "</tr>";
						$time1 = explode(" ",$value[8]);
						$group_alias ="";
				}
					echo "<tr><td colspan=\"6\" align='right'>总共[".$day."天]总计：</td>";
					echo "<td >".$total_money."</td>";
					echo "<td align='right'>平均每天:</td>";
					echo "<td>".number_format($total_money/$day,2)."</td></tr>";
?>
	</TABLE>

			<TABLE border="1">
			<tr>
				<td colspan="9" align="center">
					<h1> 
<?PHP 
						echo "支出搜索结果";
?>
					</h1>
				</td>
			</tr>
			  <tr>
				<th>序号</th>
				<th>用户</th>
				<th>家庭</th>
				<th>支出主类</th>
				<th>支出子类</th>
				<th>支出地址</th>
				<th>钱</th>
				<th>备注</th>
				<th>时间</th>
			  </tr>	
<?PHP
			$total_money = "0";
			$result = $Finance->search($sql_out);
			foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						$total_money = $total_money + $value[1];
						
						$time2 = explode(" ",$value[8]);
						if ( $time1['0'] != $time2['0'] )
						{
							$day++;
						}
						echo "<tr>";
						echo "<td>".++$key1."</td>";
						if($Finance->convertUserAliasID($value[2]))
						{
							echo "<td>".$Finance->convertUserAliasID($value[2])."</td>";
						} else {
							echo "<td>".$Finance->convertUserID($value[2])."</td>";
						}
						$group_alias = $Finance->convertGroupAliasID($value[3]);
						if(empty($group_alias['1']))
						{
							echo "<td>".$group_alias['0']."</td>";
						} else {
							echo "<td>".$group_alias['1']."</td>";
						}
						echo "<td>".$Finance->convertIdToNmae("_out_mantype",$value[4])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_out_subtype",$value[5])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[7]."</td>";
						echo "<td>".$value[8]."</td>";
						echo "</tr>";
						$time1 = explode(" ",$value[8]);
						$group_alias ="";
				}
					echo "<tr><td colspan=\"6\" align='right'>总共[".$day."天]总计：</td>";
					echo "<td >".$total_money."</td>";
					echo "<td align='right'>平均每天:</td>";
					echo "<td>".number_format($total_money/$day,2)."</td></tr>";
?>
	</TABLE>
<?PHP
} else if ($type == "date") {
?>
			<TABLE border="1">
			<tr>
				<td colspan="9" align="center">
					<h1> 
<?PHP 
						echo "收入搜索结果";
?>
					</h1>
				</td>
			</tr>
			  <tr>
				<th>序号</th>
				<th>用户</th>
				<th>家庭</th>
				<th>收入主类</th>
				<th>收入子类</th>
				<th>收入地址</th>
				<th>钱</th>
				<th>备注</th>
				<th>时间</th>
			  </tr>	
<?PHP
			$sql_date_in = "SELECT * FROM in_corde WHERE ";
			$sql_date_in .= $sql_where;
			$total_money = "0";
			$result = $Finance->search($sql_date_in);
			foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						$total_money = $total_money + $value[1];
						
						$time2 = explode(" ",$value[8]);
						if ( $time1['0'] != $time2['0'] )
						{
							$day++;
						}
						echo "<tr>";
						echo "<td>".++$key1."</td>";
						if($Finance->convertUserAliasID($value[2]))
						{
							echo "<td>".$Finance->convertUserAliasID($value[2])."</td>";
						} else {
							echo "<td>".$Finance->convertUserID($value[2])."</td>";
						}
						$group_alias = $Finance->convertGroupAliasID($value[3]);
						if(empty($group_alias['1']))
						{
							echo "<td>".$group_alias['0']."</td>";
						} else {
							echo "<td>".$group_alias['1']."</td>";
						}
						echo "<td>".$Finance->convertIdToNmae("_in_mantype",$value[4])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_in_subtype",$value[5])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[7]."</td>";
						echo "<td>".$value[8]."</td>";
						echo "</tr>";
						$time1 = explode(" ",$value[8]);
						$group_alias ="";
				}
					echo "<tr><td colspan=\"6\" align='right'>总共[".$day."天]总计：</td>";
					echo "<td >".$total_money."</td>";
					echo "<td align='right'>平均每天:</td>";
					echo "<td>".number_format($total_money/$day,2)."</td></tr>";
?>
	</TABLE>

			<TABLE border="1">
			<tr>
				<td colspan="9" align="center">
					<h1> 
<?PHP 
						echo "支出搜索结果";
?>
					</h1>
				</td>
			</tr>
			  <tr>
				<th>序号</th>
				<th>用户</th>
				<th>家庭</th>
				<th>支出主类</th>
				<th>支出子类</th>
				<th>支出地址</th>
				<th>钱</th>
				<th>备注</th>
				<th>时间</th>
			  </tr>	
<?PHP
			$sql_date_out = "SELECT * FROM out_corde WHERE ";
			$sql_date_out .= $sql_where;
			$total_money = "0";
			$result = $Finance->search($sql_date_out);
			foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						$total_money = $total_money + $value[1];
						
						$time2 = explode(" ",$value[8]);
						if ( $time1['0'] != $time2['0'] )
						{
							$day++;
						}
						echo "<tr>";
						echo "<td>".++$key1."</td>";
						if($Finance->convertUserAliasID($value[2]))
						{
							echo "<td>".$Finance->convertUserAliasID($value[2])."</td>";
						} else {
							echo "<td>".$Finance->convertUserID($value[2])."</td>";
						}
						$group_alias = $Finance->convertGroupAliasID($value[3]);
						if(empty($group_alias['1']))
						{
							echo "<td>".$group_alias['0']."</td>";
						} else {
							echo "<td>".$group_alias['1']."</td>";
						}
						echo "<td>".$Finance->convertIdToNmae("_out_mantype",$value[4])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_out_subtype",$value[5])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[7]."</td>";
						echo "<td>".$value[8]."</td>";
						echo "</tr>";
						$time1 = explode(" ",$value[8]);
						$group_alias ="";
				}
					echo "<tr><td colspan=\"6\" align='right'>总共[".$day."天]总计：</td>";
					echo "<td >".$total_money."</td>";
					echo "<td align='right'>平均每天:</td>";
					echo "<td>".number_format($total_money/$day,2)."</td></tr>";
?>
	</TABLE>
<?PHP
} else if ($type == "notes") {
?>
			<TABLE border="1">
			<tr>
				<td colspan="9" align="center">
					<h1> 
<?PHP 
						echo "收入搜索结果";
?>
					</h1>
				</td>
			</tr>
			  <tr>
				<th>序号</th>
				<th>用户</th>
				<th>家庭</th>
				<th>收入主类</th>
				<th>收入子类</th>
				<th>收入地址</th>
				<th>钱</th>
				<th>备注</th>
				<th>时间</th>
			  </tr>	
<?PHP
			$sql_notes_in = "SELECT * FROM in_corde WHERE ";
			$sql_notes_in .= $sql_where;
			$total_money = "0";
			$result = $Finance->search($sql_notes_in);
			foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						$total_money = $total_money + $value[1];
						
						$time2 = explode(" ",$value[8]);
						if ( $time1['0'] != $time2['0'] )
						{
							$day++;
						}
						echo "<tr>";
						echo "<td>".++$key1."</td>";
						if($Finance->convertUserAliasID($value[2]))
						{
							echo "<td>".$Finance->convertUserAliasID($value[2])."</td>";
						} else {
							echo "<td>".$Finance->convertUserID($value[2])."</td>";
						}
						$group_alias = $Finance->convertGroupAliasID($value[3]);
						if(empty($group_alias['1']))
						{
							echo "<td>".$group_alias['0']."</td>";
						} else {
							echo "<td>".$group_alias['1']."</td>";
						}
						echo "<td>".$Finance->convertIdToNmae("_in_mantype",$value[4])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_in_subtype",$value[5])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[7]."</td>";
						echo "<td>".$value[8]."</td>";
						echo "</tr>";
						$time1 = explode(" ",$value[8]);
						$group_alias ="";
				}
					echo "<tr><td colspan=\"6\" align='right'>总共[".$day."天]总计：</td>";
					echo "<td >".$total_money."</td>";
					echo "<td align='right'>平均每天:</td>";
					echo "<td>".number_format($total_money/$day,2)."</td></tr>";
?>
	</TABLE>

			<TABLE border="1">
			<tr>
				<td colspan="9" align="center">
					<h1> 
<?PHP 
						echo "支出搜索结果";
?>
					</h1>
				</td>
			</tr>
			  <tr>
				<th>序号</th>
				<th>用户</th>
				<th>家庭</th>
				<th>支出主类</th>
				<th>支出子类</th>
				<th>支出地址</th>
				<th>钱</th>
				<th>备注</th>
				<th>时间</th>
			  </tr>	
<?PHP
			$sql_notes_out = "SELECT * FROM out_corde WHERE ";
			$sql_notes_out .= $sql_where;
			$total_money = "0";
			$result = $Finance->search($sql_notes_out);
			foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						$total_money = $total_money + $value[1];
						
						$time2 = explode(" ",$value[8]);
						if ( $time1['0'] != $time2['0'] )
						{
							$day++;
						}
						echo "<tr>";
						echo "<td>".++$key1."</td>";
						if($Finance->convertUserAliasID($value[2]))
						{
							echo "<td>".$Finance->convertUserAliasID($value[2])."</td>";
						} else {
							echo "<td>".$Finance->convertUserID($value[2])."</td>";
						}
						$group_alias = $Finance->convertGroupAliasID($value[3]);
						if(empty($group_alias['1']))
						{
							echo "<td>".$group_alias['0']."</td>";
						} else {
							echo "<td>".$group_alias['1']."</td>";
						}
						echo "<td>".$Finance->convertIdToNmae("_out_mantype",$value[4])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_out_subtype",$value[5])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[7]."</td>";
						echo "<td>".$value[8]."</td>";
						echo "</tr>";
						$time1 = explode(" ",$value[8]);
						$group_alias ="";
				}
					echo "<tr><td colspan=\"6\" align='right'>总共[".$day."天]总计：</td>";
					echo "<td >".$total_money."</td>";
					echo "<td align='right'>平均每天:</td>";
					echo "<td>".number_format($total_money/$day,2)."</td></tr>";
?>
	</TABLE>

<?PHP
} else {
	echo "不支持的搜索。";
}
} else {
?>
	<FORM name="outcord" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>" method="POST" >
		<INPUT type="hidden" name="sub_search" value="1">
		<TABLE >
			<TR>
				<TD colspan="2" align="center">
					<FONT size=3 color="#CC9900">注：收入与支出不能同时被搜索。</FONT>
				</TD>
			</TR>
			<TR>
				<TD align="right">
				搜索整个家庭：
				</TD>
				<TD>
					<INPUT TYPE="checkbox" name="search_group" >
				</TD>
			</TR>
			<TR>
				<TD align="right">
					时间从：
				</TD>
				<TD>
					<select name = "from_year">
					<option value = "">&nbsp;</option>
					<?PHP 
						$year=2010;
						while( $year <= 2020 )
						{
							echo "<option value =".$year.">" . $year . "</option>";
							$year++;
						}
					?>
					</select>
					/
					<select name = "from_month">
					<option value = "">&nbsp;</option>
					<?PHP 
						$month=1;
						while( $month <= 12 )
						{
							if ($month < 10 )
							{
								$month = "0".$month;
							}
							echo "<option value =".$month.">" . $month . "</option>";
							$month++;
						}
					?>
					</select>
					/
					<select name = "from_day">
					<option value = "">&nbsp;</option>
					<?PHP 
						$day=1;
						while( $day <= 31 )
						{
							if ($day < 10 )
							{
								$day = "0".$day;
							}
							echo "<option value =".$day.">" . $day . "</option>";
							$day++;
						}
					?>
					</select>
				</TD>
			</TR>
			<TR>
				<TD align="right">
					时间到：
				</TD>
				<TD>
					<select name = "to_year">
					<option value = "">&nbsp;</option>
					<?PHP 
						$year=2010;
						while( $year <= 2020 )
						{
							echo "<option value =".$year.">" . $year . "</option>";
							$year++;
						}
					?>
					</select>
					/
					<select name = "to_month">
					<option value = "">&nbsp;</option>
					<?PHP 
						$month=1;
						while( $month <= 12 )
						{
							if ($month < 10 )
							{
								$month = "0".$month;
							}
							echo "<option value =".$month.">" . $month . "</option>";
							$month++;
						}
					?>
					</select>
					/
					<select name = "to_day">
					<option value = "">&nbsp;</option>
					<?PHP 
						$day=1;
						while( $day <= 31 )
						{
							if ($day < 10 )
							{
								$day = "0".$day;
							}
							echo "<option value =".$day.">" . $day . "</option>";
							$day++;
						}
					?>
					</select>
				</TD>
			</TR>
			<TR>
				<TD align="right">
					搜索备注：
				</TD>
				<TD>
					<input type="text" name="notes" size="18" maxlength="20">
				</TD>
			</TR>
			<TR>
				<TD align="right">
					个人支出主类：
				</TD>
				<TD>
					<select name="out_mantype_array[]" multiple="multiple" size="5">
				<?PHP
					$result = $Finance->getInOutType("_out_mantype");
					foreach( $result  as  $key => $value )
					{
						$key1 = $key;
						echo "<option value=\"".$value[0]."\">".++$key1.". ".$value[4]."</option>";
					}
				?>
					<option value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
					</select>
				</TD>
			</TR>
			<TR>
				<TD align="right">
					<FONT size=2 color="#CC9900">[只能单独使用]<BR>个人支出子类：</FONT>
				</TD>
				<TD>
					<?PHP 
							//******************提取主类信息******************
							$forum_data = $Finance->getManTypeList("_out_mantype"); 
							//print_r ($forum_data);

							//**************获取子类信息**************       
							$forum_data2 = $Finance->getSubTypeList("_out_subtype"); 
							//print_r ($forum_data2);

							?>

							<!--************ JavaScript处理province--onChange *************-->
							<script language = "JavaScript"> 
							var onecount2; 
							subcat2 = new Array(); 
							<?PHP 
							$num2 = count($forum_data2);
							?>
							onecount2=<?PHP echo $num2;?>;
							<?PHP
							for($j=0;$j<$num2;$j++)
							{
							?>
							subcat2[<?PHP echo $j;?>] = new Array("<?PHP echo $forum_data2[$j]['id'];?>","<?PHP echo $forum_data2[$j]['man_id'];?>","<?PHP echo $forum_data2[$j]['name'];?>");
							<?PHP }?> 
							function changelocation(id) 
							{ 
							document.outcord.out_subtype_id.length = 0; 
							var id=id; 
							var j; 
							document.outcord.out_subtype_id.options[0] = new Option('',''); 
							for (j=0;j < onecount2; j++) 
							{ 
							if (subcat2[j][1] == id) 
							   { 
							   document.outcord.out_subtype_id.options[document.outcord.out_subtype_id.length] = new Option(subcat2[j][2], subcat2[j][0]); 
							   } 
							} 
							}
							</script> 

							<!--********************页面表单*************************-->
							<select name="out_mantype_id" onChange="changelocation(document.outcord.out_mantype_id.options[document.outcord.out_mantype_id.selectedIndex].value)" size="1"> 
							<option selected></option> 
							   
							<?PHP 
							$num = count($forum_data);

							for($i=0;$i<$num;$i++)
							{
							?>
							<option value="<?PHP echo $forum_data[$i]['id'];?>"><?PHP echo $forum_data[$i]['name'];?></option> 
							<?PHP 
							}
							?>
							</select>
							<select name="out_subtype_id"> 
							<option selected value=""></option> 
							</select>
				
				</TD>
			</TR>
			<TR>
				<TD align="right">
					个人收入主类：
				</TD>
				<TD>
					<select name="in_mantype_array[]" multiple="multiple" size="5">
				<?PHP
					$result = $Finance->getInOutType("_in_mantype");
					foreach( $result  as  $key => $value )
					{
						$key1 = $key;
						echo "<option value=\"".$value[0]."\">".++$key1.". ".$value[4]."</option>";
					}
				?>
					<option value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
					</select>
				</TD>
			</TR>
			<TR>
			<TD align="right">
				<FONT size=2 color="#CC9900">[只能单独使用]<BR>个人收入子类：</FONT>
			</TD>
			<TD>
					<?PHP			
					//******************提取主类信息******************
					$forum_data3 = $Finance->getManTypeList("_in_mantype"); 
					//print_r ($forum_data3);

					//**************获取子类信息**************       
					$forum_data4 = $Finance->getSubTypeList("_in_subtype"); 
					//echo "<BR><BR>";
					//print_r ($forum_data4);

					?>

					<!--************ JavaScript处理province--onChange *************-->
					<script language = "JavaScript"> 
					var onecount4; 
					subcat4 = new Array(); 
					<?PHP 
					$num4 = count($forum_data4);
					?>
					onecount4=<?PHP echo $num4;?>;
					<?PHP
					for($j2=0;$j2<$num4;$j2++)
					{
					?>
					subcat4[<?PHP echo $j2;?>] = new Array("<?PHP echo $forum_data4[$j2]['id'];?>","<?PHP echo $forum_data4[$j2]['man_id'];?>","<?PHP echo $forum_data4[$j2]['name'];?>");
					<?PHP }?> 
					function changelocation2(id2) 
					{ 
					document.outcord.in_subtype_id.length = 0; 
					var id2=id2; 
					var j2; 
					document.outcord.in_subtype_id.options[0] = new Option('',''); 
					for (j2=0;j2 < onecount4; j2++) 
					{ 
					if (subcat4[j2][1] == id2) 
					   { 
					   document.outcord.in_subtype_id.options[document.outcord.in_subtype_id.length] = new Option(subcat4[j2][2], subcat4[j2][0]); 
					   } 
					} 
					}
					</script> 

					<!--********************页面表单*************************-->
					<select name="in_mantype_id" onChange="changelocation2(document.outcord.in_mantype_id.options[document.outcord.in_mantype_id.selectedIndex].value)" size="1"> 
					<option selected></option> 
					   
					<?PHP 
					$num3 = count($forum_data3);

					for($i=0;$i<$num3;$i++)
					{
					?>
					<option value="<?PHP echo $forum_data3[$i]['id'];?>"><?PHP echo $forum_data3[$i]['name'];?></option> 
					<?PHP  
					}
					?>
					</select>
					<select name="in_subtype_id" size="1"> 
					<option selected value=""></option> 
					</select>
			</TD>
			</TR>
			<TR>
				<TD align="right">
					个人地址类：
				</TD>
				<TD>
					<select name="address_array[]" multiple="multiple" size="5">
				<?PHP
					$result = $Finance->getAddress();
					foreach( $result  as  $key => $value )
					{
						$key1 = $key;
						echo "<option value=\"".$value[0]."\">".++$key1.". ".$value[4]."</option>";
					}
				?>
				<option value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
					</select>
				</TD>
			</TR>
			<TR>
				<TD colspan="2" align="center">
					<INPUT type="submit" value="<?PHP echo $_SEARCH?>">
					<INPUT type="reset" value="<?PHP echo $_CLEAR?>">
				</TD>
			</TR>
		</TABLE>
	</FORM>
<?PHP } ?>

	<?PHP require_once("tail.php");?>
	</BODY>
</HTML>
