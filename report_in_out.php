<HTML>
    <?PHP 
        require_once("head.php");
        $year = isset($_POST['year']) ? $_POST['year'] : '';
        $current = isset($_POST['current']) ? $_POST['current'] : '';
        $total_out_money = '0';
        $total_in_money = '0';
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
             document.actionForm1.action = "report_in_out.php";    
             document.actionForm1.submit();    
         }    
         function formSubmit11(){    
             document.actionForm11.action = "report_in_out.php";    
             document.actionForm11.submit();    
         }  
         function formSubmit2(){    
             document.actionForm2.action = "report_in_out.php";    
             document.actionForm2.submit();    
         }    
         function formSubmit21(){    
             document.actionForm21.action = "report_in_out.php";    
             document.actionForm21.submit();    
         }    
         function formSubmit4(){    
             document.actionForm4.action = "report_in_out.php";    
             document.actionForm4.submit();    
         }
        </script> 
<?PHP        

    $day = date('z',mktime(0,0,0,date("m"),date("d"),date("Y")-$_SESSION['__year']));
    if ( $date != date("Y") )
    {
        $day = date('z',mktime(0,0,0,12,31,$date));
    }
?>
    <TABLE border="1">
        <tr>
            <td colspan="6" align="center">
                <h1><?PHP echo $date?>年收支平衡报表统计</h1>

                <form name="actionForm1" method="POST" style="display: inline;">   
                    <INPUT type="hidden" name="year" value="last">   
                    <a href="javascript:formSubmit1()">前一年</a>  
                </form>
               	<form name="actionForm21" method="POST" style="display: inline;">   
                    <INPUT type="hidden" name="detail" value="1">
                    <INPUT type="hidden" name="current" value="1">
                    <a href="javascript:formSubmit21()">当年</a>  
                    </form>
                <form name="actionForm2" method="POST" style="display: inline;">   
                    <INPUT type="hidden" name="year" value="next">  
                    <a href="javascript:formSubmit2()">后一年</a>  
                </form>
                    
            </td>
        </tr><tr>
            <th>年收入总数</th>
            <th>平均收入</th>
            <th>年支出总数</th>
            <th>平均支出</th>
            <th>年差数</th>
            <th>天差数</th>
        </tr><tr>
<?PHP    

    $result = $Finance->getReportOutYear($date);
    foreach( $result  as  $key => $value )
    {
        $total_out_money = $total_out_money + $value[1];                
    }
    
    $result = $Finance->getReportInYear($date);
    foreach( $result  as  $key => $value )
    {
        $total_in_money = $total_in_money + $value[1];                
    }
    echo "<td bgcolor=\"#66CC66\">".$total_in_money."</td>";
    echo "<td bgcolor=\"#9900FF\">".number_format($total_in_money/$day,2)."</td>";
    echo "<td bgcolor=\"#CC3333\">".$total_out_money."</td>";
    echo "<td bgcolor=\"#9900FF\">".number_format($total_out_money/$day,2)."</td>";
    $num = "5000";
    if ( number_format($total_in_money-$total_out_money,2) > $num )
    {
        $color = "#66CC66";    
    } else {
        $color = "#CC3333";    
    }
    echo "<td bgcolor=\"".$color."\">".number_format($total_in_money-$total_out_money,2)."</td>";
    echo "<td bgcolor=\"#9900FF\">".number_format(number_format($total_in_money/$day,2)-number_format($total_out_money/$day,2),2)."</td>";
?>
        </tr>
        <tr>
            <td align="right">
                当年天数：
            </td>
            <td colspan="5" align="left">
                <?PHP echo $day."天" ?>
            </td>
        </tr>
    </TABLE>
    <?PHP require_once("tail.php");?>
</BODY>
</HTML>
