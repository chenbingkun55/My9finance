<HTML>
<?PHP
        require_once("head.php");
        $new_group = isset($_POST['new_group']) ? $_POST['new_group'] : '';
        $exit_group = isset($_POST['exit_group']) ? $_POST['exit_group'] : '';
        $new_member = isset($_POST['new_member']) ? $_POST['new_member'] : '';
        $list_member = isset($_POST['list_member']) ? $_POST['list_member'] : '';

?>
<BODY>
    <script>   
         function formSubmit1(){    
             document.actionForm1.action = "function_add_group.php";    
             document.actionForm1.submit();    
         } 
         function formSubmit3(){    
             document.actionForm3.action = "function_add_group.php";    
             document.actionForm3.submit();    
         } 
         function formSubmit6(){    
             document.actionForm6.action = "form_process.php";    
             document.actionForm6.submit();    
         } 

         <?PHP 
                $result = $Finance->getGroupMemberList();
                foreach( $result  as  $key => $value )
                {         
                    echo "function formSubmit7".$key."(){\n";
                    echo "document.actionForm7".$key.".action = \"form_process.php\";\n";    
                    echo "document.actionForm7".$key.".submit();\n";  
                    echo "}\n"; 
                }
                
                $result = $Finance->getGroupList();
                foreach( $result  as  $key => $value )
                {
                 	echo "function formSubmit2".$key."(){\n";    
                        echo "document.actionForm2".$key.".action = \"form_process.php\";\n";    
                        echo "document.actionForm2".$key.".submit();\n";    
                        echo "}\n";
                }

                $i = 1;
                while ( $i < 6 )
                {
                    echo "function formSubmit4".$i."(){\n";    
                    echo "document.actionForm4".$i.".action = \"form_process.php\";\n";    
                    echo "document.actionForm4".$i.".submit();\n";    
                    echo "}\n";
                    $i++;
                }

                $i = 1;
                while ( $i < 6 )
                {
                    echo "function formSubmit5".$i."(){\n";    
                    echo "document.actionForm5".$i.".action = \"form_process.php\";\n";    
                    echo "document.actionForm5".$i.".submit();\n";    
                    echo "}\n";
                    $i++;
                }
        
    echo "</script>";

    if($new_group == "NEWGROUP" )
    {
    ?>
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


<?PHP
    } else if ($exit_group == "EXITGROUP") {
        if ($Finance->deleteUserGroup($_SESSION['__useralive'][0]))
        {        
            $_SESSION['__error_logid'] = "5001";
            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=index.php\">";
        } else {
            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function.php?error_id=5001\">";
        }

    } else if ($new_member == "NEWMEMBER") {
?>
            <TABLE border="1">
            <tr>
                <td colspan="5" align="center">
                <h1><?PHP echo $_NEW_MEMBER_H;?></h1>
            </tr>
            <tr>
                <th>序号</th>
                <th>用户名</th>
                <th>家庭</th>
                <th>个性名</th>
                <th>操作</th>
              </tr>                    
<?PHP
        $i = 1;
        while ( $i < 6 )
        {

            
            if ( ! empty($_POST["member$i"]))
            {            
                echo "<tr>";
                echo "<td>".$i."</td>";
                echo "<td>".$Finance->convertUserID($_POST["member$i"])."</td>";
                echo "<td>".$_SESSION['__groupname']."</td>";
                echo "<td>".$Finance->convertUserAliasID($_POST["member$i"])."</td>";
                echo "<td>";

                echo "<form name=\"actionForm4".$i."\" method=\"POST\" style=\"display: inline;\">";
                echo "<INPUT type=\"hidden\" name=\"member\" value=\"";
                echo $_POST["member$i"]."\">";
                echo "<INPUT type=\"hidden\" name=\"new_member\" value=\"ACCPETMEMBER\" >";
                echo "<a href=\"javascript:formSubmit4".$i."()\">".$_ACCEPT."</a>"; 
                echo "</form>";
                echo "/";
                echo "<form name=\"actionForm5".$i."\" method=\"POST\" style=\"display: inline;\">";
                echo "<INPUT type=\"hidden\" name=\"member\" value=\"";
                echo $_POST["member$i"]."\">";
                echo "<INPUT type=\"hidden\" name=\"new_member\" value=\"DENYMEMBER\" >";
                echo "<a href=\"javascript:formSubmit5".$i."()\">".$_DENY."</a>"; 
                echo "</form>";
                
                echo "</td>";
                echo "</tr>";
            }
            $i++;
        }        
    echo "</TABLE>";
    } else if ($list_member == "LISTMEMBER" || $Finance->getGroupAdmin()) {
            $group_member_num = $Finance->getGroupMemberNum();
?>
        <TABLE border="1">
            <tr>
                <td colspan="4" align="center">
                <h1><?PHP echo "&nbsp;<".$_SESSION['__groupname'].">".$_GROUP_MEMBER;?>&nbsp;</h1>
<?PHP
            if($group_member_num['0']['0'] == 1 && $Finance->getGroupAdmin())
            {
?>
                <form name="actionForm6" method="POST" style="display: inline;"> 
                    <INPUT type="hidden" name="group_id" value="<?PHP echo $_SESSION['__group_id']?>">
                    <INPUT type="hidden" name="deletegroup" value="DELETEGROUP">
                    <INPUT type="hidden" name="groupadmin" value="1">
                    <a href="javascript:formSubmit6()">删除家庭</a>  
                </form>
<?PHP
            } else {
                echo "<CENTER><FONT COLOR=#3333FF>删除家庭</FONT></CENTER>";
                echo "<FONT color=#666600 SIZE=2>注：家庭里没有成员才可以删除！</FONT><BR>";
                echo "<FONT color=#666600 SIZE=2>     并且会删除该家庭的所有收支记录！</FONT>";
            }
?>
            </tr>
            <tr>
                <th>序号</th>
                <th>用户名</th>
                <th>家庭</th>
                <th>操作</th>
              </tr>    
<?PHP
         $i = 1;
        $result = $Finance->getGroupMemberList();
        foreach( $result  as  $key => $value )
        {
            if ( $value['0'] == $_SESSION['__useralive'][0] )
            {
                continue;
            }
                echo "<tr>";
                echo "<td>".$i."</td>";
                echo "<td>".$Finance->convertUserAliasID($value['0'])."</td>";
                echo "<td>".$_SESSION['__groupname']."</td>";
                echo "<td>";

                echo "<form name=\"actionForm7".$key."\" method=\"POST\" style=\"display: inline;\">";
                echo "<INPUT type=\"hidden\" name=\"user_id\" value=\"".$value['0']."\">";
                echo "<INPUT type=\"hidden\" name=\"delete_member\" value=\"DELETEMEMBER\" >";
                echo "<a href=\"javascript:formSubmit7".$key."()\">".$_DELETE_MEMBER."</a>"; 
                echo "</form>";
                
                echo "</td>";
                echo "</tr>";
                $i++;
        }
?>
        </table>

<?PHP
    } else {
?>

            <TABLE border="1">
              <tr>
                <td colspan="5" align="center">
                <h1><?PHP echo $_ADD_TO_GROUP;?></h1>
                <?PHP
                $yes_group = $Finance->yesUserInGroup();
                if($_SESSION['__groupname'] == "公共组" && empty($yes_group))
                { 
                ?>
                    <form name="actionForm1" method="POST" style="display: inline;"> 
                        <INPUT type="hidden" name="new_group" value="NEWGROUP">
                        <a href="javascript:formSubmit1()">新建家庭</a>  
                    </form>
                <?PHP } else { ?>
                    <form name="actionForm3" method="POST" style="display: inline;"> 
                        <INPUT type="hidden" name="exit_group" value="EXITGROUP">
                        <a href="javascript:formSubmit3()">退出《
                        <?PHP 
                            $group_alias = $Finance->convertGroupAliasID($yes_group);
                            if(empty($group_alias['1']))
                            {
                                echo $group_alias['0'];
                            } else {
                                echo $group_alias['1'];
                            }
                        ?>》家庭  </a>
                    </form>
                <?PHP }?>
                </td>
              </tr>
              <tr>
                <th>序号</th>
                <th>组名</th>
                <th>个性名</th>
                <th>加入密码</th>
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
                        echo "<FORM name=\"actionForm2".$key."\" method=\"POST\" style=\"display: inline;\">";
                        echo "<td><input type=\"password\" name=\"group_password\" size=\"11\" maxlength=\"20\">";
                        echo "</td><td>";
                        echo "<INPUT type=\"hidden\" name=\"group_id\" value=".$value[0].">";
                        echo "<INPUT type=\"hidden\" name=\"addtogroup\" value=\"ADDTOGROUP\">";
                        echo "<a href=\"javascript:formSubmit2".$key."()\">".$_ADD_TO."</a>";
                        echo "</FORM>";
                        echo "</td>";
                        echo "</tr>";
                        
                        
                }
    echo "</TABLE>";
    } ?>
    <?PHP require_once("tail.php");?>
</BODY>
</HTML>
