<<<<<<< HEAD
<HTML>
	<?PHP require_once("head.php");?>
	<BODY>
	
<?PHP 
	if ( $_POST['getrecordtype']  == 1 || $_SESSION['__gettype'] == "ADDOUTCORDE")
	{
		echo "<FORM  name=\"myform\" action=\"form_process.php\" method=\"POST\" >";	
?>
<?PHP 
			echo $_OUT.": ";
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
								<?php 
								$num2 = count($forum_data2);
								?>
								onecount2=<?echo $num2;?>;
								<?
								for($j=0;$j<$num2;$j++)
								{
								?>
								subcat2[<?echo $j;?>] = new Array("<?echo $forum_data2[$j]['id'];?>","<?echo $forum_data2[$j]['man_id'];?>","<?echo $forum_data2[$j]['name'];?>");
								<?}?> 
								function changelocation(id) 
								{ 
								document.myform.city.length = 0; 
								var id=id; 
								var j; 
								document.myform.city.options[0] = new Option('选择子类',''); 
								for (j=0;j < onecount2; j++) 
								{ 
								if (subcat2[j][1] == id) 
								   { 
								   document.myform.city.options[document.myform.city.length] = new Option(subcat2[j][2], subcat2[j][0]); 
								   } 
								} 
								}
								</script> 

								<!--********************页面表单*************************-->
								<select name="bigClass" onChange="changelocation(document.myform.bigClass.options[document.myform.bigClass.selectedIndex].value)" size="1"> 
								<option selected>选择主类</option> 
								   
								<?php 
								$num = count($forum_data);

								for($i=0;$i<$num;$i++)
								{
								?>
								<option value="<?echo $forum_data[$i]['id'];?>"><?echo $forum_data[$i]['name'];?></option> 
								<? 
								}
								?>
								</select>
								<select name="city" size="1"> 
								<option selected value="">选择子类</option> 
								</select>
				<BR>地点：
				<SELECT NAME="address_id" size="1" >
				<?PHP
					$address = $Finance->getInOutType("_address");
					foreach( $address as $key => $value )
					{
						echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
					}
				?>
				</SELECT>				
				<BR>
				<?PHP $Finance->NumList(); echo $_YUAN?>
				<BR><?PHP echo $_NOTES?><BR>
				<input type="text" name="notes" size="10" maxlength="50">
				<input type="hidden" name="addoutcorde" value="ADDOUTCORDE">
				<INPUT type="submit" value="<?PHP echo $_ADD_OUT?>">
				</FORM>
		<BR>
			<TABLE border="1">
			  <tr>
				<th>序号</th>				
				<th>时间</th>
				<th>主类</th>
				<th>子类</th>
				<th>地点</th>
				<th>钱</th>
				<th>备注</th>	
				<th>操作</th>	

			  </tr>					
		<?PHP 	

				$total_money = 0;
	
				$result = $Finance->listInOutCorde("_out_corde");
				foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						$time = explode(" ",$value[8]);
						$total_money = $total_money + $value[1];

						echo "<tr>";
						echo "<td>".++$key1."</td>";
						echo "<td>".$time[1]."</td>";
						echo "<td>".$Finance->convertIdToNmae("_out_mantype",$value[4])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_out_subtype",$value[5])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[7]."</td>";
						echo "<td><FORM action=\"form_process.php\" method=\"POST\"  style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_ALTER.">";
						echo "<INPUT type=\"hidden\" name=\"out_corde_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"out_mantype_id\" value=".$value[4].">";
						echo "<INPUT type=\"hidden\" name=\"out_subtype_id\" value=".$value[5].">";
						echo "<INPUT type=\"hidden\" name=\"address_id\" value=".$value[6].">";
						echo "<INPUT type=\"hidden\" name=\"money\" value=".$value[8].">";
						echo "<INPUT type=\"hidden\" name=\"notes\" value=".$value[7].">";
						echo "<INPUT type=\"hidden\" name=\"alteroutcorde\" value=\"ALTEROUTCORDE\">";
						echo "</FORM>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_DELETE.">";
						echo "<INPUT type=\"hidden\" name=\"outcorde_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"deleteoutcorde\" value=\"DELETEOUTCORDE\">";
						echo "</FORM></td>";
						echo "</tr>";
				}
				echo "<tr><td colspan=\"5\" align='right'>当天总计：</td>";
				echo "<td colspan=\"3\">".$total_money."</td></tr>";
		?>
		</TABLE>

<?PHP
		} elseif ($_POST['getrecordtype']  == 2 || $_SESSION['__gettype'] == "ADDINCORDE") {
?>
		<FORM  action="form_process.php" method="POST" >
			<?PHP 
			echo $_IN.": ";
			?>
				<SELECT NAME="in_mantype_id" size="1" >
				<?PHP
					$in_mantype_list = $Finance->getInOutType("_in_mantype");
					foreach( $in_mantype_list as $key => $value )
					{
						echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
					}

				?>
				</SELECT>
				<SELECT NAME="in_subtype_id" size="1" >
				<?PHP
					$in_subtype_list = $Finance->getInOutType("_in_subtype");
					foreach( $in_subtype_list as $key => $value )
					{
						echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
					}

				?>
				</SELECT>
				<BR>地点：
				<SELECT NAME="address_id" size="1" >
				<?PHP
					$address = $Finance->getInOutType("_address");
					foreach( $address as $key => $value )
					{
						echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
					}
				?>
				</SELECT>				
				<BR>
				<?PHP $Finance->NumList(); echo $_YUAN?>
				<BR><?PHP echo $_NOTES?><BR>
				<input type="text" name="notes" size="10" maxlength="50">
				<input type="hidden" name="addincorde" value="ADDINCORDE">
				<INPUT type="submit" value="<?PHP echo $_ADD_IN?>">
		</FORM>
		<BR>
			<TABLE border="1">
			  <tr>
				<th>序号</th>				
				<th>时间</th>
				<th>主类</th>
				<th>子类</th>
				<th>地点</th>
				<th>钱</th>
				<th>备注</th>	
				<th>操作</th>	

			  </tr>					
		<?PHP 	

				$total_money = 0;
	
				$result = $Finance->listInOutCorde("_in_corde");
				foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						$time = explode(" ",$value[8]);
						$total_money = $total_money + $value[1];

						echo "<tr>";
						echo "<td>".++$key1."</td>";
						echo "<td>".$time[1]."</td>";
						echo "<td>".$Finance->convertIdToNmae("_in_mantype",$value[4])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_in_subtype",$value[5])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[7]."</td>";
						echo "<td><FORM action=\"form_process.php\" method=\"POST\"  style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_ALTER.">";
						echo "<INPUT type=\"hidden\" name=\"in_corde_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"in_mantype_id\" value=".$value[4].">";
						echo "<INPUT type=\"hidden\" name=\"in_subtype_id\" value=".$value[5].">";
						echo "<INPUT type=\"hidden\" name=\"address_id\" value=".$value[6].">";
						echo "<INPUT type=\"hidden\" name=\"money\" value=".$value[8].">";
						echo "<INPUT type=\"hidden\" name=\"notes\" value=".$value[7].">";
						echo "<INPUT type=\"hidden\" name=\"alterincorde\" value=\"ALTERINCORDE\">";
						echo "</FORM>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_DELETE.">";
						echo "<INPUT type=\"hidden\" name=\"incorde_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"deleteincorde\" value=\"DELETEINCORDE\">";
						echo "</FORM></td>";
						echo "</tr>";
				}
				echo "<tr><td colspan=\"5\" align='right'>当天总计：</td>";
				echo "<td colspan=\"3\">".$total_money."</td></tr>";
		?>
		</TABLE>


<?PHP } ?>	
<?PHP require_once("tail.php");?>
	</BODY>
=======
<HTML>
	<?PHP require_once("head.php");?>
	<BODY>
	
<?PHP 
	if ( $_POST['getrecordtype']  == 1 || $_SESSION['__gettype'] == "ADDOUTCORDE")
	{
		echo "<FORM  name=\"myform\" action=\"form_process.php\" method=\"POST\" >";	
?>
<?PHP 
			echo $_OUT.": ";
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
								<?php 
								$num2 = count($forum_data2);
								?>
								onecount2=<?echo $num2;?>;
								<?
								for($j=0;$j<$num2;$j++)
								{
								?>
								subcat2[<?echo $j;?>] = new Array("<?echo $forum_data2[$j]['id'];?>","<?echo $forum_data2[$j]['man_id'];?>","<?echo $forum_data2[$j]['name'];?>");
								<?}?> 
								function changelocation(id) 
								{ 
								document.myform.city.length = 0; 
								var id=id; 
								var j; 
								document.myform.city.options[0] = new Option('选择子类',''); 
								for (j=0;j < onecount2; j++) 
								{ 
								if (subcat2[j][1] == id) 
								   { 
								   document.myform.city.options[document.myform.city.length] = new Option(subcat2[j][2], subcat2[j][0]); 
								   } 
								} 
								}
								</script> 

								<!--********************页面表单*************************-->
								<select name="bigClass" onChange="changelocation(document.myform.bigClass.options[document.myform.bigClass.selectedIndex].value)" size="1"> 
								<option selected>选择主类</option> 
								   
								<?php 
								$num = count($forum_data);

								for($i=0;$i<$num;$i++)
								{
								?>
								<option value="<?echo $forum_data[$i]['id'];?>"><?echo $forum_data[$i]['name'];?></option> 
								<? 
								}
								?>
								</select>
								<select name="city" size="1"> 
								<option selected value="">选择子类</option> 
								</select>
				<BR>地点：
				<SELECT NAME="address_id" size="1" >
				<?PHP
					$address = $Finance->getInOutType("_address");
					foreach( $address as $key => $value )
					{
						echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
					}
				?>
				</SELECT>				
				<BR>
				<?PHP $Finance->NumList(); echo $_YUAN?>
				<BR><?PHP echo $_NOTES?><BR>
				<input type="text" name="notes" size="10" maxlength="50">
				<input type="hidden" name="addoutcorde" value="ADDOUTCORDE">
				<INPUT type="submit" value="<?PHP echo $_ADD_OUT?>">
				</FORM>
		<BR>
			<TABLE border="1">
			  <tr>
				<th>序号</th>				
				<th>时间</th>
				<th>主类</th>
				<th>子类</th>
				<th>地点</th>
				<th>钱</th>
				<th>备注</th>	
				<th>操作</th>	

			  </tr>					
		<?PHP 	

				$total_money = 0;
	
				$result = $Finance->listInOutCorde("_out_corde");
				foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						$time = explode(" ",$value[8]);
						$total_money = $total_money + $value[1];

						echo "<tr>";
						echo "<td>".++$key1."</td>";
						echo "<td>".$time[1]."</td>";
						echo "<td>".$Finance->convertIdToNmae("_out_mantype",$value[4])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_out_subtype",$value[5])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[7]."</td>";
						echo "<td><FORM action=\"form_process.php\" method=\"POST\"  style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_ALTER.">";
						echo "<INPUT type=\"hidden\" name=\"out_corde_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"out_mantype_id\" value=".$value[4].">";
						echo "<INPUT type=\"hidden\" name=\"out_subtype_id\" value=".$value[5].">";
						echo "<INPUT type=\"hidden\" name=\"address_id\" value=".$value[6].">";
						echo "<INPUT type=\"hidden\" name=\"money\" value=".$value[8].">";
						echo "<INPUT type=\"hidden\" name=\"notes\" value=".$value[7].">";
						echo "<INPUT type=\"hidden\" name=\"alteroutcorde\" value=\"ALTEROUTCORDE\">";
						echo "</FORM>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_DELETE.">";
						echo "<INPUT type=\"hidden\" name=\"outcorde_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"deleteoutcorde\" value=\"DELETEOUTCORDE\">";
						echo "</FORM></td>";
						echo "</tr>";
				}
				echo "<tr><td colspan=\"5\" align='right'>当天总计：</td>";
				echo "<td colspan=\"3\">".$total_money."</td></tr>";
		?>
		</TABLE>

<?PHP
		} elseif ($_POST['getrecordtype']  == 2 || $_SESSION['__gettype'] == "ADDINCORDE") {
?>
		<FORM  action="form_process.php" method="POST" >
			<?PHP 
			echo $_IN.": ";
			?>
				<SELECT NAME="in_mantype_id" size="1" >
				<?PHP
					$in_mantype_list = $Finance->getInOutType("_in_mantype");
					foreach( $in_mantype_list as $key => $value )
					{
						echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
					}

				?>
				</SELECT>
				<SELECT NAME="in_subtype_id" size="1" >
				<?PHP
					$in_subtype_list = $Finance->getInOutType("_in_subtype");
					foreach( $in_subtype_list as $key => $value )
					{
						echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
					}

				?>
				</SELECT>
				<BR>地点：
				<SELECT NAME="address_id" size="1" >
				<?PHP
					$address = $Finance->getInOutType("_address");
					foreach( $address as $key => $value )
					{
						echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
					}
				?>
				</SELECT>				
				<BR>
				<?PHP $Finance->NumList(); echo $_YUAN?>
				<BR><?PHP echo $_NOTES?><BR>
				<input type="text" name="notes" size="10" maxlength="50">
				<input type="hidden" name="addincorde" value="ADDINCORDE">
				<INPUT type="submit" value="<?PHP echo $_ADD_IN?>">
		</FORM>
		<BR>
			<TABLE border="1">
			  <tr>
				<th>序号</th>				
				<th>时间</th>
				<th>主类</th>
				<th>子类</th>
				<th>地点</th>
				<th>钱</th>
				<th>备注</th>	
				<th>操作</th>	

			  </tr>					
		<?PHP 	

				$total_money = 0;
	
				$result = $Finance->listInOutCorde("_in_corde");
				foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						$time = explode(" ",$value[8]);
						$total_money = $total_money + $value[1];

						echo "<tr>";
						echo "<td>".++$key1."</td>";
						echo "<td>".$time[1]."</td>";
						echo "<td>".$Finance->convertIdToNmae("_in_mantype",$value[4])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_in_subtype",$value[5])."</td>";
						echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[7]."</td>";
						echo "<td><FORM action=\"form_process.php\" method=\"POST\"  style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_ALTER.">";
						echo "<INPUT type=\"hidden\" name=\"in_corde_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"in_mantype_id\" value=".$value[4].">";
						echo "<INPUT type=\"hidden\" name=\"in_subtype_id\" value=".$value[5].">";
						echo "<INPUT type=\"hidden\" name=\"address_id\" value=".$value[6].">";
						echo "<INPUT type=\"hidden\" name=\"money\" value=".$value[8].">";
						echo "<INPUT type=\"hidden\" name=\"notes\" value=".$value[7].">";
						echo "<INPUT type=\"hidden\" name=\"alterincorde\" value=\"ALTERINCORDE\">";
						echo "</FORM>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_DELETE.">";
						echo "<INPUT type=\"hidden\" name=\"incorde_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"deleteincorde\" value=\"DELETEINCORDE\">";
						echo "</FORM></td>";
						echo "</tr>";
				}
				echo "<tr><td colspan=\"5\" align='right'>当天总计：</td>";
				echo "<td colspan=\"3\">".$total_money."</td></tr>";
		?>
		</TABLE>


<?PHP } ?>	
<?PHP require_once("tail.php");?>
	</BODY>
>>>>>>> e79fba4c37b2c02476590015a5952175b7fd5b25
</HTML>