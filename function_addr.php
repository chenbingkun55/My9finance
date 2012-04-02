<HTML>
	<?PHP require_once("head.php");?>
<BODY>
<?PHP 
	if( $_SESSION['__gettype'] == "ALTERADDRESS")
	{
?>
	<FORM action="form_process.php" method="POST" >
		原地址："<?PHP echo $Finance->convertIdToNmae("_address",$_SESSION['__gettype_id'] )?>"
		,更改为
		<?PHP echo $_ADDR_NAME ?>: <input type="text" name="addr_name" size="12" maxlength="20" value="<?PHP echo $Finance->convertIdToNmae("_address",$_SESSION['__gettype_id'] )?>">
			,是否显示
			<?PHP
				$is_display = $Finance->getIsDisplay("_address",$_SESSION['__gettype_id']);
				$is_display['0']['0'] ? $checked = "checked=\"checked\"" : $checked="" ;
			?>
			<INPUT TYPE="checkbox" <?PHP echo $checked?> name="is_display" >
		<input type="hidden" name="addaddress" value="ALTERADDRESS">
		<INPUT type="hidden" name="alteractive" value="1">
		<INPUT type="hidden" name="address_id" value="<?PHP echo $_SESSION['__gettype_id']?>">
		<INPUT type="submit" value="<?PHP echo $_ALTER?>">
	</FORM>

<?PHP } else { ?>
	<FORM action="form_process.php" method="POST" >
		<?PHP echo $_ADDR_NAME ?>: <input type="text" name="addr_name" size="12" maxlength="20">
					,是否显示
			<INPUT TYPE="checkbox" checked="checked" name="is_display" >
		<input type="hidden" name="addaddress" value="ADDADDRESS">
		<INPUT type="submit" value="<?PHP echo $_ADD_ADDR?>">
	</FORM>
			<TABLE border="1">
			  <tr>
				<th >序号</th>
				<th >显示</th>
				<th >名称</th>
				<th >排序</th>
				<th>地址操作</th>
			  </tr>					
		<?PHP 	
				$result = $Finance->getAddress();
				foreach( $result  as  $key => $value )
				{
						$key1 = $key;

						echo "<tr>";
						
						echo "<td>".++$key1."</td>";
						echo "<td>";
						echo $value[3] == "1" ? "是":"--";
						echo "</td>";
						echo "<td>".$value[4]."</td>";

						echo "<td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value= \"上\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_front\" value=\"TAXISADDRFRONT\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_table\" value=\"_address\">";
						echo "<INPUT type=\"hidden\" name=\"store\" value=".$value[2].">";
						echo "</FORM>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value= \"下\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_after\" value=\"TAXISADDRAFTER\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_table\" value=\"_address\">";
						echo "<INPUT type=\"hidden\" name=\"store\" value=".$value[2].">";
						echo "</FORM></td>";

						echo "<td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_ALTER.">";
						echo "<INPUT type=\"hidden\" name=\"address_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"addaddress\" value=\"ALTERADDRESS\">";
						echo "</FORM>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_DELETE.">";
						echo "<INPUT type=\"hidden\" name=\"address_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"deleteaddress\" value=\"DELETEADDRESS\">";
						echo "</FORM></td>";
						echo "</tr>";
				}
		?>
		</TABLE>
	<?PHP }?>
	<?PHP require_once("tail.php");?>
</BODY>
</HTML>