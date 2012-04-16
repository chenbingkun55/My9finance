		<HTML>
		<BODY>
		<?PHP 
				require_once("head.php"); 
			$num='０';
			
			echo date('Y-m',mktime(0,0,0,date("M")-6,1,date("Y")));
			echo "/n";
			echo date('z',mktime(0,0,0,12,31,2008));

		?>
		<?PHP require_once("tail.php");?>
		</BODY>
		</HTML>
