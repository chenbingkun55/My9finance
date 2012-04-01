<?PHP 
	if( $_SESSION['__gettype'] == "ALTERUSER" ||  $_SESSION['__useralive'][0] != 1)
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



				$sql = "INSERT INTO ".$this->_out_subtype." (id,user_id,store,is_display,name,create_date)   VALUES  ('','".$user_id."','1','1','衣','".date("Y-m-d H:i:s")."'),('','".$user_id."','2','1','食','".date("Y-m-d H:i:s")."'),('','".$user_id."','3','1','住','".date("Y-m-d H:i:s")."'),('','".$user_id."','4','1','行','".date("Y-m-d H:i:s")."')";
			$this->insert($sql);