		<HTML>
		<BODY>
		<?PHP 
				require_once("head.php"); 
				$user_id = $Finance->getUserID("test3");
				echo $user_id[0][0];
		?>
		<?PHP require_once("tail.php");?>
		</BODY>
		</HTML>
