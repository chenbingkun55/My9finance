<<<<<<< HEAD
        <HTML>
        <?PHP 
                require_once("head.php"); 
        ?>
        <script>   
         function formSubmit1(){    
             document.actionForm1.action = "in_out_record.php";    
             document.actionForm1.submit();    
         }  
         function formSubmit2(){    
             document.actionForm2.action = "in_out_record.php";    
             document.actionForm2.submit();    
         }  
         function formSubmit3(){    
             document.actionForm3.action = "function_add_group.php";    
             document.actionForm3.submit();    
         }  
        </script>
<?PHP
    $new_member = $Finance->getIsGroupAdmin($_SESSION['__group_id']);
    if ($new_member) 
    {
        echo "<FORM name=\"actionForm3\" method=\"POST\" style=\"display: inline;\">";
        echo "<INPUT type=\"hidden\" name=\"new_member\" value=\"NEWMEMBER\">";
        echo "<INPUT type=\"hidden\" name=\"member1\" value=\"".$new_member['0']['0']."\">";
        echo "<INPUT type=\"hidden\" name=\"member2\" value=\"".$new_member['1']['0']."\">";
        echo "<INPUT type=\"hidden\" name=\"member3\" value=\"".$new_member['2']['0']."\">";
        echo "<INPUT type=\"hidden\" name=\"member4\" value=\"".$new_member['3']['0']."\">";
        echo "<INPUT type=\"hidden\" name=\"member5\" value=\"".$new_member['4']['0']."\">";
        echo "<BLINK><FONT color=\"#CC3300\">***** </FONT>";
        echo "<a href=\"javascript:formSubmit3()\"><FONT color=\"#CC3300\">".$_NEW_MEMBER."</FONT></a>";
        echo "<FONT color=\"#CC3300\"> *****</FONT></BLINK>";
        echo "<BR>";
        echo "</FORM>";
    }
?>

        <BODY>
            <FORM name="actionForm1" method="POST" style="display: inline;">
            <INPUT type="hidden" name="getrecordtype" value="1">
                1.  <a href="javascript:formSubmit1()"><?PHP echo $_OUT.$_RECORD;?></a>
            </FORM>
                <FONT color="#0000CC">/</FONT>
            <FORM name="actionForm2" method="POST" style="display: inline;">
                <INPUT type="hidden" name="getrecordtype" value="2">
                <a href="javascript:formSubmit2()"><?PHP echo $_IN.$_RECORD;?></a>
            </FORM>
                <br>
                2. <a href="./function.php"><?PHP echo $_FUNCTION ?></a><br>
                3. <a href="./report.php"><?PHP echo $_REPORT ?></a><br>
                4. <a href="./search.php"><?PHP echo $_SEARCH ?></a><br>
                <BR>

                <?PHP require_once("tail.php");?>
        </BODY>
        </HTML>
=======
        <HTML>
        <?PHP 
                require_once("head.php"); 
        ?>
        <script>   
         function formSubmit1(){    
             document.actionForm1.action = "in_out_record.php";    
             document.actionForm1.submit();    
         }  
         function formSubmit2(){    
             document.actionForm2.action = "in_out_record.php";    
             document.actionForm2.submit();    
         }  
         function formSubmit3(){    
             document.actionForm3.action = "function_add_group.php";    
             document.actionForm3.submit();    
         }  
        </script>
<?PHP
    $new_member = $Finance->getIsGroupAdmin($_SESSION['__group_id']);
    if ($new_member) 
    {
        echo "<FORM name=\"actionForm3\" method=\"POST\" style=\"display: inline;\">";
        echo "<INPUT type=\"hidden\" name=\"new_member\" value=\"NEWMEMBER\">";
        echo "<INPUT type=\"hidden\" name=\"member1\" value=\"".$new_member['0']['0']."\">";
        echo "<INPUT type=\"hidden\" name=\"member2\" value=\"".$new_member['1']['0']."\">";
        echo "<INPUT type=\"hidden\" name=\"member3\" value=\"".$new_member['2']['0']."\">";
        echo "<INPUT type=\"hidden\" name=\"member4\" value=\"".$new_member['3']['0']."\">";
        echo "<INPUT type=\"hidden\" name=\"member5\" value=\"".$new_member['4']['0']."\">";
        echo "<BLINK><FONT color=\"#CC3300\">***** </FONT>";
        echo "<a href=\"javascript:formSubmit3()\"><FONT color=\"#CC3300\">".$_NEW_MEMBER."</FONT></a>";
        echo "<FONT color=\"#CC3300\"> *****</FONT></BLINK>";
        echo "<BR>";
        echo "</FORM>";
    }
?>

        <BODY>
            <FORM name="actionForm1" method="POST" style="display: inline;">
            <INPUT type="hidden" name="getrecordtype" value="1">
                1.  <a href="javascript:formSubmit1()"><?PHP echo $_OUT.$_RECORD;?></a>
            </FORM>
                <FONT color="#0000CC">/</FONT>
            <FORM name="actionForm2" method="POST" style="display: inline;">
                <INPUT type="hidden" name="getrecordtype" value="2">
                <a href="javascript:formSubmit2()"><?PHP echo $_IN.$_RECORD;?></a>
            </FORM>
                <br>
                2. <a href="./function.php"><?PHP echo $_FUNCTION ?></a><br>
                3. <a href="./report.php"><?PHP echo $_REPORT ?></a><br>
                4. <a href="./search.php"><?PHP echo $_SEARCH ?></a><br>
                <BR>

                <?PHP require_once("tail.php");?>
        </BODY>
        </HTML>
>>>>>>> e79fba4c37b2c02476590015a5952175b7fd5b25
