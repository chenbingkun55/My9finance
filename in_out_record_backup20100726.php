<HTML>
	<?PHP require_once("head.php");?>
	<BODY>
	
<?PHP 
	if ( $_POST['getrecordtype']  == 1 || $_SESSION['__gettype'] == "ADDOUTCORDE")
	{
?>
		<FORM  action="form_process.php" method="POST" >
			<?PHP 
			echo $_OUT.": ";
			?>
				<SELECT NAME="out_mantype_id" size="1" >
				<?PHP
					$out_mantype_list = $Finance->getInOutType("_out_mantype");
					foreach( $out_mantype_list as $key => $value )
					{
						echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
					}

				?>
				</SELECT>
				<SELECT NAME="out_subtype_id" size="1" >
				<?PHP
					$out_subtype_list = $Finance->getInOutType("_out_subtype");
					foreach( $out_subtype_list as $key => $value )
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
</HTML>