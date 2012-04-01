<HTML>
    </BODY>
       <?PHP 
       $sendphone = isset($_POST['sendphone']) ? $_POST['sendphone'] : '';
       $sendpwd = isset($_POST['sendpwd']) ? $_POST['sendpwd'] : '';
       $reciphone = isset($_POST['reciphone']) ? $_POST['reciphone'] : '';
       $message = isset($_POST['message']) ? $_POST['message'] : '';
       $issend = isset($_POST['issend']) ? $_POST['issend'] : '';
          require_once("head.php");
	?>

        <fieldset>
	<legend>&nbsp;短信发送:&nbsp;</legend>
	<FORM action="task.php" method="post" >
	   <TABLE border="0">
	      <TR>
	         <TD><?PHP echo $_SENDPHONE." :"?></TD>
	         <TD> <input type="text" name="sendphone" size="12" maxlength="20"></TD>
	      </TR>
	      <TR>
	         <TD><?PHP echo $_SENDPWD." :"?></TD>
	         <TD> <input type="password" name="sendpwd" size="12" maxlength="20"></TD>
	      </TR>
	      <TR>
	         <TD><?PHP echo $_RECIPHONE." :"?></TD>
	         <TD><input type="text" name="reciphone" size="12" maxlength="20"></TD>
	      </TR>
	      <TR>
	         <TD><?PHP echo $_MESSAGE." :"?></TD>
	         <TD><input type="text" name="message" size="12" maxlength="20"></TD>
	      </TR>
	  </TABLE>
	 <INPUT type="hidden" name="issend" value="1">
	 <INPUT type="submit" value="<?PHP echo $_SEND?>">
      </FORM>
      </fieldset>
    <?PHP
    	if ( $issend == "1" ) {
	    $url = "http://sms.api.bz/fetion.php?username=".$sendphone."&password=".$sendpwd."&sendto=".$reciphone."&message=".$message;
	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=".$url."\">";
	}
    ?>
    <?PHP
       require_once("tail.php");
    ?>
    </BODY>
</HTML>
