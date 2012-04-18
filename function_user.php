<HTML>
	<?PHP require_once("head.php");?>
<BODY>
<?PHP 
	if( $_SESSION['__gettype'] == "ALTERUSER" ||  $_SESSION['__useralive'][0] != 1 )
	{
			if (empty($_SESSION['__gettype_id']))
			{
					$_SESSION['__gettype_id'] = $_SESSION['__useralive'][0]   ;
			} 
			$result = $Finance->drawUserID($_SESSION['__gettype_id']);
			foreach( $result  as  $key => $value )
			{
?>
				<FORM action="form_process.php" method="POST" >
					<TABLE border="0">
					<TR>
						<TD><?PHP echo $_USER_NAME ?>:</TD>
						<TD><input type="text" name="user_name" size="12" maxlength="20" value = "<?PHP echo $value['1'] ?>"></TD>
					</TR>
					<TR>
						<TD><?PHP echo $_USER_ALIAS ?>:</TD>
						<TD><input type="text" name="user_alias" size="12" maxlength="20" value = "<?PHP echo $value['2']?>"></TD>
					</TR>
					<TR>
						<TD><?PHP echo $_USER_PASSWORD ?>:</TD>
						<TD><input type="password" name="user_password" size="11" maxlength="20"></TD>
					</TR>
					<TR>
						<TD><?PHP echo $_NOTES ?>:</TD>
						<TD><input type="text" name="notes" size="12" maxlength="20" value = "<?PHP echo $value['4']?>"></TD>
					</TR>
				<?PHP 
					if ($_SESSION['__useralive'][0] == 1)
					{
				?>
					<TR>
						<TD><?PHP echo $_RESIDE_GROUP ?>:</TD>
						<TD>
						<SELECT NAME="group_id" size="1" >
						<?PHP
							$result = $Finance->getGroupList();
							foreach( $result  as  $key => $value )
							{
								echo "<option value=".$value['0'].">".$value['1']."</option>\n";
							}
						?>
						</SELECT>
					</TR>
					<?PHP } ?>
					<TR>
						<TD COLSPAN="2" align="center">
						<input type="hidden" name="alteruser" value="ALTERUSER">
						<input type="hidden" name="user_password_old" value="<?PHP echo $value['3']?>">
						<INPUT type="hidden" name="alteractive" value="1">
						<INPUT type="submit" value="<?PHP echo $_ALTER_USER?>">
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
			<TD><?PHP echo $_USER_NAME ?>:</TD>
			<TD><input type="text" name="user_name" size="12" maxlength="20"></TD>
		</TR>
		<TR>
			<TD><?PHP echo $_USER_ALIAS ?>:</TD>
			<TD><input type="text" name="user_alias" size="12" maxlength="20"></TD>
		</TR>
		<TR>
			<TD><?PHP echo $_USER_PASSWORD ?>:</TD>
			<TD><input type="password" name="user_password" size="11" maxlength="20"></TD>
		</TR>
		<TR>
			<TD><?PHP echo $_NOTES ?>:</TD>
			<TD><input type="text" name="notes" size="12" maxlength="20"></TD>
		</TR>
		<TR>
			<TD><?PHP echo $_RESIDE_GROUP ?>:</TD>
			<TD>
			<SELECT NAME="group_id" size="1" >
			<?PHP
				$result = $Finance->getGroupList();
				foreach( $result  as  $key => $value )
				{
					echo "<option value=".$value['0'].">".$value['1']."</option>\n";
				}
			?>
			</SELECT>
			</TD>
		</TR>
		<TR>
			<TD COLSPAN="2" align="center">
			<input type="hidden" name="adduser" value="ADDUSER">
			<INPUT type="submit" value="<?PHP echo $_ADD_USER?>">
			</TD>
		</TR>
		</TABLE>

	</FORM>
			<TABLE border="1">
			  <tr>
				<th>序号</th>
				<th>用户名</th>
				<th>家庭</th>
				<th>个性名</th>
				<th>备注</th>
				<th>最后登录时间</th>
				<th>操作</th>
			  </tr>					
		<?PHP 	
				$result = $Finance->getUserList();
				foreach( $result  as  $key => $value )
				{
						$key1 = $key;

						echo "<tr>";
						echo "<td>".++$key1."</td>";
						echo "<td>".$value[1]."</td>";
						$group_name = $Finance->convertGroupAliasID($Finance->getUserResideGroup($value[0]));
						if(empty($group_name['1']))
						{
							echo "<td>".$group_name['0']."</td>";
						} else {
							echo "<td>".$group_name['1']."</td>";
						}
						echo "<td>".$value[2]."</td>";
						echo "<td>".$value[4]."</td>";
						echo "<td>".$value[6]."</td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<td><INPUT  TYPE=\"submit\" value=".$_ALTER.">";
						echo "<INPUT type=\"hidden\" name=\"user_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"alteruser\" value=\"ALTERUSER\">";
						echo "</FORM>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_DELETE.">";
						echo "<INPUT type=\"hidden\" name=\"user_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"deleteuser\" value=\"DELETEUSER\">";
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