<HTML>
	<?PHP require_once("head.php");?>
<BODY>
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
						<INPUT type="hidden" name="registr_user" value="REGISTRUSER">
						<INPUT type="submit" value="<?PHP echo $_REGISTR?>">
						</TD>
					</TR>
					</TABLE>
				</FORM>
	<?PHP require_once("tail.php");?>
</BODY>
</HTML>
