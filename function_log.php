<HTML>
	<?PHP require_once("head.php");?>
<BODY>
<?PHP 
		if( $_SESSION['__gettype'] == "ALTERLOG") 
		{
	?>
	log level定义：<BR>
	1. ERROR	log_id   1-1999<BR>
	2. WAIN		log_id   2000-4999<BR>
	3. INFO		log_id	 5000-9999<BR>
		<FORM  action="form_process.php" method="post" >
		
			<?PHP echo $_LOG_ID ?>: <input type="text" name="log_id" size="12" maxlength="20" value = "<?PHP echo $_SESSION['__gettype_id'] ?>"><BR>
			<?PHP echo $_LOG_CONTENT ?>: <input type="text" name="content" size="12" maxlength="50" value = "<?PHP  echo $Finance->convertLogIdToContent($_SESSION['__gettype_id'] )?>"><BR>
			<INPUT type="hidden" name="alterlog" value="ALTERLOG">
			<INPUT type="hidden" name="alteractive" value="1">
			<INPUT type="submit" value="<?PHP echo $_ALTER_LOG_RESOLVE?>">
		</FORM>


<?PHP
		} else {
?>
	log level定义：<BR>
	1. ERROR	log_id   1-1999<BR>
	2. WAIN		log_id   2000-4999<BR>
	3. INFO		log_id	 5000-9999<BR>
		<FORM action="form_process.php" method="post" >
			<?PHP echo $_LOG_ID ?>: <input type="text" name="log_id" size="12" maxlength="20"><BR>
			<?PHP echo $_LOG_CONTENT ?>: <input type="text" name="content" size="12" maxlength="20"><BR>
			<INPUT type="hidden" name="addlog" value="ADDLOG">
			<INPUT type="submit"  value="<?PHP echo $_ADD_LOG_RESOLVE?>">
		</FORM>

				<TABLE border="1">
					  <tr>
						<th >序号</th>
						<th >日志ID</th>
						<th >名称</th>
						<th >操作</th>
					  </tr>					
	<?PHP 
				$result = $Finance->getLogContentList();
				foreach( $result  as  $key => $value )
				{
						$key1 = $key;

						echo "<tr>";
						echo "<td>".++$key1."</td>";
						echo "<td>".$value[1]."</td>";
						echo "<td>".$value[2]."</td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<td><INPUT  TYPE=\"submit\" value=".$_ALTER.">";
						echo "<INPUT type=\"hidden\" name=\"id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"log_id\" value=".$value[1].">";
						echo "<INPUT type=\"hidden\" name=\"alterlog\" value=\"ALTERLOG\">";
						echo "</FORM>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_DELETE.">";
						echo "<INPUT type=\"hidden\" name=\"id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"deletelog\" value=\"DELETELOG\">";
						echo "</FORM>";
						echo "</td>";
						echo "</tr>";
				}
			}
		?>
		</TABLE>

	<?PHP require_once("tail.php");?>
</BODY>
</HTML>