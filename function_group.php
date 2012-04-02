<HTML>
	<?PHP require_once("head.php");?>
<BODY>
<?PHP 
	if( $_SESSION['__gettype'] == "ALTERGROUP" ||  $_SESSION['__useralive'][0] != 1)
	{
			if (empty($_SESSION['__gettype_id']))
			{
					$_SESSION['__gettype_id'] = "1"   ;
			} 
			$result = $Finance->drawGroupID($_SESSION['__gettype_id']);
			foreach( $result  as  $key => $value )
			{
?>
				<FORM action="form_process.php" method="POST" >
					<TABLE border="0">
					<TR>
						<TD><?PHP echo $_GROUP_NAME ?>:</TD>
						<TD><input type="text" name="group_name" size="12" maxlength="20" value = "<?PHP echo $value['1'] ?>"></TD>
					</TR>
					<TR>
						<TD><?PHP echo $_GROUP_ALIAS ?>:</TD>
						<TD><input type="text" name="group_alias" size="12" maxlength="20" value = "<?PHP echo $value['2']?>"></TD>
					</TR>
					<TR>
						<TD><?PHP echo $_GROUP_PASSWORD ?>:</TD>
						<TD><input type="password" name="group_password" size="11" maxlength="20"></TD>
					</TR>
					<TR>
						<TD><?PHP echo $_NOTES ?>:</TD>
						<TD><input type="text" name="notes" size="12" maxlength="20" value = "<?PHP echo $value['5']?>"></TD>
					</TR>
					<TR>
						<TD COLSPAN="2" align="center">
						<input type="hidden" name="altergroup" value="ALTERGROUP">
						<input type="hidden" name="group_password_old" value="<?PHP echo $value['3']?>">
						<INPUT type="hidden" name="alteractive" value="1">
						<INPUT type="hidden" name="group_id" value="<?PHP echo $value['0']?>">
						<INPUT type="submit" value="<?PHP echo $_ALTER_GROUP?>">
						</TD>
					</TR>
					</TABLE>
				</FORM>
<?PHP
			}
	} else { ?>

	<FORM action="form_process.php" method="POST" >
		<TABLE border="0">
		<TR>
			<TD><?PHP echo $_GROUP_NAME ?>:</TD>
			<TD><input type="text" name="group_name" size="12" maxlength="20"></TD>
		</TR>
		<TR>
			<TD><?PHP echo $_GROUP_ALIAS ?>:</TD>
			<TD><input type="text" name="group_alias" size="12" maxlength="20"></TD>
		</TR>
		<TR>
			<TD><?PHP echo $_GROUP_PASSWORD ?>:</TD>
			<TD><input type="password" name="group_password" size="11" maxlength="20"></TD>
		</TR>
		<TR>
			<TD><?PHP echo $_NOTES ?>:</TD>
			<TD><input type="text" name="notes" size="12" maxlength="20"></TD>
		</TR>
		<TR>
			<TD COLSPAN="2" align="center">
			<input type="hidden" name="addgroup" value="ADDGROUP">
			<INPUT type="submit" value="<?PHP echo $_ADD_GROUP?>">
			</TD>
		</TR>
		</TABLE>
	</FORM>
			<TABLE border="1">
			  <tr>
				<th>序号</th>
				<th>组名</th>
				<th>个性名</th>
				<th>备注</th>
				<th>操作</th>
			  </tr>					
		<?PHP 	
				$result = $Finance->getGroupList();
				foreach( $result  as  $key => $value )
				{
						$key1 = $key;

						echo "<tr>";
						echo "<td>".++$key1."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[2]."</td>";
						echo "<td>".$value[5]."</td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<td><INPUT  TYPE=\"submit\" value=".$_ALTER.">";
						echo "<INPUT type=\"hidden\" name=\"group_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"altergroup\" value=\"ALTERGROUP\">";
						echo "</FORM>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_DELETE.">";
						echo "<INPUT type=\"hidden\" name=\"group_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"deletegroup\" value=\"DELETEGROUP\">";
						echo "</FORM>";
						echo "</td>";
						echo "</tr>";
				}
		?>
		</TABLE>

<?PHP }?>
	<?PHP require_once("tail.php");?>
</BODY>
</HTML>