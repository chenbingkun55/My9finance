<<<<<<< HEAD
<HTML>
    <?PHP 
        require_once("head.php");
        $detail = isset($_POST['detail']) ? $_POST['detail'] : '';
        $year = isset($_POST['year']) ? $_POST['year'] : '';
        $person = isset($_POST['person']) ? $_POST['person'] : '';
        $current = isset($_POST['current']) ? $_POST['current'] : '';
        $user_id2 = isset($_POST['user_id2']) ? $_POST['user_id2'] : '';
        $total_money = '0';
        $total_money_ratio = '0';
        if ( $year == "last" )
        {
            $_SESSION['__year']++;
        } elseif ( $year == "next") {
            $_SESSION['__year']--;
        } elseif ($current == 1 ) {
	    $_SESSION['__year'] = 0;
	}
	$date = date('Y',mktime(0,0,0,1,1,date("Y")-$_SESSION['__year']));
    ?>
<BODY>  
        <script>   
         function formSubmit1(){    
             document.actionForm1.action = "report_in_year.php";    
             document.actionForm1.submit();    
         }    
         function formSubmit11(){    
             document.actionForm11.action = "report_in_year.php";    
             document.actionForm11.submit();    
         }  
         function formSubmit2(){    
             document.actionForm2.action = "report_in_year.php";    
             document.actionForm2.submit();    
         }    
         function formSubmit21(){    
             document.actionForm21.action = "report_in_year.php";    
             document.actionForm21.submit();    
         }    
         function formSubmit22(){    
             document.actionForm22.action = "report_in_year.php";    
             document.actionForm22.submit();    
         }    

         function formSubmit4(){    
             document.actionForm4.action = "report_in_year.php";    
             document.actionForm4.submit();    
         }
         <?PHP  $result = $Finance->getReportInYearTotal($date);
                $user = "";
                foreach( $result  as  $key => $value )
                {
                    
                    if ( $user == $value[2] )
                    {
                        $user = $value[2];
                    } else {
                        echo "function formSubmit5".$key."(){\n";    
                        echo "document.actionForm5".$key.".action = \"report_in_year.php\";\n";    
                        echo "document.actionForm5".$key.".submit();\n";    
                        echo "}\n";

                        echo "function formSubmit3".$key."(){\n";    
                        echo "document.actionForm3".$key.".action = \"report_in_year.php\";\n";    
                        echo "document.actionForm3".$key.".submit();\n";    
                        echo "}\n";

                    }
                    $user = $value[2];
                }
        ?>
        </script> 
<?PHP        

    $day = date('z',mktime(0,0,0,date("m"),date("d"),date("Y")-$_SESSION['__year'])) + 1 ;
    if ( $date != date("Y") )
    {
        $day = date('z',mktime(0,0,0,12,31,$date)) + 1;
    }


if ($detail == 1 )
{
?> 

            <TABLE border="1">
            <tr>
                <td colspan="9" align="center">
                    <h1><?PHP echo $date?>年收入报表</h1>
                    <form name="actionForm4" method="POST" style="display: inline;"> 
                        <INPUT type="hidden" name="detail" value="0">
                        <a href="javascript:formSubmit4()">查看统计</a>  
                    </form>
                    <form name="actionForm1" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="last">
                        <INPUT type="hidden" name="detail" value="1">
                        <a href="javascript:formSubmit1()">前一年</a>  
                    </form>
                    <form name="actionForm21" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="detail" value="1">
                        <INPUT type="hidden" name="current" value="1">
                        <a href="javascript:formSubmit21()">当年</a>  
                    </form>
                    <form name="actionForm2" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="next">
                        <INPUT type="hidden" name="detail" value="1">
                        <a href="javascript:formSubmit2()">后一年</a>  
                    </form>
                </td>
            </tr>
              <tr>
                <th>序号</th>
                <th>用户</th>
                <th>家庭</th>
                <th>收入主类</th>
                <th>收入子类</th>
                <th>收入地址</th>
                <th>钱</th>
                <th>备注</th>
                <th>时间</th>
              </tr>                    
            <?PHP
                $result = $Finance->getReportInYear($date);
                foreach( $result  as  $key => $value )
                {
                        $key1 = $key;
                        $total_money = $total_money + $value[1];
                        
                        echo "<tr>";
                        echo "<td>".++$key1."</td>";
                        if($Finance->convertUserAliasID($value[2]))
                        {
                            echo "<td>".$Finance->convertUserAliasID($value[2])."</td>";
                        } else {
                            echo "<td>".$Finance->convertUserID($value[2])."</td>";
                        }
                        $group_alias = $Finance->convertGroupAliasID($value[3]);
                        if(empty($group_alias['1']))
                        {
                            echo "<td>".$group_alias['0']."</td>";
                        } else {
                            echo "<td>".$group_alias['1']."</td>";
                        }
                        echo "<td>".$Finance->convertIdToNmae("_in_mantype",$value[4])."</td>";
                        echo "<td>".$Finance->convertIdToNmae("_in_subtype",$value[5])."</td>";
                        echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
                        echo "<td>".$value[1]."</td>";
                        echo "<td>".$value[7]."</td>";
                        echo "<td>".$value[8]."</td>";
                        echo "</tr>";
                        $group_alias ="";

                }
                
                    echo "<tr><td colspan=\"6\" align='right'>当年[".$day."天]总计：</td>";
                    echo "<td >".$total_money."</td>";
                    echo "<td align='right'>平均每天:</td>";
                    echo "<td>".number_format($total_money/$day,2)."</td></tr>";
                    
                ?>
        </TABLE>
<?PHP 
} elseif($person == 1 ) {
?>
        <TABLE border="1">
            <tr>
                <td colspan="9" align="center">
                    <h1> 
<?PHP 
                        echo $date."年";
                        if($Finance->convertUserAliasID($user_id2))
                        {
                            echo " -".$Finance->convertUserAliasID($user_id2)."- ";
                        } else {
                            echo " -".$Finance->convertUserID($user_id2)."- ";
                        }
                        echo "收入报表";
?>
                        </h1>
                    <form name="actionForm4" method="POST" style="display: inline;"> 
                        <INPUT type="hidden" name="detail" value="0">
                        <a href="javascript:formSubmit4()">查看统计</a>  
                    </form>
                    <form name="actionForm1" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="last"> 
                        <INPUT type="hidden" name="person" value="1">
                        <INPUT type="hidden" name="user_id2" value="<?PHP echo $user_id2?>">
                        <a href="javascript:formSubmit1()">前一年</a>  
                    </form>
                    <form name="actionForm11" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="person" value="1">
                        <INPUT type="hidden" name="current" value="1">
                        <INPUT type="hidden" name="user_id2" value="<?PHP echo $user_id2?>">
                        <a href="javascript:formSubmit11()">当年</a>  
                    </form>
                    <form name="actionForm2" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="next">  
                        <INPUT type="hidden" name="person" value="1">
                        <INPUT type="hidden" name="user_id2" value="<?PHP echo $user_id2?>">
                        <a href="javascript:formSubmit2()">后一年</a>  
                    </form>
                </td>
            </tr>
              <tr>
                <th>序号</th>
                <th>用户</th>
                <th>家庭</th>
                <th>收入主类</th>
                <th>收入子类</th>
                <th>收入地址</th>
                <th>钱</th>
                <th>备注</th>
                <th>时间</th>
              </tr>    
<?php

            $result = $Finance->getReportPersonInYear($user_id2,$date);
            foreach( $result  as  $key => $value )
                {
                        $key1 = $key;
                        $total_money = $total_money + $value[1];
                        
                        echo "<tr>";
                        echo "<td>".++$key1."</td>";
                        if($Finance->convertUserAliasID($value[2]))
                        {
                            echo "<td>".$Finance->convertUserAliasID($value[2])."</td>";
                        } else {
                            echo "<td>".$Finance->convertUserID($value[2])."</td>";
                        }
                        $group_alias = $Finance->convertGroupAliasID($value[3]);
                        if(empty($group_alias['1']))
                        {
                            echo "<td>".$group_alias['0']."</td>";
                        } else {
                            echo "<td>".$group_alias['1']."</td>";
                        }
                        echo "<td>".$Finance->convertIdToNmae("_in_mantype",$value[4])."</td>";
                        echo "<td>".$Finance->convertIdToNmae("_in_subtype",$value[5])."</td>";
                        echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
                        echo "<td>".$value[1]."</td>";
                        echo "<td>".$value[7]."</td>";
                        echo "<td>".$value[8]."</td>";
                        echo "</tr>";
                        $group_alias ="";

                }
                
                    echo "<tr><td colspan=\"6\" align='right'>当年[".$day."天]总计：</td>";
                    echo "<td >".$total_money."</td>";
                    echo "<td align='right'>平均每天:</td>";
                    echo "<td>".number_format($total_money/$day,2)."</td></tr>";
?>
    </TABLE>
<?PHP 
}else{                    
?>
        <TABLE border="1">
            <tr>
                <td colspan="5" align="center">
                    <h1><?PHP echo $date?>年收入报表统计</h1>

                    <form name="actionForm1" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="last">   
                        <a href="javascript:formSubmit1()">前一年</a>  
                    </form>
                    <form name="actionForm22" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="current" value="1">
                        <a href="javascript:formSubmit22()">当年</a>  
                    </form>
                    <form name="actionForm2" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="next">  
                        <a href="javascript:formSubmit2()">后一年</a>  
                    </form>
                    
                </td>
            </tr>
              <tr>
                <th>序号</th>
                <th>用户</th>
                <th>家庭</th>
                <th>钱</th>
                <th>收入次数</th>
              </tr>                    

    
<?PHP    

    $result = $Finance->getReportOutYear($date);
    foreach( $result  as  $key => $value )
    {
        $total_money = $total_money + $value[1];                
    }

    $result = $Finance->getReportInYearTotal($date);
    foreach( $result  as  $key => $value )
    {
        $total_money_ratio = $total_money_ratio + $value[1];
    }
    
    foreach( $result  as  $key => $value )
    {
        $key1 = $key;
        $ratio[$value[2]] = number_format($value[1]/$total_money_ratio,2);


        echo "<tr>";
        echo "<td>".++$key1."</td>";

        if($Finance->convertUserAliasID($value[2]))
        {
            echo "<td><form name=\"actionForm5".$key."\" method=\"POST\" style=\"display: inline;\">";
            echo "<INPUT type=\"hidden\" name=\"person\" value=\"1\">";
            echo "<INPUT type=\"hidden\" name=\"user_id2\" value=\"".$value[2]."\">";
            echo "<a href=\"javascript:formSubmit5".$key."()\">".$Finance->convertUserAliasID($value[2])."</a></form></td>";
        } else {
            echo "<td><form name=\"actionForm5".$key."\" method=\"POST\" style=\"display: inline;\">";
            echo "<INPUT type=\"hidden\" name=\"person\" value=\"1\">";
            echo "<INPUT type=\"hidden\" name=\"user_id2\" value=\"".$value[2]."\">";
            echo "<a href=\"javascript:formSubmit5".$key."()\">".$Finance->convertUserID($value[2])."</a></form></td>";
        }
        $group_alias = $Finance->convertGroupAliasID($value[3]);
        
        if(empty($group_alias['1']))
        {

                    
            echo "<td><form name=\"actionForm3".$key."\" method=\"POST\" style=\"display: inline;\"> ";    
            echo "<INPUT type=\"hidden\" name=\"detail\" value=\"1\">";    
            echo "<INPUT type=\"hidden\" name=\"group_id\" value=\"".$value[3]."\">";    
            echo "<a href=\"javascript:formSubmit3".$key."()\">";
            echo $group_alias['0'];
            echo "</a>  </form></td>";
        } else {
            echo "<td><form name=\"actionForm3".$key."\" method=\"POST\" style=\"display: inline;\"> ";    
            echo "<INPUT type=\"hidden\" name=\"detail\" value=\"1\">";    
            echo "<INPUT type=\"hidden\" name=\"group_id\" value=\"".$value[3]."\">";    
            echo "<a href=\"javascript:formSubmit3".$key."()\">";
            echo $group_alias['1'];
            echo "</a>  </form></td>";
        }
        echo "<td>".$value[1]."</td>";
        echo "<td>".$value[0]."</td>";
        echo "</tr>";
        $group_alias ="";
    }
    echo "<TR>";
    echo "<TD colspan=\"3\" align=\"right\">当年[".$day."天]总计:</TD>";
    echo "<TD colspan=\"2\">".$total_money_ratio."&nbsp;平均每天:".number_format($total_money_ratio/$day,2)."</TD>";
    echo "</TR>";
    echo "<tr><TD colspan=\"5\">";

    $color = "#663300";
    $yibai = "100";
    if (isset($ratio)) {
    	foreach( $ratio  as  $key => $value )
    	{        
        	echo "<TABLE width=\"100%\">";
        	if($Finance->convertUserAliasID($key))
        	{
            	echo "<tr><td colspan=\"2\">".$Finance->convertUserAliasID($key)." 占总比例</td></tr>";
        	} else {
            	echo "<tr><td colspan=\"2\">".$Finance->convertUserID($key)." 占总比例</td></tr>";
        	}


        	echo "<TR>";
        	echo "<TD colspan=\"2\">";
            	if ( $value*$yibai > 20 )
            	{
               	 	echo "<table width=100%><tr><td width=\"".($value*$yibai)."%\" bgcolor=".$color.">";
                	echo "<strong><font color=#FFFFFF>".($value*$yibai)."%</font></strong></td>";
                	echo "<td width=\"".(100-$value*$yibai)."%\"></td>";
                	echo "</tr></table>";
            	} else {
                	echo "<table width=100%><tr><td width=\"".($value*$yibai)."%\" bgcolor=".$color.">";
                	echo "</td>";
                	echo "<td width=\"".(100-$value*$yibai)."%\"><strong><font color=#663300>".($value*$yibai)."%</font></strong>";
                	echo "</td>";
                	echo "</tr></table>";
            	}
        	echo "</TD>";

        /* 最早使用的用来显示比例条的方式。
        echo "<TD width=\"".($value*$yibai)."%\" bgcolor=".$color."><font color=#FFFFFF>".($value*$yibai)."%</font></TD>";
        echo "<TD>&nbsp;</TD>";*/
        	if ( $color == "#663300" )
        	{
            	$color = "#6633FF";
        	}
        	elseif( $color == "#6633FF" ){
            	$color = "#FFCC00";
        	}
        	elseif( $color == "#FFCC00" ){
            	$color = "#3399FF";
        	} else {
            	$color = "#663300";
        	}
?>
        	</TR>
        </TABLE>
<?PHP
	}
    }
?>
    </TD></tr>
    </TABLE>
<?PHP }?>
    <?PHP require_once("tail.php");?>
</BODY>
</HTML>
=======
<HTML>
    <?PHP 
        require_once("head.php");
        $detail = isset($_POST['detail']) ? $_POST['detail'] : '';
        $year = isset($_POST['year']) ? $_POST['year'] : '';
        $person = isset($_POST['person']) ? $_POST['person'] : '';
        $current = isset($_POST['current']) ? $_POST['current'] : '';
        $user_id2 = isset($_POST['user_id2']) ? $_POST['user_id2'] : '';
        $total_money = '0';
        $total_money_ratio = '0';
        if ( $year == "last" )
        {
            $_SESSION['__year']++;
        } elseif ( $year == "next") {
            $_SESSION['__year']--;
        } elseif ($current == 1 ) {
	    $_SESSION['__year'] = 0;
	}
	$date = date('Y',mktime(0,0,0,1,1,date("Y")-$_SESSION['__year']));
    ?>
<BODY>  
        <script>   
         function formSubmit1(){    
             document.actionForm1.action = "report_in_year.php";    
             document.actionForm1.submit();    
         }    
         function formSubmit11(){    
             document.actionForm11.action = "report_in_year.php";    
             document.actionForm11.submit();    
         }  
         function formSubmit2(){    
             document.actionForm2.action = "report_in_year.php";    
             document.actionForm2.submit();    
         }    
         function formSubmit21(){    
             document.actionForm21.action = "report_in_year.php";    
             document.actionForm21.submit();    
         }    
         function formSubmit22(){    
             document.actionForm22.action = "report_in_year.php";    
             document.actionForm22.submit();    
         }    

         function formSubmit4(){    
             document.actionForm4.action = "report_in_year.php";    
             document.actionForm4.submit();    
         }
         <?PHP  $result = $Finance->getReportInYearTotal($date);
                $user = "";
                foreach( $result  as  $key => $value )
                {
                    
                    if ( $user == $value[2] )
                    {
                        $user = $value[2];
                    } else {
                        echo "function formSubmit5".$key."(){\n";    
                        echo "document.actionForm5".$key.".action = \"report_in_year.php\";\n";    
                        echo "document.actionForm5".$key.".submit();\n";    
                        echo "}\n";

                        echo "function formSubmit3".$key."(){\n";    
                        echo "document.actionForm3".$key.".action = \"report_in_year.php\";\n";    
                        echo "document.actionForm3".$key.".submit();\n";    
                        echo "}\n";

                    }
                    $user = $value[2];
                }
        ?>
        </script> 
<?PHP        

    $day = date('z',mktime(0,0,0,date("m"),date("d"),date("Y")-$_SESSION['__year'])) + 1 ;
    if ( $date != date("Y") )
    {
        $day = date('z',mktime(0,0,0,12,31,$date)) + 1;
    }


if ($detail == 1 )
{
?> 

            <TABLE border="1">
            <tr>
                <td colspan="9" align="center">
                    <h1><?PHP echo $date?>年收入报表</h1>
                    <form name="actionForm4" method="POST" style="display: inline;"> 
                        <INPUT type="hidden" name="detail" value="0">
                        <a href="javascript:formSubmit4()">查看统计</a>  
                    </form>
                    <form name="actionForm1" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="last">
                        <INPUT type="hidden" name="detail" value="1">
                        <a href="javascript:formSubmit1()">前一年</a>  
                    </form>
                    <form name="actionForm21" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="detail" value="1">
                        <INPUT type="hidden" name="current" value="1">
                        <a href="javascript:formSubmit21()">当年</a>  
                    </form>
                    <form name="actionForm2" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="next">
                        <INPUT type="hidden" name="detail" value="1">
                        <a href="javascript:formSubmit2()">后一年</a>  
                    </form>
                </td>
            </tr>
              <tr>
                <th>序号</th>
                <th>用户</th>
                <th>家庭</th>
                <th>收入主类</th>
                <th>收入子类</th>
                <th>收入地址</th>
                <th>钱</th>
                <th>备注</th>
                <th>时间</th>
              </tr>                    
            <?PHP
                $result = $Finance->getReportInYear($date);
                foreach( $result  as  $key => $value )
                {
                        $key1 = $key;
                        $total_money = $total_money + $value[1];
                        
                        echo "<tr>";
                        echo "<td>".++$key1."</td>";
                        if($Finance->convertUserAliasID($value[2]))
                        {
                            echo "<td>".$Finance->convertUserAliasID($value[2])."</td>";
                        } else {
                            echo "<td>".$Finance->convertUserID($value[2])."</td>";
                        }
                        $group_alias = $Finance->convertGroupAliasID($value[3]);
                        if(empty($group_alias['1']))
                        {
                            echo "<td>".$group_alias['0']."</td>";
                        } else {
                            echo "<td>".$group_alias['1']."</td>";
                        }
                        echo "<td>".$Finance->convertIdToNmae("_in_mantype",$value[4])."</td>";
                        echo "<td>".$Finance->convertIdToNmae("_in_subtype",$value[5])."</td>";
                        echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
                        echo "<td>".$value[1]."</td>";
                        echo "<td>".$value[7]."</td>";
                        echo "<td>".$value[8]."</td>";
                        echo "</tr>";
                        $group_alias ="";

                }
                
                    echo "<tr><td colspan=\"6\" align='right'>当年[".$day."天]总计：</td>";
                    echo "<td >".$total_money."</td>";
                    echo "<td align='right'>平均每天:</td>";
                    echo "<td>".number_format($total_money/$day,2)."</td></tr>";
                    
                ?>
        </TABLE>
<?PHP 
} elseif($person == 1 ) {
?>
        <TABLE border="1">
            <tr>
                <td colspan="9" align="center">
                    <h1> 
<?PHP 
                        echo $date."年";
                        if($Finance->convertUserAliasID($user_id2))
                        {
                            echo " -".$Finance->convertUserAliasID($user_id2)."- ";
                        } else {
                            echo " -".$Finance->convertUserID($user_id2)."- ";
                        }
                        echo "收入报表";
?>
                        </h1>
                    <form name="actionForm4" method="POST" style="display: inline;"> 
                        <INPUT type="hidden" name="detail" value="0">
                        <a href="javascript:formSubmit4()">查看统计</a>  
                    </form>
                    <form name="actionForm1" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="last"> 
                        <INPUT type="hidden" name="person" value="1">
                        <INPUT type="hidden" name="user_id2" value="<?PHP echo $user_id2?>">
                        <a href="javascript:formSubmit1()">前一年</a>  
                    </form>
                    <form name="actionForm11" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="person" value="1">
                        <INPUT type="hidden" name="current" value="1">
                        <INPUT type="hidden" name="user_id2" value="<?PHP echo $user_id2?>">
                        <a href="javascript:formSubmit11()">当年</a>  
                    </form>
                    <form name="actionForm2" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="next">  
                        <INPUT type="hidden" name="person" value="1">
                        <INPUT type="hidden" name="user_id2" value="<?PHP echo $user_id2?>">
                        <a href="javascript:formSubmit2()">后一年</a>  
                    </form>
                </td>
            </tr>
              <tr>
                <th>序号</th>
                <th>用户</th>
                <th>家庭</th>
                <th>收入主类</th>
                <th>收入子类</th>
                <th>收入地址</th>
                <th>钱</th>
                <th>备注</th>
                <th>时间</th>
              </tr>    
<?php

            $result = $Finance->getReportPersonInYear($user_id2,$date);
            foreach( $result  as  $key => $value )
                {
                        $key1 = $key;
                        $total_money = $total_money + $value[1];
                        
                        echo "<tr>";
                        echo "<td>".++$key1."</td>";
                        if($Finance->convertUserAliasID($value[2]))
                        {
                            echo "<td>".$Finance->convertUserAliasID($value[2])."</td>";
                        } else {
                            echo "<td>".$Finance->convertUserID($value[2])."</td>";
                        }
                        $group_alias = $Finance->convertGroupAliasID($value[3]);
                        if(empty($group_alias['1']))
                        {
                            echo "<td>".$group_alias['0']."</td>";
                        } else {
                            echo "<td>".$group_alias['1']."</td>";
                        }
                        echo "<td>".$Finance->convertIdToNmae("_in_mantype",$value[4])."</td>";
                        echo "<td>".$Finance->convertIdToNmae("_in_subtype",$value[5])."</td>";
                        echo "<td>".$Finance->convertIdToNmae("_address",$value[6])."</td>";
                        echo "<td>".$value[1]."</td>";
                        echo "<td>".$value[7]."</td>";
                        echo "<td>".$value[8]."</td>";
                        echo "</tr>";
                        $group_alias ="";

                }
                
                    echo "<tr><td colspan=\"6\" align='right'>当年[".$day."天]总计：</td>";
                    echo "<td >".$total_money."</td>";
                    echo "<td align='right'>平均每天:</td>";
                    echo "<td>".number_format($total_money/$day,2)."</td></tr>";
?>
    </TABLE>
<?PHP 
}else{                    
?>
        <TABLE border="1">
            <tr>
                <td colspan="5" align="center">
                    <h1><?PHP echo $date?>年收入报表统计</h1>

                    <form name="actionForm1" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="last">   
                        <a href="javascript:formSubmit1()">前一年</a>  
                    </form>
                    <form name="actionForm22" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="current" value="1">
                        <a href="javascript:formSubmit22()">当年</a>  
                    </form>
                    <form name="actionForm2" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="next">  
                        <a href="javascript:formSubmit2()">后一年</a>  
                    </form>
                    
                </td>
            </tr>
              <tr>
                <th>序号</th>
                <th>用户</th>
                <th>家庭</th>
                <th>钱</th>
                <th>收入次数</th>
              </tr>                    

    
<?PHP    

    $result = $Finance->getReportOutYear($date);
    foreach( $result  as  $key => $value )
    {
        $total_money = $total_money + $value[1];                
    }

    $result = $Finance->getReportInYearTotal($date);
    foreach( $result  as  $key => $value )
    {
        $total_money_ratio = $total_money_ratio + $value[1];
    }
    
    foreach( $result  as  $key => $value )
    {
        $key1 = $key;
        $ratio[$value[2]] = number_format($value[1]/$total_money_ratio,2);


        echo "<tr>";
        echo "<td>".++$key1."</td>";

        if($Finance->convertUserAliasID($value[2]))
        {
            echo "<td><form name=\"actionForm5".$key."\" method=\"POST\" style=\"display: inline;\">";
            echo "<INPUT type=\"hidden\" name=\"person\" value=\"1\">";
            echo "<INPUT type=\"hidden\" name=\"user_id2\" value=\"".$value[2]."\">";
            echo "<a href=\"javascript:formSubmit5".$key."()\">".$Finance->convertUserAliasID($value[2])."</a></form></td>";
        } else {
            echo "<td><form name=\"actionForm5".$key."\" method=\"POST\" style=\"display: inline;\">";
            echo "<INPUT type=\"hidden\" name=\"person\" value=\"1\">";
            echo "<INPUT type=\"hidden\" name=\"user_id2\" value=\"".$value[2]."\">";
            echo "<a href=\"javascript:formSubmit5".$key."()\">".$Finance->convertUserID($value[2])."</a></form></td>";
        }
        $group_alias = $Finance->convertGroupAliasID($value[3]);
        
        if(empty($group_alias['1']))
        {

                    
            echo "<td><form name=\"actionForm3".$key."\" method=\"POST\" style=\"display: inline;\"> ";    
            echo "<INPUT type=\"hidden\" name=\"detail\" value=\"1\">";    
            echo "<INPUT type=\"hidden\" name=\"group_id\" value=\"".$value[3]."\">";    
            echo "<a href=\"javascript:formSubmit3".$key."()\">";
            echo $group_alias['0'];
            echo "</a>  </form></td>";
        } else {
            echo "<td><form name=\"actionForm3".$key."\" method=\"POST\" style=\"display: inline;\"> ";    
            echo "<INPUT type=\"hidden\" name=\"detail\" value=\"1\">";    
            echo "<INPUT type=\"hidden\" name=\"group_id\" value=\"".$value[3]."\">";    
            echo "<a href=\"javascript:formSubmit3".$key."()\">";
            echo $group_alias['1'];
            echo "</a>  </form></td>";
        }
        echo "<td>".$value[1]."</td>";
        echo "<td>".$value[0]."</td>";
        echo "</tr>";
        $group_alias ="";
    }
    echo "<TR>";
    echo "<TD colspan=\"3\" align=\"right\">当年[".$day."天]总计:</TD>";
    echo "<TD colspan=\"2\">".$total_money_ratio."&nbsp;平均每天:".number_format($total_money_ratio/$day,2)."</TD>";
    echo "</TR>";
    echo "<tr><TD colspan=\"5\">";

    $color = "#663300";
    $yibai = "100";
    if (isset($ratio)) {
    	foreach( $ratio  as  $key => $value )
    	{        
        	echo "<TABLE width=\"100%\">";
        	if($Finance->convertUserAliasID($key))
        	{
            	echo "<tr><td colspan=\"2\">".$Finance->convertUserAliasID($key)." 占总比例</td></tr>";
        	} else {
            	echo "<tr><td colspan=\"2\">".$Finance->convertUserID($key)." 占总比例</td></tr>";
        	}


        	echo "<TR>";
        	echo "<TD colspan=\"2\">";
            	if ( $value*$yibai > 20 )
            	{
               	 	echo "<table width=100%><tr><td width=\"".($value*$yibai)."%\" bgcolor=".$color.">";
                	echo "<strong><font color=#FFFFFF>".($value*$yibai)."%</font></strong></td>";
                	echo "<td width=\"".(100-$value*$yibai)."%\"></td>";
                	echo "</tr></table>";
            	} else {
                	echo "<table width=100%><tr><td width=\"".($value*$yibai)."%\" bgcolor=".$color.">";
                	echo "</td>";
                	echo "<td width=\"".(100-$value*$yibai)."%\"><strong><font color=#663300>".($value*$yibai)."%</font></strong>";
                	echo "</td>";
                	echo "</tr></table>";
            	}
        	echo "</TD>";

        /* 最早使用的用来显示比例条的方式。
        echo "<TD width=\"".($value*$yibai)."%\" bgcolor=".$color."><font color=#FFFFFF>".($value*$yibai)."%</font></TD>";
        echo "<TD>&nbsp;</TD>";*/
        	if ( $color == "#663300" )
        	{
            	$color = "#6633FF";
        	}
        	elseif( $color == "#6633FF" ){
            	$color = "#FFCC00";
        	}
        	elseif( $color == "#FFCC00" ){
            	$color = "#3399FF";
        	} else {
            	$color = "#663300";
        	}
?>
        	</TR>
        </TABLE>
<?PHP
	}
    }
?>
    </TD></tr>
    </TABLE>
<?PHP }?>
    <?PHP require_once("tail.php");?>
</BODY>
</HTML>
>>>>>>> e79fba4c37b2c02476590015a5952175b7fd5b25
