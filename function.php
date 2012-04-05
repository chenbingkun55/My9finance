<<<<<<< HEAD
<HTML>
<?PHP
		require_once("head.php");
		$_SESSION['__gettype'] = "";

?>
	<script>   
         function formSubmit1(){    
			 document.actionForm1.action = "function_type.php";    
             document.actionForm1.submit();    
         }    
		 function formSubmit2(){    
			 document.actionForm2.action = "function_type.php";    
             document.actionForm2.submit();    
         } 
		 function formSubmit3(){    
			 document.actionForm3.action = "function_add_group.php";    
             document.actionForm3.submit();    
         } 
        </script>
<BODY>

			<FORM name="actionForm1" method="POST" style="display: inline;">
			<INPUT type="hidden" name="getmantype" value="1">
				1.  <a href="javascript:formSubmit1()"><?PHP echo $_IN.$_LISTTYPE;?></a>
			</FORM>
				<FONT color="#0000CC">/</FONT>
			<FORM name="actionForm2" method="POST" style="display: inline;">
				<INPUT type="hidden" name="getmantype" value="2">
				<a href="javascript:formSubmit2()"><?PHP echo $_OUT.$_LISTTYPE;?></a>
			</FORM>
</a><br>
<?PHP 
		if(  $_SESSION['__useralive'][0] == 1 )
		{
				echo "2. <a href=\"function_log.php\">".$_LIST_LOG_RESOLVE."</a><br>";
				echo "3. <a href=\"function_addr.php\">".$_LIST_ADDRESS."</a><br>";
				echo "4. <a href=\"function_user.php\">". $_LIST_USER."</a><br>";
				echo "5. <a href=\"function_group.php\">".$_LIST_GROUP."</a><br>";
		} else {
				echo "2. <a href=\"function_addr.php\">".$_LIST_ADDRESS."</a><br>";
				echo "3. <a href=\"function_user.php\">".$_ALTER_USER."</a><br>";
				if($Finance->getGroupAdmin())
				{
					echo "<FORM name=\"actionForm3\" method=\"POST\" style=\"display: inline;\">";
					echo "<INPUT type=\"hidden\" name=\"list_member\" value=\"LISTMEMBER\">";
					echo "4. <a href=\"javascript:formSubmit3()\">".$_LIST_GROUP."</a>";
					echo "</FORM>";
				} else {
					echo "4. <a href=\"function_add_group.php\">".$_ADD_EXIT_GROUP."</a><br>";
				}
		}
?>
<BR>
	<?PHP require_once("tail.php");?>
</BODY>
</HTML>
=======
<HTML>
<?PHP
		require_once("head.php");
		$_SESSION['__gettype'] = "";

?>
	<script>   
         function formSubmit1(){    
			 document.actionForm1.action = "function_type.php";    
             document.actionForm1.submit();    
         }    
		 function formSubmit2(){    
			 document.actionForm2.action = "function_type.php";    
             document.actionForm2.submit();    
         } 
		 function formSubmit3(){    
			 document.actionForm3.action = "function_add_group.php";    
             document.actionForm3.submit();    
         } 
        </script>
<BODY>

			<FORM name="actionForm1" method="POST" style="display: inline;">
			<INPUT type="hidden" name="getmantype" value="1">
				1.  <a href="javascript:formSubmit1()"><?PHP echo $_IN.$_LISTTYPE;?></a>
			</FORM>
				<FONT color="#0000CC">/</FONT>
			<FORM name="actionForm2" method="POST" style="display: inline;">
				<INPUT type="hidden" name="getmantype" value="2">
				<a href="javascript:formSubmit2()"><?PHP echo $_OUT.$_LISTTYPE;?></a>
			</FORM>
</a><br>
<?PHP 
		if(  $_SESSION['__useralive'][0] == 1 )
		{
				echo "2. <a href=\"function_log.php\">".$_LIST_LOG_RESOLVE."</a><br>";
				echo "3. <a href=\"function_addr.php\">".$_LIST_ADDRESS."</a><br>";
				echo "4. <a href=\"function_user.php\">". $_LIST_USER."</a><br>";
				echo "5. <a href=\"function_group.php\">".$_LIST_GROUP."</a><br>";
		} else {
				echo "2. <a href=\"function_addr.php\">".$_LIST_ADDRESS."</a><br>";
				echo "3. <a href=\"function_user.php\">".$_ALTER_USER."</a><br>";
				if($Finance->getGroupAdmin())
				{
					echo "<FORM name=\"actionForm3\" method=\"POST\" style=\"display: inline;\">";
					echo "<INPUT type=\"hidden\" name=\"list_member\" value=\"LISTMEMBER\">";
					echo "4. <a href=\"javascript:formSubmit3()\">".$_LIST_GROUP."</a>";
					echo "</FORM>";
				} else {
					echo "4. <a href=\"function_add_group.php\">".$_ADD_EXIT_GROUP."</a><br>";
				}
		}
?>
<BR>
	<?PHP require_once("tail.php");?>
</BODY>
</HTML>
>>>>>>> e79fba4c37b2c02476590015a5952175b7fd5b25
