<?PHP 	
	session_start();
	header("Content-Type:text/html;charset=UTF-8"); 	
	date_default_timezone_set('PRC');
	require_once("config.inc.php");
	require_once(INCLUDE_PATH.'finance.inc.php');
	$sessionid = session_id();
	$xing = '';
	
	if (empty($_SESSION['__username'])  ||  $sessionid != ($Finance->getUserSession($_SESSION['__useralive'][0])))
	{
		$_SESSION['__error_logid'] = "3";
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=index.php\">";
	}

	//$_SESSION['__error_logid'] = $_GET['error_id'];
	if (empty($_SESSION['__error_logid']) ) 
	{
	} else {
		echo $Finance->convertLogIdToContent($_SESSION['__error_logid'] )."<BR><BR>";
	}

	if (empty($_SESSION['__username']) ) 
	{
	} else {
		if($Finance->getGroupAdmin()) $xing = "<FONT color=\"#0000CC\">*</FONT>";
		echo   $xing."<a href=\"function_user.php\">".$_SESSION['__username']."</a>&nbsp;你好！&nbsp;&nbsp;";
		$group_name = $Finance->convertGroupAliasID($_SESSION['__group_id']);
		if (empty($group_name[1]))
		{
			$_SESSION['__groupname'] = $group_name['0'];
		}else{
			$_SESSION['__groupname'] = $group_name['1'];
		}

	if (empty($_SESSION['__groupname']))
	{
		$_SESSION['__error_logid'] = "3";
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=index.php\">";
	}
	

		echo $_RESIDE_GROUP."&nbsp:".$_SESSION['__groupname']."<BR><BR>";
	}

	echo "&nbsp;<STRONG><FONT SIZE=3 COLOR=\"#3300FF\"> <a href=\"./images/logo_max_color.gif\"><IMG align=\"absmiddle\" SRC=\"./images/logo_color.gif\" WIDTH=\"25\" HEIGHT=\"21\" BORDER=\"0\" ALT=\"彩贝壳个人收支系统\"></a> ". $_TITLE ."  </FONT></STRONG><BR><BR>";
	
	echo "<a href=\"main.php\"><<主页</a>";
	echo "  <a href=\"function.php\"><<功能管理</a>";
	echo "  <a href=\"report.php\"><<报表</a>";
	echo "  <a href=\"search.php\"><<搜索</a>";
	echo "  <a href=\"task.php\"><<任务</a>";
	echo "<BR><BR>";
?>
<HEAD>
<TITLE> <?PHP echo $_TITLE?> </TITLE>
</HEAD>


