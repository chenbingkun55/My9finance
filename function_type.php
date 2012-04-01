<HTML>
		<?PHP 
			require_once("head.php");
			$getmantype = isset($_POST["getmantype"]) ? $_POST["getmantype"]:'' ;
		?>
	<BODY>

<?PHP	
		if( $getmantype == 1 || $_SESSION['__gettype'] == "ADDINMANTYPE") 
		{
?>
		<FORM action="form_process.php" method="POST">
			<?PHP echo $_ADD . $_ADDMANTYPE. $_IN . $_TYPE ?>
			名称
			<input type="text" name="addmantypename" size="6" maxlength="10">
			,是否显示
			<INPUT TYPE="checkbox" checked="checked" name="is_display" >
			<INPUT type="hidden" name="addmantype" value="ADDINMANTYPE">
			<INPUT  TYPE="submit" value="<?PHP echo $_ADD?>">
		</FORM>
			<BR>
			<TABLE  border="1">
			  <tr>
				<th width = \"10%\">序号</th>
				<th width = \"10%\">显示</th>
				<th width = \"30%\">名称</th>
				<th width = \"10%\">排序</th>
				<th colspan="2" width = \"20%\">主类操作</th>
				<th width = \"20%\">子类操作</th>
			  </tr>					
		<?PHP 	
				$result = $Finance->getInOutType("_in_mantype");
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
						echo "<INPUT type=\"hidden\" name=\"taxis_front\" value=\"TAXISMANFRONT\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_table\" value=\"_in_mantype\">";
						echo "<INPUT type=\"hidden\" name=\"store\" value=".$value[2].">";
						echo "</FORM>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value= \"下\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_after\" value=\"TAXISMANAFTER\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_table\" value=\"_in_mantype\">";
						echo "<INPUT type=\"hidden\" name=\"store\" value=".$value[2].">";
						echo "</FORM></td>";

						echo "<td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_ALTER.">";
						echo "<INPUT type=\"hidden\" name=\"in_mantype_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"alterinmantype\" value=\"ALTERINMANTYPE\">";
						echo "</FORM></td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<td><INPUT  TYPE=\"submit\" value=".$_DELETE.">";
						echo "<INPUT type=\"hidden\" name=\"in_mantype_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"deleteinmantype\" value=\"DELETEINMANTYPE\">";
						echo "</FORM></td>";
						echo "<td><FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_LISTSUBTYPE.">";
						echo "<INPUT type=\"hidden\" name=\"in_mantype_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"addinsubtype\" value=\"ADDINSUBTYPE\">";
						echo "</FORM></td>";
						echo "</tr>";

				}
		?>
		</TABLE>

<?PHP
		} elseif ( $_SESSION['__gettype'] == "ALTERINMANTYPE") {
	?>

		<FORM action="form_process.php" method="POST">
			<?PHP echo $_ALTER . $_ADDMANTYPE. $_IN . $_TYPE; ?>
			名称
			<input type="text" name="altermantypename" size="6" maxlength="10" value="<?echo $Finance->convertIdToNmae("_in_mantype",$_SESSION['__gettype_id'])?>">
			<?PHP echo "原名称 \"".$Finance->convertIdToNmae("_in_mantype",$_SESSION['__gettype_id'])."\",是否显示";?>
			<?PHP
				$is_display = $Finance->getIsDisplay("_in_mantype",$_SESSION['__gettype_id']);
				$is_display['0']['0'] ? $checked = "checked=\"checked\"" : $checked="" ;
			?>
			<INPUT TYPE="checkbox" <?PHP echo $checked?> name="is_display" >
			<INPUT type="hidden" name="alterinmantype" value="ALTERINMANTYPE">
			<INPUT type="hidden" name="in_mantype_id" value="<?PHP echo $_SESSION['__gettype_id']?>">
			<INPUT type="hidden" name="alteractive" value="1">
			<INPUT TYPE="submit" value="<?PHP echo $_ALTER?>">
		</FORM>


<?PHP
		} elseif ( $_SESSION['__gettype'] == "ADDINSUBTYPE") {
	?>

		<FORM action="form_process.php" method="POST">
			<?PHP echo $_ADD . $_ADDSUBTYPE. $_IN . $_TYPE ?>
			名称
			<input type="text" name="addsubtypename" size="6" maxlength="10">
			,所属主类<?PHP  echo " \"".$Finance->convertIdToNmae("_in_mantype",$_SESSION['__gettype_id'])."\" "?>是否显示
			<INPUT TYPE="checkbox" checked="checked" name="is_display" >
			<INPUT type="hidden" name="addinsubtype" value="ADDINSUBTYPE">
			<INPUT type="hidden" name="in_mantype_id" value="<?PHP echo $_SESSION['__gettype_id']?>">
			<INPUT type="hidden" name="alteractive" value="1">
			<INPUT TYPE="submit" value="<?PHP echo $_ADD?>">
		</FORM>
		<BR>
			<TABLE border="1">
			  <tr>
				<th width = \"10%\">序号</th>
				<th width = \"10%\">所属主类</th>
				<th width = \"10%\">显示</th>
				<th width = \"20%\">名称</th>
				<th width = \"10%\">排序</th>
				<th colspan="2" width = \"25%\">子类操作</th>
			  </tr>					
		<?PHP 	
				$result = $Finance->getSubType("_in_subtype",$_SESSION['__gettype_id']);
				foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						
						echo "<tr>";
						echo "<td>".++$key1."</td>";
						echo "<td>".$Finance->convertIdToNmae("_in_mantype",$_SESSION['__gettype_id'])."</td>";
						echo "<td>";
						echo $value[4] == "1" ? "是":"--";
						echo "</td>";
						echo "<td>".$value[5]."</td>";
						echo "<td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value= \"上\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_front\" value=\"TAXISSUBFRONT\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_table\" value=\"_in_subtype\">";
						echo "<INPUT type=\"hidden\" name=\"store\" value=".$value[3].">";
						echo "<INPUT type=\"hidden\" name=\"mantype_id\" value=\"".$_SESSION['__gettype_id']."\">";
						echo "</FORM>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value= \"下\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_after\" value=\"TAXISSUBAFTER\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_table\" value=\"_in_subtype\">";
						echo "<INPUT type=\"hidden\" name=\"store\" value=".$value[3].">";
						echo "<INPUT type=\"hidden\" name=\"mantype_id\" value=\"".$_SESSION['__gettype_id']."\">";
						echo "</FORM></td>";

						echo "<td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_ALTER.">";
						echo "<INPUT type=\"hidden\" name=\"in_subtype_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"in_mantype_id\" value=\"".$_SESSION['__gettype_id']."\">";
						echo "<INPUT type=\"hidden\" name=\"alterinsubtype\" value=\"ALTERINSUBTYPE\">";
						echo "</FORM></td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<td><INPUT  TYPE=\"submit\" value=".$_DELETE.">";
						echo "<INPUT type=\"hidden\" name=\"in_subtype_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"deleteinsubtype\" value=\"DELETEINSUBTYPE\">";
						echo "</FORM></td>";
						echo "</tr>";
				}
		?>
		</TABLE>

<?PHP
		} elseif ( $_SESSION['__gettype'] == "ALTERINSUBTYPE") {
	?>

		<FORM action="form_process.php" method="POST">
			<?PHP echo $_ALTER . $_IN. $_ADDSUBTYPE . $_TYPE; ?>
			名称
			<input type="text" name="altersubtypename" size="6" maxlength="10" value="<?PHP echo $Finance->convertIdToNmae("_in_subtype",$_SESSION['__getsubtype_id'])?>">
			<?PHP echo "原属主类 \"".$Finance->convertIdToNmae("_in_mantype",$_SESSION['__gettype_id'])."\" "?>
			<?PHP echo "原名称 \"".$Finance->convertIdToNmae("_in_subtype",$_SESSION['__getsubtype_id'])."\",是否显示";?>
			<?PHP
				$is_display = $Finance->getIsDisplay("_in_subtype",$_SESSION['__getsubtype_id']);
				$is_display['0']['0'] ? $checked = "checked=\"checked\"" : $checked="" ;
			?>
			<INPUT TYPE="checkbox" <?PHP echo $checked?> name="is_display" >
			<INPUT type="hidden" name="alterinsubtype" value="ALTERINSUBTYPE">
			<INPUT type="hidden" name="in_subtype_id" value="<?PHP echo $_SESSION['__getsubtype_id']?>">
			<INPUT type="hidden" name="in_mantype_id" value="<?PHP echo $_SESSION['__gettype_id']?>">
			<INPUT type="hidden" name="alteractive" value="1">
			<INPUT TYPE="submit" value="<?PHP echo $_ALTER?>">
		</FORM>

<?PHP
		} elseif ( $getmantype == 2 || $_SESSION['__gettype'] == "ADDOUTMANTYPE") {
	?>

		<FORM action="form_process.php" method="POST">
			<?PHP echo $_ADD . $_ADDMANTYPE. $_OUT . $_TYPE ?>
			名称
			<input type="text" name="addmantypename" size="6" maxlength="10">
			,是否显示
			<INPUT TYPE="checkbox" checked="checked" name="is_display" >
			<INPUT type="hidden" name="addmantype" value="ADDOUTMANTYPE">
			<INPUT TYPE="submit" value="<?PHP echo $_ADD?>">
		</FORM>
			<BR>
			<TABLE border="1">
			  <tr>
				<th width = \"10%\">序号</th>
				<th width = \"10%\">显示</th>
				<th width = \"30%\">名称</th>
				<th width = \"10%\">排序</th>
				<th colspan="2" width = \"20%\">主类操作</th>
				<th width = \"20%\">子类操作</th>
			  </tr>					
		<?PHP 	
				$result = $Finance->getInOutType("_out_mantype");
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
						echo "<INPUT type=\"hidden\" name=\"taxis_front\" value=\"TAXISMANFRONT\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_table\" value=\"_out_mantype\">";
						echo "<INPUT type=\"hidden\" name=\"store\" value=".$value[2].">";
						echo "</FORM>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value= \"下\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_after\" value=\"TAXISMANAFTER\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_table\" value=\"_out_mantype\">";
						echo "<INPUT type=\"hidden\" name=\"store\" value=".$value[2].">";
						echo "</FORM></td>";

						echo "<td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_ALTER.">";
						echo "<INPUT type=\"hidden\" name=\"out_mantype_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"alteroutmantype\" value=\"ALTEROUTMANTYPE\">";
						echo "</FORM></td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<td><INPUT  TYPE=\"submit\" value=".$_DELETE.">";
						echo "<INPUT type=\"hidden\" name=\"out_mantype_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"deleteoutmantype\" value=\"DELETEOUTMANTYPE\">";
						echo "</FORM></td>";
						echo "<td><FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_LISTSUBTYPE.">";
						echo "<INPUT type=\"hidden\" name=\"out_mantype_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"addoutsubtype\" value=\"ADDOUTSUBTYPE\">";
						echo "</FORM></td>";
						echo "</tr>";

				}
		?>
		</TABLE>

<?PHP
		} elseif ( $_SESSION['__gettype'] == "ALTEROUTMANTYPE") {
	?>

		<FORM action="form_process.php" method="POST">
			<?PHP echo $_ALTER . $_ADDMANTYPE. $_OUT . $_TYPE; ?>
			名称
			<input type="text" name="altermantypename" size="6" maxlength="10" value="<?PHP echo $Finance->convertIdToNmae("_out_mantype",$_SESSION['__gettype_id'])?>">
			<?PHP echo "原名称 \"".$Finance->convertIdToNmae("_out_mantype",$_SESSION['__gettype_id'])."\",是否显示";?>
			<?PHP
				$is_display = $Finance->getIsDisplay("_out_mantype",$_SESSION['__gettype_id']);
				$is_display['0']['0'] ? $checked = "checked=\"checked\"" : $checked="" ;
			?>
			<INPUT TYPE="checkbox" <?PHP echo $checked?> name="is_display" >
			<INPUT type="hidden" name="alteroutmantype" value="ALTEROUTMANTYPE">
			<INPUT type="hidden" name="out_mantype_id" value="<?PHP echo $_SESSION['__gettype_id']?>">
			<INPUT type="hidden" name="alteractive" value="1">
			<INPUT TYPE="submit" value="<?PHP echo $_ALTER?>">
		</FORM>


<?PHP
		} elseif ( $_SESSION['__gettype'] == "ADDOUTSUBTYPE") {
	?>

		<FORM action="form_process.php" method="POST">
			<?PHP echo $_ADD . $_ADDSUBTYPE. $_OUT. $_TYPE ?>
			名称
			<input type="text" name="addsubtypename" size="6" maxlength="10">
			,所属主类<?PHP  echo " \"".$Finance->convertIdToNmae("_out_mantype",$_SESSION['__gettype_id'])."\" "?>是否显示
			<INPUT TYPE="checkbox" checked="checked" name="is_display" >
			<INPUT type="hidden" name="addoutsubtype" value="ADDOUTSUBTYPE">
			<INPUT type="hidden" name="out_mantype_id" value="<?PHP echo $_SESSION['__gettype_id']?>">
			<INPUT type="hidden" name="alteractive" value="1">
			<INPUT TYPE="submit" value="<?PHP echo $_ADD?>">
		</FORM>
		<BR>
			<TABLE border="1">
			  <tr>
				<th width = \"10%\">序号</th>
				<th width = \"10%\">所属主类</th>
				<th width = \"10%\">显示</th>
				<th width = \"20%\">名称</th>
				<th width = \"10%\">排序</th>
				<th colspan="2" width = \"25%\">子类操作</th>
			  </tr>					
		<?PHP 	
				$result = $Finance->getSubType("_out_subtype",$_SESSION['__gettype_id']);
				foreach( $result  as  $key => $value )
				{
						$key1 = $key;
						
						echo "<tr>";
						
						echo "<td>".++$key1."</td>";
						echo "<td>".$Finance->convertIdToNmae("_out_mantype",$_SESSION['__gettype_id'])."</td>";
						echo "<td>";
						echo $value[4] == "1" ? "是":"--";
						echo "</td>";
						echo "<td>".$value[5]."</td>";

						echo "<td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value= \"上\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_front\" value=\"TAXISSUBFRONT\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_table\" value=\"_out_subtype\">";
						echo "<INPUT type=\"hidden\" name=\"store\" value=".$value[3].">";
						echo "<INPUT type=\"hidden\" name=\"mantype_id\" value=\"".$_SESSION['__gettype_id']."\">";
						echo "</FORM>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value= \"下\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_after\" value=\"TAXISSUBAFTER\">";
						echo "<INPUT type=\"hidden\" name=\"taxis_table\" value=\"_out_subtype\">";
						echo "<INPUT type=\"hidden\" name=\"store\" value=".$value[3].">";
						echo "<INPUT type=\"hidden\" name=\"mantype_id\" value=\"".$_SESSION['__gettype_id']."\">";
						echo "</FORM></td>";

						echo "<td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<INPUT  TYPE=\"submit\" value=".$_ALTER.">";
						echo "<INPUT type=\"hidden\" name=\"out_subtype_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"out_mantype_id\" value=\"".$_SESSION['__gettype_id']."\">";
						echo "<INPUT type=\"hidden\" name=\"alteroutsubtype\" value=\"ALTEROUTSUBTYPE\">";
						echo "</FORM></td>";
						echo "<FORM action=\"form_process.php\" method=\"POST\" style=\"display: inline;\">";
						echo "<td><INPUT  TYPE=\"submit\" value=".$_DELETE.">";
						echo "<INPUT type=\"hidden\" name=\"out_subtype_id\" value=".$value[0].">";
						echo "<INPUT type=\"hidden\" name=\"deleteoutsubtype\" value=\"DELETEOUTSUBTYPE\">";
						echo "</FORM></td>";
						echo "</tr>";
				}
		?>
		</TABLE>

<?PHP
		} elseif ( $_SESSION['__gettype'] == "ALTEROUTSUBTYPE") {
	?>

		<FORM action="form_process.php" method="POST">
			<?PHP echo $_ALTER . $_OUT. $_ADDSUBTYPE . $_TYPE; ?>
			名称
			<input type="text" name="altersubtypename" size="6" maxlength="10" value="<?PHP echo $Finance->convertIdToNmae("_out_subtype",$_SESSION['__getsubtype_id'])?>">
			<?PHP echo "原属主类 \"".$Finance->convertIdToNmae("_out_mantype",$_SESSION['__gettype_id'])."\" "?>
			<?PHP echo "原名称 \"".$Finance->convertIdToNmae("_out_subtype",$_SESSION['__getsubtype_id'])."\",是否显示";?>
			<?PHP
				$is_display = $Finance->getIsDisplay("_out_subtype",$_SESSION['__getsubtype_id']);
				$is_display['0']['0'] ? $checked = "checked=\"checked\"" : $checked="" ;
			?>
			<INPUT TYPE="checkbox" <?PHP echo $checked?> name="is_display" >
			<INPUT type="hidden" name="alteroutsubtype" value="ALTEROUTSUBTYPE">
			<INPUT type="hidden" name="out_subtype_id" value="<?PHP echo $_SESSION['__getsubtype_id']?>">
			<INPUT type="hidden" name="out_mantype_id" value="<?PHP echo $_SESSION['__gettype_id']?>">
			<INPUT type="hidden" name="alteractive" value="1">
			<INPUT TYPE="submit" value="<?PHP echo $_ALTER?>">
		</FORM>

<?PHP
		} elseif( $getmantype == "" ) {
			echo  "请选择要添加的主类别";
		}
?>
	<?PHP require_once("tail.php");?>
	</BODY>
</HTML>
