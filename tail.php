<?PHP
	if ( $_GET['registr'] == 1 ):
		echo "";
	else:
		echo "<BR><div align = \"left\"><a href=\"index.php?logout=1&username=".$_SESSION['__useralive'][1]."\">".$_LOGOUT."</a></div>";
		$_SESSION['__global_logid'] = "";
		$_SESSION['__gettype'] = "";
	endif;
		echo  "<center><div style=\"position:absolute;height:45pt;top:expression(document.body.clientHeight-this.style.pixelHeight+document.body.scrollTop);font:12pt;color:blue;\">Copyright  &copy; 2010-2012  ChenBK.CO.CC All Rights Reserved  <BR> 一个简单在线个人收支管理系统<BR>E-mail :   <a href=\"mailto:chenbingkun55@163.com\">ChenBingKun55@163.com</a></div></center>";

?>
