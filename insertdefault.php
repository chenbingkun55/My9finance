		<HTML>
		<BODY>
		<?PHP 
				require_once("head.php"); 
				if (! empty($_GET["user_id"]))
				{
					$Finance->insertMantypeDefault($_GET["user_id"]);
					$Finance->insertSubtypeDefault($_GET["user_id"]);
					$Finance->insertAddressDefault($_GET["user_id"]);
					echo "<BR>添加默认收支主类、收支子类、地址。<BR>";
				} else {
					echo "<BR>没有输入用户ID。<BR>";
				}

		?>
		<?PHP require_once("tail.php");?>
		</BODY>
		</HTML>