<<<<<<< HEAD
<?PHP
    session_start();
    header("Content-Type:text/html;charset=UTF-8"); 
    require_once("config.inc.php");
    require_once(INCLUDE_PATH.'finance.inc.php');
        if (empty($_SESSION['__error_logid']) ) 
        {
        } else {
            echo $Finance->convertLogIdToContent($_SESSION['__error_logid'] )."<BR><BR>";
        }
    unset($_SESSION['']);
    session_unset();
    $_SESSION['__month'] = 0;
?>

<HTML>
    <HEAD>
    <TITLE> <?PHP echo $_TITLE?> </TITLE>
    </HEAD>
        <BODY>
        <?PHP echo "<BR><BR>&nbsp;<STRONG><FONT SIZE=3 COLOR=\"#3300FF\"> <a href=\"./images/logo_max_color.gif\"><IMG align=\"absmiddle\" SRC=\"./images/logo_color.gif\" WIDTH=\"25\" HEIGHT=\"21\" BORDER=\"0\" ALT=\"彩贝壳个人收支系统\"></a> ". $_TITLE ."  </FONT></STRONG><BR>";?>
        <BR>
        <fieldset>
        <legend>&nbsp;登录&nbsp;</legend>
        <FORM action="form_process.php" method="post" >
        <TABLE border="0">
        <TR>
            <TD><?PHP echo $_USERNAME ?></TD>
            <TD> <input type="text" name="username" size="12" maxlength="20"></TD>
        </TR>
        <TR>
            <TD><?PHP echo $_PASSWORD ?></TD>
            <TD><input type="password" name="password" size="12" maxlength="20"></TD>
        </TR>
        </TABLE>
            <INPUT type="hidden" name="login" value="LOGIN">
            <INPUT type="submit" value="<?PHP echo $_LOGIN?>">
        </FORM>
        </fieldset>
        <?PHP    
        echo  "<center><div style=\"position:absolute;height:45pt;top:expression(document.body.clientHeight-this.style.pixelHeight+document.body.scrollTop);font:12pt;color:blue;\">Copyright  &copy; 2010-2012  ChenBK.CO.CC All Rights Reserved  <BR> 一个简单在线个人收支管理系统<BR>E-mail :  <a href=\"mailto:chenbingkun55@163.com\">ChenBingKun55@163.com</a></div></center>";
        
?>
    </BODY>
</HTML>
=======
<?PHP
    session_start();
    header("Content-Type:text/html;charset=UTF-8"); 
    require_once("config.inc.php");
    require_once(INCLUDE_PATH.'finance.inc.php');
        if (empty($_SESSION['__error_logid']) ) 
        {
        } else {
            echo $Finance->convertLogIdToContent($_SESSION['__error_logid'] )."<BR><BR>";
        }
    unset($_SESSION['']);
    session_unset();
    $_SESSION['__month'] = 0;
?>

<HTML>
    <HEAD>
    <TITLE> <?PHP echo $_TITLE?> </TITLE>
    </HEAD>
        <BODY>
        <?PHP echo "<BR><BR>&nbsp;<STRONG><FONT SIZE=3 COLOR=\"#3300FF\"> <a href=\"./images/logo_max_color.gif\"><IMG align=\"absmiddle\" SRC=\"./images/logo_color.gif\" WIDTH=\"25\" HEIGHT=\"21\" BORDER=\"0\" ALT=\"彩贝壳个人收支系统\"></a> ". $_TITLE ."  </FONT></STRONG><BR>";?>
        <BR>
        <fieldset>
        <legend>&nbsp;登录&nbsp;</legend>
        <FORM action="form_process.php" method="post" >
        <TABLE border="0">
        <TR>
            <TD><?PHP echo $_USERNAME ?></TD>
            <TD> <input type="text" name="username" size="12" maxlength="20"></TD>
        </TR>
        <TR>
            <TD><?PHP echo $_PASSWORD ?></TD>
            <TD><input type="password" name="password" size="12" maxlength="20"></TD>
        </TR>
        </TABLE>
            <INPUT type="hidden" name="login" value="LOGIN">
            <INPUT type="submit" value="<?PHP echo $_LOGIN?>">
        </FORM>
        </fieldset>
        <?PHP    
        echo  "<center><div style=\"position:absolute;height:45pt;top:expression(document.body.clientHeight-this.style.pixelHeight+document.body.scrollTop);font:12pt;color:blue;\">Copyright  &copy; 2010-2012  ChenBK.CO.CC All Rights Reserved  <BR> 一个简单在线个人收支管理系统<BR>E-mail :  <a href=\"mailto:chenbingkun55@163.com\">ChenBingKun55@163.com</a></div></center>";
        
?>
    </BODY>
</HTML>
>>>>>>> e79fba4c37b2c02476590015a5952175b7fd5b25
