<HTML>
    <?PHP 
        require_once("head.php");
	$year = isset($_POST['year'])?$_POST['year']:'';
        $mantype_id = isset($_POST['mantype_id']) ? $_POST['mantype_id'] : '';
        $current = isset($_POST['current']) ? $_POST['current'] : '';
        $detail = isset($_POST['detail']) ? $_POST['detail'] : '';
        $total_money = '0';
        $total_money_ratio = '0';

        if ( $year == "last" )
             {
                     $_SESSION['__year']++;
        } elseif( $year == "next") {
                 $_SESSION['__year']--;
           } elseif( $current == 1 ) {
                $_SESSION['__year'] = 0;
	}
                 
	$date = date('Y',mktime(0,0,0,1,1,date("Y")-$_SESSION['__year']));
    ?>
<BODY>  
        <script>   
         function formSubmit1(){    
             document.actionForm1.action = "report_out_mantype_year.php";    
             document.actionForm1.submit();    
         }    
         function formSubmit11(){    
             document.actionForm11.action = "report_out_mantype_year.php";    
             document.actionForm11.submit();    
         }  
         function formSubmit2(){    
             document.actionForm2.action = "report_out_mantype_year.php";    
             document.actionForm2.submit();    
         }    
         function formSubmit21(){    
             document.actionForm21.action = "report_out_mantype_year.php";    
             document.actionForm21.submit();    
         }    
         function formSubmit22(){    
             document.actionForm22.action = "report_out_mantype_year.php";    
             document.actionForm22.submit();    
         }    

         function formSubmit4(){    
             document.actionForm4.action = "report_out_mantype_year.php";    
             document.actionForm4.submit();    
         }
         <?PHP  $result = $Finance->getReportOutManTypeMonthTotal($date);
                $mantype_id2 = "";
                foreach( $result  as  $key => $value )
                {

                    if ( $mantype_id2 == $value[3] )
                    {
                        $mantype_id2 = $value[3];
                    } else {

                        echo "function formSubmit3".$key."(){\n";    
                        echo "document.actionForm3".$key.".action = \"report_out_mantype_year.php\";\n";    
                        echo "document.actionForm3".$key.".submit();\n";    
                        echo "}\n";
                    }
                    $mantype_id2 = $value[3];
                }
        ?>
        </script> 
<?PHP
	$day = date('z',mktime(0,0,0,date("m"),date("d"),date("Y")-$_SESSION['__year'])) + 1;
	if ( $date != date("Y") ) {
	$day = date('z',mktime(0,0,0,12,31,$date)) + 1;
	}

    if ( ! empty($mantype_id))
    {
        $_SESSION['__mantype_id'] = $mantype_id;
    }

    if ( $_SESSION['__year'] == '0' )
    {
        $day = date("d");
    }


if ($detail == 1 )
{
    if ($_SESSION['__useralive'][0] == 1 )
    {
        $sql = "SELECT * FROM out_corde WHERE create_date like '".$date."%' AND out_mantype_id = '".$_SESSION['__mantype_id']."'";
    } else {
        $sql = "SELECT * FROM out_corde WHERE create_date like '".$date."%' AND group_id = '".$_SESSION['__group_id']."' AND out_mantype_id = '".$_SESSION['__mantype_id']."'";
    }
?> 

            <TABLE border="1">
            <tr>
                <td colspan="9" align="center">
                    <h1><?PHP echo $date?>年支出主类报表</h1>
                    <form name="actionForm4" method="POST" style="display: inline;"> 
                        <INPUT type="hidden" name="detail" value="0">
                        <a href="javascript:formSubmit4()">查看统计</a>  
                    </form>
                    <form name="actionForm1" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="last">
                        <INPUT type="hidden" name="detail" value="1">
                        <a href="javascript:formSubmit1()">上一年</a>  
                    </form>
                    &nbsp;<a href="report_out_mantype_year.php">当年</a>&nbsp;
                    <form name="actionForm2" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="next">
                        <INPUT type="hidden" name="detail" value="1">
                        <a href="javascript:formSubmit2()">下一年</a>  
                    </form>
                </td>
            </tr>
              <tr>
                <th>序号</th>
                <th>用户</th>
                <th>家庭</th>
                <th>支出主类</th>
                <th>支出子类</th>
                <th>支出地址</th>
                <th>钱</th>
                <th>备注</th>
                <th>时间</th>
              </tr>                    
            <?PHP

                $result = $Finance->search($sql);
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
                        echo "<td>".$Finance->convertIdToNmae("_out_mantype",$value[4])."</td>";
                        echo "<td>".$Finance->convertIdToNmae("_out_subtype",$value[5])."</td>";
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
                <td colspan="6" align="center">
                    <h1><?PHP echo $date?>年支出主类报表统计</h1>

                    <form name="actionForm1" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="last">   
                        <a href="javascript:formSubmit1()">上一年</a>  
                    </form>
                    <form name="actionForm22" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="current" value="1">
                        <a href="javascript:formSubmit22()">当年</a>  
                    </form>
                    <form name="actionForm2" method="POST" style="display: inline;">   
                        <INPUT type="hidden" name="year" value="next">  
                        <a href="javascript:formSubmit2()">下一年</a>  
                    </form>
                    
                </td>
            </tr>
              <tr>
                <th>序号</th>
                <th>用户</th>
                <th>主类</th>
                <th>钱</th>
                <th>占用比例</th>                
                <th>支出次数</th>
              </tr>                    

<?PHP    
    $color = "#663300";
    $yibai = "100";

    $result = $Finance->getReportOutManTypeMonth($date);
    foreach( $result  as  $key => $value )
    {
        $total_money = $total_money + $value[1];                
    }

    $result = $Finance->getReportOutManTypeMonthTotal($date);
    foreach( $result  as  $key => $value )
    {
        $total_money_ratio = $total_money_ratio + $value[1];
    }
    
    foreach( $result  as  $key => $value )
    {
        $key1 = $key;
        $money_ratio = number_format($value[1]/$total_money,2);


        echo "<tr>";
        echo "<td>".++$key1."</td>";                        
        if($Finance->convertUserAliasID($value[2]))
        {
            echo "<td>".$Finance->convertUserAliasID($value[2])."</td>";
        } else {
            echo "<td>".$Finance->convertUserID($value[2])."</td>";
        }
        echo "<td><form name=\"actionForm3".$key."\" method=\"POST\" style=\"display: inline;\"> ";    
        echo "<INPUT type=\"hidden\" name=\"detail\" value=\"1\">";    
        echo "<INPUT type=\"hidden\" name=\"mantype_id\" value=\"".$value[3]."\">";    
        echo "<a href=\"javascript:formSubmit3".$key."()\">";
        echo $Finance->convertIdToNmae("_out_mantype",$value[3]);
        echo "</a>  </form></td>";
        echo "<td>".$value[1]."</td>";
        echo "<td>";
            if ( $money_ratio*$yibai > 50 )
            {
                echo "<table width=100%><tr><td width=\"".($money_ratio*$yibai)."%\" bgcolor=".$color.">";
                echo "<strong><font color=#FFFFFF>".($money_ratio*$yibai)."%</font></strong></td>";
                echo "<td width=\"".(100-$money_ratio*$yibai)."%\"></td>";
                echo "</tr></table>";
            } else {
                echo "<table width=100%><tr><td width=\"".($money_ratio*$yibai)."%\" bgcolor=".$color.">";
                echo "</td>";
                echo "<td width=\"".(100-$money_ratio*$yibai)."%\"><strong><font color=#663300>".($money_ratio*$yibai)."%</font></strong>";
                echo "</td>";
                echo "</tr></table>";
            }
        echo "</td>";
        echo "<td>".$value[0]."</td>";
        echo "</tr>";

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
    }
    echo "<TR>";
    echo "<TD colspan=\"3\" align=\"right\">当年总计:</TD>";
    echo "<TD colspan=\"3\">".$total_money_ratio."&nbsp;</TD>";
    echo "</TR>";

?>
        </TABLE>
<?PHP
    }
?>
    </TD></tr>
    </TABLE>
    <?PHP require_once("tail.php");?>
</BODY>
</HTML>
